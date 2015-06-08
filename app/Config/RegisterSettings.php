<?php namespace SocialCuratorGrid\Config;

/**
* Register the Plugin Settings
*/
class RegisterSettings {

	public function __construct()
	{
		add_action( 'admin_init', array( $this, 'registerSettings' ) );
	}

	/**
	* Register the settings
	*/
	public function registerSettings()
	{
		register_setting( 'social-curator-grid-general', 'social_curator_display' );
	}

}