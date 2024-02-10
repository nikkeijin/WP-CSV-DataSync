<?php

/* 

################################################## 

Function to create or update users

*/

// Utils functions
include_once('utils/get_user_by.php');
include_once('utils/generate_random_username.php');

global $set_user_role;
$set_user_role = "company";

function create_user_with_csv_data($display_name, $email, $password, $tel, $cel, $zip, $address, $url)
{
    $existing_user = get_user_by_field('display_name', $display_name);

    if ($existing_user) {

        // User already exists, handle as needed (e.g., update user)
        update_user_with_csv_data($display_name, $email, $password, $tel, $cel, $zip, $address, $url);

    } else {

        // User does not exist, create a new user
        $random_username = generate_random_username();
        if (empty($password)) $password = wp_generate_password(50, true, true);

        $user_id = wp_create_user($random_username, $password, $email);

        if (!is_wp_error($user_id)) {
            user_fields($user_id, $display_name, $email, $password, $url);
            user_custom_fields($user_id, $tel, $cel, $zip, $address);
        } else {

            // Handle the error if user creation fails
            echo 'User creation error: ' . $user_id->get_error_message();
            return;

        }
    }
}


function update_user_with_csv_data($display_name, $email, $password, $tel, $cel, $zip, $address, $url)
{
    $user = get_user_by_field('display_name', $display_name);

    if ($user) {
        // User exists based on display name or nickname, update the user
        user_fields($user->ID, $display_name, $email, $password, $url);
        user_custom_fields($user->ID, $tel, $cel, $zip, $address);
    }
}


/* 

################################################## 

Fields to be used on create/update user function

*/
function user_fields($user_id, $display_name, $email, $password, $url)
{

    global $set_user_role;

    $set_user_role = isset($set_user_role) ? $set_user_role : 'subscriber';

    $user = new WP_User($user_id);
    $user->set_role($set_user_role);

    if ($email) wp_update_user(array('ID' => $user->ID, 'user_email' => $email));
    if ($password) wp_set_password($password, $user->ID);
    if ($display_name) {
        wp_update_user(array('ID' => $user->ID, 'display_name' => $display_name));
        wp_update_user(array('ID' => $user->ID, 'nickname' => $display_name));
    }
    if ($url)
        wp_update_user(array('ID' => $user->ID, 'user_url' => $url));
}


function user_custom_fields($user_id, $tel, $cel, $zip, $address)
{
    update_user_meta($user_id, 'tel', $tel);
    update_user_meta($user_id, 'cel', $cel);
    update_user_meta($user_id, 'zip', $zip);
    update_user_meta($user_id, 'address', $address);
}