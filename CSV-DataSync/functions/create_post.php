<?php

/* 

################################################## 

Function to create posts

// Pending: Verify if the user already has the post before creating the post.

*/

// Utils functions
require_once('utils/assign_term_by_name.php');

global $set_post_type;
$set_post_type = "jobs";

function create_post_with_csv_data($display_name, $post_title, $term_1, $term_2)
{
    // Find the user ID based on the display_name
    $user = get_user_by_field('display_name', $display_name);

    if ($user) {
        
        global $set_post_type;

        // Create a new post and assign it to the user
        $post_id = wp_insert_post(
            array(
                'post_title' => $post_title,
                'post_type' => $set_post_type,
                'post_author' => $user->ID,
                'post_status' => 'publish',
            )
        );

        // Assign the "discipline" term by name
        assign_term_by_name($term_1, 'discipline', $post_id);

        // Assign the "prefecture" term by name
        assign_term_by_name($term_2, 'prefecture', $post_id);
    }
}