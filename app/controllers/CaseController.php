<?php

use Form\CaseForm;
load(['CaseForm'], FORMS);

    class CaseController extends Controller
    {   

        public function __construct()
        {
            parent::__construct();
            $this->data['_form'] = new CaseForm();
            $this->model = model('CaseModel');
        }

        public function index() {
            $this->data['cases'] = $this->model->getAll();
            return $this->view('case/index', $this->data);
        }

        public function create() {
            $req = request()->inputs();
            $this->data['title'] = 'Record New Case';
            if(isSubmitted()) {
                $this->model->createOrUpdate($req);
            }
            return $this->view('case/create', $this->data);
        }
    }