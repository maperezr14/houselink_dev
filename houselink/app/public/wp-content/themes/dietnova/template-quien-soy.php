<?php
/**
    Template Name: template quien soy
 */
get_header();
the_post();
$id = get_the_ID();

$imagen_relacionada = get_field("imagen_relacionada",$id);
$nombre = get_field("nombre",$id);
$nivel_educativo = get_field("nivel_educativo",$id);
$colaboraciones = get_field("colaboraciones",$id);
$eventos = get_field("eventos",$id);
$experiencia_laboral = get_field("experiencia_laboral",$id);

?>
    <section class="cabecera-internas">
      <div class="banner-breadcrum">
          <img src="<?php echo $imagen_relacionada; ?>">
          <div class="title-breadcrum">
            <h2><?php the_title(); ?></h2>
            <div class="breadcrum">
              <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
            </div>
          </div>
        </div>
    </section>
    <section id="quien-soy" class="single-content">
      <div class="content">        
        <div class="desc-single">
          <h2 class="title"><?php echo $nombre?></h2>
          <div class="content-perfil">
            <div class="bloque nivel-educativo">
              <h3>Nivel Educativo</h3>
              <?php echo $nivel_educativo ?>
            </div>
            <div class="bloque colaboraciones">
              <h3>Colaboraciones</h3>
              <?php echo $colaboraciones?>
            </div>
            <div class="bloque eventos">
              <h3>Eventos</h3>
              <?php echo $eventos?>
            </div>
            <div class="bloque experiencia-laboral">
              <h3>Experiencia Laboral</h3>
              <?php echo $experiencia_laboral?>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php get_footer(); ?>