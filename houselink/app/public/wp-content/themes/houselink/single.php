<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
get_header();
the_post();
$id = get_the_ID();
$imagen = get_the_post_thumbnail_url($id ,'full');
$excerpt = get_the_excerpt($id );
?>
<script>
  var post_actual = <?php echo $id;?>;
</script>
  <section class="banner-post">
    <div class="image">
      <img src="<?php echo $imagen?>" alt="<?php echo $titulo; ?>">
    </div>
  </section>
  <section id="noticia" class="">
    <div class="content noticia">
      <div class="detalle-noticia">
        <h1><?php the_title(); ?></h1>
        <div class="tags">
          <span class="date"><?php the_time(get_option('date_format')); ?></span>
        </div>
        <div class="body-note">
          <?php the_content(); ?>
        </div>
        <div class="tags-share">
          <div class="tags">           
            <span class="category">
            <?php
              $category_names = array(); // Array para almacenar los nombres de las categorías
              foreach ((get_the_category()) as $category) {
                  $category_names[] = $category->cat_name; // Agrega el nombre de cada categoría al array
              }
              $category_list = implode(', ', $category_names); // Une los nombres de las categorías con comas
              echo $category_list; // Imprime la lista de categorías separadas por comas
            ?>              
            </span>        
          </div>
          <div class="share">
            <p>
              <span>Compartir:</span>
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
              <a href="https://twitter.com/intent/tweet?text=<?php the_title() ?>&url=<?php the_permalink() ?>" target="_blank"><i class="fab fa-twitter"></i></a>
            </p>
          </div>
        </div>
        <div class="navigation-post">
          <?php the_post_navigation(); ?>
        </div>
        <!-- <div class="comentarios">
          <!-- <?php //comments_template(); ?> 
        </div> -->
      </div>
    </div>
  </section>

<?php get_footer(); ?>
