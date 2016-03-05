<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<?php
$terms = get_the_terms( $post->id, 'location' );
$slug = $terms[0]->slug;

wp_safe_redirect( home_url( "/store/$slug" ) );
exit;
?>