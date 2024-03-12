<?php

// Hook into Contact Form 7 submission
add_action('wpcf7_before_send_mail', 'process_contact_form_submission');

function process_contact_form_submission($contact_form)
{
    // Check if the form has the specified ID (replace 123 with your actual form ID)
    if ($contact_form->id() == '11854') {
        // Get the submitted form data

      
        $submission = WPCF7_Submission::get_instance();

        if ($submission) {
            $posted_data = $submission->get_posted_data();

            // Assuming your email field in Contact Form 7 has the name 'your-email'
            $email = isset($posted_data['your-email']) ? sanitize_email($posted_data['your-email']) : '';

            // Check if the email is not empty
            if (!empty($email)) {
                // Check if the email exists in Airtable
                if (!email_exists_in_airtable($email)) {
                    // If not, add the email to Airtable
                    add_email_to_airtable($email);
                }
            }
        }
    }
}

// Function to check if email exists in Airtable
function email_exists_in_airtable($email)
{
    // Airtable API details
    $api_key = 'patCuA6rrjZhYRywr.589deb4809e5cc8db7afe627a4834898ca4f5d521070662e838774fdf8971ddf';
    $base_id = 'apprApTNrKO3fjlwq';
    $table_name = 'People';

    error_log('email_exists_in_airtable');
    // Form Airtable API URL
    $api_url = "https://api.airtable.com/v0/{$base_id}/{$table_name}?filterByFormula=AND({Primary Email}='{$email}')";

    // Make API request to check if email exists
    $response = wp_remote_get($api_url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
        ),
    )
    );


    if (is_wp_error($response)) {
        // Log or handle the error
        error_log('Error checking email in Airtable: ' . $response->get_error_message());
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Check if records exist in the response
    return !empty($data['records']);
}

// Function to add email to Airtable
function add_email_to_airtable($email)
{
    // Airtable API details
    $api_key = 'patCuA6rrjZhYRywr.589deb4809e5cc8db7afe627a4834898ca4f5d521070662e838774fdf8971ddf';
    $base_id = 'apprApTNrKO3fjlwq';
    $table_name = 'People';

    // Form Airtable API URL
    $api_url = "https://api.airtable.com/v0/{$base_id}/{$table_name}";

    // Prepare data for Airtable
    $data = array(
        'fields' => array(
            'Primary Email' => $email,
            // Add other fields as needed
        ),
    );

    // Make API request to add email to Airtable
    $response = wp_remote_post($api_url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
        ),
        'body' => wp_json_encode($data),
    )
    );

    if (is_wp_error($response)) {
        // Log or handle the error
        error_log('Error adding email to Airtable: ' . $response->get_error_message());
    } else {
        // Check if the request was successful
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            // Log or handle the unexpected response
            error_log('Unexpected response adding email to Airtable: ' . $response_code);
        }
    }
}
