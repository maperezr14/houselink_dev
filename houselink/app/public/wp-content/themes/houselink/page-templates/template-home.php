<?php
/**
 * Template Name: Template Home
 *
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
get_header();
the_post();
$id = get_the_ID();
$logo_banner = get_field("logo_banner");
$title_banner = get_field("title_banner");
$subtitle_banner = get_field("subtitle_banner");

?>
    <section class="banner-ppal">
      <div class="content">
        <div class="image">
          <img src="<?php echo get_the_post_thumbnail_url();?>" alt="Houselink">
        </div>
        <div class="caption">
          <img class="logo_banner" src="<?php echo $logo_banner;?>" alt="Houselink">
          <h1><?php echo $title_banner; ?></h1>
          <p><?php echo $subtitle_banner; ?></p>
        </div>
      </div>
    </section>

<?php 
$aboutus_home =  get_field("aboutus_home");
$aboutus_description_home =  $aboutus_home["aboutus_description_home"];
$aboutus_image_home =  $aboutus_home["aboutus_image_home"];
$aboutus_title_section_home =  $aboutus_home["aboutus_title_section_home"];
?>
  <section id="aboutus_home" class="aboutus_home">
    <div class="content">
      <div class="title-description">
        <h2 class="title"><?php echo $aboutus_title_section_home; ?></h2>
        <?php echo $aboutus_description_home; ?>
      </div>
      <div class="image-related">
        <img src="<?php echo $aboutus_image_home; ?>" alt="Houselink">
      </div>
    </div>
  </section>


<?php 
$title_section_clients =  get_field("title_section_clients");
$aboutus_description_home =  $aboutus_home["aboutus_description_home"];
?>
  <section id="review" class="single-content review-home">
    <div class="content review">
      <div class="desc-single">
        <h2 class="title">
          <?php echo $title_section_clients;?>
        </h2>
        <div class="list-review">
          <!-- Widget de reseñas google -->
        </div>
      </div>      
    </div>
  </section>

<?php
$title_section_blog_home =  get_field("title_section_blog_home",$id);
$description_section_blog_home =  get_field("description_section_blog_home",$id);
?> 
  <section id="ultimos-articulos" class="ultimos-articulos single-content">
    <div class="content">
      <div class="desc-single">
        <h2 class="title"><?php echo $title_section_blog_home;?></h2>
        <div class="bajada">
          <?php echo $description_section_blog_home;?>
        </div>
        <div class="lista-articulos">
          <?php
          $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 2,
            'orderby' => 'date',
            'order' => 'desc'
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
                <article class="articulo">
                  <a href="<?php echo esc_url( get_permalink($id_post) ); ?>">
                    <div class="image-article">
                      <img src="<?php echo $imagen?>" alt="<?php echo $titulo; ?>">
                    </div>
                    <div class="info-article">
                      <h3><?php echo $titulo; ?></h3>
                      <p><?php echo $excerpt; ?></p>
                      <a href="<?php echo esc_url( get_permalink($id_post) ); ?>"><span class="seguir-leyendo">Seguir leyendo</span></a>
                    </div>
                  </a>
                </article>
            <?php endwhile; wp_reset_postdata(); endif;?>             
          </div>
          <div class="boton-ir">
            <a href="../blog" class="btn-blog-home">Ver todos los artículos</a>
          </div>
        </div>           
    </div>
  </section>
<?php
get_footer(); 
?>