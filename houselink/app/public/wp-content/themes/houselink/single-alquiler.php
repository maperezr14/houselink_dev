<?php
/**
 * The template for displaying Single Property for rent
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
get_header();
the_post();
$id = get_the_ID();

$property_ubication = get_field('property_ubication');
$property_city = $property_ubication['property_city'];
$property_neighborhood = $property_ubication['property_neighborhood'];
$property_street = $property_ubication['property_street'];
$property_number = $property_ubication['property_number'];
$property_price = get_field('property_price');
$property_gallery = get_field('property_gallery');
$property_form = get_field('property_form');

?>
    <section class="cabecera-inmueble">
      <div class="title-breadcrum">
        <h2>
          Piso en Alquiler en <?php echo $property_street;?>
          <?php
            if (!empty($property_number)) {
            echo ', '. $property_number;
            }
          ?>.
        </h2>
        <p>
          <strong>
            <?php echo $property_neighborhood; ?>
          </strong>
          <span>
            <?php echo $property_price; ?> €
          </span> 
        </p>
      </div>
      <div class="banner-destacado">
          <img src="<?php echo get_the_post_thumbnail_url($id,'full');?>">
      </div>
    </section>
    <section id="inmmueble" class="single-content">
      <div class="content">
        <div class="description">
          <?php echo get_the_content() ?>
        </div>
        <?php
        
        <div class="features">
          <h3>Caracteristicas del Inmueble</h3>
          <div class="features-list">
          <?php
            $property_features = get_field('property_features');

            if (!empty($property_features)) {
                if (!empty($property_features['property_status'])) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/status.svg"> Estado: ' . $property_features['property_status'] . '</p>';
                }

                if (!empty($property_features['property_location'])) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/location.svg"> Ubicación: ' . $property_features['property_location'] . '</p>';
                }

                if (!empty($property_features['property_floor'])) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/floor.svg"> Piso: ' . $property_features['property_floor'] . '</p>';
                }
                if (isset($property_features['property_elevator'])) {
                  if ($property_features['property_elevator']) {
                      echo '<p><img src="' . get_template_directory_uri() . '/assets/img/elevator.svg"> Ascensor: Si</p>';
                  } else {
                      echo '<p><img src="' . get_template_directory_uri() . '/assets/img/elevator.svg"> Ascensor: No</p>';
                  }
                }              

                if (!empty($property_features['property_bedrooms'])) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/bedrooms.svg"> Habitaciones: ' . $property_features['property_bedrooms'] . '</p>';
                }

                if (!empty($property_features['property_bathrooms'])) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/bathroom.svg">  Baños: ' . $property_features['property_bathrooms'] . '</p>';
                }

                if (!empty($property_features['property_energy_certificate'])) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/energy.svg"> Certificado energético: ' . $property_features['property_energy_certificate'] . '</p>';
                }

                if (!empty($property_features['property_size'])) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/size.svg">  Tamaño: ' . $property_features['property_size'] . ' m²</p>';
                }

                if (!empty($property_features['property_furnished'])) {                
                  if (!empty($property_features['property_furnished']) && $property_features['property_furnished']) {
                  } else {
                  }               
                }
                
                if (isset($property_features['property_furnished'])) {
                  if ($property_features['property_furnished']) {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/sofa-on.svg" alt="Amoblado"> Amoblado</p>';
                  } else {
                    echo '<p><img src="' . get_template_directory_uri() . '/assets/img/sofa-off.svg" alt="Sin amoblar"> Sin amoblar</p>';
                  }
                } 
            }
            ?>

          </div>
        </div>        
      </div>
    </section>
    <!-- <section id="contacto" class="contacto contacto-inmueble">
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
  </section> -->
  <!-- <div class="lightbox-tyc" id="pp" style="display: none;">
    <div class="tyc-content">
      <div class="close-box"><i class="far fa-times-circle"></i></div>
      <div class="box">
        <h2><?php the_field('titulo_1', 'option'); ?></h2>
        <div class="tyc-desc">
          <?php the_field('descripcion_1', 'option'); ?>
        </div>
      </div>
    </div>
  </div> -->
<?php
get_footer(); 
?>