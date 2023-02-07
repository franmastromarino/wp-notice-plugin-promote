<?php

namespace QuadLayers\WP_Notice_Plugin_Promote\Traits;

/**
 * Trait PluginActions
 *
 * @package QuadLayers\WP_Notice_Plugin_Promote\Traits\PluginActions
 * @since 1.0.0
 */
trait PluginActions {

	use PluginActionsLinks;

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

}
