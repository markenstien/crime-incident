<?php 
	class TestController extends Controller
	{
		public function show(){
			return $this->view('test/show');
		}
	}