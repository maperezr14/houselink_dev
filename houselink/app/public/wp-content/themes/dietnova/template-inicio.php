<?php
/**
    Template Name: template inicio
 */
get_header();
the_post();
$id = get_the_ID();
$imagenppal = get_field("imagenppal",$id);
$imagen = $imagenppal["imagen"];
$titulo = $imagenppal["titulo"];
$bajada = $imagenppal["bajada"];
?>
    <section id="banners" class="">
      <div class="content slider-ppal">
        <div class="image">
          <div class="image-grafica">
            <img src="<?php echo $imagen;?>" alt="Diet Nova">
          </div>
          <div class="image-triangle">
            <img src="../wp-content/themes/houselink/assets/img/pattern-1024x1024.png">
          </div>
          <div class="image-circle">
            <img src="../wp-content/themes/houselink/assets/img/circle.png">
          </div>
        </div>
        <div class="caption">
          <h1><?php echo $titulo; ?></h1>
          <p><?php echo $bajada; ?></p>
        </div>
      </div>
    </section>

<?php 
$descripcion_2 =  get_field("descripcion_2",$id);
$titulo_2 =  get_field("titulo_2",$id);
$cards = get_field("cards",$id);
?>
<section id="nos-adaptamos" class="nos-adaptamos">
  <div class="content">
    <div class="title-bajada">
      <h2 class="title"><?php echo $titulo_2; ?></h2>
      <?php echo $descripcion_2; ?>
    </div>
    <div class="cards">
      <?php
        foreach ($cards as $key => $card) {
          $icono = $card["icono"];
          $etiqueta = $card["etiqueta"];?>
        <div class="card">
          <img src="<?php echo $icono;?>" alt="Diet Nova">
          <h3><?php echo $etiqueta;?></h3>
        </div> 
        <?php
        }
        ?>
    </div>
  </div>
</section>

<section id="services" class="single-content service-home">
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

<section id="tarifas" class="single-content tarifas-home">
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
$titulo_blog =  get_field("titulo_blog",$id);
$bajada =  get_field("bajada",$id);
?> 
        <section id="ultimos-articulos" class="ultimos-articulos single-content">
          <div class="content">
            <div class="desc-single">
              <h2 class="title"><?php echo $titulo_blog;?></h2>
              <p><?php echo $bajada;?></p>
              <div class="lista-articulos">
                <?php
                $args = array(
                  'post_type' => 'post',
                  'post_status' => 'publish',
                  'posts_per_page' => 2
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
                      <div class="articulo">
                        <a href="<?php echo esc_url( get_permalink($id_post) ); ?>">
                          <div class="image-article">
                            <img src="<?php echo $imagen?>" alt="<?php echo $titulo; ?>">
                          </div>
                          <div class="info-article">
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
                            <h3><?php echo $titulo; ?></h3>
                            <p><?php echo $excerpt; ?></p>
                            <a href="<?php echo esc_url( get_permalink($id_post) ); ?>"><span class="seguir-leyendo">Seguir leyendo</span></a>
                          </div>
                        </a>
                      </div>
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