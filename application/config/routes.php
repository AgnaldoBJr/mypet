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

$route['default_controller'] = 'mypet';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Website
$route['animais'] = 'website/animaisweb';
$route['entrar'] = 'mypet/entrar';
$route['cadastrar'] = 'mypet/cadastrar';
$route['agendar'] = 'mypet/agendar';
$route['logout'] = 'mypet/logout';

$route['clientes'] = 'website/clientesweb';
$route['clientes/editar-dados'] = 'website/clientesweb/editarDados';
$route['clientes/editar-animal'] = 'website/clientesweb/editarAnimal';
$route['clientes/excluir-animal'] = 'website/clientesweb/excluirAnimal';
$route['clientes/novo-animal'] = 'website/clientesweb/novoAnimal';

//Sistema
$route['sistema'] = 'sistema/login/redirecionar';
$route['sistema/agendamentos'] = 'sistema/agendamentos';

$route['sistema/clientes'] = 'sistema/clientes';
$route['sistema/clientes/novo'] = 'sistema/clientes/novo';
$route['sistema/clientes/editar'] = 'sistema/clientes/editar';
$route['sistema/clientes/excluir'] = 'sistema/clientes/excluir';

$route['sistema/users'] = 'sistema/users';
$route['sistema/users/novo'] = 'sistema/users/novo';
$route['sistema/users/editar'] = 'sistema/users/editar';
$route['sistema/users/excluir'] = 'sistema/users/excluir';

$route['sistema/animais'] = 'sistema/animais';
$route['sistema/animais/novo'] = 'sistema/animais/novo';
$route['sistema/animais/editar'] = 'sistema/animais/editar';
$route['sistema/animais/excluir'] = 'sistema/animais/excluir';

$route['sistema/dashboard'] = 'sistema/dashboard';
$route['sistema/servicos'] = 'sistema/servicos';

$route['sistema/login'] = 'sistema/login';
$route['sistema/login/entrar'] = 'sistema/login/entrar';
$route['sistema/logout'] = 'sistema/login/logout';
$route['sistema/(:any)'] = 'sistema/dashboard';

$route['(:any)'] = 'mypet';
