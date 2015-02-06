<?php

function moodle_update_profile_picture(ElggUser $user)
{
	$moodle = new Moodle();
	$moodleUser = $moodle->findUser($user->email);
	if($moodleUser != null)
	{
		//http://kmstest.dig.center/mod/profile/icondirect.php?lastcache=1423189472&joindate=1419540682&guid=97&size=large
		$moodle->query("core_user_update_users", array(
			'users' => array(
				array(
					'id' => $moodleUser->id,
					'preferences' => array(
						'picture_url' =>
						array(
							'type' => 'picture_url',
							'value' => $user->getIconURL('medium')
						)
					)					
				)
			)

		));					
		
		/*$icon = $user->getIconURL($size);
		if(strpos($icon, 'defaultlarge') === false)
		{
			$moodle->query("local_kms_update_profile_picture", array(
				'email' => $user->email,
				'picture' => file_get_contents($icon)
			));			
		}*/
		/*
		$icon = $user->getIconURL($size);
		$contents = 		*/
	}	
}

function moodle_update_profile_data(ElggUser $user)
{
	$moodle = new Moodle();
	$moodleUser = $moodle->findUser($user->email);
	if($moodleUser != null)
	{
		$moodle->query("core_user_update_users", array(
			'users' => 
				array(
					array(
						'id' => $moodleUser->id,
						'city' => $user->location,
						'description' => strip_tags($user->description),
						'url' => elgg_normalize_url("profile/".$user->username),
						'phone1' => $user->phone,
						'phone2' => $user->mobile
					)
				)
		));
	}
		
}

function moodle_update_role(ElggUser $user)
{
	
}
