<?php namespace SocialCuratorGrid\Config;

class Activation {

	public function __construct()
	{
		$this->defaultOptions();
	}

	/**
	* Set Default Options
	*/
	private function defaultOptions()
	{
		if ( !is_admin() ) return;
		
		$version = \SocialCuratorGrid\Helpers::version();
		$display_option = get_option('social_curator_grid_display');

		if ( version_compare( $version, '1.1', '<' ) && !isset($display_option['set']) ){
			$display_option['set'] = '1';
			$display_option['output_css'] = '1';
			update_option('social_curator_grid_display', $display_option);
		}
	}

}