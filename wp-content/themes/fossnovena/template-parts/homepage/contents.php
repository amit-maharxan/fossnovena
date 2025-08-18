<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <div class="mx-auto">
            <img src="https://fossnovena.org/wp-content/uploads/2020/08/perpetual_register.jpg" alt="Perpetual Register" class="w-full h-auto" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[30%_70%] gap-6 mx-4 md:mx-12 my-8 md:my-12">
            <div class="p-4">
                <div>
                    <h3 class="text-xl font-semibold uppercase cinzel-font text-[#0b83c0]">Perpetual</h3>
                </div>
                <div>
                    <h2 class="text-4xl font-bold uppercase cinzel-font text-[#e14426]">Register</h2>
                </div>
                <div class="my-4 border-b"></div>
                <div>
                    <p class="text-base text-gray-700">
                        The Perpetual Register records the names of our members who have passed into eternity. 
                        Click on the letter to search the Register by surname.
                    </p>
                </div>
            </div>

            <div class="p-4">
                <div class="atoz-filter flex flex-wrap gap-2">
                    <?php foreach (range('A', 'Z') as $letter) {
                        echo '<span class="filter-letter" data-letter="' . strtolower($letter) . '">' . $letter . '</span>';
                    } ?>
                </div>
                <hr class="text-gray-200">
                <div id="posts-container" class="grid border-1 p-4 mt-6 border-gray-100">
                    <?php
                    $args = array(
                        'post_type'      => 'entry',
                        'posts_per_page' => -1,
                        'orderby'        => 'title',
                        'order'          => 'ASC'
                    );
                    $query = new WP_Query($args);

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
                                echo '<h5 class="entry-title">';
                                echo '<a href="' . esc_url($post['permalink']) . '" rel="bookmark">';
                                echo esc_html($post['title']);
                                echo '<br>' . esc_html($post['meta']);
                                echo '</a>';
                                echo '</h5>';
                            }
                        }
                    } else {
                        echo 'No records found.';
                    } ?>
                    <div class="loader-icon">
                        <img src="<?php echo FOSS_IMG.'/loader.gif';?>" alt="loader">
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
jQuery(document).ready(function($) {
    $('.loader-icon').hide();

    setTimeout(function() {
        $('.filter-letter:first').click();
    }, 500);

    $('.filter-letter').on('click', function(e) {
        e.preventDefault();

        $('.loader-icon').show();
        $('.filter-letter').removeClass('active');
        $(this).addClass('active');
        var letter      = $(this).data('letter');
        var container   = $('#posts-container');
        container.html("<div class='loader-icon'><img src='<?php echo FOSS_IMG.'/loader.gif';?>' alt='loader'></div>");

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'atoz_filter',
                letter: letter
            },
            success: function(response) {
                $('.loader-icon').hide();
                container.html(response);
            },
            error: function() {
                container.html('<p>Error fetching posts. Please try again.</p>');
            }
        });
    });
});
</script>