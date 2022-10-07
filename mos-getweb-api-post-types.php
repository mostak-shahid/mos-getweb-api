<?php

function cptui_register_my_cpts() {

	/**
	 * Post Type: Banners.
	 */

	$labels = [
		"name" => esc_html__( "Banners", "twentytwentyone" ),
		"singular_name" => esc_html__( "Banner", "twentytwentyone" ),
	];

	$args = [
		"label" => esc_html__( "Banners", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "banner", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "banner", $args );

	/**
	 * Post Type: Industries.
	 */

	$labels = [
		"name" => esc_html__( "Industries", "twentytwentyone" ),
		"singular_name" => esc_html__( "Industry", "twentytwentyone" ),
	];

	$args = [
		"label" => esc_html__( "Industries", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "industry", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "industry", $args );

	/**
	 * Post Type: Technologies.
	 */

	$labels = [
		"name" => esc_html__( "Technologies", "twentytwentyone" ),
		"singular_name" => esc_html__( "Technology", "twentytwentyone" ),
	];

	$args = [
		"label" => esc_html__( "Technologies", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "technology", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "technology", $args );

	/**
	 * Post Type: Projects.
	 */

	$labels = [
		"name" => esc_html__( "Projects", "twentytwentyone" ),
		"singular_name" => esc_html__( "Project", "twentytwentyone" ),
	];

	$args = [
		"label" => esc_html__( "Projects", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "project", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "project", $args );

	/**
	 * Post Type: Testimonials.
	 */

	$labels = [
		"name" => esc_html__( "Testimonials", "twentytwentyone" ),
		"singular_name" => esc_html__( "Testimonial", "twentytwentyone" ),
	];

	$args = [
		"label" => esc_html__( "Testimonials", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "testimonial", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "testimonial", $args );

	/**
	 * Post Type: Blocks.
	 */

	$labels = [
		"name" => esc_html__( "Blocks", "twentytwentyone" ),
		"singular_name" => esc_html__( "Block", "twentytwentyone" ),
	];

	$args = [
		"label" => esc_html__( "Blocks", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "block", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"show_in_graphql" => false,
	];

	register_post_type( "block", $args );

	/**
	 * Post Type: Jobs.
	 */

	$labels = [
		"name" => esc_html__( "Jobs", "twentytwentyone" ),
		"singular_name" => esc_html__( "Job", "twentytwentyone" ),
	];

	$args = [
		"label" => esc_html__( "Jobs", "twentytwentyone" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "job", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"show_in_graphql" => false,
	];

	register_post_type( "job", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );


function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'technology_catagory', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "technology_catagory",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "technology_catagory", [ "technology" ], $args );

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'banner_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "banner_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "banner_category", [ "banner" ], $args );

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'service_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "service_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "service_category", [ "service" ], $args );

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'step_ategory', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "step_ategory",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "step_ategory", [ "step" ], $args );

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'industry_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "industry_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "industry_category", [ "industry" ], $args );

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'project_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "project_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "project_category", [ "project" ], $args );

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'testimonials_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "testimonials_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "testimonials_category", [ "testimonial" ], $args );

	/**
	 * Taxonomy: Categories.
	 */

	$labels = [
		"name" => esc_html__( "Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'block_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "block_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "block_category", [ "block" ], $args );

	/**
	 * Taxonomy: Job Categories.
	 */

	$labels = [
		"name" => esc_html__( "Job Categories", "twentytwentyone" ),
		"singular_name" => esc_html__( "Job Category", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Job Categories", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'job_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "job_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "job_category", [ "job" ], $args );

	/**
	 * Taxonomy: Tags.
	 */

	$labels = [
		"name" => esc_html__( "Tags", "twentytwentyone" ),
		"singular_name" => esc_html__( "Tag", "twentytwentyone" ),
	];

	
	$args = [
		"label" => esc_html__( "Tags", "twentytwentyone" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'project_tag', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "project_tag",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "project_tag", [ "project" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );