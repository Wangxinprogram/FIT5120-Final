<?php
/*
Plugin Name: HospitalSearch
Description: Search Hospital Details
Version: 1.0
Author: Xin Wang
*/

function custom_search_hospital_shortcode() {
    $output = '<div class="search-container">
        <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
            <input type="text" id="search1" name="search1" placeholder="input postcode like 3220">
            <button type="submit" id="search-btn">Search</button>
        </form>
    </div>';

    if ( isset( $_POST['search1'] ) ) {
        $search_term = sanitize_text_field( $_POST['search1'] );

        global $wpdb;
        $table_name = 'hospital_details';
        $column_A = 'hospital_name';
        $column_B = 'address';
		$column_C = 'location';
		$column_D = 'postcode';
		$column_E = 'telephone';

        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE $column_D LIKE %s", '%' . $wpdb->esc_like( $search_term ) . '%' ) );

        $output .= "<table>";
        $output .= "<tr><th>Hospital Name</th><th>Address</th><th>Location</th><th>Postcode</th><th>Telephone</th></tr>";

        if ( ! empty( $results ) ) {
            foreach ( $results as $row ) {
                //$output .= "<tr><td>" . esc_html( $row->$column_A ) . "</td><td>" . esc_html( $row->$column_B ) . "</td></tr>";
				$output .= "<tr><td>" . $row->$column_A . "</td><td>" . $row->$column_B . "</td><td>" . $row->$column_C . "</td><td>" . $row->$column_D . "</td><td>" . $row->$column_E . "</td></tr>";
            }
        } else {
            $output .= "<tr><td colspan='5'>No Matching Results</td></tr>";
        }
        $output .= "</table>";
    }

    return $output;
}

add_shortcode('custom_search_hospital', 'custom_search_hospital_shortcode' );

function custom_search_hospital_styles() {
    echo '
    <style>
        
    .search-container {
      text-align: right;
      margin-right: 10%;
    }

    
    #search1 {
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
	
	table {
        border-collapse: collapse;
        width: 100%;
        max-width: 880px;
        margin: 20px auto; 
        font-size: 16px;
        color: #333;
        border: 2px solid #444;
      }

      th, td {
        text-align: center;
        padding: 10px;
        border: 1px solid #444;
      }

      thead {
        font-weight: bold;
      }
	  
	  @media screen and (max-width: 768px) {
        table{
          width: calc(45% - 10px);
        }
      }

      @media screen and (max-width: 480px) {
        .table {
          width: 100%;
        }
      }
    </style>';
}

add_action('wp_head', 'custom_search_hospital_styles' );