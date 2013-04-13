<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

// admin
$route['import_export/admin/export(/:any)?']		= 'admin_export$1';
$route['import_export/admin/export_data(/:any)?']	= 'admin_export/export_data$1';
$route['import_export/admin/export_blog(/:any)?']	= 'admin_export/export_blog$1';
$route['import_export/admin/export_site(/:any)?']	= 'admin_export/export_site$1';