<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage houselink
 * @since houselink 1.0
 */

get_header(); ?>

<section class="error-404 not-found">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12">
				<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'houselink' ); ?></h1>
			</div>
		</div>
	</div>
</section><!-- .error-404 -->

<?php get_footer(); ?>
