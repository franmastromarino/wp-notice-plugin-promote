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
 * Trait PluginActionsLinks
 *
 * @package QuadLayers\WP_Notice_Plugin_Promote\Traits\PluginActionsLinks
 * @since 1.0.0
 */
trait PluginActionsLinks {

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	protected $plungin_slug;

	/**
	 * Check if plugin is installed.
	 *
	 * @return bool
	 */
	public function is_installed() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$plugin_path       = $this->get_path();
		$installed_plugins = get_plugins();
		return isset( $installed_plugins[ $plugin_path ] );
	}

	/**
	 * Check if plugin is activated.
	 *
	 * @return bool
	 */
	public function is_activated() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$plugin_path = $this->get_path();
		return is_plugin_active( $plugin_path );
	}

	/**
	 * Get plugin install link.
	 *
	 * @return string
	 */
	public function get_install_link() {
		return wp_nonce_url( self_admin_url( "update.php?action=install-plugin&plugin={$this->plugin_slug}" ), "install-plugin_{$this->plugin_slug}" );
	}

	/**
	 * Get plugin activate link.
	 *
	 * @return string
	 */
	public function get_activate_link() {
		$plugin_path = $this->get_path();
		return self_admin_url( wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin_path . '&amp;paged=1', 'activate-plugin_' . $plugin_path ) );
	}

	/**
	 * Get plugin path.
	 *
	 * @return string
	 */
	private function get_path() {
		return "{$this->plugin_slug}/{$this->plugin_slug}.php";
	}


}
