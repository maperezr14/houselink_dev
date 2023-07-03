<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage houselink
 * @since houselink 1.0
 */

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
        <div class="tags">
          <span class="category">
            <?php
              foreach((get_the_category()) as $category) {
                    echo $category->cat_name . ' ';
              }
            ?>                  
          </span>
          <span class="date"><?php the_time(get_option('date_format')); ?></span>
        </div>
        <h1><?php the_title(); ?></h1>
        <div class="body-note">
          <?php the_content(); ?>
        </div>
        <div class="tags-share">
          <div class="tags">
            <p>
              <span>Etiquetas:</span>
              <?php
                $posttags = get_the_tags();
                if ($posttags) {
                  foreach($posttags as $tag) {
                    echo $tag->name . ', '; 
                  }
                }
              ?>
            </p>
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
        <div class="comentarios">
          <?php comments_template(); ?>
        </div>
      </div>
      <?php get_sidebar(); ?>
    </div>
  </section>

<?php get_footer(); ?>
