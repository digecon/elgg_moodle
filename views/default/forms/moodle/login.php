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
	'name' => 'username', 
	'value' => $userdata->username
));

echo elgg_view('input/password', array(
	'name' => 'password', 
	'value' => $userdata->password
)); 

echo elgg_view('input/submit', array(
	'id' => 'submit_button', 
	'value' => elgg_echo('login')
));

?>	
</form>
</body>
</html>
