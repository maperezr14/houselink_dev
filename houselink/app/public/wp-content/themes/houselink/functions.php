<?php
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Opciones',
    'menu_title'  => 'Opciones',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
}

add_filter('show_admin_bar', '__return_false');
if ( ! function_exists( 'houselink_setup' ) ) :

function houselink_setup() {

	load_theme_textdomain( 'houselink' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'houselink' ),
    'primary_mobile' => __( 'Primary Menu Mobile', 'houselink' ),
		'secundary'  => __( 'Secundary Menu', 'houselink' ),
    'enlaces'  => __( 'Enlaces Útiles', 'houselink' ),
	) );

	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 120,
		'flex-width'  => true,
		'flex-height' => true,
	));

  add_theme_support( 'html5', array(
    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
  ));
}

endif;
add_action( 'after_setup_theme', 'houselink_setup' );

function houselink_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Widget Area', 'houselink' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'houselink' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'houselink_widgets_init' );

if ( ! function_exists( 'houselink_fonts_url' ) ) :

function houselink_fonts_url() {

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin';
	$fonts[] = 'Roboto:300,400,500,700,900';

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => implode( '|', $fonts ) ,
			'subset' => $subsets,
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

endif;


function dimox_breadcrumbs() {

  /* === OPTIONS === */
  $text['home']     = 'Inicio'; // text for the 'Home' link
  $text['category'] = 'Archive by Category "%s"'; // text for a category page
  $text['search']   = 'Search Results for "%s" Query'; // text for a search results page
  $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
  $text['author']   = 'Articles Posted by %s'; // text for an author page
  $text['404']      = 'Error 404'; // text for the 404 page
  $text['page']     = 'Page %s'; // text 'Page N'
  $text['cpage']    = 'Comment Page %s'; // text 'Comment Page N'

  $wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // the opening wrapper tag
  $wrap_after     = '</div><!-- .breadcrumbs -->'; // the closing wrapper tag
  $sep            = '<span class="breadcrumbs__separator"> › </span>'; // separator between crumbs
  $before         = '<span class="breadcrumbs__current">'; // tag before the current crumb
  $after          = '</span>'; // tag after the current crumb

  $show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
  $show_current   = 1; // 1 - show current page title, 0 - don't show
  $show_last_sep  = 1; // 1 - show last separator, when current page title is not displayed, 0 - don't show
  /* === END OF OPTIONS === */

  global $post;
  $home_url       = home_url('/');
  $link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
  $link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
  $link          .= '<meta itemprop="position" content="%3$s" />';
  $link          .= '</span>';
  $parent_id      = ( $post ) ? $post->post_parent : '';
  $home_link      = sprintf( $link, $home_url, $text['home'], 1 );

  if ( is_home() || is_front_page() ) {

    if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;

  } else {

    $position = 0;

    echo $wrap_before;

    if ( $show_home_link ) {
      $position += 1;
      echo $home_link;
    }

    if ( is_category() ) {
      $parents = get_ancestors( get_query_var('cat'), 'category' );
      foreach ( array_reverse( $parents ) as $cat ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
      }
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        $cat = get_query_var('cat');
        echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_current ) {
          if ( $position >= 1 ) echo $sep;
          echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
        } elseif ( $show_last_sep ) echo $sep;
      }

    } elseif ( is_search() ) {
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        if ( $show_home_link ) echo $sep;
        echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_current ) {
          if ( $position >= 1 ) echo $sep;
          echo $before . sprintf( $text['search'], get_search_query() ) . $after;
        } elseif ( $show_last_sep ) echo $sep;
      }

    } elseif ( is_year() ) {
      if ( $show_home_link && $show_current ) echo $sep;
      if ( $show_current ) echo $before . get_the_time('Y') . $after;
      elseif ( $show_home_link && $show_last_sep ) echo $sep;

    } elseif ( is_month() ) {
      if ( $show_home_link ) echo $sep;
      $position += 1;
      echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
      if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_day() ) {
      if ( $show_home_link ) echo $sep;
      $position += 1;
      echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
      $position += 1;
      echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
      if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_single() && ! is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $position += 1;
        $post_type = get_post_type_object( get_post_type() );
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
        if ( $show_current ) echo $sep . $before . get_the_title() . $after;
        elseif ( $show_last_sep ) echo $sep;
      } else {
        $cat = get_the_category(); $catID = $cat[0]->cat_ID;
        $parents = get_ancestors( $catID, 'category' );
        $parents = array_reverse( $parents );
        $parents[] = $catID;
        foreach ( $parents as $cat ) {
          $position += 1;
          if ( $position > 1 ) echo $sep;
          echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
        }
        if ( get_query_var( 'cpage' ) ) {
          $position += 1;
          echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
          echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
        } else {
          if ( $show_current ) echo $sep . $before . get_the_title() . $after;
          elseif ( $show_last_sep ) echo $sep;
        }
      }

    } elseif ( is_post_type_archive() ) {
      $post_type = get_post_type_object( get_post_type() );
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_home_link && $show_current ) echo $sep;
        if ( $show_current ) echo $before . $post_type->label . $after;
        elseif ( $show_home_link && $show_last_sep ) echo $sep;
      }

    } elseif ( is_attachment() ) {
      $parent = get_post( $parent_id );
      $cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
      $parents = get_ancestors( $catID, 'category' );
      $parents = array_reverse( $parents );
      $parents[] = $catID;
      foreach ( $parents as $cat ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
      }
      $position += 1;
      echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
      if ( $show_current ) echo $sep . $before . get_the_title() . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_page() && ! $parent_id ) {
      if ( $show_home_link && $show_current ) echo $sep;
      if ( $show_current ) echo $before . get_the_title() . $after;
      elseif ( $show_home_link && $show_last_sep ) echo $sep;

    } elseif ( is_page() && $parent_id ) {
      $parents = get_post_ancestors( get_the_ID() );
      foreach ( array_reverse( $parents ) as $pageID ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
      }
      if ( $show_current ) echo $sep . $before . get_the_title() . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_tag() ) {
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        $tagID = get_query_var( 'tag_id' );
        echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_home_link && $show_current ) echo $sep;
        if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
        elseif ( $show_home_link && $show_last_sep ) echo $sep;
      }

    } elseif ( is_author() ) {
      $author = get_userdata( get_query_var( 'author' ) );
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_home_link && $show_current ) echo $sep;
        if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
        elseif ( $show_home_link && $show_last_sep ) echo $sep;
      }

    } elseif ( is_404() ) {
      if ( $show_home_link && $show_current ) echo $sep;
      if ( $show_current ) echo $before . $text['404'] . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( has_post_format() && ! is_singular() ) {
      if ( $show_home_link && $show_current ) echo $sep;
      echo get_post_format_string( get_post_format() );
    }

    echo $wrap_after;

  }
} // end of dimox_breadcrumbs()

