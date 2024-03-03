# Primary Category Plugin

This WordPress plugin allows publishers to designate a primary category for their posts. It adds a meta box to the post editor to set the primary category, provides a way to save the primary category for each post, and offers a shortcode to list the posts by primary category.

## Installation

1. Upload the `PrimaryCategoryPlugin` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## How To Use

1. Edit a post where you will see a new meta box in the right sidebar called "Primary Category".

2. In the "Primary Category" meta box, you will see a dropdown list of all categories. Select your "Primary Category" from the dropdown. The selected value will be saved when you save your post.

3. To display posts from a specific primary category, you can use the provided shortcode. For instance, if you want to display posts that have the 'Tech' category as their primary category, use this shortcode in your post or page: `[primary_category_posts category="Tech"]`. Replace 'Tech' with your desired category name.

4. The shortcode will generate a list of post titles that have the defined category as their primary category. Each title will be a link to its respective post.

## Uninstalling

When the plugin is deactivated and deleted from the 'Plugins' menu, all the '_primary_category' metadata added by the plugin will be removed from all posts.

## Notes

Remember that the shortcode will work properly only if it is used after the 'Primary Category' has been set for posts.