<?php
class O612SuscripcionMailchimp {

  function __construct() {
    add_action( 'init', [$this, 'init'] );
    add_action( 'template_redirect', [$this, 'template_redirect'] );
    add_shortcode( 'formulario-suscripcion', [$this, 'shortcode_formulario_suscripcion'] );
  }

  function init() {
    register_post_type(
      'suscriptores', array(
          'labels' =>  array('name' => __('Suscriptores', 'suscripcion'), 'singular_name' => __('Lead', 'suscripcion')),
          'public' => true,
          'exclude_from_search' => true,
          'show_in_admin_bar'   => false,
          'show_in_nav_menus'   => false,
          'publicly_queryable' => false,
          'query_var'   => false,
          'menu_icon'   => 'dashicons-groups',
          'supports'    => array( 'title', 'editor')
      )
    );
  }

  function shortcode_formulario_suscripcion( $atts ){
    ob_start();
    include 'shortcodes/formulario-suscripcion.php';
    $formulario = ob_get_clean();
    return $formulario;  
  }

  function template_redirect() {
    if ($_POST) {
      wp_insert_post([
        'post_title' => $_POST['nombre'],
        'post_content' => $_POST['email'],
        'post_type' => 'suscriptores',
        'post_status' => 'publish'
      ]);
    }
  }

}