function houselink_javascript_detection() {

	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

}

add_action( 'wp_head', 'houselink_javascript_detection', 0 );

function houselink_scripts() {
  wp_enqueue_style( 'normalize', get_template_directory_uri().'/assets/css/normalize.css', array(), time() );  
  wp_enqueue_style( 'slick-css', get_template_directory_uri().'/assets/css/slick.css', array(), time() ); 
  wp_enqueue_style( 'materialize-css', get_template_directory_uri().'/assets/css/materialize.min.css', array(), time() );      
  wp_enqueue_style('icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), time() ); 
  wp_enqueue_style('houselink-fonts', houselink_fonts_url() , array() , null);
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css', array(), time() ); 
  wp_enqueue_style( 'houselink-style', get_stylesheet_uri() ); 

  // Load our main stylesheet.
  wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', array(), time(),true );
  wp_enqueue_script( 'materialize-js', get_template_directory_uri() . '/assets/js/materialize.min.js', array(), time(),true );  
  wp_register_script( 'houselink-script', get_template_directory_uri() . '/assets/js/funciones.js', array(), time(), true );
  wp_localize_script( 'houselink-script', 'URL', get_site_url());
  wp_localize_script( 'houselink-script', 'URLTHEME', get_template_directory_uri());
  wp_localize_script( 'houselink-script', 'ajaxhouselink', array(

    'ajaxurl'  => admin_url( 'admin-ajax.php'),
    'seguridad' => wp_create_nonce("load_more_posts"),

  ));

  wp_enqueue_script( 'houselink-script');
}

add_action( 'wp_enqueue_scripts', 'houselink_scripts' );
add_filter('style_loader_tag', 'remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'remove_type_attr', 10, 2);
add_filter('show_admin_bar', '__return_false');

function remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

function houselink_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}

add_filter( 'get_search_form', 'houselink_search_form_modify' );

function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['json'] = 'application/json';
	return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function create_post_type() {
    
    //CPT Servicios
    register_post_type('Servicios', array(
        'labels' => array(
            'name' => __('Servicios') ,
            'singular_name' => __('Servicio')
        ) ,
        'public' => true,
        'show_in_nav_menus' => true,
        'add_new' => 'Agregar Nuevo',
        'has_archive' => false,
        'menu_icon' => 'dashicons-admin-network',
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'page-attributes'
        ) ,
        'rewrite' => array(
            'slug' => 'servicios',
            'with_front' => false
        ) ,
    ));

    register_post_type('Alquiler', array(
      'labels' => array(
          'name' => __('Inmuebles en Alquiler') ,
          'singular_name' => __('Inmueble en Alquiler')
      ) ,
      'public' => true,
      'show_in_nav_menus' => true,
      'add_new' => 'Agregar Nuevo',
      'has_archive' => false,
      'menu_icon' => 'dashicons-building',
      'supports' => array(
          'title',
          'editor',
          'thumbnail',
          'page-attributes'
      ) ,
      'rewrite' => array(
          'slug' => 'para-alquilar',
          'with_front' => false
      ),
      'template' => true
    ));   
    
    register_post_type('Comprar', array(
      'labels' => array(
          'name' => __('Comprar') ,
          'singular_name' => __('Comprar')
      ) ,
      'public' => true,
      'show_in_nav_menus' => true,
      'add_new' => 'Agregar Nuevo',
      'has_archive' => false,
      'menu_icon' => 'dashicons-building',
      'supports' => array(
          'title',
          'editor',
          'thumbnail',
          'page-attributes'
      ) ,
      'rewrite' => array(
          'slug' => 'para-comprar',
          'with_front' => false
      ) ,
    ));
}

