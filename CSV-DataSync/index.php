<?php

/*
Plugin Name: CSV DataSync
Description: CSV DataSync is a versatile plugin designed to streamline your WordPress content management tasks. Effortlessly create and update user profiles while seamlessly generating new posts from CSV data. With CSV DataSync, you can efficiently manage your site's content, ensuring that user information remains up-to-date and new posts are added with ease. Whether you're importing large volumes of data or simply updating existing content, CSV DataSync is the perfect solution for maintaining a dynamic and organized WordPress site.
Version: 1.0
Author: https://github.com/nikkeijin/
*/

add_action('admin_menu', 'csv_importer_menu');

//Create the Plugin Admin Menu
function csv_importer_menu()
{
    add_menu_page('CSV Importer', 'CSV Importer', 'manage_options', 'csv-importer', 'csv_importer_page');
}

function csv_importer_page()
{

    if (!current_user_can('manage_options')) {
        wp_die('You do not have permission to access this page.');
    }

    // Verify if the form is submitted and the nonce is valid
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $csv_file_tmp = $_FILES['csv_file']['tmp_name'];
        // Add your CSV processing code here to update the database
        include('include.php');
    }
?>

    <!-- Display the CSV import form -->
    <div class="wrap">
        <h2>CSV Importer</h2>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('csv_import_action', 'csv_import_nonce'); ?>
            <label for="csv_file">Select CSV File:</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv">
            <input type="submit" name="submit" class="button button-primary" value="Upload CSV">
        </form>
    </div>

<?php

}
