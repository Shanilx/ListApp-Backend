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
$route['apanel/MemCacheR'] = 'backend/MemCacheR';
//$route['404_override'] = 'backend/login/page_not_found';
// $route['404_override'] = ;
$route['translate_uri_dashes'] = FALSE;


$route['apanel/product/(:num)'] = 'backend/product/index/$1';
$route['apanel/product/(:num)/(:num)'] = 'backend/product/index/$1/$2';

$route['apanel/product/add'] = 'backend/product/addProduct';
$route['apanel/product/getCompany'] = 'backend/product/getCompany';
$route['apanel/product/getSchedule'] = 'backend/product/getSchedule';
$route['apanel/product/getPackingtype'] = 'backend/product/getPackingtype';
$route['apanel/product/getPackSize'] = 'backend/product/getPackSize';
$route['apanel/product/getForm'] = 'backend/product/getForm';
$route['apanel/product/csv_upload_form'] = 'backend/product/csv_upload';
$route['apanel/product/upload_file_in_db'] = 'backend/product/upload_file_in_db';
$route['apanel/product/edit/(:any)'] = 'backend/product/editProduct/$1';
$route['apanel/product/detail/(:any)'] = 'backend/product/detailProduct/$1';
$route['apanel/product/delete/(:any)'] = 'backend/product/deleteProduct/$1';
$route['apanel/product/export_product_detail'] = 'backend/product/exports_data';
$route['apanel/product/sample_exports_data'] = 'backend/product/sample_exports_data';
$route['apanel/product/product_detail/(:any)'] = 'backend/product/product_detail/$1';
$route['apanel/product/product_changeStatus'] = 'backend/product/product_changeStatus';
$route['apanel/product/check_product_name'] = 'backend/product/check_product_name';
$route['apanel/product/check_product_and_form_combination'] = 'backend/product/check_product_and_form_combination';
$route['apanel/product/deleteMultiple'] = 'backend/product/deleteMultiple';
$route['apanel/product/deletebyfilter'] = 'backend/product/deletebyfilter';

$route['apanel/product/ajaxDataTable'] = 'backend/product/ajaxDataTable_get';


//------------------------Supplier Routes------
$route['apanel/Supplier'] = 'backend/Supplier/index';
$route['apanel/Supplier/getAllcities'] = 'backend/Supplier/getAllcities';

$route['apanel/Supplier/Showsupplier'] = 'backend/Supplier/Showsupplier';
$route['apanel/Supplier/AddBulkProduct/(:any)'] = 'backend/Supplier/AddBulkProduct/$1';
$route['apanel/Supplier/Product/(:any)'] = 'backend/Supplier/Product/$1';
$route['apanel/Supplier/upload_bulk_product'] = 'backend/Supplier/upload_bulk_product';
$route['apanel/Supplier/Addsupplier'] = 'backend/Supplier/Addsupplier';
$route['apanel/Supplier/Editsupplier/(:any)'] = 'backend/Supplier/Editsupplier/$1';
$route['apanel/Supplier/EditsupplierData/(:any)'] = 'backend/Supplier/EditsupplierData/$1';
$route['apanel/Supplier/Deletesupplier/(:any)'] = 'backend/Supplier/Deletesupplier/$1';
$route['apanel/Supplier/supplier_changeStatus'] = 'backend/Supplier/supplier_changeStatus';
$route['apanel/Supplier/supplier_detail/(:any)'] = 'backend/Supplier/supplier_detail/$1';
$route['apanel/Supplier/ajaxDataTableSupplier'] = 'backend/Supplier/ajaxDataTableSupplier';
$route['apanel/changestatus'] = 'backend/Supplier/changestatus';

//------------------------Retailer Routes------
$route['apanel/Retailer'] = 'backend/Retailer/index';
$route['apanel/Retailer/getAllcities'] = 'backend/Retailer/getAllcities';

