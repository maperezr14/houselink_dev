<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage houselink
 * @since houselink 1.0
 */
?>
<aside>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="widget-area" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>
</aside>