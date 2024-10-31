<?php
/*
Plugin Name: Restock product after purchase
Plugin URI: https://oleksandrustymenko.net.ua/woocommerce-restock-product
Description: This plugin will automatically restock a product after it is purchased, so you don't have to worry about running out of goods.  After the plug-in is installed and activated, it will do all the work for you.
Version: 1.0
Author: Oleksandr Ustymenko
Author URI: http://oleksandrustymenko.net.ua
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

add_action( 'woocommerce_order_status_completed', 'woo_ustymenko_restocks_order_completed' , 10, 1 );
function woo_ustymenko_restocks_order_completed( $woo_ustymenko_restocks_order_id )
{
    // Get an instance of the order object
    $woo_ustymenko_restocks_order = wc_get_order( $woo_ustymenko_restocks_order_id );

    // Iterating though each order items
    foreach ( $woo_ustymenko_restocks_order->get_items() as $woo_ustymenko_restocks_item_id => $woo_ustymenko_restocks_item_values ) {

        // Item quantity
        $woo_ustymenko_restocks_item_qty = $woo_ustymenko_restocks_item_values['qty'];

        // getting the product ID (Simple and variable products)
        $woo_ustymenko_restocks_product_id = $woo_ustymenko_restocks_item_values['variation_id'];
        if( $woo_ustymenko_restocks_product_id == 0 || empty($woo_ustymenko_restocks_product_id) ) $woo_ustymenko_restocks_product_id = $woo_ustymenko_restocks_item_values['product_id'];

        // Get an instance of the product object
        $woo_ustymenko_restocks_product = wc_get_product( $woo_ustymenko_restocks_product_id );

        // Get the stock quantity of the product
        $woo_ustymenko_restocks_stock = $woo_ustymenko_restocks_product->get_stock_quantity();

        // Increase back the stock quantity
        wc_update_product_stock( $woo_ustymenko_restocks_product, $woo_ustymenko_restocks_item_qty, 'increase' );
    }
}
?>