$route['apanel/Retailer/Showretailer'] = 'backend/Retailer/Showretailer';
$route['apanel/Retailer/Addretailer'] = 'backend/Retailer/Addretailer';
$route['apanel/Retailer/Editretailer/(:any)'] = 'backend/Retailer/Editretailer/$1';
$route['apanel/Retailer/EditretailerData/(:any)'] = 'backend/Retailer/EditretailerData/$1';
$route['apanel/Retailer/Deleteretailer/(:any)'] = 'backend/Retailer/Deleteretailer/$1';
$route['apanel/Retailer/retailer_changeStatus'] = 'backend/Retailer/retailer_changeStatus';
$route['apanel/Retailer/retailer_detail/(:any)'] = 'backend/Retailer/retailer_detail/$1';
$route['apanel/Retailer/ajaxDataTableRetailer'] = 'backend/Retailer/ajaxDataTableRetailer';
$route['apanel/Retailer/check_emial_mobile'] = 'backend/Retailer/check_emial_mobile';


//------------------------Company Routes------
$route['apanel/Company'] = 'backend/Company/index';
$route['apanel/Company/add'] = 'backend/Company/add';
$route['apanel/Company/Addcompany'] = 'backend/Company/Addcompany';
$route['apanel/Company/Editcompany/(:any)'] = 'backend/Company/Editcompany/$1';
$route['apanel/Company/EditData/(:any)'] = 'backend/Company/EditData/$1';
$route['apanel/company/Deletecompany/(:any)'] = 'backend/Company/Deletecompany/$1';
$route['apanel/company/check_company_name'] = 'backend/Company/check_company_name';
$route['apanel/Company/Company_changeStatus'] = 'backend/Company/Company_changeStatus';
$route['apanel/Company/ajaxDataTableCompany'] = 'backend/Company/ajaxDataTableCompany';

//------------------------Schedule Routes------
$route['apanel/Schedule'] = 'backend/Schedule/index';
$route['apanel/Schedule/add'] = 'backend/Schedule/add';
$route['apanel/Schedule/AddSchedule'] = 'backend/Schedule/AddSchedule';
$route['apanel/Schedule/EditSchedule/(:any)'] = 'backend/Schedule/EditSchedule/$1';
$route['apanel/Schedule/EditData/(:any)'] = 'backend/Schedule/EditData/$1';
$route['apanel/Schedule/DeleteSchedule/(:any)'] = 'backend/Schedule/Deleteschedule/$1';
$route['apanel/Schedule/check_shedule_name'] = 'backend/Schedule/check_shedule_name';
$route['apanel/Schedule/Schedule_changeStatus'] = 'backend/Schedule/Schedule_changeStatus';
$route['apanel/Schedule/ajaxDataTableSchedule'] = 'backend/Schedule/ajaxDataTableSchedule';

//------------------------Packingtype Routes------
$route['apanel/Packingtype'] = 'backend/Packingtype/index';
$route['apanel/Packingtype/checkName'] = 'backend/Packingtype/checkName';
$route['apanel/Packingtype/add'] = 'backend/Packingtype/add';
$route['apanel/Packingtype/AddPackingtype'] = 'backend/Packingtype/AddPackingtype';
$route['apanel/Packingtype/EditPackingtype/(:any)'] = 'backend/Packingtype/EditPackingtype/$1';
$route['apanel/Packingtype/EditData/(:any)'] = 'backend/Packingtype/EditData/$1';
$route['apanel/Packingtype/DeletePackingtype/(:any)'] = 'backend/Packingtype/DeletePackingtype/$1';
$route['apanel/Packingtype/Packingtype_changeStatus'] = 'backend/Packingtype/Packingtype_changeStatus';
$route['apanel/Packingtype/ajaxDataTablePacking'] = 'backend/Packingtype/ajaxDataTablePacking';

