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

<form method="get" class="search-form search-form-roster" action="<?php echo esc_url( home_url('/') ); ?>">
    <div>
        <input type="hidden" value="current-members" name="member_class" /> 
        <input type="text" value="" class="search-field" placeholder="Search current members" name="s" />
        <input type="submit" class="search-submit" value="Search" />
    </div>
</form>