function custom_pagination($numpages = '', $pagerange = '', $paged='',$url = '') {

  if (empty($pagerange)) {
    $pagerange = 2;
  }

  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }

  if (empty($url)) {
    $url = get_pagenum_link(1);
  }

  /** 
   * We construct the pagination arguments to enter into our paginate_links
   * function. 
   */

$pagination_args = array(
    'base'            => $url. '%_%',
    'format'          => 'page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __( '<i class="fas fa-chevron-left"></i>', 'houselink' ),
    'next_text'       => __( '<i class="fas fa-chevron-right"></i>', 'houselink' ),
    'type'            => 'plain',
    'add_args'        => false,
    'add_fragment'    => ''
);

$paginate_links = paginate_links($pagination_args);

  if ($paginate_links) {
    echo '<nav class="pagination" >';
    echo $paginate_links;
    echo "</nav>";
  }
}


function add_classes_on_li($classes, $item, $args) {
  $classes[] = 'c-menu__item';
  return $classes;
}

add_action( 'init', 'create_post_type');
add_filter( 'nav_menu_css_class','add_classes_on_li',1,3);
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
add_filter( 'auto_update_plugin', '__return_true' );

function houselink_com() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $imagen = wp_get_attachment_image( $custom_logo_id, 'full', false, array('class'    => 'img-logo',));

   /* if (!is_front_page()) 
    {
      $imagen = '<img src="'.get_theme_mod( 'logo_internas' ).'" class="img-logo" >';
    }*/

    $html = sprintf( '<a href="%1$s" class="logo" rel="home">%2$s</a>',
            esc_url( home_url( '/' ) ),$imagen);
    return $html;   
} 

function add_class_to_all_menu_anchors( $atts ) {

    $aux = explode("#",$atts['href']);



    if(count($aux) == 2 and empty($aux[0]))

    {

        $atts["href"] = get_site_url()."#".$aux[1];

    }

 

    return $atts;

}

add_filter( 'nav_menu_link_attributes', 'add_class_to_all_menu_anchors', 10 );
add_filter( 'get_custom_logo', 'houselink_com' );

require get_template_directory() . '/inc/template-tags.php';

function remove_json_api () {
  remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action( 'rest_api_init', 'wp_oembed_register_route' );
  add_filter( 'embed_oembed_discover', '__return_false' );
  remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
  remove_filter( 'oembed_response_data', 'get_oembed_response_data_rich', 10, 4 );
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
  remove_action( 'wp_head', 'wp_oembed_add_host_js' );
  add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
  remove_action('wp_head', 'wp_print_scripts');
  add_action('wp_footer', 'wp_print_scripts', 5);
  add_action('wp_footer', 'wp_print_head_scripts', 5);
}

