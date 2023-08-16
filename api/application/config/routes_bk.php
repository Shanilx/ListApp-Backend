<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'landing/home';		//for landing page
// $route['default_controller'] = 'frontend/front';
$route['default_controller'] = 'backend/login';
//$route['404_override'] = 'backend/login/page_not_found';
// $route['404_override'] = ;
$route['translate_uri_dashes'] = FALSE;


$route['apanel/product'] = 'backend/product/index';

$route['apanel/product/add'] = 'backend/product/addProduct';
$route['apanel/product/csv_upload_form'] = 'backend/product/csv_upload';
$route['apanel/product/upload_file_in_db'] = 'backend/product/upload_file_in_db';
$route['apanel/product/edit/(:any)'] = 'backend/product/editProduct/$1';
$route['apanel/product/detail/(:any)'] = 'backend/product/detailProduct/$1';
$route['apanel/product/delete/(:any)'] = 'backend/product/deleteProduct/$1';
$route['apanel/product/export_product_detail'] = 'backend/product/exports_data';
$route['apanel/product/sample_exports_data'] = 'backend/product/sample_exports_data';
$route['apanel/product/product_detail/(:any)'] = 'backend/product/product_detail/$1';
$route['apanel/product/product_changeStatus'] = 'backend/product/product_changeStatus';


//------------------------Supplier Routes------
$route['apanel/Supplier'] = 'backend/Supplier/index';
$route['apanel/Supplier/getAllcities'] = 'backend/Supplier/getAllcities';

$route['apanel/Supplier/Showsupplier'] = 'backend/Supplier/Showsupplier';
$route['apanel/Supplier/Addsupplier'] = 'backend/Supplier/Addsupplier';
$route['apanel/Supplier/Editsupplier/(:any)'] = 'backend/Supplier/Editsupplier/$1';
$route['apanel/Supplier/EditsupplierData/(:any)'] = 'backend/Supplier/EditsupplierData/$1';
$route['apanel/Supplier/Deletesupplier/(:any)'] = 'backend/Supplier/Deletesupplier/$1';
$route['apanel/product/supplier_changeStatus'] = 'backend/Supplier/supplier_changeStatus';
$route['apanel/Supplier/supplier_detail/(:any)'] = 'backend/Supplier/supplier_detail/$1';



//------------------------Landing page Routes------
$route['home'] = 'landing/home';
$route['signup'] = 'landing/signup';
$route['thankyou'] = 'landing/thankyou';



