<?php
/*
Plugin Name: RecipeCentral Search Widget
Plugin URI: http://recipecentral.com
Description: Add a RecipeCentral.com search form to your site
Version: 1.0
Author: Jeff Wolfe
Author URI: http://wolfeplanet.net
License: GPLv2
 */

add_action( 'widgets_init', 'recipe_central_widget_init');
function recipe_central_widget_init() {
	register_widget('recipe_central_widget');
}

class recipe_central_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'recipe_central_widget', // Base ID
			'RecipeCentral Widget', // Name
			array( 'description' => 'RecipeCentral Widget' ) // Args
		);
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => 'Recipe Central Search',
			'subdomain' => 'recipes'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$subdomain = $instance['subdomain'];

		?>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $title; ?>" /></label><br>
		<label for="<?php echo $this->get_field_id('subdomain'); ?>">Your Recipe Central Subdomain: <input class="widefat" type="text" name="<?php echo $this->get_field_name('subdomain'); ?>" id="<?php echo $this->get_field_id('subdomain'); ?>" value="<?php echo $subdomain; ?>" /></label><br>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['subdomain'] = strip_tags( $new_instance['subdomain'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract($args);
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$subdomain = $instance['subdomain'];

		if ( '' != $title ) { echo $before_title . $title . $after_title; }
		$widget_url = 'http://cdn.recipecentral.com/assets/scripts/widgets/standard.js?subdomain=' . $subdomain;
		?>
		<script type="text/javascript" id="recipecentral_widget" src="<?php echo esc_url($widget_url); ?>"></script>
		<?php
		echo $after_widget;
	}
}
