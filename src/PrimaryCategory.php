<?php

namespace PrimaryCategoryPlugin;

class PrimaryCategory {

    /**
     * PrimaryCategory constructor.
     */
    public function __construct() {

        // Handle registering activation hook
        register_activation_hook( __FILE__,     [ 'PrimaryCategoryPlugin\\Activate', 'handleActivation' ] );

        // Handle registering deactivation hook
        register_deactivation_hook( __FILE__,   ['PrimaryCategoryPlugin\Deactivate', 'handleDeactivation' ] );

        // Handle registering uninstall hook
        register_uninstall_hook( __FILE__,      ['PrimaryCategoryPlugin\\Uninstall', 'handleUninstallation'] );

    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init(): void
    {
        // Add action to add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'addPrimaryCategoryMetabox' ) );

        // Add action to save primary category
        add_action( 'save_post', array( $this, 'savePrimaryCategory' ) );

        // Add shortcode to display posts by primary category
        add_shortcode( 'primary_category_posts', array( $this, 'displayPostsByPrimaryCategory' ) );
    }

    /**
     * Add primary category metabox
     *
     * @return void
     */
    public function addPrimaryCategoryMetabox(): void
    {
        // Add metabox to post edit screen
        add_meta_box(
            'primary_category_metabox',
            'Primary Category',
            array( $this, 'primaryCategoryMetaboxCallback' ),
            'post',
            'side',
            'default'
        );
    }

    /**
     * Save primary category
     *
     * @param mixed $post
     * @return void
     */
    public function primaryCategoryMetaboxCallback( mixed $post ): void
    {
        // Security nonce
        wp_nonce_field( 'save_primary_category', 'primary_category_nonce' );

        //
        $selected_primary_category = get_post_meta( $post->ID, '_primary_category', true );
        wp_dropdown_categories( array(
            'name'             => 'primary_category',
            'selected'         => $selected_primary_category,
            'show_option_none' => 'Select Primary Category'
        ) );
    }

    /**
     * Save primary category
     *
     * @param int $post_id
     * @return void
     */
    public function savePrimaryCategory( int $post_id ): void
    {
        // Check security nonce
        if ( ! isset( $_POST['primary_category_nonce'] ) || ! wp_verify_nonce( $_POST['primary_category_nonce'], 'save_primary_category' ) ) {
            return;
        }

        // Update the primary category meta value
        if ( isset( $_POST['primary_category'] ) ) {
            update_post_meta( $post_id, '_primary_category', sanitize_text_field( $_POST['primary_category'] ) );
        }
    }

    /**
     * Display posts by primary category
     *
     * @param array $atts
     * @return string
     */
    public function displayPostsByPrimaryCategory(array $atts ): string
    {
        // Getting the shortcode's attributes
        $atts = shortcode_atts( array(
            'category' => '1',
        ), $atts );

        // Creating the query arguments
        $args = array(
            'meta_key'   => '_primary_category',
            'meta_value' => $atts['category'],
            'post_type'  => 'post'
        );

        // Querying the posts by primary category
        $query = new \WP_Query( $args );
        wp_reset_postdata();

        // Array with the posts data
        $template_atts = array(
            'posts' 		=> $query->posts,
        );

        // Generate the posts HTML from the template
        ob_start();
        load_template( PLUGIN_TEMPLATES . 'display-posts.php', true,  $template_atts );

        return ob_get_clean();
    }

}