add_action( 'after_setup_theme', 'remove_json_api' );

function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}

add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});

add_filter( 'xmlrpc_methods', function( $methods ) {
   unset( $methods['pingback.ping'] );
   return $methods;
} );

function theme_slug_get_social_sites() {
	$social_sites = array(
    array('nombre' => 'facebook' , 'icono' => 'fab fa-facebook-f', 'color' => '#3b5998'),
    array('nombre' => 'instagram' , 'icono' => 'fab fa-instagram', 'color' => '#405de6'),
    array('nombre' => 'linkedin' , 'icono' => 'fab fa-linkedin-in', 'color' => '#0077b5'),
		array('nombre' => 'facebook-messenger' , 'icono' => 'fab fa-facebook-messenger', 'color' => '#0084ff'),
    array('nombre' => 'twitter' , 'icono' => 'fab fa-twitter', 'color' => '#1da1f2'),        
    array('nombre' => 'google-plus' , 'icono' => 'fab fa-google-plus', 'color' => '#dd4b39'),
		array('nombre' => 'pinterest' , 'icono' => 'fab fa-pinterest', 'color' => '#bd081c'),
		array('nombre' => 'youtube' , 'icono' => 'fab fa-youtube', 'color' => '#ff0000'),
		array('nombre' => 'vimeo' , 'icono' => 'fab fa-vimeo-v', 'color' => '#1ab7ea'),
    array('nombre' => 'rss' , 'icono' => 'fas fa-rss', 'color' => '#f26522')
	);
	return $social_sites;
}

function theme_slug_show_social_icons($tipo = "icono") {
     $social_sites = theme_slug_get_social_sites();
     foreach( $social_sites as $social_site ) {
         if ( strlen( get_theme_mod( $social_site["nombre"] ) ) > 0 ) {
             $active_sites[] = $social_site;
         }
     }

     if ( !empty( $active_sites ) ) {
         foreach ( $active_sites as $active_site ) { ?>
            <a href="<?php echo get_theme_mod( $active_site["nombre"] ); ?>" target="_blank" <?php /* ?>style="background-color: <?php echo $active_site["color"]; ?>" <?php */ ?>>
                <?php
                if($tipo == "icono")
                {
                ?>
                <i class="<?php echo $active_site["icono"]; ?>"></i>
                <?php
                }else{
                    echo $active_site["nombre"];
                }
                ?>
            </a>
         <?php
         }
     }
}

function footer_custom($wp_customize)
{

	$social_sites = theme_slug_get_social_sites();
	$priority = 5;

	$wp_customize->add_section( 'seccion_redes', array(
	    'title'      => __("Redes sociales", 'houselink' ),   
	    'priority'   => 30,
	));

	foreach( $social_sites as $social_site ) {

		$wp_customize->add_setting($social_site["nombre"], array(
			'default'   => '',
			'transport' => 'refresh',
		));

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "control_link_".$social_site["nombre"], 
			array(
				'label'      => __(ucfirst(str_replace('-', ' ', $social_site["nombre"])), 'houselink' ),
				'section'    => 'seccion_redes',
				'settings'   => $social_site["nombre"],
				'type'           => 'url',
				'priority' => $priority,			
			)
		));
	    $priority += 5;
	}
}

add_action( 'customize_register' ,"footer_custom");

function vermas_blog()
{
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $actual = $_POST['actual'];
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => get_option("posts_per_page"),
        'paged' => $paged,
    );

    if(isset($actual) and !empty($actual))
    {
       $args["post__not_in"] = array($actual);
    }

    $my_posts = new WP_Query( $args );
    if ( $my_posts->have_posts() ){
        while ( $my_posts->have_posts() ){
          $my_posts->the_post();
          $id_post = get_the_ID();
          $imagen = get_the_post_thumbnail_url($id_post,'full');
          $titulo = get_the_title();
          $excerpt = get_the_excerpt($id_post);
    ?>
        <div class="noticia">
          <a href="<?php echo esc_url( get_permalink($id_post) ); ?>">
            <div class="img-portada">
              <img src="<?php echo $imagen ; ?>" alt="Clinica Angloamericana">
            </div>
            <div class="titular-content">
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
              
              <h2><?php echo $titulo; ?></h2>
              <p class="resumen"><?php echo $excerpt; ?></p>
            </div>
          </a>
        </div>
    <?php 
      } 
    }
 
    wp_die();
}

