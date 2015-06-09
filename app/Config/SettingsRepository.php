<?php namespace SocialCuratorGrid\Config;

class SettingsRepository {

	/**
	* Whether to output CSS
	*/
	public function outputCSS()
	{
		$option = get_option('social_curator_grid_display');
		return ( isset($option['output_css']) && $option['output_css'] == '1' ) ? true : false;
	}

}