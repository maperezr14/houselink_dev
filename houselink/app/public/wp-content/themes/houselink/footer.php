<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package      Houselink
 * @author       maridev.es
 * @since        1.0.0
 * @license      GPL-2.0+
**/
?>
<?php 
$options = get_fields('option');
$correo_contacto = $options['correo_contacto'];
$formulario = $options['formulario'];
$logo_footer = $options['logo_footer'];
$copyright_footer = $options['copyright_footer'];

?>
 </main>
      <footer>
        <div class="content">
          <div class="about-us">
            <img src="<?php echo $logo_footer;?>" alt="Houselink">
          </div>
          <div class="enlaces-utiles">
            <?php if ( has_nav_menu( 'enlaces' )): ?>
              <ul class="enlaces">
              <?php
                  wp_nav_menu(array(
                    'menu' => '',
                    'container' => '',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => '',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '%3$s',
                    'depth' => 0,
                    'theme_location' => 'enlaces',
                    'walker'        =>  new Materialize_Walker_Nav_Menu(),
                  ));
                endif; ?> 
              </ul>
          </div>
          <div class="suscribe-contact">
            <div class="suscripcion">
              <h3>Newsletter</h3>
              <p>Suscribete y sé el primero en enterarte de los últimos articulos publicados con información de interés para tí.</p>
              <div class="formulario">
                <?php echo do_shortcode($formulario);?>
              </div>
            </div>
          </div>          
        </div>
        <div class="close">
          <p>&copy; <?php echo $copyright_footer; ?></p>
        </div>
      </footer>
<?php wp_footer(); ?>
</body>
</html>