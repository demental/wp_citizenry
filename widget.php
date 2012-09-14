<?php

class Citizenry_bridge_Widget extends WP_Widget {

	public function __construct() {
    $options = array(
    "classname" => "citizenry-bridge-widget",
    "description" => "Display random registered user"
    );
    parent::__construct("citizenry-bridge-widget", "Citizenry random user", $options);
	}

 	public function form( $instance ) {
		// outputs the options form on admin
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}

	public function widget( $args, $defaut ) {
    $data = wp_parse_args($data, $defaut);
    global $wpdb;

    $table_prefix = $wpdb->prefix;

    extract($args);
    echo $before_widget;
    $json = citizenry_fetch('people/random');
    extract($json);
    include plugin_dir_path(__FILE__).'./widget/template.php';

    echo $after_widget;
	}
}
function citizenry_register_widgets(){
  register_widget( 'Citizenry_bridge_Widget' );
}
add_action('widgets_init', 'citizenry_register_widgets');