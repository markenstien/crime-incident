<?php

use Form\CaseForm;
use Form\PeopleForm;
use Services\CategoryService;
use Services\UserService;

load(['CaseForm', 'PeopleForm'], FORMS);
load(['UserService', 'CategoryService'], SERVICES);

    class CaseController extends Controller
    {   

        public function __construct()
        {
            parent::__construct();
            $this->data['_form'] = new CaseForm();
            $this->data['_peopleForm'] = new PeopleForm();
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
                $res = $this->model->createOrUpdate($req);
                if(!$res) {
                    Flash::Set($this->model->getErrorString(), 'danger');
                    return request()->return();
                }

                Flash::set($this->model->getMessageString());
                return redirect(_route('case:show', $res));
            }
            return $this->view('case/create', $this->data);
        }

        public function show($id) {
            $this->data['title'] = 'Case Report';
            $this->data['case'] = $this->model->get($id);

            $peopleArray = [
                'victims' => [],
                'suspects' => []
            ];

            $people = $this->model->getPeople($id);

            if($people) {
                foreach($people as $key => $row) {
                    if ($row->people_type == UserService::VICTIM) {
                        $peopleArray['victims'][] = $row;
                    } else {
                        $peopleArray['suspects'][] = $row;
                    }
                }
            }
            
            $this->data['peopleArray'] = $peopleArray;

            return $this->view('case/show', $this->data);
        }

        public function addPeople($caseId) {
            $req = request()->inputs();

            if (isSubmitted()) {
                $res = $this->model->addPeople($req);
                if(!$res) {
                    Flash::set($this->model->getErrorString(),'danger');
                    return request()->return();
                }

                Flash::set($this->model->getMessageString());
                return redirect(_route('case:show', $req['case_id']));
            }

            $this->data['_peopleForm']->setValue('case_id', $caseId);
            $this->data['caseId'] = $caseId;

            return $this->view('case/add_people', $this->data);
        }

        public function showPerson($personId) {
            $person = $this->model->getPerson($personId);
            $this->data['person'] = $person;
            $this->data['case'] = $person->case;

            return $this->view('case/show_person', $this->data);
        }

        public function editPeople($personId) {
            $req = request()->inputs();
            $person = $this->model->getPerson($personId);

            if(isSubmitted()) {
                $res = $this->model->editPeople($req, $req['id']);
                if(!$res) {
                    Flash::set($this->model->getErrorString(), 'danger');
                }else{
                    Flash::set($this->model->getMessageString());
                    return redirect(_route('case:show', $person->case_id));
                }
            }
            $this->data['_peopleForm']->setValueObject($person);
            $this->data['_peopleForm']->addId($personId);
            $this->data['_peopleForm']->setValue('case_id', $person->case_id);
            $this->data['caseId'] = $person->case_id;

            
            return $this->view('case/edit_people', $this->data);
        }

        public function peopleSearch() {
            $this->data['cases'] = null;

            if(isset($_GET['advance_search'])) {
                $this->data['cases'] = $this->model->getAll([
                    'where' => [
                        'cases.incident_date' => [
                            'condition' => 'between',
                            'value' => [$_GET['start_date'], $_GET['end_date']]
                        ],
                        'barangay_id' => $_GET['barangay_id'],
                        'crime_type_id' => $_GET['crime_type_id']
                    ]
                ]);
            } elseif(isset($_GET['keyword_search'])) {
                $keyword = $_GET['keyword'];
                if(strlen($keyword) < 3) {
                    Flash::set("Keyword must atleast be greater than 3 characters", 'danger');
                    return request()->return();
                }

                $this->data['cases'] = $this->model->getByPeopleFirst([
                    'where' => [
                        'cases.title' => [
                            'condition' => 'like',
                            'value' => "%{$keyword}%",
                            'concatinator' => 'OR'
                        ],
                        'people.firstname' => [
                            'condition' => 'like',
                            'value' => "%{$keyword}%",
                            'concatinator' => 'OR'
                        ],
                        'people.lastname' => [
                            'condition' => 'like',
                            'value' => "%{$keyword}%",
                            'concatinator' => 'OR'
                        ],
                    ]
                ]);
            }

            return $this->view('case/people_search', $this->data);
        }
    }