<?php

add_filter('sanitize_user', 'allow_japanese_as_username', 10, 3);

function allow_japanese_as_username($username, $raw_username, $strict)
{
    if ($strict) {
        $username = wp_strip_all_tags($raw_username);
        $username = remove_accents($username);
        $username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
        $username = preg_replace('/&.+?;/', '', $username);

        $username = preg_replace('|[^a-zA-Z0-9ぁ-ゖァ-ヺ一-龢豈-頻 _.\-@]|', '', $username);
        $username = trim($username);
        $username = preg_replace('|\s+|', ' ', $username);
    }
    return $username;
}

// Add this code to your create_user() function
$username = apply_filters('sanitize_user', $username, '', false);