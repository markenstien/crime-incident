<?php

use Services\UserService;

    class StationModel extends Model
    {
        public $table = 'stations';
        public $_fillables = [
            'name',
            'description',
            'hotline',
            'address',
            'lat',
            'lng',
            'chief',
            'is_active'
        ];

        public function createOrUpdate($platformData, $id = null)
        {
            $platformData['_token'] = 'reference';
            $stationId = parent::createOrUpdate($platformData, $id);

            if(is_null($id)) {
                $this->userModel = model('UserModel');
                $this->userModel->save([
                    'firstname' => "DEFAULT",
                    'lastname'  => "DEFAULT",
                    'username'  => strtoupper(substr($platformData['name'],-1,3) . random_letter(5)),
                    'password' => UserService::DEFAULT_PASSWORD,
                    'phone' => $platformData['hotline'],
                    'user_type' => UserService::SUPERVISOR,
                    'station_id' => $stationId
                ]);
                //create account for that station
            }else{
                $stationId = $id;
            }

            return $stationId;
        }

        public function getAll($params = []) {
            return parent::all($params['where'] ?? null,$params['order'] ?? null);
        }

        public function getTotal() {
            $this->db->query(
                "SELECT count(id) as total
                    FROM {$this->table}"
            );
            return $this->db->single()->total ?? 0;
        }
    }