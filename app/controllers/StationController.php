<?php

    use Form\StationForm;   
    load(['StationForm'],FORMS);

    class StationController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->data['_form'] = new StationForm();
            $this->model = model('StationModel');
            $this->user = model('UserModel');
        }

        public function index() {
            $this->data['title'] = 'Stations';
            $this->data['stations'] = $this->model->all();
            return $this->view('station/index', $this->data);
        }

        public function create() {
            $req = request()->inputs();
            if(isSubmitted()) {
                $res = $this->model->createOrUpdate($req);
                if($res) {
                    Flash::set($this->model->getMessageString());
                    return redirect(_route('station:index'));
                } else {
                    Flash::set($this->model->getErrorString());
                    return request()->return();
                }
            }
            $this->data['title'] = 'Create Station';

            return $this->view('station/create', $this->data);
        }
        public function show($id) {
            $station = $this->model->get($id);
            $this->data['title'] = "Station : " . $station->reference;
            $this->data['station'] = $station;
            $this->data['station_admin'] = $this->user->get([
                'station_id' => $id
            ]);

            return $this->view('station/show' , $this->data);
        }
        public function edit($id) {
            $req = request()->inputs();
            $station = $this->model->get($id);

            if(isSubmitted()) {
                $res = $this->model->createOrUpdate($req, $id);
                if($res) {
                    Flash::set($this->model->getMessageString());
                    return redirect(_route('station:show', $id));
                } else {
                    Flash::set($this->model->getErrorString());
                    return request()->return();
                }
            }
            $form = $this->data['_form'];

            $form->setValueObject($station);
            $form->addId($id);
            $form->init([
                'action' => _route('station:edit', $id)
            ]);

            $this->data['title'] = "Station : " . $station->reference;
            $this->data['station'] = $station;
            return $this->view('station/edit' , $this->data);
        }
    }