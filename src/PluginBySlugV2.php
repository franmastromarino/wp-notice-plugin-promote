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
class PluginBySlugV2 {

	use Traits\PluginActions;

	/**
	 * Plugin instance.
	 *
	 * @var array
	 */
	protected static $instance = array();

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	protected $plugin_slug;


	/**
	 * Plugin install link.
	 *
	 * @var string
	 */
	protected $plugin_install_link;


	/**
	 * Plugin install label.
	 *
	 * @var string
	 */
	protected $plugin_install_label;

	/**
	 * Contructor.
	 *
	 * @param array $notice Plugin notice.
	 */
	public function __construct( array $notice ) {
		foreach ( $notice as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

}
