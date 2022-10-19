<?php 

    namespace Form;
    use Core\Form;
    use Services\CategoryService;

    load(['Form'], CORE);
    load(['CategoryService'], SERVICES);

    class CaseForm extends Form {

        public function __construct()
        {
            parent::__construct();
            $this->categoryModel = model('CategoryModel');

            $this->addTitle();
            $this->addIncidentDate();
            $this->addIncidentTime();
            $this->addCrimeType();
            $this->addBarangayId();
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
                'category' => CategoryService::BARANGAY_TYPE
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
    }