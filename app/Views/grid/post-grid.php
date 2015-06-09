<div class="social-curator-post-grid" data-social-curator-post-grid>
	<div class="gutter-sizer"></div>
</div><!-- .social-curator-post-grid -->

<div class="social-curator-grid-loading" data-social-curator-grid-loading style="display:none;">
	<?php echo $this->loading(); ?>
</div>

<?php if ( $this->options['allowmore'] == 'true' ) : ?>
<div class="social-curator-grid-footer" data-social-curator-grid-footer>
	<button data-load-more-posts><?php echo $this->options['loadmoretext']; ?></button>
</div>
<?php endif; ?>

<!-- Single Post Template -->
<div data-single-post-template style="display:none;">
	<?php $this->postTemplate(); ?>
</div>

<!-- Twitter Intents Template -->
<div data-twitter-intents-template style="display:none;">
	<?php $this->twitterIntentsTemplate(); ?>
</div>