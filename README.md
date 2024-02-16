# CSV Importer Plugin

## Description

CSV DataSync is a versatile plugin designed to streamline your WordPress content management tasks. Effortlessly create and update user profiles while seamlessly generating new posts from CSV data. With CSV DataSync, you can efficiently manage your site's content, ensuring that user information remains up-to-date and new posts are added with ease. Whether you're importing large volumes of data or simply updating existing content, CSV DataSync is the perfect solution for maintaining a dynamic and organized WordPress site.

## Requirements

- WordPress (version 6.0 or higher)
- PHP (version 7.4 or higher)

## Installation

1. Download the plugin zip file.
2. Go to your WordPress admin panel.
3. Navigate to "Appearance" -> "Themes" or "Plugins" -> "Add New".
4. Click on the "Upload Plugin" button and select the zip file you downloaded.
5. Activate the plugin after installation.

## Configuration

In the `functions/create_or_update_user.php` file, you'll need to configure the `$set_user_role` variable to specify the user role for the users you're creating or updating. This ensures that users are assigned the correct role upon creation or update.

Similarly, in the `functions/create_post.php` file, you'll need to configure the `$set_post_type` variable to specify the post type for the posts you're creating or updating. This ensures that posts are assigned to the correct post type within your WordPress installation.

## Usage

1. Before importing your CSV file, ensure it adheres to the following column structure:
    
   **Columns for User Profile:**
   - Display Name
   - Email
   - Password
   - Custom Field Telephone
   - Custom Field Cellphone
   - Custom Field ZIP Code
   - Custom Field Address
   - Website URL
    
   **Columns for Post:**
   - Title
   - Term 1
   - Term 2

   Please note:
   - The first line of your CSV file is ignored during processing.
   - The order of columns is crucial and should not be altered. Ensure that the columns are arranged exactly as listed above.
  
You can find a sample CSV file (`template.csv`) in this repository for reference.

## Plugin Flow

The CSV Data Importer plugin operates with the following flow:

1. **Plugin Initialization**: The main plugin file `index.php` initializes the plugin, sets up the plugin's metadata, and creates the plugin admin menu.   
        
- The `csv_importer_menu()` function creates the admin menu for the CSV Importer plugin.        
- The `csv_importer_page()` function defines the page content for the CSV Importer plugin.   
        
2. **CSV File Processing**: When a CSV file is uploaded via the form, the plugin verifies the submission and processes the uploaded file in `functions/csv_processing_script.php`. This script is responsible for processing the CSV file, extracting its data to assign them into variables, and using them as parameters for functions to create or update users and posts.
        
## Optional Custom Fields
        
If you plan to use the provided example code as-is, ensure you add the following optional custom fields to the user profile:
```php
/*

################################################## 

Custom Fields for User Profile

*/
function update_profile_fields($contactmethods)
{
    $contactmethods['tel'] = 'Telephone';
    $contactmethods['cel'] = 'Cellphone';
    $contactmethods['zip'] = 'ZIP Code';
    $contactmethods['address'] = 'Address';

    return $contactmethods;
}
add_filter('user_contactmethods', 'update_profile_fields', 10, 1);
```

## Bonus

```php
/*

################################################## 

By default, when deleting a user in the WordPress Dashboard, you will be asked whether you want to delete all of that user's content or attribute it to another user. 
However, this option applies to the default post type, not custom post types (CPT). 
Nevertheless, this function also allows CPT to be either deleted or attributed to another user.

*/

function delete_user_content($user_id, $reassign, $user)
{

    // Check if the user has posts of the specified custom post type
    $args = array(
        'post_type' => 'courses',
        'author' => $user_id,
        'posts_per_page' => -1,
    );

    $user_posts = get_posts($args);

    if (count($user_posts) < 1) return;

    if ($reassign) {
        foreach ($user_posts as $post) {
            // Update the author of each post to the new user
            wp_update_post(
                array(
                    'ID' => $post->ID,
                    'post_author' => $reassign,
                )
            );
        }
        return;
    }

    foreach ($user_posts as $post) {
        wp_delete_post($post->ID, true);
    }

}
add_action('delete_user', 'delete_user_content', 10, 3);
```
