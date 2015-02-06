<?php

function moodle_update_profile(ElggUser $user)
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
					'city' => $user->location,
					'description' => $user->description,
					'url' => elgg_normalize_url("profile/".$user->username),
					'phone1' => $user->phone,
					'phone2' => $user->mobile,
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
		
		$role = kms_get_user_role($user);
		$config = include(dirname(__DIR__)."/config.php");
		
		$assign = array();
		$unassign = array();
		
		foreach($config as $role_name => $role_id)
		{
			if($role_name == $role)
			{
				$assign[] = array(
					'roleid' => $role_id,
					'userid' => $moodleUser->id,
					'contextid' => 1
				);
			}
			else
			{
				$unassign[] = array(
					'roleid' => $role_id,
					'userid' => $moodleUser->id,
					'contextid' => 1
				);
			}
		}
		//core_role_unassign_roles 
		
		$moodle->query("core_role_unassign_roles", array(
			'unassignments' => $unassign
		));
		
		$moodle->query("core_role_assign_roles", array(
			'assignments' => $assign
		));				
	}	
}
