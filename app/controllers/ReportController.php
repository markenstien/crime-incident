<?php

	use Services\ReportService;
	load(['ReportService'],SERVICES);

	class ReportController extends Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->caseModel = model('CaseModel');
			$this->reportService = new ReportService($this->caseModel);
		}

		public function create(){
			$req = request()->inputs();
			$this->data['title'] = 'Reports';

			if (isset($req['filter'])) {
				$this->reportService->generate($req['start_date'], $req['end_date']);
				$this->data['generalSummary'] = $this->reportService->summarizeGeneral($this->reportService->getCases());
				$this->data['caseRadius'] = $this->reportService->createLatLangVicinity($this->reportService->getCases());
			}
			return $this->view('report/create', $this->data);
		}
		

		public function index()
		{	
			return $this->view('report/index');
		}
	}