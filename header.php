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
			<h1 class="site-title invisible"><?php bloginfo( 'name' ); ?></h1>
			<div id="loginbar">
				<button id="hamburger" class="c-hamburger c-hamburger--rot">
					<span>Toggle nav</span>
				</button>

				<div class="loginbar-links desktop-only">
					<p>
						<?php if ( ! is_user_logged_in() ) : ?>
							<a href="<?php echo wp_login_url(); ?>" class="login-frontend">Log In</a>
						<?php else : ?>
							<a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout-frontend">Log Out</a>
							|
							<a href="<?php echo home_url( '/account' ); ?>">My Account</a>
						<?php endif; ?>
						|
						<?php rhd_cart_link(); ?>
					</p>
					<div class="login-dropdown">
						<?php
						$args = array(
							'echo' => true,
							'remember' => true,
							'redirect' => site_url( '/account' )
						);
						wp_login_form( $args );
						?>
					</div>
				</div>
				<div id="header-search">
					<?php rhd_navbar_search_form(); ?>
				</div>
			</div>
			<div id="navbar">
				<div class="navbar-inner" id="masthead">
					<a href="<?php echo home_url(); ?>"><img id="site-title" class="site-title-image" src="<?php echo RHD_UPLOAD_URL; ?>/2016/07/marshalla-logo.png" alt="<?php bloginfo( 'name' ); ?>"></a>
					<div class="nav-dropdown">
						<a class="mobile-only" href="<?php echo home_url(); ?>"><img id="site-title-mobile" class="site-title-image" src="<?php echo RHD_UPLOAD_URL; ?>/2016/07/marshalla-logo.png" alt="<?php bloginfo( 'name' ); ?>"></a>
						<div class="loginout-mobile mobile-only">
							<p>
								<?php wp_loginout( home_url() ); ?>
								<?php if ( is_user_logged_in() ) : ?>
									| <a href="<?php echo home_url( '/account' ); ?>">My Account</a>
								<?php endif; ?>
								<?php if ( class_exists( 'WooCommerce' ) ) : ?>
									| <?php rhd_cart_link(); ?>
								<?php endif; ?>
							</p>
						</div>
						<?php wp_nav_menu( $nav_args ); ?>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->

		<main id="main">