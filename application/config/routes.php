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
$route['subestaciones'] = 'subestaciones';
$route['subestaciones/detalle/(:num)'] = 'subestaciones/detalle/$1';
$route['subestaciones/cargas/(:num)'] = 'subestaciones/cargas/$1';
$route['subestaciones/graficos/(:num)/(:any)'] = 'subestaciones/graficos/$1/$2';
$route['subestaciones/crear_trans'] = 'subestaciones/crear_trans';
$route['subestaciones/set_trans'] = 'subestaciones/set_trans';
$route['subestaciones/crear_sub'] = 'subestaciones/crear_sub';
$route['subestaciones/subir_archivo'] = 'subestaciones/subir_archivo';
$route['subestaciones/galeria/(:num)'] = 'subestaciones/galeria/$1';
$route['subestaciones/borrar_fotos'] = 'subestaciones/borrar_fotos';
//$route['subestaciones/mod_sub'] = 'subestaciones/mod_sub';
$route['graficos_control/graficosDatos'] = 'graficos_control/graficosDatos';

$route['archivos/crear/(:num)/(:num)'] = 'archivos/mod_archivos/$1/$2';
$route['archivos/subir_cargas'] = 'archivos/subir_cargas';
$route['archivos/mantenimiento'] = 'archivos/mant_archivos';
$route['archivos/set_archivo'] = 'archivos/set_archivo';
//$route['excel'] = 'excel';
//$route['excel/importar'] = 'excel/importar_line';
$route['login'] = 'login/index';
$route['login/new_user'] = 'login/new_user';
$route['login/logout_ci'] = 'login/logout_ci';
$route['login/crear_user'] = 'login/crear_user';
$route['login/cambio_pass'] = 'login/cambio_pass';
$route['login/guest_login'] = 'login/guest_login';
$route['cambioPassword'] = 'login/cambioPassword';

$route['admin/usuarios'] = 'login/admin_users';
//$route['admin/traer_users'] = 'login/get_data';
$route['sistema/mod_sistema'] = 'sistema/mod_sistema';
$route['sistema/mod_sistema_action'] = 'sistema/mod_sistema_action';

$route['(:any)'] = 'subestaciones/index';
$route['default_controller'] = "login/index";
$route['404_override'] = '';



/* End of file routes.php */
/* Location: ./application/config/routes.php */