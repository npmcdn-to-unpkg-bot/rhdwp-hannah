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

<form role="search" method="get" class="search-form" action="<?php echo home_url(); ?>">
    <div>
        <input type="text" value="" placeholder="I'm looking for..." name="search" />
        <input type="submit" class="search-submit" value="Search" />
    </div>
</form>