add_action('wp_ajax_nopriv_vermas_blog', 'vermas_blog');
add_action('wp_ajax_vermas_blog', 'vermas_blog');

function wp_lista_random()

{

    $args = array(

            'post_type' => 'post',

            'orderby'   => 'rand',

            'posts_per_page' => 4, 

        );

         

    $the_query = new WP_Query( $args );



    if ( $the_query->have_posts())

    {

    ?>

    <div class="row">



    <?php

        while ( $the_query->have_posts() ) {

            $the_query->the_post();

            $postid = $the_query->ID;

            $title = get_the_title();

            ?>

            <div class="col-lg-12 col-6 post-destacado">

                <div class="row align-items-center">

                    <div class="col-lg-5 col-12 contenedor-thumbaail-circulo">

                        <div class="contenedor-thum">

                        <?php if ( has_post_thumbnail() ) : ?>

                                <?php the_post_thumbnail("thumbnail", ['class' => 'thumbaail-circulo']); ?>

                        <?php endif; ?> 

                        </div>

                    </div>

                    <div class="col-lg-7 col-12">

                        <a href="<?php echo get_permalink($postid); ?>"><h3><?php echo $title; ?></h3></a>

                        <p><?php echo get_the_date("d  F") ?></p>

                        <h4><?php echo get_the_author() ?></h4>

                    </div>                          

                </div>

            </div>              

        <?php 

        }

    ?>



    </div>

    <?php

        wp_reset_postdata();

    }   

}

function houselink_post_meta()
{
?>
<div class="blog-layout-meta">

    <ul class="post-meta-box">

        <li>

        <?php

            $categories = get_the_category();

            $lista = array();

            foreach ($categories as $key => $categorie) {

                $lista[] = '<a href="' . esc_url( get_category_link( $categorie->term_id ) ) . '">' . esc_html( $categorie->name ) . '</a>';

            }

            echo implode(", ", $lista);
        ?>  
        </li>
        <li class="vcard author">By  <?php echo get_the_author(); ?></li>
        <li class="published"><?php $tiempo = explode("-",  get_the_date("M-d-Y"))?>
            <time datetime="<?php echo get_the_date("Y-m-d")?>" ><?php echo $tiempo[1]." ".$tiempo[0]." ".$tiempo[2]; ?></time>
        </li>
    </ul>
</div>
<?php
}

function wpcf7_modify_this($posted_data) {
    /* if checkbox isn't checked send Nej to mail */
    if ($posted_data['privacidad'][0] == "")
        $posted_data['privacidad'][0] = "Nej";
    return $posted_data;
}

add_action("wpcf7_posted_data", "wpcf7_modify_this");

add_filter( 'comment_form_default_fields', 'bootstrap4_comment_form_fields' );

function bootstrap4_comment_form_fields( $fields ) {

    $commenter = wp_get_current_commenter();

    $req      = get_option( 'require_name_email' );

    $aria_req = ( $req ? " aria-required='true'" : '' );

    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

    $fields   =  array(

        'author' => '<div class="form-group  comment-form-author col-lg-6 col-md-6 col-sm-6 col-xs-12">'.

                    '<label>Nombre*</label>'.

                    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  size="30"' . $aria_req . ' /></div>',

        'email'  => '<div class="form-group comment-form-email col-lg-6 col-md-6 col-sm-6 col-xs-12">'.

                    '<label>Correo*</label>'.

                    '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . '  value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',

       /* 'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .

                    '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'  */      

    );

    

    return $fields;

}


add_filter( 'comment_form_defaults', 'bootstrap4_comment_form' );

function bootstrap4_comment_form( $args ) {

    $args['comment_field'] = '<div class="form-group comment-form-comment col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <label>Comentario</label>

            <textarea  class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>

        </div>';

    $args['class_submit'] = 'btn btn-enviar-comentario'; // since WP 4.1

    $args['title_reply'] =  __('Agregar comentario');

    $args['title_reply_before'] = '<div class="content-title-form"><div class="contenedor-title-comment"><h2 id="reply-title" class="comment-reply-title">';

    $args['title_reply_after'] =  '</h2></div></div>';

    $args['label_submit'] =  __('Publicar comentario');

    $args['comment_notes_before' ] =  '';

    $args['submit_field' ] = '<div class="form-submit col-lg-12 col-md-12 col-sm-12 col-xs-12">%1$s %2$s</div>';

    $args['class_form'] = 'comment-form row';

    

    return $args;

}

