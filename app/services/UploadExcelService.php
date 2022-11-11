<?php 
    namespace Services;
    load(['CategoryService'],SERVICES);

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

			foreach ($reader->getSheetIterator() as $sheet) 
            {
			    foreach ($sheet->getRowIterator() as $row) {
			        // do stuff with the row
			        $cells = $row->getCells();
			        //skip headers
			        if($counter == 1)
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
                            $barangayId = $stationData->id;
                        }
                        //search 

                        $data = [
                            'CaseReference' => $cells[0]->getValue(),
                            'Case' => $cells[13]->getValue(),
                            'CaseDescription' => str_escape($cells[31]->getValue()),
                            'Status' => $cells[32]->getValue(),
                            'IncidentTime' => $cells[3]->getValue()->format('H:i:s'),
                            'IncidentDate' => $cells[3]->getValue()->format('Y-m-d'),
                            'Station' => $stationId,
                            'Barangay' => $barangayId,
                            'CrimeType' => $crimeTypeId,
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
                                'gender' => $cells[35]->getValue(),
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

			return $uploadStorage;
        }
    }