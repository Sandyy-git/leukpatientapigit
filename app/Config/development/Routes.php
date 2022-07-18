<?php

$routes->resource('blog');
$routes->resource('web');
$routes->group("api", ["namespace" => "App\Controllers\Api"] , function($routes){

	$routes->group("employee", function($routes){

	   $routes->get("list", "ApiController::listEmployee");
	   $routes->post("add", "ApiController::addEmployee");
	   $routes->get("single/(:num)", "ApiController::singleEmployee/$1");
	   $routes->put("update/(:num)", "ApiController::updateEmployee/$1");
	   $routes->delete("delete/(:num)", "ApiController::deleteEmployee/$1");
	});
	 
});



?>