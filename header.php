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

		<?php
		// Final setup
		global $main_class;
		$header_class = ( is_front_page() || is_page( 'bio' ) || is_page( 'contact' ) ) ? 'header-overlay' : '';
		?>

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

		<div id="page" class="hfeed site sb-site-container">
			<header id="site-header" class="site-header <?php echo $header_class ? $header_class : ''; ?>">
				<div id="masthead">
					<div id="site-title">
						<a href="<?php echo home_url(); ?>">
							<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						</a>
					</div>

					<button id="hamburger" class="c-hamburger c-hamburger--rot">
						<span>Toggle nav</span>
					</button>

					<?php wp_nav_menu( $nav_args_main ); ?>
				</div>
			</header><!-- #masthead -->

			<main id="main" class="<?php echo rhd_main_div_class(); ?>">