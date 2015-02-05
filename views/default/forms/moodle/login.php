<?php
/* @var $moodle Moodle */

/**
 * Moodle login form
 */
$moodle = $vars['moodle'];
$login_url = $moodle->getUrl() . '/login/index.php';
$userdata = $moodle->getUserData();

?>
<html>
<body onload="document.forms.submit_form.submit();">
<h1><?php echo elgg_echo("moodle:wait")?></h1>
<form method="post" action="<?php echo $login_url; ?>" name="submit_form" style="display:none;">
<?php 

echo elgg_view('input/text', array(
	'name' => 'openid_url', 
	'value' => elgg_normalize_url("profile/".$userdata['username'])
));

?>	
</form>
</body>
</html>
