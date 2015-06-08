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
	grid.offset = 0;
	grid.numberposts = parseInt(social_curator_grid.perpage);

	/**
	* Get Social Posts
	*/
	grid.getPosts = function()
	{
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
		console.log(posts);
	}

	/**
	* Load More Posts
	*/
	grid.loadMore = function()
	{
		this.getPosts();
	}

	/**
	* Load More Click Event
	*/
	$(document).on('click', '[data-load-more-posts]', function(e){
		e.preventDefault();
		grid.loadMore();
	});
}