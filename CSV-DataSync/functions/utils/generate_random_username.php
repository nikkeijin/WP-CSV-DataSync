<?php

function generate_random_username()
{
    // Maximum number of attempts to generate a unique username
    $max_attempts = 10;
    $attempt = 0;

    do {
        // Generate a random username
        $random_username = mt_rand(100000000, 999999999); 
        $existing_user = username_exists($random_username);

        // Check if the generated username already exists
        if (!$existing_user) {
            // Return the unique username
            return $random_username; 
        }

        $attempt++;
    } while ($attempt < $max_attempts);

    // If maximum attempts are reached and a unique username is not found, return false or handle the error as needed
    return false;
}