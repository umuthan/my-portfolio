<?php

add_action( 'init', 'create_portfolio_post_type' );
/**
 * Register a portfolio post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function create_portfolio_post_type() {
	$labels = array(
		'name'               => _x( 'Portfolio', 'post type general name', 'my-portfolio' ),
		'singular_name'      => _x( 'Portfolio', 'post type singular name', 'my-portfolio' ),
		'menu_name'          => _x( 'Portfolio', 'admin menu', 'my-portfolio' ),
		'name_admin_bar'     => _x( 'Portfolio', 'add new on admin bar', 'my-portfolio' ),
		'add_new'            => _x( 'Add New', 'portfolio', 'my-portfolio' ),
		'add_new_item'       => __( 'Add New Portfolio', 'my-portfolio' ),
		'new_item'           => __( 'New Portfolio', 'my-portfolio' ),
		'edit_item'          => __( 'Edit Portfolio', 'my-portfolio' ),
		'view_item'          => __( 'View Portfolio', 'my-portfolio' ),
		'all_items'          => __( 'All Portfolio', 'my-portfolio' ),
		'search_items'       => __( 'Search Portfolio', 'my-portfolio' ),
		'parent_item_colon'  => __( 'Parent Portfolio:', 'my-portfolio' ),
		'not_found'          => __( 'No Portfolio found.', 'my-portfolio' ),
		'not_found_in_trash' => __( 'No Portfolio found in Trash.', 'my-portfolio' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'my-portfolio' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
	);

	register_post_type( 'portfolio', $args );
}
