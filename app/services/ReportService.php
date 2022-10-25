<?php 
    namespace Services;
    use Services\UserService;
    load(['UserService'], SERVICES);
    
    class ReportService {
        private $caseModel;
        private $cases;
        public function __construct($caseModel)
        {
            $this->caseModel = $caseModel;
        }
        public function generate($startDate, $endDate, $stationId = null, $crimeTypes = [], $barangayId = null) {
            $cases = $this->caseModel->getAll([
                'where' => [
                    'incident_date' => [
                        'condition' => 'between',
                        'value' => [
                            $startDate, $endDate
                        ]
                    ]
                ],
                'order' => 'incident_date desc'
            ]);

            foreach($cases as $key => $row) {
                $row->people = $this->caseModel->getPeople($row->id);
            }
            $this->cases = $cases;
        }

        public function getCases() {
            return $this->cases;
        }


        public function summarizeGeneral($cases) {
            $retVal = [
                'numberofDays' => 0,
                'period' => ['startdate', 'endate'],
                'totalNumberOfCase' => 0,
                'totalNumberOfCrimeType' => 0,
                'totalNumberOfStation' => 0,
                'totalNumberOfBarangay' => 0,
                'peopleInvolved' => [
                    'victims' => [
                        'total' => 0,
                        'male' => 0,
                        'female' => 0
                    ],
                    'suspects' => [
                        'total' => 0,
                        'male' => 0,
                        'female' => 0
                    ],
                    'total' => 0
                ]
            ];

            $first = $cases[0];
            $last = end($cases);
            
            $tmpHolder = [
                'crimeTypes' => [],
                'stations' => [],
                'barangays' => []
            ];
            foreach($cases as $key => $row) {
                //categories
                if(!isEqual($row->crime_type_id, array_keys($tmpHolder['crimeTypes']))){
                    $tmpHolder['crimeTypes'][$row->crime_type_id] = [
                        'name' => $row->crime_type,
                        'total' => 0
                    ];
                }
                $tmpHolder['crimeTypes'][$row->crime_type_id]['total']++;

                //stations
                if(!isEqual($row->station_id, array_keys($tmpHolder['stations']))){
                    $tmpHolder['stations'][$row->station_id] = [
                        'name' => $row->station_name,
                        'total' => 0
                    ];
                }
                $tmpHolder['stations'][$row->station_id]['total']++;

                //barangay_id
                if(!isEqual($row->barangay_id, array_keys($tmpHolder['barangays']))){
                    $tmpHolder['barangays'][$row->barangay_id] = [
                        'name' => $row->barangay,
                        'total' => 0
                    ];
                }
                $tmpHolder['barangays'][$row->barangay_id]['total']++;

                if(is_array($row->people)) {
                    foreach($row->people as $peopleKey => $people) {
                        if(isEqual($people->people_type, UserService::VICTIM)) {
                            if(isEqual($people->people_type, UserService::FEMALE)) {
                                $retVal['peopleInvolved']['victims']['female']++;
                            }else{
                                $retVal['peopleInvolved']['victims']['male']++;
                            }
                            $retVal['peopleInvolved']['victims']['total']++;
                        }else{
                            $retVal['peopleInvolved']['suspects']['total']++;
                            if(isEqual($people->people_type, UserService::FEMALE)) {
                                $retVal['peopleInvolved']['suspects']['female']++;
                            }else{
                                $retVal['peopleInvolved']['suspects']['male']++;
                            }
                        }
                        $retVal['peopleInvolved']['total']++;
                    }
                }
            }

            $retVal['totalNumberOfCase'] = count($cases);
            $retVal['totalNumberOfCrimeType'] = count($tmpHolder['crimeTypes']);
            $retVal['totalNumberOfStation'] = count($tmpHolder['stations']);
            $retVal['totalNumberOfBarangay'] = count($tmpHolder['barangays']);
            $retVal['data'] = $tmpHolder;
            $retVal['cases'] = $cases;
            return $retVal;
        }


        public function summarizePeople($peopleArray) {
            $retVal = [
                'victims' => [
                    'male' => [
                        'ages' => [],
                        'total' => 0
                    ],
                    'female' => [
                        'ages' => ['low', 'high'],
                        'total' => 0
                    ],
                    'deaths' => 0,
                    'total' => 0
                ],
                'suspects' => [
                    'male' => [
                        'ages' => [],
                        'total' => 5
                    ],
                    'female' => [
                        'ages' => [],
                        'total' => 5
                    ],
                    'deaths' => 0,
                    'total' => 0
                ],
                'total' => 0
            ];

            foreach($peopleArray as $key => $people) {
                if(isEqual($people->people_type, UserService::VICTIM)) {
                    if(isEqual($people->people_type, UserService::FEMALE)) {
                        $retVal['victims']['female']['total']++;
                    }else{
                        $retVal['victims']['male']['total']++;
                    }

                    if($people->is_dead) {
                        $retVal['victims']['deaths']++;
                    }
                    $retVal['victims']['ages'][] = $people->age;

                    $retVal['victims']['total']++;
                }else{
                    $retVal['suspects']['total']++;
                    if(isEqual($people->people_type, UserService::FEMALE)) {
                        $retVal['suspects']['female']['total']++;
                    }else{
                        $retVal['suspects']['male']['total']++;
                    }

                    if($people->is_dead) {
                        $retVal['suspects']['deaths']++;
                    }
                    $retVal['suspects']['ages'][] = $people->age;
                    $retVal['suspects']['total']++;
                }
                $retVal['total']++;
            }

            return $retVal;
        }

        public function createLatLangVicinity($cases) {
            $retVal = [
                'radius' => [
                    'lat' => 123123, 'lng' => 123123, 'total' => 5,
                ]
            ];

            foreach($cases as $key => $row) {
                if(!isEqual($row->case_radius, array_keys($retVal))) {
                    $retVal[$row->case_radius] = [
                        'lat' => $row->lat,
                        'lng' => $row->lng,
                        'total' => 0
                    ];
                }
                $retVal[$row->case_radius]['total']++;
            }
            
            return $retVal;
        }
    } 