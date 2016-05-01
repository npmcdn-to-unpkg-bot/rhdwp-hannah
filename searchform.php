<?php
/**
 * Roundhouse Designs
 *
 * Custom Search Form
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url('/') ); ?>">
    <div>
        <input type="text" value="" class="search-field" placeholder="Looking for something?" name="s" />
        <input type="submit" class="search-submit" value="Search" />
        <input type="hidden" value="post" name="post_type" id="post_type" />
    </div>
</form>
