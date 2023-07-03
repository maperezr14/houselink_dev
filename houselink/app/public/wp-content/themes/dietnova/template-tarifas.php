<?php
/**
    Template Name: template tarifas 
 */
get_header();
the_post();
$id = get_the_ID();

$imagen = get_field("imagen",$id);
$precio = get_field("precio", $id);
$formulario =  get_field("formulario",$id);
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
<section id="tarifas" class="single-content">
  <div class="content tarifas">
      <div class="desc-single">
        <h2 class="title">Elige un plan</h2>
        <p>Consulta mis tarifas y selecciona el plan que mejor se adapte a tus necesidades para comenzar tu cambio ahora.</p>
        <div class="list-tarifas">
          <div class="slider-planes center">
            <?php
            $args = array(
              'post_type' => 'tarifas',
              'post_status' => 'publish',
              'posts_per_page' => -1,
              'orderby' => 'date_update',
              'order' => 'ASC'
            );

            $tarifas = new WP_Query($args);
              if ($tarifas->have_posts() ):  
                while ($tarifas->have_posts()): 
                  $tarifas->the_post(); 
                  $id_tarifas = get_the_ID();
                  $titulo = get_the_title();
                  $precio = get_field("precio", $id);
                  $resumen = get_field("resumen", $id);
                  ?>
                  <div class="item tarifa">
                    <p class="tarifa">€<?php echo $precio; ?></p>
                    <h3><?php echo $titulo; ?></h3>
                    <div class="descripcion">
                      <?php echo $resumen; ?>
                    </div>
                    <a href="<?php echo esc_url(get_permalink($id_tarifas)); ?>" class="btn-plan">Saber más</a>
                  </div>
                  <?php endwhile; wp_reset_postdata(); ?>
              <?php endif; ?>
            </div>
        </div>
      </div>      
    </div>
  </section>
  <?php
  get_footer(); 
  ?>