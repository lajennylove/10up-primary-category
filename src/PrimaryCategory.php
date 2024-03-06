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

        // Enqueue assets
        add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'));
    }

    /**
     * Enqueue the built CSS and JS files from Vite
     *
     * @return void
     */
    public function enqueueAssets(): void
    {
        // Get the dist directory
        $pathDir = PLUGIN_PATH_ASSETS . '/dist';
        $distDir = PLUGIN_ASSETS . '/dist';

        // Get the manifest file
        $assetsManifestPath = $pathDir . '/.vite/manifest.json';

        // If the manifest file exists, enqueue the assets
        if ( file_exists( $assetsManifestPath ) ) {

            // Decode the manifest file
            $manifest = json_decode( file_get_contents( $assetsManifestPath ), true );

            // Loop through the manifest and enqueue the assets
            foreach ( $manifest as $key => $value ) {

                // Get the file URL
                $fileUrl = $distDir . $value['file'];

                // Enqueue CSS files
                if ( isset( $value['css'] ) ) {
                    foreach ( $value['css'] as $cssFile ) {
                        wp_enqueue_style( 'plugin-style-' . $key, $distDir . $cssFile );
                    }
                }

                // Enqueue JS files
                if ( substr( $value['file'], -3 ) === '.js' ) {
                    wp_enqueue_script( 'plugin-script-' . $key, $fileUrl, array(), null, true );
                }
            }
        }
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

        // Get the primary category meta value
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
            'category' => '',
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