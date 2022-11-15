<?php 

    abstract class AdminController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            if(!whoIs()) {
                Flash::set("Un-Authorized Access", 'danger');
                return redirect(_route('auth:login'));
            }
        }
    }