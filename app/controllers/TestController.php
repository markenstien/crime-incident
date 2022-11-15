<?php

	use Services\UploadExcelService;
	load(['UploadExcelService'], SERVICES);

	class TestController extends Controller
	{
		public function show(){
			return $this->view('test/show');
		}

		public function test() {
			$path = PATH_UPLOAD.DS.'crimes_clean_date.xlsx';
			if (file_exists($path)){
				$files = UploadExcelService::upload($path);
			} else {
				echo 'FILE ERROR : --'.PATH_UPLOAD.DS.'crimes_clean_date.xlsx';
			}
		}
	}