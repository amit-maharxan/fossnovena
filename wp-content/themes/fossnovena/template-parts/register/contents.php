<?php

require_once(ABSPATH . 'wp-load.php');

function handle_csv_import() {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        $file_info = pathinfo($_FILES['csvFile']['name']);
        $file_extension = strtolower($file_info['extension']);

        if ($file_extension === 'csv') {
            $temp_file_path = $_FILES['csvFile']['tmp_name'];

            if (($handle = fopen($temp_file_path, 'r')) !== FALSE) {
                $row = 0;
                $posts_created = 0;

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($row === 0) {
                        $row++;
                        continue;
                    }

                    $id         = sanitize_text_field($data[0]);
                    $entry      = sanitize_text_field($data[1]);
                    $lifeStats  = sanitize_text_field($data[2]);
                    $sort       = sanitize_text_field($data[3]);

                    $existing_post = get_page_by_title($entry, OBJECT, 'entry');
                    if (!$existing_post) {
                        $post_args = array(
                            'post_title'    => $entry,
                            'post_status'   => 'publish',
                            'post_type'     => 'entry',
                        );

                        $post_id = wp_insert_post($post_args);

                        if (!is_wp_error($post_id)) {
                            update_post_meta($post_id, 'csv_id', $id);
                            update_post_meta($post_id, 'csv_entry', $entry);
                            update_post_meta($post_id, 'csv_life_stats', $lifeStats);
                            update_post_meta($post_id, 'csv_sort', $sort);
                            $posts_created++;
                        }
                    }
                    $row++;
                }
                fclose($handle);
                echo '<h4 class="success upload-message">Import complete! ' . esc_html($posts_created) . ' posts created successfully.</h4>';
            } else {
                echo '<h4 class="danger upload-message">Error! Unable to open the uploaded file.</h4>';
            }
        } else {
            echo '<h4 class="danger upload-message">Error! The uploaded file is not a CSV. Please upload a .csv file.</h4>';
        }
    } else {
        if (isset($_POST['submit'])) {
            echo '<h4 class="danger upload-message">Error !</h4>';
        }
    }
}

if (isset($_POST['submit'])) {
    handle_csv_import();
} ?>

<div class="flex items-center justify-center max-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md mt-20">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Upload a CSV File to Import Data</h2>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="csvFile" class="block text-gray-700 text-sm font-semibold mb-2">Select CSV file to upload:</label>
                <div class="flex items-center space-x-3">
                    <!-- Custom styled file input button -->
                    <label for="csvFile" class="custom-file-upload">
                        Choose File
                    </label>
                    <!-- Display selected file name -->
                    <span id="fileName" class="text-gray-600 text-sm">No file chosen</span>
                    <input type="file" name="csvFile" id="csvFile" onchange="updateFileName(this)">
                </div>
            </div>

            <button type="submit" name="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 shadow-md">
                Upload and Import
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