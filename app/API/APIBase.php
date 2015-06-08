<?php namespace SocialCuratorGrid\API;

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

	public function __construct()
	{
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