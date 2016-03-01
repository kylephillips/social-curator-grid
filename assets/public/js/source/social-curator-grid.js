/**
* Function fires once a post has been loaded, before being appended to the grid
* @param array data - post data
* @param object element - New DOM element
*/
function social_curator_grid_post_preloaded(element, data){}

/**
* Function fires once a post has been loaded and appended to the grid
* @param array data - post data
* @param object element - New DOM element
*/
function social_curator_grid_post_loaded(data, element){}




/**
* To use data from the social curator plugin, you must add social-curator as a dependency when enqueuing the script.
* Use the nonce generator from the primary plugin to generate a nonce dynamically, and pass a callback function as a parameter.
* This ensures the nonce will be injected and available before any dependent scripts are run.
*/
jQuery(function($){

$(document).ready(function(){
	var nonce = new SocialCuratorNonce;
	nonce.injectNonce(loadGrid);

	/**
	* Callback function after nonce has been generated and injected
	*/
	function loadGrid()
	{
		var postgrid = new socialCuratorGrid(jQuery('[data-social-curator-post-grid]'));
		postgrid.init();
	}

});

/**
* The Primary Grid Object
*/
var socialCuratorGrid = function(el, options)
{
	var grid = this;
	
	grid.o = {
		el : el,
		btn : $('[data-load-more-posts]'),
		loading : $('[data-social-curator-grid-loading]'),
		offset : 0,
		numberposts : parseInt(social_curator_grid.perpage),
		masonry : ( social_curator_grid.masonry == 'true' ) ? true : false,
		columns : ( social_curator_grid.masonrycolumns ) ? social_curator_grid.masonrycolumns : 'two',
		completetext : social_curator_grid.completetext,
		footer : $('[data-social-curator-grid-footer]'),
		thumbnailsonly : (  social_curator_grid.thumbnailsonly === 'true' ) ? true : false
	}

	/**
	* Init
	*/
	grid.init = function()
	{
		if ( grid.o.masonry ) {
			$(grid.o.el).addClass('masonry-grid');
			$(grid.o.el).addClass(grid.o.columns);
		}
		grid.bindEvents();
		grid.getPosts();
	}

	/**
	* Bind Events
	*/
	grid.bindEvents = function()
	{
		$(grid.o.btn).on('click', function(e){
			e.preventDefault();
			grid.getPosts();
		});
	}

	/**
	* Get Social Posts
	*/
	grid.getPosts = function()
	{
		grid.loading(true);
		$.ajax({
			url: social_curator.ajaxurl,
			type: 'POST',
			data: {
				nonce : social_curator_nonce,
				action: 'social_curator_get_posts',
				offset: grid.o.offset,
				number: grid.o.numberposts,
				thumbnailsonly: grid.o.thumbnailsonly
			},
			success: function(data){
				grid.o.offset = grid.o.offset + grid.o.numberposts;
				grid.loadPosts(data.posts);
			}
		});
	}

	/**
	* Load Posts into the view
	*/
	grid.loadPosts = function(posts)
	{
		for ( var i = 0; i < posts.length; i++ ){
			var post = new socialCuratorGridPost;
			var newpost = post.format(posts[i]);
			if ( grid.o.masonry ){
				grid.applyMasonry(newpost);
			} else {
				$(grid.o.el).append(newpost);
			}
			social_curator_grid_post_loaded(posts[i], newpost);
		}
		if ( posts.length < grid.o.numberposts ) return grid.noPosts();
		grid.loading(false);
	}

	/**
	* No more posts to load
	*/
	grid.noPosts = function()
	{
		grid.loading(false);
		$(grid.o.btn).remove();
		$(grid.o.footer).text(grid.o.completetext);
	}

	/**
	* Add / Remove Loading Indication
	*/
	grid.loading = function(loading)
	{
		if ( loading ){
			$(grid.o.loading).show();
			$(grid.o.btn).attr('disabled', 'disabled').html(social_curator_grid.loading).addClass('loading');
			return;
		}

		$(grid.o.loading).hide();
		$(grid.o.btn).attr('disabled', false).html(social_curator_grid.loadmore).removeClass('loading');
	}

	/**
	* Apply Masonry
	*/
	grid.applyMasonry = function(append)
	{
		var $masonry_container = $(grid.o.el).masonry({
			itemSelector: '[data-template]',
			percentPosition: true ,
			gutter: '.gutter-sizer'
		});
		$masonry_container.imagesLoaded(function(){
			$masonry_container.masonry();
		});
		if ( append ) $masonry_container.append( append ).masonry( 'appended', append );
	}
}



/**
* A single post
*/
var socialCuratorGridPost = function()
{
	var post = this;
	post.template = $('[data-single-post-template]').find('[data-template]');

	/**
	* Format the post to be injected into the grid
	*/
	post.format = function(data)
	{
		var newpost = $(post.template).clone();
		$(newpost).attr('data-post-container-id', data.id);
		$(newpost).addClass(data.site);
		$(newpost).find('[data-icon-link]').html(data.icon_link);
		$(newpost).find('[data-profile-image]').html('<img src="' + data.profile_image_link + '" data-profile-image class="social-curator-profile-image" onerror="this.onerror=null;this.src=' + "'" + social_curator_grid.defaultavatar + "'" + ';">');
		$(newpost).find('[data-profile-link]').attr('href', data.profile_link);
		$(newpost).find('[data-profile-name]').text(data.profile_name);
		$(newpost).find('[data-date]').text(data.date);
		$(newpost).find('[data-post-content]').html(data.content);
		$(newpost).find('[data-site]').text(data.site);
		$(newpost).find('[data-link]').attr('href', data.link);
		$(newpost).find('[data-icon]').attr('class', social_curator_grid.iconprefix + data.site);
		if ( data.thumbnail ){
			var html = '<a href="' + data.link + '"><img src="' + data.thumbnail + '" /></a>';
			$(newpost).find('[data-thumbnail]').html(html);
		}
		if ( social_curator_grid.twitterintents === '1' && data.site === 'twitter' ){
			var intentFormatter = new socialCuratorTwitterIntents;
			newpost = intentFormatter.append(data, newpost);
		}
		social_curator_grid_post_preloaded(newpost, data)
		return newpost;
	}
}



/**
* Twitter Intents
*/
var socialCuratorTwitterIntents = function()
{

	var intents = this;
	intents.template = $('[data-twitter-intents-template]').find('[data-single-intent-template]');

	/**
	* Append intents to the element
	*/
	intents.append = function(data, element)
	{
		var newintents = $(intents.template).clone().appendTo(element);
		$(newintents).find('[data-intent-retweet]').html('<a href="https://twitter.com/intent/retweet?tweet_id=' + data.original_id + '"><i class="' + social_curator_grid.iconprefix + 'loop"></i></a>');
		
		var favoritebtn = $(newintents).find('[data-intent-favorite]');
		if ( $(favoritebtn).hasClass('heart') ){
			$(newintents).find('[data-intent-favorite]').html('<a href="https://twitter.com/intent/favorite?tweet_id=' + data.original_id + '"><i class="' + social_curator_grid.iconprefix + 'heart"></i></a>');
		} else {
			$(newintents).find('[data-intent-favorite]').html('<a href="https://twitter.com/intent/favorite?tweet_id=' + data.original_id + '"><i class="' + social_curator_grid.iconprefix + 'star-full"></i></a>');
		}
		
		$(newintents).find('[data-intent-tweet]').html('<a href="https://twitter.com/intent/tweet?in_reply_to=' + data.original_id + '"><i class="' + social_curator_grid.iconprefix + 'redo2"></i></a>');
		return element;
	}

}


}); // jQuery

