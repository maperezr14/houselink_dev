<?php
/**
 * The sidebar containing the main widget area
 *
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
?>
<aside>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="widget-area" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>
</aside>