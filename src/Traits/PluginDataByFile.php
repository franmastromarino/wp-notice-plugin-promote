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
}
