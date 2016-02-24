<?php

require_once( AMP__DIR__ . '/includes/embeds/class-amp-base-embed-handler.php' );

// Much of this class is borrowed from Jetpack embeds
class AMP_Brightcove_Embed_Handler extends AMP_Base_Embed_Handler {
	
	private static $script_slug = 'amp-brightcove';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-brightcove-0.1.js';

	function register_embed() {
		add_shortcode( 'bc_video', array( $this, 'shortcode' ) );
	}

	public function unregister_embed() {
		remove_shortcode( 'bc_video' );
	}

	public function get_scripts() {
		if ( ! $this->did_convert_elements ) {
			return array();
		}

		return array( self::$script_slug => self::$script_src );
	}

  // Handles the `brightcove` shortcode for
	// https://wordpress.org/plugins/brightcove-video-connect/
	public function shortcode( $attr ) {
		return $this->render( array(
			'account_id' => $attr['account_id'],
			'video_id' => $attr['video_id'],
		) );
	}

	public function render( $args ) {
		$this->did_convert_elements = true;

		return AMP_HTML_Utils::build_tag(
			'amp-brightcove',
			array(
				'data-account' => $args['account_id'],
				'data-video-id' => $args['video_id'],
				'layout' => 'responsive',
				'width' => '640',
				'height' => '360',
			)
		);
	}

}