<?php namespace SocialCuratorGrid\API;

use SocialCuratorGrid\API\APIBase;

/**
* Register the Grid Shortcode
*/
class GridShortcode extends APIBase {

	public function __construct()
	{
		parent::__construct();
		add_shortcode('social_curator_post_grid', array($this, 'init'));
	}

	/**
	* Shortcode Options
	*/
	private function setOptions($options)
	{
		$this->options = shortcode_atts(array(
			'number' => '9',
			'loadmore' => 'true',
			'loadmoretext' => __('Load More Posts', 'socialcurator'),
			'loadingtext' => __('Loading', 'socialcurator')
		), $options);
	}

	/**
	* Enqueue Script
	*/
	private function enqueueScript()
	{
		wp_enqueue_script(
			'social-curator-grid',
			Helpers::plugin_url() . '/assets/js/public/social-curator-post-grid.min.js', 
			array('jquery', 'masonry'),
			$this->version
		);
		wp_localize_script( 
			'social-curator-grid', 
			'social_curator_grid', 
			array(
				'loading' => $this->options['loadingtext'],
				'loadmore' => $this->options['loadmoretext']
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
		include Helpers::view('api/post-grid');
	}

}