//------------------------Form Routes------
$route['apanel/Form'] = 'backend/Form/index';
$route['apanel/Form/add'] = 'backend/Form/add';
$route['apanel/Form/checkName'] = 'backend/Form/checkName';
$route['apanel/Form/Add_Form'] = 'backend/Form/Add_Form';
$route['apanel/Form/Edit_Form/(:any)'] = 'backend/Form/Edit_Form/$1';
$route['apanel/Form/Edit_Form_Data/(:any)'] = 'backend/Form/Edit_Form_Data/$1';
$route['apanel/Form/DeleteForm/(:any)'] = 'backend/Form/DeleteForm/$1';
$route['apanel/Form/Form_changeStatus'] = 'backend/Form/Form_changeStatus';
$route['apanel/Form/ajaxDataTableForm'] = 'backend/Form/ajaxDataTableForm';

//------------------------Pack Size Routes------
$route['apanel/Packsize'] = 'backend/Pack_Size/index';
$route['apanel/Packsize/checkName'] = 'backend/Pack_Size/checkName';
$route['apanel/Packsize/add'] = 'backend/Pack_Size/add';
$route['apanel/Packsize/Add_pack_size'] = 'backend/Pack_Size/Add_pack_size';
$route['apanel/Packsize/Edit_pack_size/(:any)'] = 'backend/Pack_Size/Edit_pack_size/$1';
$route['apanel/Packsize/Edit_packsize_Data/(:any)'] = 'backend/Pack_Size/Edit_packsize_Data/$1';
$route['apanel/Packsize/DeletePacksize/(:any)'] = 'backend/Pack_Size/DeletePacksize/$1';
$route['apanel/Packsize/Packsize_changeStatus'] = 'backend/Pack_Size/Packsize_changeStatus';
$route['apanel/Packsize/ajaxDataTablePacksize'] = 'backend/Pack_Size/ajaxDataTablePacksize';//------------------------Pack Size Notification------
$route['apanel/Notification'] = 'backend/Notification/index';
$route['apanel/Notification/Add'] = 'backend/Notification/Add_Notification';
$route['apanel/Notification/Add_Notification'] = 'backend/Notification/Add_Notification';
$route['apanel/Notification/DeleteNotification/(:any)'] = 'backend/Notification/DeleteNotification/$1';
$route['apanel/Notification/ajaxDataTableNotification'] = 'backend/Notification/ajaxDataTableNotification';
$route['apanel/Notification/Notification_detail/(:any)'] = 'backend/Notification/Notification_detail/$1';
//------------------------ Routes For LOg Data------------------
$route['apanel/Log-data'] = 'backend/Log_data/index';
$route['apanel/Log-data/Delete/(:any)'] = 'backend/Log_data/DeleteLog_data/$1';
$route['apanel/Log-data/ajaxDataTableLog'] = 'backend/Log_data/ajaxDataTableLog';


//-----------------------Backend Routes for Admin--------
$route['apanel'] = 'backend/login';
$route['apanel/logout'] = 'backend/login/logout';
$route['apanel/dashboard'] = 'backend/login/dashboard';
$route['apanel/profile'] = 'backend/login/profile';

//--------------------------Managedata Routes For Admin-------------
 $route['apanel/Managedata'] = 'backend/Managedata/index';
 $route['apanel/Managedata/ajaxDataTable'] = 'backend/Managedata/ajaxDataTable_get';
 $route['apanel/Managedata/ajaxDataTable'] = 'backend/Managedata/ajaxDataTable_get';

//-----------------------Backend Routes for API USER LOGIN--------

 $route['user/login'] = 'backend_api/Login_API/UserLogin';

//-----------------------Backend Routes for API--------
 /* Slider management */
 $route['apanel/slider-list'] = 'backend/ManageSlider';
 $route['apanel/slider-add'] = 'backend/ManageSlider/add';
 $route['apanel/slider-upload'] = 'backend/ManageSlider/addSlider';
 $route['apanel/slider-edit/(:any)'] = 'backend/ManageSlider/edit/$1';
 $route['apanel/slider-update/(:any)'] = 'backend/ManageSlider/updateSlider/$1';
 $route['apanel/slider-delete/(:any)'] = 'backend/ManageSlider/DeleteSliderData/$1';


