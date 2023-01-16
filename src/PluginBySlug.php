<?php

namespace QuadLayers\WP_Notice_Plugin_Promote;

/**
 * PluginBySlug Class
 * This class handles plugin data based on plugin slug
 *
 * @since 1.0.0
 */
class PluginBySlug {

	use Traits\PluginInstall;

	protected static $instance = array();

	private function __construct( string $plugin_slug ) {

		$this->plugin_slug = $plugin_slug;
	}

	public function get_action_label() {

		if ( $this->is_activated() ) {
			return '';
		}

		if ( $this->is_installed() ) {
			return esc_html__( 'Activate', 'wp-notice-plugin-promote' );
		}

		return esc_html__( 'Install', 'wp-notice-plugin-promote' );
	}

	public function get_action_link() {

		if ( $this->is_activated() ) {
			return '';
		}

		if ( $this->is_installed() ) {
			return $this->get_activate_link();
		}

		return $this->get_install_link();
	}

	public function get_notice_more_link() {

		return $this->get_install_link();
	}

	public static function instance( string $plugin_slug ) {

		if ( ! $plugin_slug ) {
			return false;
		}

		if ( ! isset( self::$instance[ $plugin_slug ] ) ) {
			self::$instance[ $plugin_slug ] = new self( $plugin_slug );
		}

		return self::$instance[ $plugin_slug ];
	}

}
