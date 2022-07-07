<?php 
/**
* Static Wrapper for Bootstrap Class
* Prevents T_STRING error when checking for 5.3.2
*/
class SocialCuratorGrid {

	public static function init()
	{
		global $social_curator_grid_version;
		$social_curator_grid_version = '1.0.1';

		$app = new SocialCuratorGrid\Bootstrap;
	}
}