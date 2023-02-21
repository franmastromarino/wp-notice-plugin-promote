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
 * Trait PluginDataByFile
 *
 * @package QuadLayers\WP_Notice_Plugin_Promote\Traits\PluginDataByFile
 * @since 1.0.0
 */
trait PluginDataByFile {

	/**
	 * Plugin file path
	 *
	 * @var string
	 */
	private $plugin_file;

	/**
	 * Plugin author URL
	 *
	 * @var string
	 */
	private $plugin_url;

	/**
	 * Plugin slug
	 *
	 * @var string
	 */
	private $plugin_slug;

	/**
	 * Plugin base folder
	 *
	 * @var string
	 */
	private $plugin_base;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $plugin_version;

	/**
	 * Plugin name
	 *
	 * @var string
	 */
	private $plugin_name;

	/**
	 * Check if plugin is valid.
	 *
	 * @return bool
	 */
	public function is_valid() {
		if ( ! $this->get_file() ) {
			return false;
		}
		if ( ! is_file( $this->get_file() ) ) {
			return false;
		}

		if ( ! $this->get_name() ) {
			return false;
		}

		return true;
	}

	/**
	 * Get plugin file path.
	 *
	 * @return string
	 */
	public function get_file() {
		return $this->plugin_file;
	}

	/**
	 * Get plugin slug.
	 *
	 * @return string
	 */
	public function get_slug() {
		if ( $this->plugin_slug ) {
			return $this->plugin_slug;
		}
		if ( ! $this->get_file() ) {
			return false;
		}
		$plugin_slug       = basename( $this->get_file(), '.php' );
		$this->plugin_slug = $plugin_slug;
		return $this->plugin_slug;
	}

	/**
	 * Get plugin base folder.
	 *
	 * @return string
	 */
	public function get_base() {
		if ( $this->plugin_base ) {
			return $this->plugin_base;
		}
		if ( ! $this->get_file() ) {
			return false;
		}
		$plugin_base       = plugin_basename( $this->get_file() );
		$this->plugin_base = $plugin_base;
		return $this->plugin_base;
	}

	/**
	 * Get plugin version.
	 *
	 * @return string
	 */
	public function get_version() {
		if ( $this->plugin_version ) {
			return $this->plugin_version;
		}
		$plugin_data = $this->get_wp_plugin_data( $this->get_file() );
		if ( empty( $plugin_data['Version'] ) ) {
			return false;
		}
		$this->plugin_version = $plugin_data['Version'];
		return $this->plugin_version;
	}

	/**
	 * Get plugin name.
	 *
	 * @return string
	 */
	public function get_name() {
		if ( $this->plugin_name ) {
			return $this->plugin_name;
		}
		$plugin_data = $this->get_wp_plugin_data( $this->get_file() );
		if ( empty( $plugin_data['Name'] ) ) {
			return false;
		}
		$this->plugin_name = $plugin_data['Name'];
		return $this->plugin_name;
	}

	/**
	 * Get plugin URL.
	 *
	 * @return string
	 */
	public function get_url() {
		if ( $this->plugin_url ) {
			return $this->plugin_url;
		}
		$plugin_data = $this->get_wp_plugin_data( $this->get_file() );
		if ( empty( $plugin_data['PluginURI'] ) ) {
			return false;
		}
		$this->plugin_url = $plugin_data['PluginURI'];
		return $this->plugin_url;
	}

	/**
	 * Get plugin data from WordPress.
	 *
	 * @return array|bool
	 */
	private function get_wp_plugin_data() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';

		}
		if ( ! $this->get_file() ) {
			return false;
		}
		return get_plugin_data( $this->get_file() );
	}
}
