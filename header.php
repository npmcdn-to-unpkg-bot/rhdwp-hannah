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
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title><?php wp_title(); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. It's time... <a href="//browsehappy.com/">Upgrade your browser</a> to improve your experience. And your life.</p>
	<![endif]-->

	<?php
	$nav_args = array(
		'theme_location' => 'primary',
		'menu_id' => 'site-navigation',
		'menu_class' => 'site-navigation',
		'container' => 'nav',
		'container_id' => 'site-navigation-container',
		'walker' => new RHD_Walker_Nav
	);
	?>

	<div id="page" class="hfeed site">
		<header id="header" class="site-header">
			<div id="navbar" class="masthead">
				<div class="navbar-inner">
					<a id="logo-simple-link" href="<?php echo home_url(); ?>">
						<?php get_template_part( 'img/inline', 'logo-simple.svg' ); ?>
					</a>
					<?php get_template_part( 'img/inline', 'site-title.svg' ); ?>

					<div class="nav-dropdown">
						<h1 class="site-title invisible"><?php bloginfo( 'name' ); ?></h1>
						<?php wp_nav_menu( $nav_args ); ?>

						<div id="header-social">
							<?php echo do_shortcode( '[rhd-social-icons color1="#b6a072" color2="#9d9d9d" widget_loc="header"]' ); ?>
						</div>

						<div id="header-search">
							<?php rhd_navbar_search_form(); ?>
						</div>
					</div>

					<button id="hamburger" class="c-hamburger c-hamburger--rot">
						<span>Toggle nav</span>
					</button>
				</div>
			</div>
		</header><!-- #masthead -->

		<?php if ( is_front_page() ) : ?>
			<section id="featured-content">
				<div class="featured-content-wrapper">
					<div class="featured-content-inner">
						<div class="featured-content-slider">
							<img class="logo-overlay" src="<?php echo RHD_IMG_DIR; ?>/logo-full.png" alt="Vintage Revivals">
							<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( 'featured-posts', 'slug' ); } ?>
						</div>
						<div class="featured-links">
							<div class="shop-link">
								<a href="//shop.vintagerevivals.com" rel="prefetch">
									<img src="<?php echo RHD_UPLOAD_URL; ?>/2014/10/vintage_revivals_shop_-copy.jpg" alt="The VR Shop">
								</a>
							</div>
							<div class="featured-single">
								<?php rhd_featured_post(); ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<main id="main">