<?php
/**
 * QuadLayers WP Notice Plugin Promote
 *
 * @package   quadlayers/wp-notice-plugin-promote
 * @author    QuadLayers
 * @link      https://github.com/quadlayers/wp-notice-plugin-promote
 * @copyright Copyright (c) 2023
 * @license   GPL-3.0
 */

namespace QuadLayers\WP_Notice_Plugin_Promote\Traits;

/**
 * Trait PluginActions
 *
 * @package QuadLayers\WP_Notice_Plugin_Promote\Traits\PluginActions
 * @since 1.0.0
 */
trait PluginActions {

	use PluginActionsLinks;

	/**
	 * Get plugin action label.
	 *
	 * @return string
	 */
	public function get_action_label() {

		if ( $this->is_activated() ) {
			return '';
		}

		if ( $this->is_installed() ) {
			return esc_html__( 'Activate', 'wp-notice-plugin-promote' );
		}

		if ( $this->plugin_install_label ) {
			return $this->plugin_install_label;
		}

		return esc_html__( 'Install', 'wp-notice-plugin-promote' );
	}

	/**
	 * Get plugin action link.
	 *
	 * @return string
	 */
	public function get_action_link() {

		if ( $this->is_activated() ) {
			return '';
		}

		if ( $this->is_installed() ) {
			return $this->get_activate_link();
		}

		if ( $this->plugin_install_link ) {
			return $this->plugin_install_link;
		}

		return $this->get_install_link();
	}

}
