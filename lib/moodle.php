<?php

function moodle_update_profile_picture(ElggUser $user)
{
	
}

function moodle_update_profile_data(ElggUser $user)
{
	$moodle = new Moodle();
	$moodleUser = $moodle->findUser($user->email);
	if($moodleUser != null)
	{
		$moodle->query("core_user_update_users", array(array(
			'id' => $moodleUser->id,
			'city' => $user->location,
			'description' => $user->description,
			'descriptionformat' => 1,
			'url' => elgg_normalize_url("profile/".$user->username),
			'phone1' => $user->phone,
			'phone2' => $user->mobile
		)));
	}
		
}

function moodle_update_role(ElggUser $user)
{
	
}