class Basico_Walker_Comment extends Walker {

  

    public $tree_type = 'comment';

   

    public $db_fields = array('parent' => 'comment_parent', 'id' => 'comment_ID');

    /**

     * Start the list before the elements are added.

     * @param string $output Passed by reference. Used to append additional content.

     * @param int $depth Depth of comment.

     * @param array $args Not use.

     */

    public function start_lvl(&$output, $depth = 0, $args = array()) {

        $GLOBALS['comment_depth'] = $depth + 1;

        $output.="<!-- start_lvl: $depth -->"; //only for help purpose

    }

    /**

     * End the list of items after the elements are added.

     *

     * @param string $output Passed by reference. Used to append additional content.

     * @param int    $depth  Depth of comment.

     * @param array  $args   Not use.

     */

    public function end_lvl(&$output, $depth = 0, $args = array()) {

        $GLOBALS['comment_depth'] = $depth + 1;

        $output.="<!-- end_lvl: $depth -->"; //only for help purpose

    }

    /**

     * Traverse elements to create list from elements.

     *

     * This function is designed to enhance Walker::display_element() to

     * display children of higher nesting levels than selected inline on

     * the highest depth level displayed. This prevents them being orphaned

     * at the end of the comment list.

     *

     * @param object $element           Data object.

     * @param array  $children_elements List of elements to continue traversing.

     * @param int    $max_depth         Max depth to traverse.

     * @param int    $depth             Depth of current element.

     * @param array  $args              An array of arguments.

     * @param string $output            Passed by reference. Used to append additional content.

     * @return null Null on failure with no changes to parameters.

     */

    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output) {

        if (!$element)

            return;

        $id_field = $this->db_fields['id'];

        $id = $element->$id_field;

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

        // If we're at the max depth, and the current element still has children, loop over those and display them at this level

        // This is to prevent them being orphaned to the end of the list.

        if ($max_depth <= $depth + 1 && isset($children_elements[$id])) {

            foreach ($children_elements[$id] as $child)

                $this->display_element($child, $children_elements, $max_depth, $depth, $args, $output);

            unset($children_elements[$id]);

        }

    }

    /**

     * Start the element output.

     *

     * @param string $output  Passed by reference. Used to append additional content.

     * @param object $comment Comment data object.

     * @param int    $depth   Depth of comment in reference to parents.

     * @param array  $args    An array of arguments.

     */

    public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {

        $depth++;

        $GLOBALS['comment_depth'] = $depth;

        $GLOBALS['comment'] = $comment;

        $output.="<!-- start_el: $depth -->";

        if (( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping']) {

            ob_start();

            $this->ping($comment, $depth, $args);

            $output .= ob_get_clean();

        } else {

            $output.="\n" . '<div class="media" >';

            ob_start();

            $this->comment($comment, $depth, $args);

            $output .= ob_get_clean();

        }

    }

    /**

     * Ends the element output, if needed.

     * @param string $output  Passed by reference. Used to append additional content.

     * @param object $comment The comment object. Default current comment.

     * @param int    $depth   Depth of comment.

     * @param array  $args    An array of arguments.

     */

    public function end_el(&$output, $comment, $depth = 0, $args = array()) {

        $output.="\n</div><!-- end_el: $depth -->";

        $output.="\n</div><!-- Extra end_el: $depth -->";

    }

    /**

     * Output a pingback comment.

     *

     * @param object $comment The comment object.

     * @param int    $depth   Depth of comment.

     * @param array  $args    An array of arguments.

     */

    protected function ping($comment, $depth, $args) {

        $tag = 'div';

        ?>

        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>

        <div class="comment-body">

        <?php _e('Pingback:'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>

        </div>

        <?php

    }

    /**

     * Output a single comment.

     *

     * @param object $comment Comment to display.

     * @param int    $depth   Depth of comment.

     * @param array  $args    An array of arguments.

     */

    protected function comment($comment, $depth, $args) {

        $add_below = 'comment';

        ?>



        <div class="media-left">

            <div class="comment-author vcard">

            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

 

            </div>

        </div>

        <div class="media-body">

            <h4 class="media-heading">



        <?php printf(__('%s'), get_comment_author_link()); ?>

            </h4>



        <?php if ($comment->comment_approved == '0') : ?>

                <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></em>

                <br />

        <?php endif; ?>



            <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">



            <?php

            /* translators: 1: date, 2: time */

            printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time());

            ?></a><?php edit_comment_link(__('(Edit)'), '  ', '');

            ?>

            </div>



            <?php comment_text(); ?>

            <div class="reply">

                <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>

            </div>

      <?php

            }

        }

