<?php namespace SocialCuratorGrid\API;

use SocialCuratorGrid\API\GridShortcode;

/**
* Build up the required API Classes
*/
class APIFactory {

	public function __construct()
	{
		new GridShortcode;
	}

}