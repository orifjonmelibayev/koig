<?php defined('SYSPATH') or die('No direct script access.');

Route::set('koig', 'koig/<width>(/<height>)(/<bg>(/<fg>(/<text>(/<text_angle>))))') //, array('width' => '[0-9].+','height' => '[0-9].+'))
	->defaults(array(
		'controller' => 'koig',
		'action'     => 'dummy',
		'height'     => 0,
		'bg'     => '000000',
		'fg'     => 'ffffff',
		'text'     => '',
		'text_angle'     => 0,
		'text_angle'     => 0,
		'format' => 'gif',
	));