<?php

// Function to get term ID by name and assign it to the post
function assign_term_by_name($term_name, $taxonomy, $post_id)
{
    // Get the term ID by name
    $term = term_exists($term_name, $taxonomy);
    $term_id = is_array($term) ? $term['term_id'] : 0;

    if ($term_id) {
        // Assign the term to the post using its ID
        wp_set_post_terms($post_id, array($term_id), $taxonomy, true);
    } else {
        // Handle the case where the term doesn't exist
        echo $taxonomy . ' Term does not exist: ' . $term_name . '<br>';
    }
}