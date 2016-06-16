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
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="//browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
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
				<div id="navbar">
					<div class="navbar-inner">
						<div class="nav-dropdown">
							<a class="mobile-only" href="<?php echo home_url(); ?>"><img class="site-title" src="<?php echo RHD_LOGO_SRC; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
							<?php wp_nav_menu( $nav_args ); ?>
						</div>
						<!-- social -->

						<?php get_sidebar( 'header' ); ?>
						
						<div id="header-search">
							<?php rhd_navbar_search_form(); ?>
						</div>

						<button id="hamburger" class="c-hamburger c-hamburger--rot">
							<span>Toggle nav</span>
						</button>
					</div>
				</div>

				<div id="masthead">
					<h1 class="invisible"><?php bloginfo( 'name' ); ?></h1>
					<a class="site-title-link" href="<?php echo home_url(); ?>"><img id="site-title" class="site-title" src="<?php echo RHD_LOGO_SRC; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
				</div>
			</header><!-- #masthead -->
			
			<hr class="goldsep">

			<main id="main">
				<div id="content-wrapper">