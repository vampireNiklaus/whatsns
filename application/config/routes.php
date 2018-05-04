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
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['tag-(:any)'] = 'question/search/$1';//对标签重写
$route['article-(:num)'] = 'Topic/getone/$1';//对文章重写
$route['article-(:num)-(:num)'] = 'Topic/getone/$1/$2';//对文章重写
$route['cat-(:num)'] = 'Topic/catlist/$1';//对文章分类重写
$route['cat-(:num)/(:num)'] = 'Topic/catlist/$1/$2';//对文章分类重写
$route['q-(:num)'] = 'Question/view/$1';//对问题重写
$route['q-(:num)/(:num)'] = 'Question/view/$1/$2';//对问题重写
$route['u-(:num)'] = 'User/space/$1';//对用户空间重写
$route['u-(:num)/(:num)'] = 'User/space/$1/$2';//对用户空间重写
$route['c-(:num)'] = 'Category/view/$1';//对分类详情url重写
$route['c-(:num)/(:any)'] ='Category/view/$1/$2';//对分类重写
$route['c-(:num)/(:any)/(:num)'] ='Category/view/$1/$2/$3';//对分类重写
$route['ua-(:num)'] = 'User/space_answer/$1';//对用户空间用户回答重写
$route['ua-(:num)/(:num)'] = 'User/space_answer/$1/$2';//对用户空间用户回答重写
$route['uask-(:num)/(:num)'] = 'User/space_ask/$1/$2';//对用户空间用户提问重写
$route['uask-(:num)'] = 'User/space_ask/$1';//对用户空间用户提问重写
$route['ut-(:num)'] = 'Topic/userxinzhi/$1';//对用户空间用户文章url重写
$route['ut-(:num)/(:num)'] = 'Topic/userxinzhi/$1/$2';//对用户空间用户文章url重写
$route['new'] = 'Newpage/index';
$route['new/maketag'] = 'Newpage/maketag';
$route['new/default'] = 'Newpage/index';
$route['note/list'] = 'Note/clist';
$route['rss/list'] = 'Rss/clist';
$route['Api_article/list'] = 'Api_article/clist';
$route['pccaiji_catgory/list'] = 'Pccaiji_catgory/clist';