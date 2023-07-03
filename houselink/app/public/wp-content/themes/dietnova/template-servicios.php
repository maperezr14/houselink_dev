<?php
/**
    Template Name: template servicios 
 */
get_header();
the_post();
$id = get_the_ID();

$imagen = get_field("imagen",$id);
?>
<section class="cabecera-internas">
  <div class="banner-breadcrum">
    <img src="<?php echo $imagen; ?>">
    <div class="title-breadcrum">
      <h2><?php the_title(); ?></h2>
      <div class="breadcrum">
        <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
      </div>
    </div>
  </div>
</section>
<section id="services" class="single-content">
  <div class="content services">
      <div class="services-content">
        <div class="desc-single">
          <h2 class="title">Conoce nuestros <br>servicios</h2>
          <div class="list-service">
            <div class="slider-servicios center">
              <?php
              $args = array(
                'post_type' => 'servicios',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'DESC'
              );

              $servicios = new WP_Query($args);
                if ($servicios->have_posts() ):  
                  while ($servicios->have_posts()): 
                    $servicios->the_post(); 
                    $id_servicio = get_the_ID();
                    $imagen = get_the_post_thumbnail_url($id_servicio,'full');
                    $titulo = get_the_title();
                    ?>
                    <div class="item servicio">
                      <a href="<?php echo esc_url( get_permalink($id_servicio) ); ?>">
                        <div class="image-service">
                          <img src="<?php echo $imagen?>" alt="<?php echo $titulo; ?>">
                        </div>
                        <div class="description-service">
                          <h3><?php echo $titulo; ?></h3>
                          <span>Conoce más</span>
                        </div>
                      </a>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
              </div>
          </div>
        </div>      
      </div>
    </div>
  </section>
  <?php
  get_footer(); 
  ?>