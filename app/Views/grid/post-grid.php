<div class="social-curator-post-grid" data-social-curator-post-grid>
</div><!-- .social-curator-post-grid -->

<?php if ( $this->options['allowmore'] == 'true' ) : ?>
<button data-load-more-posts><?php echo $this->options['loadmoretext']; ?></button>
<?php endif; ?>

<!-- Post Template for Cloning -->
<div data-single-post-template style="display:none;">
	<?php $this->postTemplate(); ?>
</div>