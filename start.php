<?php

//page handler for main page of Moodle plugin
function moodle_page_handler(){
	include elgg_get_plugins_path() . 'moodle/pages/moodle/main.php';
}

function moodle_profile_updated($event, $object_type, $user)
{
	elgg_load_library('moodle:main');	
	moodle_update_profile($user);
}


function moodle_init()
{
	//add a tab in site menu
	elgg_register_menu_item('site', new ElggMenuItem('moodle', elgg_echo('moodle:menuitem'), '/moodle'));
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('moodle','moodle_page_handler');	
	
	elgg_register_library('moodle:main', elgg_get_plugins_path() . 'moodle/lib/moodle.php');	
	
	$ref = $_SERVER["HTTP_REFERER"];
	$moodle = elgg_get_plugin_from_id('moodle');
	$moodle_host = parse_url($moodle->getSetting('server_url'), PHP_URL_HOST);
	if(strpos($ref, $moodle_host) !== false)
	{
		elgg_load_library('moodle:main');	
		$user = get_loggedin_user();
		if($user != null)
		{
			moodle_update_profile(get_loggedin_user());		
		}
	}
}

elgg_register_event_handler('init', 'system', 'moodle_init');
elgg_register_event_handler('profileupdate', 'user', 'moodle_profile_updated');
elgg_register_event_handler('profileiconupdate', 'user', 'moodle_profile_updated');
elgg_register_event_handler('kmsroleupdate', 'user', 'moodle_profile_updated');
//elgg_register_event_handler('login', 'user', 'moodle_profile_logined', 500);


