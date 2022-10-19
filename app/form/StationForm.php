<?php
    namespace Form;

    use Core\Form;
    load(['Form'],CORE);

    class StationForm extends Form {

        public function __construct()
        {
            parent::__construct();
            $this->addname();
            $this->addHotline();
            $this->addDescription();
            $this->addAddressText();
            $this->addChief();
            $this->customSubmit('Save');
        }

        public function addName() {
            $this->add([
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => 'Name',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addHotline() {
            $this->add([
                'type' => 'text',
                'name' => 'hotline',
                'options' => [
                    'label' => 'Hotline',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addChief() {
            $this->add([
                'type' => 'text',
                'name' => 'chief',
                'options' => [
                    'label' => 'Chief Of Police',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addLat() {

        }

        public function addLang() {

        }
    }