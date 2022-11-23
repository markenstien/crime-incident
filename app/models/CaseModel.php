<?php

use Services\CategoryService;
load(['CategoryService'],SERVICES);

    class CaseModel extends Model
    {
        public $table = 'cases';

        public $_fillables = [
            'reference',
            'title',
            'description',
            'incident_date',
            'incident_time',
            'crime_type_id',
            'barangay_id',
            'station_id',
            'lat',
            'lng'
        ];

        public function __construct()
        {
            parent::__construct();
            $this->peopleModel = model('CasePeopleModel');
        }


        public function createOrUpdate($platformData, $id = null)
        {
            if(is_null($id)) {
                // $platformData['_token'] = 'reference';
                $prefix = '137501';
                $yearMonth = date("Ym", strtotime($platformData['incident_date']));
                $seriesId = parent::referenceSeries();
                $platformData['reference'] = strtoupper("{$prefix}-{$yearMonth}-{$seriesId}");
            }

            $platformData['lng'] = str_to_number($platformData['lng']);
            $platformData['lat'] = str_to_number($platformData['lat']);
            
            return parent::createOrUpdate($platformData,$id);
        }

        public function getCrimeTypes() {
            $categoryModel = model('CategoryModel');
            return $categoryModel->all([
                'category' => CategoryService::CRIME_TYPE
            ], 'name asc');
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            if (isset($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if(isset($params['order'])) {
                $order = " ORDER BY ".$params['order'];
            }

            $this->db->query(
                "SELECT cases.*, cat_crime.name as crime_type, 
                    cases.id as case_id,
                    round(((cases.lat + cases.lng + (200/3.14)) * 3.14) , 3) as case_radius,
                    cat_brgy.name as barangay,
                    station.name as station_name,
                    cases.id as case_id
                    
                    FROM {$this->table}
                    LEFT JOIN categories as cat_crime
                    on cat_crime.id = cases.crime_type_id

                    LEFT JOIN categories as cat_brgy
                    on cat_brgy.id = cases.barangay_id

                    LEFT JOIN stations as station
                    on station.id = cases.station_id
                    {$where} {$order}"
            );

            return $this->db->resultSet();
        }

        public function get($id) {
            $case = $this->getAll([
                'where' => [
                    'cases.id' => $id
                ]
            ]);
            return !$case ? false: $case[0];
        }

        public function addPeople($peopleData) {
            $res = $this->peopleModel->createOrUpdate($peopleData);
            $this->addMessage($this->peopleModel->getMessageString());
            $this->addError($this->peopleModel->getErrorString());
            return $res;
        }

        public function editPeople($peopleData, $id) {
            $res = $this->peopleModel->createOrUpdate($peopleData, $id);
            $this->addMessage($this->peopleModel->getMessageString());
            $this->addError($this->peopleModel->getErrorString());
            return $res;
        }

        public function getPeople($caseId) {
            return $this->peopleModel->getPeople([
                'where' => [
                    'cases.id' => $caseId
                ]
            ]);
        }

        public function getByPeopleFirst($params = []) {
            $where = $params['where'] ?? [];
            return $this->peopleModel->getPeople($params);
        }

        public function getPerson($personId) {
            $people = $this->peopleModel->get($personId);

            if(!$people) {
                $this->addError("Person doest not exists");
                return false;
            }
            $case = $this->get($people->case_id);
            $people->case = $case;

            return $people;
        }

        public function getTotal() {
            $this->db->query(
                "SELECT count(id) as total
                    FROM {$this->table}"
            );
            return $this->db->single()->total ?? 0;
        }
    }