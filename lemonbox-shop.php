<?php
	
	/*
	Plugin Name: LemonBox Shop
	Plugin URI: http://lemonboxapps.com
	Description: LemonBox Shop
	Version: 0.0.1
	Author: LemonBox
	Author URI: http://lemonboxapps.com
	License: DO NOT STEAL
	*/

	include( plugin_dir_path( __FILE__ ) . 'stripe.php' );

	function lbox_shop_init() {

        $labels = array(
            'name'               => _x( 'Products', 'post type general name' ),
            'singular_name'      => _x( 'Product', 'post type singular name' ),
            'add_new'            => _x( 'Add Product', 'Product' ),
            'add_new_item'       => __( 'Add New Product' ),
            'edit_item'          => __( 'Edit Product' ),
            'new_item'           => __( 'New Product' ),
            'all_items'          => __( 'All Products' ),
            'view_item'          => __( 'View Product' ),
            'search_items'       => __( 'Search Products' ),
            'not_found'          => __( 'No Products found' ),
            'not_found_in_trash' => __( 'No Products found in the Trash' ), 
            'parent_item_colon'  => '',
            'menu_name'          => 'Shop',
            'can_export'           => true
        );
        
        $args = array(
            'labels'        		=> $labels,
            'description'   		=> 'Information about our products',
            'public'        		=> true,
            'menu_position' 		=> 7,
            'taxonomies' 			=> array('category'),
            'supports'      		=> array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'has_archive'   		=> true,
            'show_in_nav_menus' 	=> true,
            'rewrite'           	=> array( 'slug' => 'products' ),
            'capability_type' 		=> 'page',
            'publicly_queryable' 	=> true
        );

        register_post_type( 'lemonbox_product', $args );

        add_option( 'stripe_mode', 'test', '', true );
        add_option( 'stripe_test_secret_key', '', '', true );
        add_option( 'stripe_test_publishable_key', '', '', true );
        add_option( 'stripe_live_secret_key', '', '', true );
        add_option( 'stripe_live_publishable_key', '', '', true );

        // global $wpdb;

        // $table_name = $wpdb->prefix . "mdb_payments";

        // $sql = "CREATE TABLE $table_name (
        //         id mediumint(11) NOT NULL AUTO_INCREMENT,
        //         token_id varchar(64) NOT NULL,
        //         name varchar(256) NOT NULL,
        //         amount float(11) NOT NULL,
        //         product_id mediumint(11) NOT NULL,
        //         user_id mediumint(11) NOT NULL,
        //         payment_type varchar(24) NOT NULL,
        //         card_type varchar(24) NOT NULL,
        //         email varchar(256) NOT NULL,
        //         last4 int(4) NOT NULL,
        //         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        //         UNIQUE KEY id (id)
        // );";
        
        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        // dbDelta($sql);
    }

    function lemonbox_load_admin_shop_assets() {
    	wp_enqueue_script( 'lemonbox-shop-admin-js', plugin_dir_url( __FILE__ ) . '/assets/js/lemonbox.shop.admin.js', array('jquery') );
    	wp_localize_script( 'lemonbox-shop-admin-js', 'lemonbox', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    function lemonbox_shop_admin_menu() {
    	add_submenu_page( 'edit.php?post_type=lemonbox_product', 'Shop Settings', 'Shop Settings', 'manage_options', 'lemonbox-shop-settings', 'lemonbox_shop_pages' );
    }

    function lemonbox_shop_pages() {
    
    	ob_start();

		if ( $_GET['page'] == 'lemonbox-shop-settings' ) {
			include( plugin_dir_path( __FILE__ ) . 'pages/shop-settings.php' );
		}

		ob_flush();

    }



    function lemonbox_update_shop_settings() {

    	extract( $_POST );

    	update_option( 'stripe_mode', $stripe_mode );
        update_option( 'stripe_test_secret_key', $stripe_test_secret_key );
    	update_option( 'stripe_test_publishable_key', $stripe_test_publishable_key );
    	update_option( 'stripe_live_secret_key', $stripe_live_secret_key );
    	update_option( 'stripe_live_publishable_key', $stripe_live_publishable_key );

    	echo json_encode( array( 'success' => true ) );

    	exit;
    }

    function lbox_get_products() {

        $args = array(
            'post_type' => 'lemonbox_product',
            'post_status' => 'publish'
        );

        $query = new WP_Query( $args );

        foreach ( $query->posts as $product ) {
            $product->price = get_post_meta( $product->ID, 'price', true );
        }

        return $query->posts;

    }

    function lemonbox_get_product( $product_id ) {

    	$args = array(
    		'post_type' => 'lemonbox_product',
    		'post_status' => 'publish',
            'p' => $product_id
    	);

    	$query = new WP_Query( $args );

    	foreach ( $query->posts as $product ) {
    		$product->price = get_post_meta( $product->ID, 'price', true );
    	}

    	return $query->posts;

    }

    function lemonbox_post_payments() {

        $product = lemonbox_get_product( $_POST['product_id'] );

        if ( $product ) {

            $purchase_info = $product[0]->post_title . ' | Qty: ' . $_POST['quantity'];

            if ( $_POST['payment_type'] == 'credit' ) {

        	    return pay_with_stripe( $purchase_info );

            } else {

                return array( 'success' => true, 'msg' => 'Your purchase was successful! ' . $purchase_info );

            }

        } 
    }

	add_action( 'init', 'lbox_shop_init' );
	add_action(	'admin_menu', 'lemonbox_shop_admin_menu');
	add_action( 'admin_enqueue_scripts', 'lemonbox_load_admin_shop_assets' );
	add_action( 'lemonbox_post_payments', 'lemonbox_post_payments', 10, 0 );

	add_action( 'wp_ajax_lemonbox_update_shop_settings', 'lemonbox_update_shop_settings' );
?>