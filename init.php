<?php defined('SYSPATH') or die('No direct script access.');

Route::set('koig', 'koig/<size>(.<format>)') 
	->defaults(array(
		'controller' => 'koig',
		'action'     => 'dummy',
		'format' => 'gif',
	));
