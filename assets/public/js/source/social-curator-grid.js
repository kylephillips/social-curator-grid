$(document).ready(function(){
	var nonce = new SocialCuratorNonce;
	nonce.injectNonce(loadPosts);

	/**
	* Callback function after nonce has been generated and injected
	*/
	function loadPosts()
	{
		var grid = new socialCuratorGrid;
		grid.getPosts();
	}
});


/**
* The Primary Grid Object
*/
var socialCuratorGrid = function()
{
	var grid = this;
	grid.el = $('[data-social-curator-post-grid]');
	grid.btn = $('[data-load-more-posts]');
	grid.offset = 0;
	grid.numberposts = parseInt(social_curator_grid.perpage);

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
				offset: grid.offset,
				number: grid.numberposts
			},
			success: function(data){
				if ( data.posts.length == 0 ) return grid.noPosts();
				grid.offset = grid.offset + grid.numberposts;
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
			$(grid.el).append(newpost);
		}
		grid.loading(false);
	}

	/**
	* No more posts to load
	*/
	grid.noPosts = function()
	{
		$(grid.btn).remove();
	}

	/**
	* Add / Remove Loading Indication
	*/
	grid.loading = function(loading)
	{
		if ( loading ){
			$(grid.el).addClass('loading');
			$(grid.btn).attr('disabled', 'disabled').html(social_curator_grid.loading).addClass('loading');
			return;
		}

		$(grid.el).removeClass('loading');
		$(grid.btn).attr('disabled', false).html(social_curator_grid.loadmore).removeClass('loading');
	}

	/**
	* Load More Click Event
	*/
	$(document).on('click', '[data-load-more-posts]', function(e){
		e.preventDefault();
		grid.getPosts();
	});
}



/**
* A single post
*/
var socialCuratorGridPost = function()
{
	var post = this;
	post.template = $('[data-single-post-template]').find('[data-template]');

	/**
	* Append the Post to the Grid
	*/
	post.format = function(data)
	{
		var newpost = $(post.template).clone();
		$(newpost).attr('data-post-container-id', data.id);
		$(newpost).find('[data-icon-link]').html(data.icon_link);
		$(newpost).find('[data-profile-image]').attr('src', data.profile_image_link);
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
		console.log(newpost);
		console.log(data);
		return newpost;
	}
}



