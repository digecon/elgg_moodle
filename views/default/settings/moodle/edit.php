<?php
/**
 * moodle plugin settings
 */

$moodle = new Moodle();

$moodle_url_label = elgg_echo('moodle:server_url');
$moodle_url_input = elgg_view('input/text', array(
		'name' => 'params[server_url]',
		'id' => 'moodle_server_url',
		'value' => $vars['entity']->server_url
));

$moodle_apikey_label = elgg_echo('moodle:apikey');
$moodle_apikey_input = elgg_view('input/text', array(
		'name' => 'params[apikey]',
		'id' => 'moodle_apikey',
		'value' => $vars['entity']->apikey
));

$security_salt_label = elgg_echo('moodle:security_salt');
$security_salt_input = elgg_view('input/text', array(
		'name' => 'params[security_salt]',
		'id' => 'moodle_security_salt',
		'value' => $moodle->getSalt()
));


echo <<<___HTML


<div>
<label for="moodle_server_url">$moodle_url_label</label>
$moodle_url_input
</div>

<div>
<label for="moodle_apikey">$moodle_apikey_label</label>
$moodle_apikey_input
</div>

<div>
<label for="moodle_security_salt">$security_salt_label</label>
$security_salt_input
</div>


___HTML;

