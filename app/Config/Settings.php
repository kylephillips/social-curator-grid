<?php namespace SocialCuratorGrid\Config;

use SocialCuratorGrid\Config\SettingsRepository;
use SocialCuratorGrid\Helpers;

/**
* Plugin Settings
*/
class Settings {

	/**
	* Settings Repository
	* @var SocialCuratorGrid\Config\SettingsRepository
	*/
	private $settings_repo;

	public function __construct()
	{
		$this->settings_repo = new SettingsRepository;
		add_action('admin_menu', array($this, 'registerSettingsPage'));
	}

	/**
	* Register the settings page
	*/
	public function registerSettingsPage()
	{
		add_options_page( 
			__('Social Curator Grid Settings', 'socialcurator'),
			__('Social Curator Grid', 'socialcurator'),
			'manage_options',
			'social-curator-grid-settings', 
			array( $this, 'settingsPage' ) 
		);
	}

	/**
	* Display the Settings Page
	* Callback for registerSettingsPage method
	*/
	public function settingsPage()
	{
		include( Helpers::view('settings/settings') );
	}

}