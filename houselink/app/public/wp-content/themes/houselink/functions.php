<?php
/**
 * The main template file
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package      Houselink
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

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
'name' => __('Servicios'),
'singular_name' => __('Servicio')
),       
'public' => true,
'show_in_nav_menus' => true,
'has_archive' => false,
'menu_icon' => 'dashicons-admin-network', 
'supports' => array('title','editor', 'thumbnail','page-attributes'),  
'rewrite'  => array('slug' => 'servicios', 'with_front' => false ),  
)
);
//CPT Inmuebles para comprar
register_post_type('Comprar', array(
'labels' => array(
'name' => __('Inmuebles en Venta'),
'singular_name' => __('Comprar')
),
'public' => true,
'show_in_nav_menus' => true,
'has_archive' => false,
'menu_icon' => 'dashicons-building', 
'supports' => array('title','editor', 'thumbnail','page-attributes'), 
'rewrite'  => array( 'slug' => 'para-comprar','with_front' => false ),
'taxonomies' => array('categoria_inmuebles'), 
'template' => true // Habilitar la selección de plantilla 
)
);
//CPT Inmuebles para alquilar
register_post_type('Alquilar', array(
'labels' => array(
// 'name' => __('Inmuebles en Alquiler'),
// 'singular_name' => __('Alquilar')
'name'                  => 'Inmuebles para alquilar',
'singular_name'         => 'Inmueble para alquilar',
'menu_name'             => 'Inmuebles Alquiler',
'add_new'               => 'Agregar Nuevo',
'add_new_item'          => 'Agregar Nuevo Inmueble para alquilar',
'edit_item'             => 'Editar Inmueble para alquilar',
'new_item'              => 'Nuevo Inmueble para alquilar',
'view_item'             => 'Ver Inmueble para alquilar',
'view_items'            => 'Ver Inmuebles para alquilar',
'search_items'          => 'Buscar Inmuebles para alquilar',
'not_found'             => 'No se encontraron inmuebles para alquilar',
'not_found_in_trash'    => 'No se encontraron inmuebles para alquilar en la papelera',
'all_items'             => 'Todos los Inmuebles para alquilar',
),
// 'public' => true,
// 'has_archive' => false,
// 'menu_icon' => 'dashicons-building', 
// 'supports' => array('title','editor', 'thumbnail','page-attributes'), 
// 'rewrite'  => array( 'slug' => 'para-alquilar','with_front' => false ),
// 'taxonomies' => array('categoria_inmuebles'),

'public'              => true,
'has_archive'         => true,
'menu_icon'           => 'dashicons-building', // Icono del menú (puedes cambiarlo)
'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'), 
'rewrite'             => array('slug' => 'para-alquilar'),
'show_in_nav_menus' => true,
'publicly_queryable'  => true,
'query_var'           => true,
'capability_type'     => 'post',
'template' => true // Habilitar la selección de plantilla
)
);

}
add_action( 'init', 'create_post_type');

//Remove Comments
function remove_closed_comments_message( $comments_text ) {
if ( ! comments_open() && get_comments_number() == 0 && ! pings_open() ) {
$comments_text = '';
}
return $comments_text;
}
add_filter( 'comments_closed_text', 'remove_closed_comments_message' );
add_filter( 'comments_open_text', 'remove_closed_comments_message' );

function remove_closed_comments_notice() {
if ( ! comments_open() && get_comments_number() == 0 && ! pings_open() ) {
global $pagenow;
if ( $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
echo '<style>#message.updated p.notice, #message.updated .updated p { display: none; }</style>';
}
}
}
add_action( 'admin_head', 'remove_closed_comments_notice' );

function add_classes_on_li($classes, $item, $args) {
$classes[] = 'c-menu__item';
return $classes;
}

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