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
 * PluginByFile Class
 * This class handles plugin data based on plugin file and use PluginActionLinks
 *
 * @since 1.0.0
 */
class PluginByFile {

	use Traits\PluginDataByFile;

	/**
	 * Setup class
	 *
	 * @param string $plugin_file Plugin file.
	 */
	public function __construct( string $plugin_file ) {
		$this->plugin_file = $plugin_file;
	}

}
