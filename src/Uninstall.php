<?php

namespace PrimaryCategoryPlugin;

class Uninstall
{
    /**
     * Handle uninstallation
     *
     * @return void
     */
    public function handleUninstallation(): void
    {
        // Creating query arguments to delete all posts with the custom meta
        $args = [
            'post_type' => 'any', // Change to query only certain post types if needed
            'posts_per_page' => -1,
            'post_status' => 'any',
            'meta_query' => [
                [
                    'key' => '_primary_category',
                ],
            ],
        ];

        // Query all posts with the custom meta
        $query = new \WP_Query($args);
        while ($query->have_posts()) {
            $query->the_post();
            // Delete the meta data
            delete_post_meta(get_the_ID(), '_primary_category');
        }
        wp_reset_postdata();

    }
}