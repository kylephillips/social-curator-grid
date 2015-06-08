<?php namespace SocialCuratorGrid\API;

use SocialCuratorGrid\API\APIBase;
use SocialCuratorGrid\Helpers;

/**
* Register the Grid Shortcode
*/
class GridShortcode extends APIBase {

	public function __construct()
	{
		parent::__construct();
		add_shortcode('social_curator_grid', array($this, 'init'));
	}

	/**
	* Shortcode Options
	*/
	private function setOptions($options)
	{
		$this->options = shortcode_atts(array(
			'perpage' => '9', // How many posts to load per request
			'loadmore' => 'true', // Ability to load more into the grid?
			'loadmoretext' => __('Load More Posts', 'socialcuratorgrid'), // Text inside Load More Button
			'loadingtext' => __('Loading', 'socialcuratorgrid') // Active text for Load More Button
		), $options);
	}

	/**
	* Enqueue Script
	*/
	private function enqueueScript()
	{
		wp_enqueue_script(
			'social-curator-grid',
			Helpers::plugin_url() . '/assets/public/js/social-curator-grid.min.js', 
			array('jquery', 'masonry', 'social-curator'),
			$this->version
		);
		wp_localize_script( 
			'social-curator-grid', 
			'social_curator_grid', 
			array(
				'loading' => $this->options['loadingtext'],
				'loadmore' => $this->options['loadmoretext'],
				'perpage' => $this->options['perpage']
			)
		);
	}

	/**
	* Instantiate the Shortcode
	*/
	public function init($options)
	{
		$this->setOptions($options);
		$this->enqueueScript();
		include Helpers::view('grid/post-grid');
	}

	/**
	* Single Post Template
	* Check for a custom template in the theme
	*/
	private function postTemplate()
	{
		$custom_template = get_template_directory() . '/templates/social-curator-grid-post-template.php';
		if ( file_exists($custom_template) ) {
			include($custom_template);
			return;
		}
		include(\SocialCuratorGrid\Helpers::view('grid/single-post-template'));
	}

}