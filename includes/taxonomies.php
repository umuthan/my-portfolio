<?php

// hook into the init action and call create_portfolio_taxonomies when it fires
add_action( 'init', 'create_portfolio_taxonomies', 0 );

// create two taxonomies, brands and categories for the post type "portfolio"
function create_portfolio_taxonomies() {
  // Add new taxonomy
	$labels = array(
		'name'                       => _x( 'Categories', 'taxonomy general name', 'my-portfolio' ),
		'singular_name'              => _x( 'Category', 'taxonomy singular name', 'my-portfolio' ),
		'search_items'               => __( 'Search Categories', 'my-portfolio' ),
		'popular_items'              => __( 'Popular Categories', 'my-portfolio' ),
		'all_items'                  => __( 'All Categories', 'my-portfolio' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Category', 'my-portfolio' ),
		'update_item'                => __( 'Update Category', 'my-portfolio' ),
		'add_new_item'               => __( 'Add New Category', 'my-portfolio' ),
		'new_item_name'              => __( 'New Category Name', 'my-portfolio' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'my-portfolio' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'my-portfolio' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories', 'my-portfolio' ),
		'not_found'                  => __( 'No categories found.', 'my-portfolio' ),
		'menu_name'                  => __( 'Categories', 'my-portfolio' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'portfolioCategory' ),
	);

	register_taxonomy( 'portfolio_category', 'portfolio', $args );

	// Add new taxonomy
	$labels = array(
		'name'                       => _x( 'Brands', 'taxonomy general name', 'my-portfolio' ),
		'singular_name'              => _x( 'Brand', 'taxonomy singular name', 'my-portfolio' ),
		'search_items'               => __( 'Search Brands', 'my-portfolio' ),
		'popular_items'              => __( 'Popular Brands', 'my-portfolio' ),
		'all_items'                  => __( 'All Brands', 'my-portfolio' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Brand', 'my-portfolio' ),
		'update_item'                => __( 'Update Brand', 'my-portfolio' ),
		'add_new_item'               => __( 'Add New Brand', 'my-portfolio' ),
		'new_item_name'              => __( 'New Brand Name', 'my-portfolio' ),
		'separate_items_with_commas' => __( 'Separate brands with commas', 'my-portfolio' ),
		'add_or_remove_items'        => __( 'Add or remove brands', 'my-portfolio' ),
		'choose_from_most_used'      => __( 'Choose from the most used brands', 'my-portfolio' ),
		'not_found'                  => __( 'No brands found.', 'my-portfolio' ),
		'menu_name'                  => __( 'Brands', 'my-portfolio' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'brand' ),
	);

	register_taxonomy( 'brand', 'portfolio', $args );

	// Add new taxonomy
	$labels = array(
		'name'                       => _x( 'Technologies', 'taxonomy general name', 'my-portfolio' ),
		'singular_name'              => _x( 'Technology', 'taxonomy singular name', 'my-portfolio' ),
		'search_items'               => __( 'Search Technologies', 'my-portfolio' ),
		'popular_items'              => __( 'Popular Technologies', 'my-portfolio' ),
		'all_items'                  => __( 'All Technologies', 'my-portfolio' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Technology', 'my-portfolio' ),
		'update_item'                => __( 'Update Technology', 'my-portfolio' ),
		'add_new_item'               => __( 'Add New Technology', 'my-portfolio' ),
		'new_item_name'              => __( 'New Technology Name', 'my-portfolio' ),
		'separate_items_with_commas' => __( 'Separate technologies with commas', 'my-portfolio' ),
		'add_or_remove_items'        => __( 'Add or remove technologies', 'my-portfolio' ),
		'choose_from_most_used'      => __( 'Choose from the most used technologies', 'my-portfolio' ),
		'not_found'                  => __( 'No technologies found.', 'my-portfolio' ),
		'menu_name'                  => __( 'Technologies', 'my-portfolio' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'technology' ),
	);

	register_taxonomy( 'technology', 'portfolio', $args );
}
