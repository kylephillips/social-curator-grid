<?php namespace SocialCuratorGrid\Config;

use SocialCurator\Config\SettingsRepository as ParentRepository;

class SettingsRepository {

	/**
	* Whether to output CSS
	*/
	public function outputCSS()
	{
		$option = get_option('social_curator_grid_display');
		return ( isset($option['output_css']) && $option['output_css'] == '1' ) ? true : false;
	}

	/**
	* Are Twitter intents enabled?
	* @return boolean
	*/
	public function twitterIntents()
	{
		$option = get_option('social_curator_grid_twitter_intents');
		return ( $option ) ? true : false;
	}

	/**
	* Is a specific site enabled?
	* @param string
	* @return boolean
	*/
	public function siteEnabled($site)
	{
		$supported_sites = new ParentRepository;
		if ( !in_array($site, $supported_sites->getEnabledSites()) ) return false;
		return true;
	}

}