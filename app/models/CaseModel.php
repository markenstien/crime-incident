<?php

use Services\CategoryService;
load(['CategoryService'],SERVICES);

    class CaseModel extends Model
    {
        public $table = 'cases';

        public $_fillables = [
            'title',
            'description',
            'incident_date',
            'incident_time',
            'crime_type_id',
            'barangay_id',
        ];

        public function __construct()
        {
            parent::__construct();
            $this->peopleModel = model('CasePeopleModel');
        }


        public function createOrUpdate($platformData, $id = null)
        {
            if(is_null($id)) {
                $platformData['_token'] = 'reference';
            }
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

            if (isset($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }
             
            $this->db->query(
                "SELECT cases.*, cat_crime.name as crime_type, 
                    cases.id as case_id,
                    cat_brgy.name as barangay 
                    FROM {$this->table}
                    LEFT JOIN categories as cat_crime
                    on cat_crime.id = cases.crime_type_id
                    LEFT JOIN categories as cat_brgy
                    on cat_brgy.id = cases.barangay_id
                    
                    {$where}"
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
    }