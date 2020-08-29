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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin/internal/user/add'] = 'admin/add_user';
$route['admin/internal/user/save']['post'] = 'admin/save_user';
$route['admin/internal/user/list'] = 'admin/view_users';
$route['admin/internal/user/change_pass/(:num)'] = 'admin/change_pass/$1';
$route['admin/internal/user/(:num)/edit'] = 'admin/edit_users/$1';
$route['admin/internal/user/save']['post'] = 'admin/edit_save_user';

$route['admin/internal/tasks'] = 'admin/view_tasks';
$route['admin/internal/tasks/delete/(:num)'] = 'admin/delete_task/$1';

$route['admin/internal/task/report/add'] = 'admin/task_report_add';
$route['admin/internal/task/report/save']['post'] = 'admin/task_report_save';

//$route['user/change_password'] = 'admin/view_tasks';

$route['task/add/future'] = 'task/add_future_task';
$route['task/add/future/save']['post'] = 'task/save_future_task';