<?php

	use Services\ReportService;
	use Services\UserService;
	load(['UserService', 'ReportService'],SERVICES);
	class DashboardController extends AdminController
	{
		public function __construct()
		{
			parent::__construct();
			$this->user_model = model('UserModel');
			$this->caseModel = model('CaseModel');
			$this->reportService = new ReportService($this->caseModel);
			$this->stationModel = model('StationModel');
			$this->categoryModel = model('CategoryModel');
		}

		public function index()
		{
			$this->data['page_title'] = 'Dashboard';
			$today = nowMilitary();
			$filter = $_GET['filter'] ?? '1 year';

			$last60Days = date('Y-m-d', strtotime("- {$filter}" . $today));
			
			$this->reportService->generate($last60Days, $today);
			$cases = $this->reportService->getCases();

			// dump($this->reportService->summarizeGeneral($cases));
			
			$report = [
				'summarized' => $this->reportService->summarizeGeneral($cases),
				'overall' => [
					'totalNumberOfCase' => $this->caseModel->getTotal(),
					'totalNumberOfStations' => $this->stationModel->getTotal(),
					'totalNumberOfBarangays' => $this->categoryModel->getBarangayTotal()
				],
				'summarizedDateScope' => 60
			];

			$this->data['cases']  = $cases;
			if($cases) {
				//sort stations to highest
				if($report['summarized']['data']['stations']) {
					$stations = $report['summarized']['data']['stations'];
					usort($stations, function($a,$b) {
						return $b['total'] - $a['total'];
					});
					$report['summarized']['data']['stations'] = $stations;
				}

				//sort stations to highest
				if($report['summarized']['data']['crimeTypes']) {
					$crimeTypes = $report['summarized']['data']['crimeTypes'];
					usort($crimeTypes, function($a,$b) {
						return $b['total'] - $a['total'];
					});
					$report['summarized']['data']['crimeTypes'] = $crimeTypes;
				}

				//sort stations to highest
				if($report['summarized']['data']['barangays']) {
					$barangays = $report['summarized']['data']['barangays'];
					usort($barangays, function($a,$b) {
						return $b['total'] - $a['total'];
					});
					$report['summarized']['data']['barangays'] = $barangays;
				}

				$this->data['caseRadius'] = $this->reportService->createLatLangVicinity($cases);
				$this->data['timeGrouped'] = $this->reportService->groupByTime($cases);
				$this->data['crimeTypes'] = $report['summarized']['data']['crimeTypes'];
			}
			$this->data['report'] = $report;
			return $this->view('dashboard/index', $this->data);
		}
	}