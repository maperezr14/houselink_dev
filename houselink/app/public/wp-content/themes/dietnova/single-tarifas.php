<?php
/**
    
 */
get_header();
the_post();
$id = get_the_ID();

$imagen = get_the_post_thumbnail_url($id_post,'full');
$formulario =  get_field("formulario",$id);

$descripcion_del_plan = get_field("descripcion_del_plan",$id);
$descripcion = $descripcion_del_plan["descripcion"];

$que_incluye = get_field("que_incluye",$id);
$incluye = $que_incluye["incluye"];

$como_inicia_el_plan = get_field("como_inicia_el_plan",$id);
$para_iniciar = $como_inicia_el_plan["para_iniciar"];

?>
    <section class="cabecera-internas">
      <div class="banner-breadcrum">
          <img src="<?php echo $imagen; ?>">
          <div class="title-breadcrum">
            <h2>Tarifas</h2>
            <div class="breadcrum">
              <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
            </div>
          </div>
        </div>
    </section>
    <section id="tarifa" class="single-content">
      <div class="content">        
        <div class="desc-single">
          <h2 class="title"><?php the_title(); ?></h2>
          <div class="descripcion-plan">
            <?php echo $descripcion ?>
          </div>
          <div class="que-incluye">
            <h3>¿Qué incluye?</h3>
            <?php echo $incluye ?>
          </div>
          <div class="como-iniciamos">
            <h3>¿Cómo iniciamos?</h3>
            <?php echo $para_iniciar ?>
          </div>
        </div>
      </div>
    </section>
    <section id="contacto" class="contacto contacto-tarifas">
      <div class="content">
        <div class="texto">
          <h2 class="title">Para más información</h2>
          <ul>
            <li>Completa tus datos en el formulario y te contactaremos en un plazo de 24 horas.</li>
            <li>En el campo “Información adicional” podrás indicarnos tus dudas y/o consultas sobre tu plan ideal.</li>
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