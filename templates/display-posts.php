<?php
/**
 * Template: Display posts by primary category
 * Display posts by primary category
 *
 */
$posts = $args['posts'];
?>
<?php if ( empty( $posts ) ) : ?>
    <p>No posts found</p>
<?php else: ?>
<ul>
    <?php foreach ( $posts as $post ) : ?>
        <li><a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( get_the_title( $post->ID ) ); ?></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>