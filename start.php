<?php

//page handler for main page of Moodle plugin
function moodle_page_handler(){
	include elgg_get_plugins_path() . 'moodle/pages/moodle/main.php';
}

function moodle_init()
{
	//add a tab in site menu
	elgg_register_menu_item('site', new ElggMenuItem('moodle', elgg_echo('moodle:menuitem'), '/moodle'));
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('moodle','moodle_page_handler');	
}

elgg_register_event_handler('init', 'system', 'moodle_init');