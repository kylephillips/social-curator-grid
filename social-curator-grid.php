<?php
/*
Plugin Name: Social Curator Grid
Plugin URI: https://github.com/kylephillips/social-curator-grid
Description: Extends the Social Curator plugin with a masonry grid of social posts
Version: 0.0.1
Author: Kyle Phillips
Author URI: https://github.com/kylephillips
Text Domain: socialcuratorgrid
Domain Path: /languages/
License: GPLv2 or later.
Copyright: Kyle Phillips
*/

/*  Copyright 2015 Kyle Phillips  (email : kylephillipsdesign@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
* Adding Support for an API/site:
* 1) Add method in Config\SupportedSites with necessary keys
* 2) Add directory/namespace for site logic under Entities\Site.
* 3) Copy over an existing Feed directory into the new site and edit the three classes as needed.
* 4) The formatted feed should return an array, whose keys match existing feeds. See Entities\Site\Twitter\Feed\FeedFormatter for example
*/
    
/**
* Check that primary Social Curator plugin is installed before instantiating
*/
register_activation_hook( __FILE__, 'socialcuratorgrid_check' );

function socialcuratorgrid_check()
{
    if ( function_exists('social_curator_version') ) return;
    if ( function_exists('deactivate_plugins') ) deactivate_plugins( basename( __FILE__ ) );
    
    wp_die('<p>The <strong>Social Curator Grid</strong> plugin requires Social Curator to be installed. Please install and activate Social Curator before enabling this plugin.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
}

if( !class_exists('SocialCuratorGrid\Bootstrap') ) :
    require_once('vendor/autoload.php');
    require_once('app/SocialCuratorGrid.php');
    SocialCuratorGrid::init();
endif;