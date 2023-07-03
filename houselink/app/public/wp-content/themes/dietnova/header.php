<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage caa
 * @since caa 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>

  <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/c2409a107bffdceb2ccbb986f/8b96eb580ae9780fd96456536.js");</script>
</head>
<body <?php body_class(); ?>>	
      <header>
        <nav class="nav-extended">
          <div class="nav-wrapper">           	
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="fas fa-bars"></i></a>
              <div class="content-nav">
                <?php
                  if ( has_nav_menu( 'primary' )):
                ?>
                <ul id="menu-principal" class="menu-desktop">
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
                      'theme_location' => 'primary',
                      'walker'        =>  new Materialize_Walker_Nav_Menu(),
                    ));
                ?>
                </ul>
                <?php houselink_the_custom_logo();?>
                <ul id="menu-secundario" class="menu-desktop">
                  <?php
                    if ( has_nav_menu( 'secundary' )):
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
                        'theme_location' => 'secundary',
                        'walker'        =>  new Materialize_Walker_Nav_Menu(),
                      ));
                    endif;
                  ?>  
                </ul>
              </div>
              <?php 
                endif;

                if ( has_nav_menu( 'primary' )):
              ?>
              <ul id="menu-mobile" class="menu-mobile">
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
                    'theme_location' => 'primary_mobile',
                    'walker'        =>  new Materialize_Walker_Nav_Menu(),
                  ));
              ?>
              </ul>
              <?php 
                endif;
              ?>
          </div>
        </nav>
      </header>
<main>	