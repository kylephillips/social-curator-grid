<?php namespace SocialCuratorGrid;

/**
* Helper Functions
*/
class Helpers {

	/**
	* Plugin URL
	*/
	public static function plugin_url()
	{
		return plugins_url() . '/social-curator-grid';
	}

	/**
	* Plugin Root Directory
	*/
	public static function plugin_root()
	{
		return dirname(__FILE__);
	}

	/**
	* Plugin Base File
	*/
	public static function plugin_file()
	{
		return dirname( dirname(__FILE__) ) . '/social-curator-grid.php';
	}

	/**
	* View
	*/
	public static function view($file)
	{
		return dirname(__FILE__) . '/Views/' . $file . '.php';
	}

	/**
	* Get the Plugin Version
	*/
	public static function version()
	{
		global $social_curator_grid_version;
		return $social_curator_grid_version;
	}

}