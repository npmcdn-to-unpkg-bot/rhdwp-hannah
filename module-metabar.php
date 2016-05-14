<?php
/**
 *
 * Displays the Blog meta bar with dropdowns and search
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<div class="blog-metabar">
	<ul class="blog-metabar-content">
		<li>
			<div class="rhd-dropdown blog-categories">
				<div class="rhd-dropdown-title">
					<span class="dd-title-text">Categories</span>
					<a class="drop" href="">
						<!-- caret -->
					</a>
				</div>
				<ul>
					<?php wp_list_categories( 'title_li=' ); ?>
				</ul>
			</div>
		</li>
		<li>
			<div class="blog-archives rhd-dropdown">
				<div class="rhd-dropdown-title">
					<span class="dd-title-text">Archives</span>
					<a class="drop" href="">
						<!-- caret -->
					</a>
				</div>
				<ul>
					<?php wp_get_archives(); ?>
				</ul>
			</div>
		</li>
		<li>
			<div class="rhd-dropdown blog-search">
				<?php rhd_get_metabar_search_form(); ?>
			</div>
		</li>
	</ul>
</div>