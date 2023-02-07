<?php

namespace QuadLayers\WP_Notice_Plugin_Promote;

/**
 * PluginBySlug Class
 * This class handles plugin data based on plugin slug
 *
 * @since 1.0.0
 */
class PluginBySlug {

	use Traits\PluginActions;

	protected static $instance = array();

	/**
	 * Plugin slug
	 *
	 * @var string
	 */
	protected $plugin_slug;

	public function __construct( string $plugin_slug ) {

		$this->plugin_slug = $plugin_slug;
	}

}
