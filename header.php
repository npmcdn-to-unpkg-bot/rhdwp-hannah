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

		<?php
			// Basic front page & device detection
			$body_classes[] = ( is_front_page() ) ? 'front-page' : '';
			$body_classes[] = ( rhd_is_mobile() ) ?  'mobile' : '';
			$body_classes[] = ( wp_is_mobile() && !rhd_is_mobile() ) ? 'tablet' : '';
			$body_classes[] = ( !wp_is_mobile() && !rhd_is_mobile() ) ? 'desktop' : '';

			session_start();
			if ( is_home() || is_single() || is_archive() || is_search() ) {
				$body_classes[] = 'blog-area';

				$_SESSION['blog_area'] = true;
			} else {
				$_SESSION['blog_area'] = false;
			}
		?>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class( $body_classes ); ?>>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="//browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<?php
			$nav_args_main = array(
				'theme_location' => 'primary',
				'menu_id' => 'site-navigation',
				'menu_class' => 'site-navigation',
				'container' => 'nav',
				'container_id' => 'site-navigation-container'
			);

			$nav_args_sb = array(
				'theme_location' => 'slidebar',
				'menu_id' => 'site-navigation-sb',
				'menu_class' => 'site-navigation',
				'container' => 'nav',
				'container_id' => 'site-navigation-sb-container'
			);
		?>

		<div class="sb-slidebar sb-right sb-style-push sb-width-thin">
			<?php wp_nav_menu( $nav_args_sb ); ?>
		</div>

		<header id="masthead" class="site-header" role="banner">
			<h1 id="site-title" class="site-title invisible"><?php bloginfo( 'name' ); ?></h1>

			<a href="<?php echo home_url(); ?>"><img id="site-brand" src="<?php echo RHD_IMG_DIR; ?>/spear-ip-logo.png" alt="Spear IP"></a>
			<?php wp_nav_menu( $nav_args_main ); ?>

			<button id="hamburger" class="sb-toggle-right cmn-toggle-switch cmn-toggle-switch__rot">
				<span>Toggle nav</span>
			</button>
		</header><!-- #masthead -->

		<div id="page" class="hfeed site sb-site-container">
			<main id="main" class="clearfix">