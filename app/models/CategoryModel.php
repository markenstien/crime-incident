<?php
    use Services\CategoryService;
    load(['CategoryService'],SERVICES);

    class CategoryModel extends Model
    {
        public $table = 'categories';

        public $_fillables = [
            'name',
            'category',
            'active'
        ];

        public function __construct()
        {
            parent::__construct();
            $this->type = CategoryService::BARANGAY_TYPE;
        }

        public function createOrUpdate($categoryData, $id = null) {
            $_fillables = parent::getFillablesOnly($categoryData);
            if (!is_null($id)) {
                $this->addMessage(parent::MESSAGE_UPDATE_SUCCESS);
                return parent::update($_fillables, $id);
            } else {
                $_fillables['active'] = true;
                $this->addMessage(parent::MESSAGE_CREATE_SUCCESS);
                return parent::store($_fillables);
            }
        }

        public function deactivateOrActivate($id) {
            $category = parent::get($id);
            if(!$category) 
                return false;
            $this->addMessage(parent::MESSAGE_UPDATE_SUCCESS);
            return parent::update([
                'active' => !$category->active
            ],$id);
        }


        public function getBarangayTotal() {
            $this->db->query(
                "SELECT count(id) as total
                    FROM {$this->table}
                    WHERE category = '{$this->type}'"
            );
            return $this->db->single()->total ?? 0;
        }
    }