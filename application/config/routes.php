<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
//$route['subestaciones/(:any)'] = 'subestaciones/home';
$route['subestaciones'] = 'subestaciones';
//$route['news/create'] = 'news/create';
//$route['subestaciones/(:any)'] = 'subestaciones/index';
$route['subestaciones/detalle/(:num)'] = 'subestaciones/detalle/$1';
$route['subestaciones/graficos/(:num)'] = 'subestaciones/graficos/$1';
$route['subestaciones/crear'] = 'subestaciones/crear';
$route['subestaciones/modificar/(:num)'] = 'subestaciones/modificar/$1';
//$route['news/(:any)'] = 'news/views/$1';
//$route['news'] = 'news';
$route['archivos/crear/(:num)/(:num)'] = 'archivos/mod_archivos/$1/$2';
$route['archivos/subir_cargas'] = 'archivos/subir_cargas';
$route['subestaciones/mod_sub'] = 'subestaciones/mod_sub';
$route['excel/importar'] = 'excel/importar_line';
$route['excel'] = 'excel';
$route['(:any)'] = 'subestaciones/index';
$route['default_controller'] = "subestaciones/index";
$route['404_override'] = '';



/* End of file routes.php */
/* Location: ./application/config/routes.php */