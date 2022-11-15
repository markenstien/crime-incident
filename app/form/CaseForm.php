<?php 

    namespace Form;
    use Core\Form;
    use Services\CategoryService;
use Services\UserService;

    load(['Form'], CORE);
    load(['CategoryService', 'UserService'], SERVICES);

    class CaseForm extends Form {

        public function __construct()
        {
            parent::__construct();
            $this->categoryModel = model('CategoryModel');
            $this->stationModel = model('StationModel');

            $this->addTitle();
            $this->addStation();
            $this->addIncidentDate();
            $this->addIncidentTime();
            $this->addCrimeType();
            $this->addBarangayId();
            $this->addLat();
            $this->addLng();
            $this->addDescription();
            // $this->addLandMark();
        }
        public function addTitle() {
            $this->add([
                'name' => 'title',
                'type' => 'text',
                'options' => [
                    'label' => 'Case Name'
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }
        
        public function addIncidentDate() {
            $this->add([
                'name' => 'incident_date',
                'type' => 'date',
                'options' => [
                    'label' => 'Incident Date'
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addIncidentTime() {
            $this->add([
                'name' => 'incident_time',
                'type' => 'time',
                'options' => [
                    'label' => 'Incident Time'
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addCrimeType() {
            $caseModel = model('CaseModel');
            $options = $caseModel->getCrimeTypes();
            $options = arr_layout_keypair($options, ['id','name']);

            $this->add([
                'name' => 'crime_type_id',
                'type' => 'select',
                'options' => [
                    'label' => 'Crime Type',
                    'option_values' => $options
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addBarangayId() {

            $options = $this->categoryModel->all([
                'category' => CategoryService::BARANGAY_TYPE,
                'active' => true
            ]);
            $options = arr_layout_keypair($options,['id','name']);
            
            $this->add([
                'name' => 'barangay_id',
                'type' => 'select',
                'options' => [
                    'label' => 'Barangay',
                    'option_values' => $options
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addStation() {
            $value = null;
            if(isEqual(whoIs('user_type'), UserService::ADMIN)) {
                $options = $this->stationModel->getAll();
            }else{
                $stationId =  whoIs('station_id');
                $options = $this->stationModel->getAll([
                    'where' => [
                        'id' =>$stationId
                    ]
                ]);

                $value = $stationId;
            }
            $options = arr_layout_keypair($options,['id','name']);

            $inputParam = [
                'name' => 'station_id',
                'type' => 'select',
                'options' => [
                    'label' => 'Stations',
                    'option_values' => $options
                ],
                'class' => 'form-control',
                'required' => true
            ];

            if(!is_null($value)) {
                $inputParam['value'] = $value;
                $inputParam['attributes'] = [
                    'readonly' => true,
                ];
            }

            $this->add($inputParam);
        }


        public function addLat() {
            $this->add([
                'name' => 'lat',
                'type' => 'text',
                'options' => [
                    'label' => 'Latitude'
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addLng() {
            $this->add([
                'name' => 'lng',
                'type' => 'text',
                'options' => [
                    'label' => 'Longitude',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addLandMark() {
            $this->add([
                'name' => 'landmark',
                'type' => 'text',
                'options' => [
                    'label' => 'Land Mark'
                ],
                'class' => 'form-control',
                'required' => true,
                'attributes' => [
                    'placeholder' => 'Eg. Sm Bicutan'
                ]
            ]);
        }
    }