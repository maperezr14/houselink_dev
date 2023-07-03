<?php
/**
 * Template Name: Template Blog
 *
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
get_header();

$imagen = get_the_post_thumbnail_url();
?>
<script>
  var post_actual = "";
</script>
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
<section id="noticias" class="">
  <div class="content noticias">
    <div class="lista-noticias">
      <div class="noticias-destacadas otras-noticias">
        <?php
          $args = array(
            'post_type' => 'post',
            'post_status' => 'publish'
          );

          $lista_posts = new WP_Query($args);
          if ($lista_posts->have_posts() ):  
            while ($lista_posts->have_posts()): 
              $lista_posts->the_post(); 
              $id_post = get_the_ID();
              $imagen = get_the_post_thumbnail_url($id_post,'full');
              $titulo = get_the_title();
              $excerpt = get_the_excerpt($id_post);                    
              ?>
        <div class="noticia">
          <a href="<?php the_permalink(); ?>">
            <div class="img-portada">
              <img src="<?php echo $imagen?>" alt="<?php echo $titulo; ?>">
            </div>
            <div class="titular-content">
              <h2><?php the_title(); ?></h2>
              <div class="resumen">
                <?php the_excerpt(); ?>
              </div>
              <a href="<?php the_permalink(); ?>"><span class="seguir-leyendo">Seguir leyendo</span></a>
            </div>
          </a>
        </div>
        <?php endwhile; else : ?>
          <p>Lo siento, no hemos encontrado ningún post.</p>
        <?php endif; ?>
      </div>
      <div class="mas-noticias">
        <a id="loadMore" href="javascript:void(0)" class="btns btn-shadow">Ver más atrículos</a>
      </div>
    </div>

  </div>
</section>
<?php
get_footer(); 
?>