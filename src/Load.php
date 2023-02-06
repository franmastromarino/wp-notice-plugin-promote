<?php

namespace QuadLayers\WP_Notice_Plugin_Promote;

/**
 * Class Load
 *
 * @package QuadLayers\WP_Notice_Plugin_Promote
 */

class Load {

	/**
	 * Developer Mode.
	 *
	 * @var bool
	 */
	protected $developer_mode = false;

	/**
	 * Notices to display.
	 *
	 * @var array
	 */
	protected $notices = array();
	/**
	 * Current Plugin File.
	 *
	 * @var string
	 */
	protected $current_plugin_file;
	/**
	 * Current Plugin.
	 *
	 * @var PluginByFile
	 */
	protected $current_plugin;

	public function __construct( string $current_plugin_file, array $notices = array() ) {
		/**
		 * Only show notices in admin panel.
		 */
		if ( ! is_admin() ) {
			return;
		}
		/**
		 * Get current plugin by file.
		 */
		$this->current_plugin = new PluginByFile( $current_plugin_file );
		/**
		 * Only show notices if current plugin file is valid.
		 */
		if ( ! $this->current_plugin->is_valid() ) {
			return;
		}
		/**
		 * Set notices.
		 */
		$this->notices = $notices;
		/**
		 * Create transient on plugin activation to delay display notices.
		 */
		register_activation_hook(
			$this->current_plugin->get_file(),
			function() {
				$notice_delay = MONTH_IN_SECONDS;
				if ( isset( $this->notices[0]->notice_delay ) ) {
					$notice_delay = $this->notices[0]->notice_delay;
				}
				$this->delay_display_notices( $notice_delay );
			}
		);
		/**
		 * Add action to display notices.
		 */
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		/**
		 * Add action to dismiss notice by id.
		 */
		add_action( 'wp_ajax_' . $this->get_action_name(), array( $this, 'ajax_notice_plugin_promote_dismiss' ) );
		/**
		 * Remove all data
		 */
		if ( $this->developer_mode ) {
			add_action( 'admin_notices', array( $this, 'remove_all_data' ) );
		}
	}
	/**
	 * Create transient on plugin activation to delay notice one month.
	 *
	 * @return void
	 */
	public function delay_display_notices( int $notice_delay = MONTH_IN_SECONDS ) {
		set_transient( $this->get_transient_key(), true, $notice_delay );
	}
	/**
	 * Action admin notices hook.
	 *
	 * @return void
	 */
	public function admin_notices() {

		$screen = get_current_screen();

		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		/**
		 * Check if notices are delayed by the transient created on plugin activation.
		 */
		$is_display_notices_delayed = $this->is_display_notices_delayed();

		if ( $is_display_notices_delayed ) {
			return;
		}
		/**
		 * Add script to dismiss notice via ajax.
		 */
		?>
		<script>
			(function($) {
				$(document).ready(()=> {
					$('.<?php echo esc_attr( $this->get_transient_key() ); ?>').on('click', '.notice-dismiss', function(e) {
						e.preventDefault();
						var notice_index = $(e.delegateTarget).data('notice_index');
						$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							notice_index: notice_index,
							action: '<?php echo esc_attr( $this->get_action_name() ); ?>',
							nonce: '<?php echo esc_attr( wp_create_nonce( $this->get_action_name() ) ); ?>'
						},
							success: function(response) {
							console.log(response);
						},
						});
					});
				})
			})(jQuery);
		</script>
		<?php

		/**
		 * Loop through notices.
		 */
		foreach ( $this->notices as $notice_index => $notice ) {
			/**
			 * Check if notice is valid.
			 */
			$is_valid_notice = $this->is_valid_notice( $notice );

			if ( ! $is_valid_notice ) {
				continue;
			}
			/**
			 * Check if notice is hidden for current user base on user meta.
			 */
			$is_notice_hidden_for_current_user = $this->is_notice_hidden_for_current_user( $notice_index );

			if ( $is_notice_hidden_for_current_user ) {
				continue;
			}
			/**
			 * Include notice template.
			 */
			$this->include_notice_template( $notice, $notice_index );
			/**
			 * Display one notice at a time.
			 */
			if ( ! $this->developer_mode ) {
				return;
			}
		}
	}
	/**
	 * Create transient key.
	 *
	 * @return string
	 */
	private function get_transient_key() {
		return 'quadlayers_' . $this->current_plugin->get_slug() . '_notice_delay';
	}

	/**
	 * Create action name.
	 *
	 * @return string
	 */
	private function get_action_name() {
		return 'quadlayers_' . $this->current_plugin->get_slug() . '_notice_close';
	}

	/**
	 * Create user meta key.
	 *
	 * @param [type] $notice_index
	 * @return string
	 */
	private function get_user_notice_meta_hidden_key( $notice_index ) {
		return 'quadlayers_' . $this->current_plugin->get_slug() . '_notice_hidden_' . $notice_index;
	}

	/**
	 * Create class to link notice to dismiss ajax action.
	 *
	 * @return string
	 */
	private function get_notices_class() {
		return $this->get_transient_key();
	}

	private function get_current_user_notice_meta_hidden( $notice_index ) {
		return get_user_meta( get_current_user_id(), $this->get_user_notice_meta_hidden_key( $notice_index ), true );
	}

	private function delete_current_user_notice_meta_hidden( $notice_index ) {
		return delete_user_meta( get_current_user_id(), $this->get_user_notice_meta_hidden_key( $notice_index ), false );
	}

	private function set_current_user_notice_meta_hidden( $notice_index ) {
		return update_user_meta( get_current_user_id(), $this->get_user_notice_meta_hidden_key( $notice_index ), true );
	}

	/**
	 * Reset notice transient dismiss to on month.
	 *
	 * @return void
	 */
	public function ajax_notice_plugin_promote_dismiss() {
		if ( isset( $_REQUEST['notice_index'] ) && check_admin_referer( $this->get_action_name(), 'nonce' ) ) {
			$notice_index = sanitize_key( $_REQUEST['notice_index'] );
			$this->set_current_user_notice_meta_hidden( $notice_index );
			if ( ! isset( $this->notices[ $notice_index ] ) ) {
				return wp_send_json_error( sprintf( esc_html__( 'Unknow notice index %s', 'wp-notice-plugin-promote' ), $notice_index ) );
			}
			$next_notice_delay = isset( $this->notices[ $notice_index + 1 ]['notice_delay'] ) ? $this->notices[ $notice_index + 1 ]['notice_delay'] : MONTH_IN_SECONDS;
			$this->delay_display_notices( $next_notice_delay );
			wp_send_json_success( sprintf( esc_html__( 'Notice index %s removed', 'wp-notice-plugin-promote' ), $notice_index ) );
		}
		wp_die();
	}

	/**
	 * Check if notice is valid based on user meta.
	 *
	 * @param [type] $notice_index
	 * @return boolean
	 */
	private function is_notice_hidden_for_current_user( $notice_index ) {
		if ( $this->developer_mode ) {
			return false;
		}
		return (bool) $this->get_current_user_notice_meta_hidden( $notice_index );
	}

	/**
	 * Check if notice is valid.
	 *
	 * @param [type] array $notice
	 * @return boolean
	 */
	private function is_valid_notice( array $notice ) {
		/**
		 * Return true if notice dose not have plugin slug.
		 */
		if ( ! isset( $notice['plugin_slug'] ) ) {
			return true;
		}
		$plugin = PluginBySlug::instance( $notice['plugin_slug'] );
		/**
		 * Return true if plugin is not activated.
		 */
		if ( ! $plugin->is_activated() ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if notices are delayed based on plugin transient.
	 *
	 * @return boolean
	 */
	private function is_display_notices_delayed() {
		if ( $this->developer_mode ) {
			return false;
		}
		return get_transient( $this->get_transient_key() );
	}

	/**
	 * Get notice template.
	 *
	 * @param [type] $notice
	 * @return void
	 */
	private function include_notice_template( array $notice, int $notice_index ) {

		$template_path = __DIR__ . '/templates/notice.php';

		$notices_class = $this->get_notices_class();

		/**
		 * Add action and action link to notice if plugin slug is set.
		 */
		if ( isset( $notice['plugin_slug'] ) ) {
			$plugin = PluginBySlug::instance( $notice['plugin_slug'] );
			$notice = array_merge(
				$notice,
				array(
					'action'      => $plugin->get_action_label(),
					'action_link' => $plugin->get_action_link(),
				)
			);
		}

		extract( $notice );

		include $template_path;
	}

	public function remove_all_data() {
		/**
		 * Loop through notices.
		 */
		foreach ( $this->notices as $notice_index => $notice ) {
			$this->delete_current_user_notice_meta_hidden( $notice_index );
		}

		delete_transient( $this->get_transient_key() );}

}