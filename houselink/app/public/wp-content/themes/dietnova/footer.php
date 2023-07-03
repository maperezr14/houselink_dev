<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage houselink
 * @since houselink 1.0
 */
?>
<?php 
$acerca_de = get_field('acerca_de', 'option');
$correo_contacto = get_field('correo_contacto', 'option');
$formulario = get_field('formulario', 'option');
?>
 </main>
      <footer>
        <div class="content">
          <div class="about-us">
            <?php houselink_the_custom_logo();?>
            <p><?php echo $acerca_de; ?></p>
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
              <h3>Suscríbete</h3>
              <p>Sé el primero en enterarte de los últimos articulos publicados con información de interés para tí.</p>
              <div class="formulario">
                <?php echo do_shortcode($formulario);?>
              </div>
            </div>
            <div class="mail-contacto">
              <h3>Más información</h3>
              <p>Para más información, escríbenos a:</p>
              <a href="mailto:<?php echo $correo_contacto;?>"><?php echo $correo_contacto;?></a>
            </div>
          </div>          
        </div>
        <div class="close">
          <p>&copy; Diet Nova 2021. Todos los derechos reservados</p>
        </div>
      </footer>
<?php wp_footer(); ?>
</body>
</html>