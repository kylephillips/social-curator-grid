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
			'allowmore' => 'true', // Ability to load more into the grid?
			'loadmoretext' => __('Load More Posts', 'socialcuratorgrid'), // Text inside Load More Button
			'loadingtext' => __('Loading', 'socialcuratorgrid'), // Active text for Load More Button
			'iconprefix' => 'social-curator-icon-', // Customize the icon prefix. Will be appended with site name, lowercase, with dashed spaces
			'masonry' => 'true', // Whether to enable masonry
			'masonrycolumns' => '2', // how many columns in the grid
			'completetext' => __('No More Posts', 'socialcuratorgrid'),
			'favoriteicon' => 'star', // star vs heart
			'thumbnailsonly' => 'false', // only include posts with thumbnails
			'thumbnailsize' => 'full', // thumbnail size to pull
		), $options);
	}

	/**
	* Enqueue Script
	*/
	private function enqueueScript()
	{
		$dependencies = array('jquery', 'social-curator');
		if ( $this->options['masonry'] == 'true' ) $dependencies[] = 'masonry';
		wp_enqueue_script(
			'social-curator-grid',
			Helpers::plugin_url() . '/assets/public/js/social-curator-grid.min.js', 
			$dependencies,
			$this->version
		);
		wp_localize_script( 
			'social-curator-grid', 
			'social_curator_grid', 
			array(
				'loading' => $this->options['loadingtext'],
				'loadmore' => $this->options['loadmoretext'],
				'perpage' => $this->options['perpage'],
				'iconprefix' => $this->options['iconprefix'],
				'masonry' => $this->options['masonry'],
				'masonrycolumns' => Helpers::convertNumber(intval($this->options['masonrycolumns'])),
				'completetext' => $this->options['completetext'],
				'twitterintents' => $this->settings_repo->twitterIntents(),
				'defaultavatar' => $this->settings_repo->fallbackAvatar(),
				'thumbnailsonly' => $this->options['thumbnailsonly'],
				'thumbnailsize' => $this->options['thumbnailsize']
			)
		);
	}

	/**
	* Enqueue Twitter Intents
	*/
	public function twitterIntents()
	{
		if ( !$this->settings_repo->twitterIntents() ) return;
		wp_enqueue_script(
			'twitter-intents',
			'//platform.twitter.com/widgets.js', 
			array(),
			$this->version,
			true
		);
	}

	/**
	* Enqueue Styles
	*/
	private function enqueueStyle()
	{
		if ( !$this->settings_repo->outputCss() ) return;
		wp_enqueue_style( 
			'social-curator-grid', 
			Helpers::plugin_url() . '/assets/public/css/social-curator-grid.css', 
			array(), 
			$this->version
		);
	}

	/**
	* Instantiate the Shortcode
	*/
	public function init($options)
	{
		$this->setOptions($options);
		$this->enqueueScript();
		$this->twitterIntents();
		$this->enqueueStyle();
		include Helpers::view('grid/post-grid');
	}

	/**
	* Single Post Template
	* Check for a custom template in the theme, default to plugin template
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

	/**
	* Twitter Intents Template
	* Check for a custom template in the theme, default to plugin template
	*/
	private function twitterIntentsTemplate()
	{
		if ( !$this->settings_repo->twitterIntents() ) return;
		$custom_template = get_template_directory() . '/templates/social-curator-grid-twitter-intents-template.php';
		if ( file_exists($custom_template) ) {
			include($custom_template);
			return;
		}
		include(\SocialCuratorGrid\Helpers::view('grid/twitter-intents'));
	}

	/**
	* Loading GIF/State
	* Allows customization of loading content
	*/
	private function loading()
	{
		$loading = '<img src="' . Helpers::plugin_url() . '/assets/public/images/loading.gif' . '" alt="' . __('Loading', 'socialcuratorgrid') . '" />';
		return apply_filters('social_curator_grid_loading_content', $loading);
	}

}