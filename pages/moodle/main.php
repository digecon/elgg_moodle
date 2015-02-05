<?php

// make sure only logged in users can see this page 
gatekeeper();

$moodle = new Moodle();
 
// render only login form
$content = elgg_view("forms/moodle/login", array(
	'moodle' => $moodle
));
 
// draw the page
echo $content;
die();
