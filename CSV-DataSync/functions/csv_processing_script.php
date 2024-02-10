<?php

/*

##################################################

CSV Processing

*/

// Assigning the path to the CSV file to a variable
$csvFile = $csv_file_tmp; 

// Opening the CSV file in read mode
if (($handle = fopen($csvFile, 'r')) !== false) { 

    // Ignore the header row if your CSV file has one
    fgetcsv($handle); 

    // Loop through each row of the CSV file
    while (($data = fgetcsv($handle)) !== false) { 

        // Extract data from CSV columns and assign them to variables
        list(
            $display_name,
            $email,
            $password,
            $tel,
            $cel,
            $zip,
            $address,
            $url,
            $post_title,
            $term_1,
            $term_2
        ) = $data;

        // Call functions to create or update users and posts using the extracted CSV data as parameters
        create_user_with_csv_data($display_name, $email, $password, $tel, $cel, $zip, $address, $url);
        update_user_with_csv_data($display_name, $email, $password, $tel, $cel, $zip, $address, $url);
        create_post_with_csv_data($display_name, $post_title, $term_1, $term_2);
    }

    fclose($handle); // Close the CSV file
}

// Display message after processing CSV data
echo 'CSV data processing complete.';
