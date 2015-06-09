<?php namespace SocialCuratorGrid\API;

use SocialCuratorGrid\Config\SettingsRepository;

/**
* Base class for API Classes
*/
abstract class APIBase {

	/**
	* Shortcode Options
	*/
	protected $options;

	/**
	* Plugin Version
	*/
	protected $version;

	/**
	* Settings Repository
	*/
	protected $settings_repo;

	public function __construct()
	{
		$this->settings_repo = new SettingsRepository;
		$this->setVersion();
	}

	/**
	* Set the Plugin Version
	*/
	protected function setVersion()
	{
		$this->version = \SocialCuratorGrid\Helpers::version();
	}

}