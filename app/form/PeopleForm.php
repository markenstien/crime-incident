<?php
    namespace Form;

    use Core\Form;
    use Services\UserService;

    load(['Form'],CORE);
    load(['UserService'], SERVICES);

    class PeopleForm extends Form
    {
        public function __construct()
        {
            parent::__construct();
            $this->addPeopleType();
            $this->addFirstName();
            $this->addLastname();
            $this->addGender();
            $this->addAge();
            $this->addPhone();
            $this->isDead();
            $this->addInjuryRemarks();
            $this->addCaseId();
            $this->customSubmit('Save People');
        }

        public function addFirstName() {
            $this->add([
                'name' => 'firstname',
                'type' => 'text',
                'options' => [
                    'label' => 'First name',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }
        
        public function addLastname() {
            $this->add([
                'name' => 'lastname',
                'type' => 'text',
                'options' => [
                    'label' => 'Last name',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addCaseId() {
            $this->add([
                'name' => 'case_id',
                'type' => 'hidden',
                'required' => true
            ]);
        }

        public function addInjuryRemarks() {
            $this->add([
                'name' => 'injury_remarks',
                'type' => 'textarea',
                'options' => [
                    'label' => 'Injury Remarks',
                    'rows' => 3
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function isDead() {
            $this->add([
                'name' => 'is_dead',
                'type' => 'select',
                'options' => [
                    'label' => 'Is Deceased',
                    'option_values' => [
                        1 => 'True',
                        0 => 'False'
                    ]
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addPhone() {
            $this->add([
                'name' => 'phone',
                'type' => 'text',
                'options' => [
                    'label' => 'Phone Number',
                ],
                'class' => 'form-control'
            ]);
        }

        public function addGender() {
            $this->add([
                'name' => 'gender',
                'type' => 'select',
                'options' => [
                    'label' => 'Gender',
                    'option_values' => [
                        UserService::MALE,
                        UserService::FEMALE
                    ]
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addAge() {
            $this->add([
                'name' => 'age',
                'type' => 'number',
                'options' => [
                    'label' => 'Age',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addPeopleType() {
            $this->add([
                'name' => 'people_type',
                'type' => 'select',
                'options' => [
                    'label' => 'Economic Type',
                    'option_values' => [
                        UserService::VICTIM,
                        UserService::SUSPECT
                    ]
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }
    }