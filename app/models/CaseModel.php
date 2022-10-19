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
            $this->db->query(
                "SELECT cases.*, cat_crime.name as crime_type, 
                    cat_brgy.name as barangay 
                    FROM {$this->table}
                    LEFT JOIN categories as cat_crime
                    on cat_crime.id = cases.crime_type_id
                    LEFT JOIN categories as cat_brgy
                    on cat_brgy.id = cases.barangay_id"
            );

            return $this->db->resultSet();
        }
    }