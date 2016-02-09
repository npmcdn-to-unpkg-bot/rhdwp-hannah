<?php
/**
 * RHD Base
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage rhd
 */
?>

<!DOCTYPE html>
	<!--[if lt IE 7]>   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>     <html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title><?php wp_title(); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="//browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

	<?php
		$nav_args_main = array(
			'theme_location' => 'primary',
			'menu_id' => 'site-navigation',
			'menu_class' => 'site-navigation',
			'container' => 'nav',
			'container_id' => 'site-navigation-container',
			'walker' => new RHD_Walker_Nav
		);

		$nav_args_sb = array(
			'theme_location' => 'slidebar',
			'menu_id' => 'site-navigation-sb',
			'menu_class' => 'site-navigation',
			'container' => 'nav',
			'container_id' => 'site-navigation-sb-container'
		);
	?>

	<div class="sb-slidebar sb-right sb-style-push">
		<img id="sb-title" src="<?php echo RHD_UPLOAD_URL; ?>/2016/02/white-title.png" alt="<?php bloginfo( 'name' ); ?>">
		<?php wp_nav_menu( $nav_args_sb ); ?>
	</div>

	<div id="page" class="hfeed site sb-site-container">
		<header id="masthead" class="site-header">
			<div id="navbar">
				<a href="<?php echo home_url(); ?>"><img id="site-title" src="<?php echo RHD_UPLOAD_URL; ?>/2016/01/small-logo.jpg" alt="River City Executive Housing"></a>

				<?php wp_nav_menu( $nav_args_main ); ?>
				<button id="hamburger" class="sb-toggle-right c-hamburger c-hamburger--htra">
					<span>Toggle nav</span>
				</button>
			</div>

			<?php if ( is_front_page() ) : ?>
				<?php
				$thumb_id = get_post_thumbnail_id();
				$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
				?>
				<div class="header-bg" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
					<h1 id="site-title-seo" class="site-title invisible"><?php bloginfo( 'name' ); ?></h1>
				</div>
			<?php else: ?>
				<div class="header-bg">
					<h1 id="site-title-seo" class="site-title invisible"><?php bloginfo( 'name' ); ?></h1>
					<?php the_post_thumbnail( 'full' ); ?>
				</div>
			<?php endif; ?>
		</header><!-- #masthead -->

		<main id="main" class="clearfix">
