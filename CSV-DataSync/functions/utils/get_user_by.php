<?php

/* 

################################################## 

Search for users by different fields such as display_name, nickname, user_id, username, email, role, and even custom fields.

Usage Example
$user = get_user_by_field('username', $variable_from_csv_data);

Usage Example with Custom Field, replace with the desired custom field name and value
$user = get_user_by_field('prefecture', $variable_from_csv_data);

*/

function get_user_by_field($field, $value)
{

    $value = htmlspecialchars($value);
    global $wpdb;

    if (in_array( $field, ["display_name", "nickname", "email"] )) {

        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE $field = %s", $value));
        return $user;

    } else if ($field == 'role'){

        $user = new WP_User_Query( array( 'role' => $value ) );
        return $user;

    } else {

        $user = new WP_User_Query( array('meta_key' => $field, 'meta_value' => $value ));
        return $user;

    }

    return false;

}