<?php
/**
 * The template for displaying pages
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage houselink
 * @since houselink 1.0
 */

get_header();

$id = get_option('page_for_posts');
$descripcion = get_field("descripcion",$id);
?>
<script>
	var post_actual = "";
</script>
<!-- <section class="cabecera-internas">
  <div class="banner-breadcrum">
      <img src="<?php //echo $imagen; ?>">
      <div class="title-breadcrum">
        <h2><?php //The_title(); ?></h2>
        <div class="breadcrum">
          <?php //if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
        </div>
      </div>
    </div>
</section> -->
<section id="noticias" class="">
  <div class="content noticias">
  	<div class="lista-noticias">
	    <div class="noticias-destacadas otras-noticias">
	      	<?php if ( have_posts() ) :
	      		$contador = 1; 			
				while ( have_posts() ) : the_post();
				$id_post = get_the_ID();
				$imagen = get_the_post_thumbnail_url($id_post,'full');
				$titulo = get_the_title();
				$excerpt = get_the_excerpt($id_post);
			?>
			<div class="noticia">
				<a href="<?php echo esc_url( get_permalink($id_post) ); ?>">
				  <div class="img-portada">
				    <img src="<?php echo $imagen ; ?>" alt="<?php echo $titulo; ?>">
				  </div>
				  <div class="titular-content">
				  	<div class="tags">
				  		<span class="category">
	                        <?php
	                          foreach((get_the_category()) as $category) {
	                                echo $category->cat_name . ' ';
	                          }
	                        ?>                  
                      	</span>
                      	<?php
					  	$diff  = strtotime("now") - get_the_time('U',$id_post);
						$fecha = floor($diff / 3600);
						if($fecha <= 24)
						{
						?>
							<p class="date-new">Hace <?php echo $fecha; ?> h</p>
						<?php	
						}else{
							$tiempo = explode("-",  get_the_date("M-d-Y"));
						?>
							<p class="date-new"><?php echo $tiempo[1]." de ".$tiempo[0]." del ".$tiempo[2]; ?></p>
						<?php	
						}
					  	?>
				  	</div>
				    <h2><?php echo $titulo; ?></h2>
				    <p class="resumen"><?php echo $excerpt; ?></p>
				    <span class="seguir-leyendo">Seguir leyendo</span>
				  </div>
				</a>
			</div>

			<?php

				if($contador == 3)
				{
			?>
			<?php		
				}

				$contador++;
				endwhile;
			else :
				echo "";

			endif;
			?>
	    </div>
	    <div class="mas-noticias">
	      <a id="loadMore" href="javascript:void(0)" class="btns btn-shadow">Ver más atrículos</a>
	    </div>
    </div>
    <?php get_sidebar(); ?>
  </div>
</section>
<?php
get_footer(); ?>
