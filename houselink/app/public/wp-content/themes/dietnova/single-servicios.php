<?php
/**
    
 */
get_header();
the_post();
$id = get_the_ID();

$imagen_relacionada = get_field("imagen_relacionada",$id);
$imagen_banner = $imagen_relacionada["imagen"];
$formulario =  get_field("formulario",$id);
?>
    <section class="cabecera-internas">
      <div class="banner-breadcrum">
          <img src="<?php echo $imagen_banner; ?>">
          <div class="title-breadcrum">
            <h2><?php the_title(); ?></h2>
            <div class="breadcrum">
              <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
            </div>
          </div>
        </div>
    </section>
    <section id="service" class="single-content">
      <div class="content">        
        <div class="desc-single">
          <h2 class="title"><?php the_title(); ?></h2>
          <?php the_content(); ?>
        </div>
      </div>
    </section>
    <section class="contacto contacto-servicios">
      <div class="content">
        <div class="texto">
          <h2 class="title">Para más información</h2>
          <ul>
            <li>Completa tus datos en el formulario y te contactaremos en un plazo de 24 horas.</li>
            <li>En el campo “Información adicional” podrás indicarnos tus dudas sobre el servicio y/o compartirnos información adicional relacionada con el paciente que requiere el servicio por el cual nos estas contactando.</li>
          </ul>
        </div>
        <div class="formulario">
          <?php echo do_shortcode($formulario);?>
        </div>
      </div>
    </section>
    <div class="lightbox-tyc" id="pp" style="display: none;">
      <div class="tyc-content">
        <div class="close-box"><i class="far fa-times-circle"></i></div>
        <div class="box">
          <h2><?php the_field('titulo_1', 'option'); ?></h2>
          <div class="tyc-desc">
            <?php the_field('descripcion_1', 'option'); ?>
          </div>
        </div>
      </div>
    </div>
<?php
get_footer(); 
?>