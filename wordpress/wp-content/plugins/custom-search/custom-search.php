<?php
/*
Plugin Name: FoodRecipesSearch
Description: Search ingredient, dish name
Version: 1.0
Author: Xin Wang
*/

function custom_search_shortcode() {
    $output = '<div class="search-bar">
        <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
            <input type="text" name="search" placeholder="Search Ingredient, Dish, Keyword...">
            <button type="submit">Search</button>
        </form>
    </div>';

    if ( isset( $_POST['search'] ) ) {
        $search_term = sanitize_text_field( $_POST['search'] );

        global $wpdb;
        $table_name = 'food_recipes';
        $column_A = 'title';
        $column_B = 'image_name';
		$column_C = 'ingredients';
		$column_D = 'instructions';
		$column_E = 'img_url';

        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE $column_A LIKE %s", '%' . $wpdb->esc_like( $search_term ) . '%' ) );

        $output .= "<table border='1'>";
        $output .= "<tr><th>column1</th><th>column2</th></tr>";

        if ( ! empty( $results ) ) {
            foreach ( $results as $row ) {
                //$output .= "<tr><td>" . esc_html( $row->$column_A ) . "</td><td>" . esc_html( $row->$column_B ) . "</td></tr>";
				$output .= "<tr><td>" . $row->$column_A . "</td><td>" . $row->$column_E . "</td></tr>";
            }
        } else {
            $output .= "<tr><td colspan='2'>No Matching Results</td></tr>";
        }
        $output .= "</table>";
    }

    return $output;
}

add_shortcode( 'custom_search', 'custom_search_shortcode' );

function custom_search_styles() {
    echo '
    <style>
        .search-bar {
            display: flex;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 5px;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>';
}

add_action( 'wp_head', 'custom_search_styles' );