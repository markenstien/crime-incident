<?php
	
	$routes = [];

	$controller = '/MailerController';
	$routes['mailer'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'send'   => $controller.'/send'
	];

	$controller = '/UserController';
	$routes['user'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show',
		'sendCredential' => $controller.'/sendCredential'
	];

	$controller = '/AuthController';
	$routes['auth'] = [
		'login' => $controller.'/login',
		'register' => $controller.'/register',
		'logout' => $controller.'/logout',
	];

	$controller = '/AttachmentController';
	$routes['attachment'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'download' => $controller.'/download',
		'show'   => $controller.'/show'
	];

	$controller = '/CategoryController';
	$routes['category'] = [
		'create' => $controller.'/create',
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'order' => $controller.'/orderReceipt',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show',
		'logs' => $controller.'/logs',
		'deactivate' => $controller.'/deactivateOrActivate'
	];

	$controller = '/DashboardController';
	$routes['dashboard'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show',
		'update' => $controller.'/update',
	];

	$controller = '/ReportController';
	$routes['report'] = [
		'index' => $controller.'/index',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'download' => $controller.'/download',
	];

	$controller = '/FormBuilderController';
	$routes['form'] = [
		'index' => $controller.'/index',
		'edit' => $controller.'/edit',
		'create' => $controller.'/create',
		'delete' => $controller.'/destroy',
		'show'   => $controller.'/show',
		'add-item' => $controller.'/addItem',
		'edit-item' => $controller. '/editItem',
		'delete-item' => $controller. '/deleteItem',
		'respond'   => '/FormController'.'/respond'
	];

	$controller = '/StationController';
	$routes['station'] = _singleBasicRoute($controller);
	
	$controller = '/CaseController';
	$routes['case'] = _singleBasicRoute($controller);
	return $routes;


	function _singleBasicRoute($controller) {
		return [
			'index' => $controller.'/index',
			'edit' => $controller.'/edit',
			'create' => $controller.'/create',
			'delete' => $controller.'/destroy',
			'download' => $controller.'/download',
			'show'   => $controller.'/show'
		];
	}
?>