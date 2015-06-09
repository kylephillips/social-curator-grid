<h3><?php _e('Social Curator Grid Settings', 'socialcurator'); ?></h3>
<div class="wrap">

	<form method="post" enctype="multipart/form-data" action="options.php">
		<?php settings_fields( 'social-curator-grid-general' ); ?>
		<h3><?php _e('Display Options', 'socialcurator'); ?></h3>
		
		<div class="social-curator-grid-settings">
			<label>
				<input type="checkbox" name="social_curator_grid_display[output_css]" value="1" id="social-curator-grid-css" <?php if ( $this->settings_repo->outputCSS() ) echo ' checked'; ?> />
				<?php _e('Output CSS', 'socialcuratorgrid'); ?>
			</label>
			<p class="social-curator-grid-textarea" style="display:none;">
				<label><?php _e('Include the following CSS in your compiled styles:', 'socialcuratorgrid'); ?></label>
				<textarea style="width:100%;height:150px;"><?php include(dirname(\SocialCuratorGrid\Helpers::plugin_root()) . '/assets/public/css/social-curator-grid-full.css'); ?></textarea>
			</p>
			<?php if ( $this->settings_repo->siteEnabled('twitter') ) : ?>
			<p>
				<label>
					<input type="checkbox" name="social_curator_grid_twitter_intents" value="1" <?php if ( $this->settings_repo->twitterIntents() ) echo 'checked'; ?> />
					<?php _e('Display Twitter Intent Buttons', 'socialcuratorgrid'); ?>
				</label>
			</p>
			<?php endif; ?>
		</div>
		<input type="hidden" name="social_curator_grid_display[set]" value="1">
		<?php submit_button(); ?>
	</form>
</div>

<script type="text/javascript">
	jQuery(function($){

		$(document).ready(function(){
			displayCss();
		});
		$('#social-curator-grid-css').on('change', function(){
			displayCss();
		});

		function displayCss()
		{
			if ( $('#social-curator-grid-css').is(':checked') ){
				$('.social-curator-grid-textarea').hide();
				return;
			}
			$('.social-curator-grid-textarea').show();			
		}
	});
</script>