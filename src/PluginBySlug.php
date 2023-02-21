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

namespace QuadLayers\WP_Notice_Plugin_Promote;

/**
 * PluginBySlug Class
 * This class handles plugin data based on plugin slug
 *
 * @since 1.0.0
 */
class PluginBySlug {

	use Traits\PluginActions;

	/**
	 * Plugin instance.
	 *
	 * @var array
	 */
	protected static $instance = array();

	/**
	 * Plugin slug
	 *
	 * @var string
	 */
	protected $plugin_slug;

	/**
	 * Contructor.
	 *
	 * @param string $plugin_slug Plugin slug.
	 */
	public function __construct( string $plugin_slug ) {

		$this->plugin_slug = $plugin_slug;
	}

}
