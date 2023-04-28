<?php
/*
Plugin Name: FoodRecipesSearch
Description: Search ingredient, dish name
Version: 1.0
Author: Xin Wang
*/

function custom_search_shortcode() {
    $output = '<div class="search-container">
        <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
            <input type="text" id="search" name="search" placeholder="Ingredient, Dish, Keyword...">
            <button type="submit" id="search-btn">Search</button>
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
		$column_F = 'title_addr';
		
		

        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE $column_A LIKE %s ", '%' . $wpdb->esc_like( $search_term ) . '%' ) );

        

        if ( ! empty( $results ) ) {
			$output .= '<div class="list-container">';
			
			$output .= '<ul class="my-list">';
            foreach ( $results as $row ) {
                //$output .= "<tr><td>" . esc_html( $row->$column_A ) . "</td><td>" . esc_html( $row->$column_B ) . "</td></tr>";
				//$output .= "<tr><td>" . $row->$column_A . "</td><td>" . $row->$column_E . "</td></tr>";
				$output .= "<li>";
				$output .= "<div>" . $row->$column_E . "</div>";
				$output .= "<h6>" . $row->$column_F . "</h6>";
				$output .= "</li>";
            }
			$output .= "</ul>";
			
			$output .= "</div>";
		
        } else {
            $output .= "<h5>No match results</h5>";
        }
        //$output .= "</table>";
    }

    return $output;
}

add_shortcode( 'custom_search', 'custom_search_shortcode' );

function custom_search_styles() {
    echo '
    <style>
        
    .search-container {
      text-align: right;
      margin-right: 10%;
    }

    
    #search {
      width: 250px;
      height: 30px;
      border-radius: 20px;
      border: none;
      padding: 5px 10px;
      background-color: #ccc;
      display: inline-block;
      vertical-align: middle;
    }

    
    #search-btn {
      width: 120px;
      height: 40px;
      border-radius: 20px;
      border: none;
      margin-left: 10px;
      background-color: #008CBA;
      color: #fff;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      display: inline-block;
      vertical-align: middle;
    }
	
	.list-container {
        display: flex;
        justify-content: center;
      }

      .my-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
      }

      .my-list li {
        width: 274px;
        box-sizing: border-box;
        padding: 10px;
        background-color: #f2f2f2;
        margin: 35px;
        border-radius: 5px;
        text-align: center;
      }

      @media screen and (max-width: 768px) {
        .my-list li {
          width: calc(45% - 10px);
        }
      }

      @media screen and (max-width: 480px) {
        .my-list li {
          width: 100%;
        }
      }

	 a {
      text-decoration: none;
      color: black;
		}
	
	h5 {
		text-align: center;
	}
    </style>';
}

add_action( 'wp_head', 'custom_search_styles' );