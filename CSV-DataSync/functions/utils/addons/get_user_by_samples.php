<?php

/* 

################################################## 

You can filter users by their unique user IDs.

*/
function get_user_by_id($user_id)
{
    return get_userdata($user_id);
}

// Example usage:
// Replace 123 with the desired user ID
$user = get_user_by_id(123);


/* 

################################################## 

You can filter users by their usernames.

*/
function get_user_by_username($username)
{
    return get_user_by('login', $username);
}

// Example usage:
// Replace with the desired username
$user = get_user_by_username('desired_username');


/* 

################################################## 

You can filter users by their email addresses.

*/
function get_user_by_email($email)
{
    return get_user_by('email', $email);
}

// Example usage:
// Replace with the desired email address
$user = get_user_by_email('user@example.com');


/* 

################################################## 

You can filter users by their roles, such as 'administrator,' 'editor,' 'author,' 'subscriber,' etc.

*/
function get_users_by_role($role)
{
    $args = array(
        'role' => $role,
    );
    $users = get_users($args);
    if (!empty($users)) {
        return $users[0]; // Return the first user with the specified role
    }
    return false;
}

// Example usage:
// Replace with the desired role
$user = get_users_by_role('subscriber');


/* 

################################################## 

Users can have custom metadata associated with them. You can filter users based on their metadata values.

*/
function get_users_by_meta($meta_key, $meta_value)
{
    $args = array(
        'meta_key' => $meta_key,
        'meta_value' => $meta_value,
    );
    $users = get_users($args);
    if (!empty($users)) {
        return $users[0]; // Return the first user with the specified metadata
    }
    return false;
}

// Example usage:
// Replace with the desired metadata key and value
$user = get_users_by_meta('custom_field', 'desired_value');


/* 

################################################## 

You can filter users based on their registration date.

*/
function get_users_registered_after($date)
{
    $args = array(
        'date_query' => array(
            array(
                'after' => $date,
            ),
        ),
    );
    $users = get_users($args);
    if (!empty($users)) {
        return $users[0]; // Return the first user registered after the specified date
    }
    return false;
}

// Example usage:
// Replace with the desired registration date
$user = get_users_registered_after('2023-01-01');