class Materialize_Walker_Nav_Menu extends Walker_Nav_Menu {
  /**
   * Unique id for dropdowns
   */
  public $submenu_unique_id = '';
  /**
   * Starts the list before the elements are added.
   *
   * @see Walker::start_lvl()
   *
   * @param string   $output Passed by reference. Used to append additional content.
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat( $t, $depth );
    $output .= "{$n}{$indent}<ul id=\"$this->submenu_unique_id\" class=\"sub-menu dropdown-content\">{$n}";
  }
  /**
   * Ends the list of after the elements are added.
   * 
   * @see Walker::end_lvl()
   *
   * @param string   $output Passed by reference. Used to append additional content.
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat( $t, $depth );
    $output .= "$indent</ul>{$n}";
  }
  /**
   * Starts the element output.
   * 
   * @see Walker::start_el()
   *
   * @param string   $output Passed by reference. Used to append additional content.
   * @param WP_Post  $item   Menu item data object.
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   * @param int      $id     Current item ID.
   */
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    // set active class for current nav menu item
    if( $item->current == 1 ) {
      $classes[] = 'active';
    }
    // set active class for current nav menu item parent
    if( in_array( 'current-menu-parent' ,  $classes ) ) {
      $classes[] = 'active';
    }
    /**
     * Filters the arguments for a single nav menu item.
     *
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param WP_Post  $item  Menu item data object.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
    // add a divider in dropdown menus
    if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
      $output .= $indent . '<li class="divider">';
    } else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
      $output .= $indent . '<li class="divider">';
    } else {
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
      $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
      $output .= $indent . '<li' . $id . $class_names .'>';
      $atts = array();
      $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
      $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
      $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
      if( in_array('menu-item-has-children', $classes ) ) {
        $atts['href']   = $item->url;
        $this->submenu_unique_id = 'dropdown-'.uniqid();
        $atts['data-activates'] = $this->submenu_unique_id;
        $atts['data-belowOrigin'] = 'true';
        if( strpos( $args->menu_class , 'side-nav' ) !== FALSE ) {
          $atts['class'] = ' side-menu-nav-item-dropdown-button';
        } else {
          $atts['class'] = ' nav-item-dropdown-button';
        }
      } else {
        $atts['href']   = ! empty( $item->url ) ? $item->url  : '';
        $atts['class'] = '';
      }
      $atts['class'] .= ' waves-effect waves-light';
      $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
      $attributes = '';
      foreach ( $atts as $attr => $value ) {
        if ( ! empty( $value ) ) {
          $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
          $attributes .= ' ' . $attr . '="' . $value . '"';
        }
      }
      if( ! in_array( 'icon-only' , $classes ) ) {
        
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
      }
      $item_output = $args->before;
      $item_output .= '<a'. $attributes .'>';
      // set icon on left side
      if( !empty( $classes ) ) {
        foreach ($classes as $class_name) {
          if( strpos( $class_name , 'material_icon' ) !== FALSE ) {
            $icon_name = explode( '-' , $class_name );
            if( isset( $icon_name[1] ) && !empty( $icon_name[1] ) ) {
              $item_output .= '<i class="material-icons left">'.$icon_name[1].'</i>';
            }
          }
        }
      }
      $item_output .= $args->link_before . $title . $args->link_after;
      if( in_array('menu-item-has-children', $classes) ){
        if( $depth == 0 ) {
              $item_output .= '<i class="material-icons right">arrow_drop_down</i>';
          }
        }
      $item_output .= '</a>';
      $item_output .= $args->after;
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
  }
  /**
   * Ends the element output, if needed.
   *
   * @since 3.0.0
   *
   * @see Walker::end_el()
   *
   * @param string   $output Passed by reference. Used to append additional content.
   * @param WP_Post  $item   Page data object. Not used.
   * @param int      $depth  Depth of page. Not Used.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  public function end_el( &$output, $item, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $output .= "</li>{$n}";
  }
} // Materialize_Walker_Nav_Menu