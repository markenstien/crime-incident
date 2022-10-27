<?php

	use Form\CaseForm;
	use Services\ReportService;
	load(['ReportService'], SERVICES);
	load(['CaseForm'], FORMS);

	class ReportController extends Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->caseModel = model('CaseModel');
			$this->stationModel = model('StationModel');

			$this->caseForm = new CaseForm();
			$this->reportService = new ReportService($this->caseModel);
		}

		public function create(){
			$req = request()->inputs();
			$this->data['title'] = 'Reports';
			$this->data['caseForm'] = $this->caseForm;

			if (isset($req['filter'])) {
				$this->reportService->generate($req['start_date'], $req['end_date'], $req['station_id'], $req['barangay_id']);
				$cases = $this->reportService->getCases();

				if (!empty($req['start_time']) || !empty($req['end_time'])) {
					$cases = $this->reportService->filterByTime($cases, $req['start_time'], $req['end_time']);
				}

				$this->data['generalSummary'] = $this->reportService->summarizeGeneral($cases);
				$this->data['caseRadius'] = $this->reportService->createLatLangVicinity($cases);
				$this->data['timeGrouped'] = $this->reportService->groupByTime($cases);
				$this->data['crimeTypes'] = $this->data['generalSummary']['data']['crimeTypes'];

				// dump($this->data['crimeTypes']);
			}

			return $this->view('report/create', $this->data);
		}
		

		public function index()
		{	
			return $this->view('report/index');
		}
	}