<?php
/**
 * Template Name: Template Legal
 *
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
get_header();
the_post();
$id = get_the_ID();

?>
<section class="cabecera-internas">
  <div class="banner-breadcrum">
    <img src="<?php echo get_the_post_thumbnail_url(); ?>">
    <div class="title-breadcrum">
      <h2><?php the_title(); ?></h2>
      <div class="breadcrum">
        <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
      </div>
    </div>
  </div>
</section>
<section id="legal" class="single-content">
  <div class="content legal">
      <?php the_content();?>
    </div>
  </section>
  <?php
  get_footer(); 
  ?>