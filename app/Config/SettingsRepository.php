<?php namespace SocialCuratorGrid\Config;

use SocialCurator\Config\SettingsRepository as ParentRepository;
use SocialCurator\Helpers;

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

	/**
	* Get the Fallback Avatar
	*/
	public function fallbackAvatar($return_url = true)
	{
		$default_url = Helpers::plugin_url() . '/assets/images/avatar-fallback.png';
		$option = get_option('social_curator_fallback_avatar');
		if ( !$option && !$return_url) return false;
		if ( !$option && $return_url ) return $default_url;
		if ( !$option ) return '<img src="' . $default_url . '" />';
		if ( $return_url ) return $option;
		return '<img src="' . $option . '" />';
	}

}