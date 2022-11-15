<?php 
    namespace Services;
    load(['CategoryService', 'UserService'],SERVICES);

    require_once LIBS.DS.'spout/vendor/autoload.php';
	use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

    class UploadExcelService {
        
        public static function upload($filePath) {
            //stores all data to upload
			$uploadStorage = [];
			$reader = ReaderEntityFactory::createReaderFromFile($filePath);
			$reader->open($filePath);
			//count header
			$counter = 1;

            $stationModel = model('StationModel');
            $cagetoryModel = model('CategoryModel');
            $caseModel = model('CaseModel');

			foreach ($reader->getSheetIterator() as $sheet) 
            {
			    foreach ($sheet->getRowIterator() as $row) {
			        // do stuff with the row
			        $cells = $row->getCells();
			        //skip headers
			        if($counter < 821)
			        {
			        	$counter++;
			        	continue;
			        }else
			        {
                        //searches 
                        $crimeType = trim(str_replace('(Incident)','',$cells[11]->getValue()));
                        $station = trim($cells[4]->getValue());
                        $barangay = trim($cells[8]->getValue());
                        
                        $stationData = $stationModel->single([
                            'name' => $station
                        ]);

                        $crimeData = $cagetoryModel->single([
                            'name' => $crimeType,
                            'category' => CategoryService::CRIME_TYPE
                        ]);

                        $barangayData = $cagetoryModel->single([
                            'name' => $barangay,
                            'category' => CategoryService::BARANGAY_TYPE
                        ]);

                        $stationId = null;
                        $barangayId = null;
                        $crimeTypeId = null;

                        if(!$stationData) {
                            //create
                            $stationId = $stationModel->createOrUpdate([
                                'name' => $station,
                                'hotline' => '391831'
                            ]);
                        } else {
                            $stationId = $stationData->id;
                        }

                        if(!$crimeData) {
                            $crimeTypeId = $cagetoryModel->createOrUpdate([
                                'name' => $crimeType,
                                'category' => CategoryService::CRIME_TYPE
                            ]);
                        } else {
                            $crimeTypeId = $crimeData->id;
                        }

                        if(!$barangayData) {
                            //create
                            $barangayId = $cagetoryModel->createOrUpdate([
                                'name' => $barangay,
                                'category' => CategoryService::BARANGAY_TYPE
                            ]);
                        } else {
                            $barangayId = $barangayData->id;
                        }
                        //search 

                        $data = [
                            'CaseReference' => $cells[0]->getValue(),
                            'Case' => $cells[13]->getValue(),
                            'CaseDescription' => str_escape($cells[31]->getValue()),
                            'Status' => $cells[32]->getValue(),
                            'IncidentTime' => $cells[6]->getValue()->format('H:i:s'),
                            'IncidentDate' => $cells[7]->getValue()->format('Y-m-d'),
                            'Station' => $stationId,
                            'Barangay' => $barangayId,
                            'CrimeType' => $crimeTypeId,
                            'Latitude' => $cells[9]->getValue(),
                            'Longhitude' => $cells[10]->getValue(),
                            'Suspect' => [
                                'name' => str_escape($cells[17]->getValue()),
                                'age' => str_escape($cells[19]->getValue()),
                                'gender' => str_escape($cells[20]->getValue()),
                                'remarks' => [
                                    'status' => $cells[18]->getValue(),
                                    'occupation' => $cells[21]->getValue(),
                                    'alcohol_used' => $cells[25]->getValue(),
                                    'drug_used' => $cells[24]->getValue(),
                                    'relation_to_victim' => $cells[27]->getValue(),
                                    'weapon_used' => $cells[28]->getValue(),
                                    'weapon_type' => $cells[29]->getValue(),
                                    'weapon_status' => $cells[30]->getValue(),
                                ]
                            ],
                            'Victim' => [
                                'name' => $cells[33]->getValue(),
                                'gender' => $cells[36]->getValue(),
                                'age' => $cells[35]->getValue(),
                                'remarks' => [
                                    'status' => $cells[34]->getValue(),
                                    'occupation'  => $cells[37]->getValue(),
                                ]
                            ]
                        ];
				        array_push($uploadStorage, $data);
			        }
			        
			    }
			}
			$reader->close();


            foreach($uploadStorage as $key => $row) {
                $caseId = $caseModel->createOrUpdate([
                    'incident_date' => $row['IncidentDate'],
                    'incident_time'  => $row['IncidentTime'],
                    'lng' => $row['Longhitude'],
                    'lat' => $row['Latitude'],
                    'title' => $row['Case'],
                    'crime_type_id' => $row['CrimeType'],
                    'barangay_id' => $row['Barangay'],
                    'station_id' => $row['Station'],
                    'description' => $row['CaseDescription']
                ]);

                if($caseId) {
                    $suspect = $row['Suspect'];
                    $victim = $row['Victim'];

                    $gender = isEqual($suspect['gender'], 'm') ? 'Male' : 'Female';

                    $fullName = explode(',', trim($suspect['name']));
                    array_walk($fullName, 'trim');
                    //insert people
                    $caseModel->addPeople([
                        'case_id' => $caseId,
                        'firstname' => $fullName[0],
                        'lastname'  => end($fullName),
                        'injury_remarks' => json_encode($suspect['remarks']),
                        'gender' => $gender,
                        'age' => $suspect['age'],
                        'people_type' => UserService::SUSPECT
                    ]);

                    $fullName = explode(',', trim($victim['name']));
                    array_walk($fullName, 'trim');
                    $gender = isEqual($victim['gender'], 'm') ? 'Male' : 'Female';

                    $caseModel->addPeople([
                        'case_id' => $caseId,
                        'firstname' => $fullName[0],
                        'lastname'  => end($fullName),
                        'injury_remarks' => json_encode($victim['remarks']),
                        'gender' => $gender,
                        'age' => $victim['age'],
                        'people_type' => UserService::VICTIM
                    ]);
                }
            }
			return $uploadStorage;
        }
    }