<?php
/**
 *
 * Displays the Blog meta bar with dropdowns and search
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<div id="blog-metabar">
	<ul id="blog-metabar-content">
		<li>
			<div id="blog-categories" class="rhd-dropdown">
				<div class="rhd-dropdown-title">
					<span class="dd-title-text">Categories</span>
					<a class="drop" href="">
						<span class="dd-link-text">&dtri;</span>
					</a>
				</div>
				<ul>
					<?php wp_list_categories( 'title_li=' ); ?>
				</ul>
			</div>
		</li>
		<li>
			<div id="blog-archives" class="rhd-dropdown">
				<div class="rhd-dropdown-title">
					<span class="dd-title-text">Archives</span>
					<a class="drop" href="">
						<span class="dd-link-text">&dtri;</span>
					</a>
				</div>
				<ul>
					<?php wp_get_archives(); ?>
				</ul>
			</div>
		</li>
		<li>
			<div id="blog-search" class="rhd-dropdown">
				<?php get_search_form(); ?>
			</div>
		</li>
	</ul>
</div>