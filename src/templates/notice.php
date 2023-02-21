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

?>
<div class="<?php echo esc_attr( $notices_class ); ?> notice notice-info is-dismissible" data-notice_index="<?php echo esc_attr( $notice_index ); ?>">
	<div class="notice-container" style="padding-top: 10px; padding-bottom: 10px; display: flex; justify-content: left; align-items: center;">
		<div class="notice-image">
			<img style="border-radius:50%;max-width: 90px;" src="<?php echo esc_url( $notice_logo ); ?>">
		</div>
		<div class="notice-content" style="margin-left: 15px;">
			<p>
				<?php if ( ! empty( $notice_title ) ) : ?>
					<?php echo wp_kses_post( $notice_title ); ?>
				<?php endif; ?>
				<br/>
				<?php if ( ! empty( $notice_description ) ) : ?>
					<?php echo wp_kses_post( $notice_description ); ?>
				<?php endif; ?>
			</p>
			<div style="display:flex;gap: 1em;align-items: center;" >
				<?php if ( ! empty( $action_link ) ) : ?>
					<a href="<?php echo esc_url( $action_link ); ?>" class="button-primary">
						<?php echo esc_html( $action ); ?>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $notice_link ) && ! empty( $notice_link_label ) ) : ?>
					<a href="<?php echo esc_url( $notice_link ); ?>" class="button-primary" target="_blank">
						<?php echo esc_html( $notice_link_label ); ?>
					</a>
				<?php endif; ?>
				<?php
				if ( ! empty( $notice_more_link ) && ! empty( $notice_more_label ) ) :
					?>
					<a href="<?php echo esc_url( $notice_more_link ); ?>" class="button-secondary" target="_blank">
						<?php echo esc_html( $notice_more_label ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>			
	</div>
</div>
