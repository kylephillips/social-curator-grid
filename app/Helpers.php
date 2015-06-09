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

	/**
	* Convert string number to english word (for class naming)
	*/
	public static function convertNumber($number)
	{
		switch ($number) {
			case 1:
				return 'one';
				break;

			case 2:
				return 'two';
				break;

			case 3:
				return 'three';
				break;

			case 4:
				return 'four';
				break;

			case 5:
				return 'five';
				break;

			case 6:
				return 'six';
				break;

			default:
				return 2;
				break;
		}
	}

}