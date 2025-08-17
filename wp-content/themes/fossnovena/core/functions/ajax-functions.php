<?php

function atoz_filter_ajax_handler() {
    $letter = isset($_POST['letter']) ? sanitize_text_field($_POST['letter']) : '';

    $args = array(
        'post_type'         => 'entry',
        'posts_per_page'    => -1,
        'orderby'           => 'title',
        'order'             => 'ASC',
        's'                 => $letter,
        'title_starts_with' => $letter
    );

    add_filter( 'posts_where', 'title_starts_with_filter' );

    $query = new WP_Query( $args );

    if ($query->have_posts()) {
        $grouped_posts = [];
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $prefix = strtoupper(substr($title, 0, 2));
            if (!isset($grouped_posts[$prefix])) {
                $grouped_posts[$prefix] = [];
            }
            $grouped_posts[$prefix][] = [
                'id'    => get_the_ID(),
                'title' => $title,
                'permalink' => get_permalink(),
                'meta' => get_post_meta(get_the_ID(), 'csv_life_stats', true)
            ];
        }
        wp_reset_postdata();

        foreach ($grouped_posts as $prefix => $posts) {
            echo '<h2 class="text-red-500">' . $prefix . '</h2>';
            foreach ($posts as $post) {
                echo '<h5 class="entry-title pb-2">';
                echo '<a href="javascript:void(0);" rel="bookmark">';
                echo esc_html($post['title']);
                echo '<br>' . esc_html($post['meta']);
                echo '</a>';
                echo '</h5>';
            }
        }
    } else {
        echo 'No records found.';
    }

    remove_filter( 'posts_where', 'title_starts_with_filter' );

    wp_die();
}

add_action('wp_ajax_atoz_filter', 'atoz_filter_ajax_handler');
add_action('wp_ajax_nopriv_atoz_filter', 'atoz_filter_ajax_handler');

// Custom function to filter posts by title that starts with a specific letter
function title_starts_with_filter($where) {
    global $wpdb;
    if (isset($_POST['letter']) && $_POST['letter'] !== '') {
        $letter = sanitize_text_field($_POST['letter']);
        $where .= $wpdb->prepare(" AND $wpdb->posts.post_title LIKE %s", $letter . '%');
    }
    return $where;
}