<?php

require_once(ABSPATH . 'wp-load.php');

function handle_csv_import() {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'csv_import_action')) {
            echo '<div class="upload-message danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                    <p class="font-bold">Security check failed!</p>
                    <p>Please try uploading the file again.</p>
                  </div>';
            return;
        }

        $file_info = pathinfo($_FILES['csvFile']['name']);
        $file_extension = strtolower($file_info['extension']);

        $import_mode = isset($_POST['import_mode']) ? sanitize_text_field($_POST['import_mode']) : 'append';

        if ($file_extension === 'csv') {
            $temp_file_path = $_FILES['csvFile']['tmp_name'];

            if (($handle = fopen($temp_file_path, 'r')) !== FALSE) {
                if ($import_mode === 'replace') {
                    $deleted_posts_count = 0;
                    $existing_entries = new WP_Query(array(
                        'post_type'      => 'entry',
                        'posts_per_page' => -1,
                        'fields'         => 'ids',
                        'post_status'    => 'any'
                    ));

                    if ($existing_entries->have_posts()) {
                        foreach ($existing_entries->posts as $post_id_to_delete) {
                            if (wp_delete_post($post_id_to_delete, true)) {
                                $deleted_posts_count++;
                            } else {
                                error_log('CSV import (replace mode): Failed to delete entry ID: ' . $post_id_to_delete);
                            }
                        }
                    }
                    echo '<div class="upload-message info bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md" role="alert">
                            <p class="font-bold">Import Mode: Replace Existing Data</p>
                            <p>' . esc_html($deleted_posts_count) . ' existing "entry" posts were deleted before import.</p>
                          </div>';
                }

                $row = 0;
                $posts_created = 0;
                $posts_skipped = 0;
                $posts_failed = 0;

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($row === 0) {
                        $row++;
                        continue;
                    }
                    if (count($data) < 4) {
                        error_log('CSV import error: Row ' . ($row + 1) . ' has too few columns. Skipping row.');
                        $row++;
                        continue;
                    }

                    $id         = sanitize_text_field($data[0]);
                    $entry      = sanitize_text_field($data[1]);
                    $lifeStats  = sanitize_text_field($data[2]);
                    $sort       = sanitize_text_field($data[3]);

                    $should_create_post = true;
                    if ($import_mode === 'append') {
                        $existing_post = get_page_by_title($entry, OBJECT, 'entry');
                        if ($existing_post) {
                            error_log('CSV import (append mode): Post with title "' . $entry . '" already exists. Skipping.');
                            $posts_skipped++;
                            $should_create_post = false;
                        }
                    }

                    if ($should_create_post) {
                        $post_args = array(
                            'post_title'    => $entry,
                            'post_status'   => 'publish',
                            'post_type'     => 'entry'
                        );

                        $post_id = wp_insert_post($post_args, true);

                        if (!is_wp_error($post_id)) {
                            update_post_meta($post_id, 'csv_id', $id);
                            update_post_meta($post_id, 'csv_entry', $entry);
                            update_post_meta($post_id, 'csv_life_stats', $lifeStats);
                            update_post_meta($post_id, 'csv_sort', $sort);
                            $posts_created++;
                        } else {
                            error_log('CSV import error: Failed to create entry "' . $entry . '": ' . $post_id->get_error_message());
                            $posts_failed++;
                        }
                    }
                    $row++;
                }
                fclose($handle);

                echo '<div class="upload-message success bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <p class="font-bold">Import complete!</p>
                        <p>' . esc_html($posts_created) . ' posts created successfully.</p>
                        ' . ($posts_skipped > 0 ? '<p>' . esc_html($posts_skipped) . ' existing posts skipped (in append mode).</p>' : '') . '
                        ' . ($posts_failed > 0 ? '<p>' . esc_html($posts_failed) . ' posts failed to create. Check error logs for details.</p>' : '') . '
                      </div>';
            } else {
                echo '<div class="upload-message danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        <p class="font-bold">Error!</p>
                        <p>Unable to open the uploaded file.</p>
                      </div>';
            }
        } else {
            echo '<div class="upload-message danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>The uploaded file is not a CSV. Please upload a .csv file.</p>
                  </div>';
        }
    } else {
        if (isset($_POST['submit'])) {
            echo '<div class="upload-message danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>No file uploaded or an unknown error occurred during upload.</p>
                  </div>';
        }
    }
}

if (isset($_POST['submit'])) {
    handle_csv_import();
}
?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-3xl text-center mb-4">
            Upload a CSV File
        </h2>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <?php wp_nonce_field('csv_import_action', '_wpnonce');?>
            <div>
                <label for="csvFile" class="block text-gray-800 text-sm font-semibold mb-2">
                    Select CSV file to upload:
                </label>
                <div class="flex items-center space-x-3">
                    <label for="csvFile" class="custom-file-upload">
                        Choose File
                    </label>
                    <span id="fileName" class="text-gray-600 text-sm">No file chosen</span>
                    <input type="file" name="csvFile" id="csvFile" onchange="updateFileName(this)">
                </div>
            </div>

            <div class="py-4">
                <label class="block text-gray-800 text-sm font-semibold mb-2">
                    Import Type:
                </label>
                <div class="flex flex-col space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="import_mode" value="append" class="form-radio text-blue-600" checked>
                        <span class="ml-2 text-gray-700">Append new data</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="import_mode" value="replace" class="form-radio text-red-600">
                        <span class="ml-2 text-gray-700">Replace all data</span>
                    </label>
                </div>
            </div>

            <button type="submit" name="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 shadow-md">
                <i class="fas fa-upload mr-2"></i> Upload and Import
            </button>
        </form>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileNameSpan = document.getElementById('fileName');
        if (input.files.length > 0) {
            fileNameSpan.textContent = input.files[0].name;
        } else {
            fileNameSpan.textContent = 'No file chosen';
        }
    }
</script>