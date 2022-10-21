<?php
    class CasePeopleModel extends Model
    {
        public $table = 'cases_people';

        public $_fillables = [
            'case_id',
            'firstname',
            'lastname',
            'injury_remarks',
            'is_dead',
            'phone',
            'gender',
            'age',
            'people_type',
        ];

        public function createOrUpdate($platformData, $id = null)
        {
            if(is_null($id)) {
                if($this->isPersonAlreadyExistInCase($platformData['firstname'], $platformData['lastname'], $platformData['case_id']))
                    return false;
            }
                
            return parent::createOrUpdate($platformData, $id);
        }
        
        public function getPeople($params = []) {
            $where = null;
            if (isset($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            $this->db->query(
                "SELECT people.*, concat(firstname, ' ', lastname) as fullname,
                CASE 
                    WHEN is_dead = true THEN 'Deceased'
                    ELSE 'No' END AS is_deceased,
                cases.title as case_title,
                cases.reference as case_reference,
                cases.incident_date,
                cases.reference as reference,
                cases.id as case_id,
                category.name as crime_type

                FROM {$this->table} as people
                LEFT JOIN cases
                on cases.id = people.case_id

                LEFT JOIN categories as category
                on category.id = cases.crime_type_id
                {$where}
                "
            );

            return $this->db->resultSet();
        }

        private function isPersonAlreadyExistInCase($firstname, $lastname, $caseId) {
            $person = parent::single([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'case_id' => $caseId
            ]);

            if($person) {
                $this->addError("Person already exist in this case incident");
                return true;
            }

            return false;
        }

        public function get($personId) {
            $person = $this->getPeople([
                'where' => [
                    'people.id' => $personId
                ]
            ]);

            return !$person ? $person : $person[0];
        }
    }