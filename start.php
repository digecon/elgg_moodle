<?php

//page handler for main page of Moodle plugin
function moodle_page_handler(){
	include elgg_get_plugins_path() . 'moodle/pages/moodle/main.php';
}

function moodle_profile_updated($event, $object_type, $user)
{
	elgg_load_library('moodle:main');	
	moodle_update_profile_data($user);
}

function moodle_profile_icon_updated($event, $object_type, $user)
{
	elgg_load_library('moodle:main');	
	moodle_update_profile_picture($user);
}

function moodle_profile_role_updated($event, $object_type, $user)
{
	elgg_load_library('moodle:main');	
	moodle_update_role($user);
}

function moodle_profile_logined($event, $object_type, $user)
{
	elgg_load_library('moodle:main');	
	moodle_update_profile_data($user);
	moodle_update_profile_picture($user);
	moodle_update_role($user);
}


function moodle_init()
{
	//add a tab in site menu
	elgg_register_menu_item('site', new ElggMenuItem('moodle', elgg_echo('moodle:menuitem'), '/moodle'));
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('moodle','moodle_page_handler');	
	
	elgg_register_library('moodle:main', elgg_get_plugins_path() . 'moodle/lib/moodle.php');	
}

elgg_register_event_handler('init', 'system', 'moodle_init');
elgg_register_event_handler('profileupdate', 'user', 'moodle_profile_updated');
elgg_register_event_handler('profileiconupdate', 'user', 'moodle_profile_icon_updated');
elgg_register_event_handler('kmsroleupdate', 'user', 'moodle_profile_role_updated');
elgg_register_event_handler('login:after', 'user', 'moodle_profile_logined');


