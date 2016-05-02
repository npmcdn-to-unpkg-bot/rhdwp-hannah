<?php
/**
 * RHD Theme Customizations
 *
 * ROUNDHOUSE DESIGNS
 *
 * @package WordPress
 * @subpackage rhd
 **/

/**
 * rhd_big_image_widgets function.
 *
 * @access public
 * @return void
 */
function rhd_big_image_widgets()
{
	$updir = wp_upload_dir();
	?>

	<aside id="highlights">
		<figure class="highlight-link">
			<a href="<?php echo home_url('/how-to-attend-camp-erin'); ?>">
				<?php
				$img_1 = wp_get_attachment_image_src( 47, '4x6' );
				$cap_1 = "Apply to attend camp";
				?>
				<img src="<?php echo $img_1[0]; ?>" alt="<?php echo $cap_1; ?>">
			</a>
			<figcaption><a href="<?php echo home_url('/how-to-attend-camp-erin'); ?>"><?php echo $cap_1; ?></a></figcaption>
		</figure>

		<figure class="highlight-link">
			<a href="<?php echo home_url('/become-a-camp-erin-volunteer'); ?>">
				<?php
				$img_2 = wp_get_attachment_image_src( 48, '4x6' );
				$cap_2 = "Volunteer";
				?>
				<img src="<?php echo $img_2[0]; ?>" alt="<?php echo $cap_2; ?>">
			</a>
			<figcaption><a href="<?php echo home_url('/become-a-camp-erin-volunteer'); ?>"><?php echo $cap_2; ?></a></figcaption>

		</figure>

		<figure class="highlight-link">
			<a href="<?php echo home_url('/donate'); ?>">
				<?php
				$img_3 = wp_get_attachment_image_src( 49, '4x6' );
				$cap_3 = "Donate";
				?>
				<img src="<?php echo $img_3[0]; ?>" alt="<?php echo $cap_3; ?>">
			</a>
			<figcaption><a href="<?php echo home_url('/donate'); ?>"><?php echo $cap_3; ?></a></figcaption>
		</figure>
	</aside>
	<?php
}
