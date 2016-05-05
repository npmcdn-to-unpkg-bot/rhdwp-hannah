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
		$nav_args_main = array(
			'theme_location' => 'primary',
			'menu_id' => 'site-navigation',
			'menu_class' => 'site-navigation',
			'container' => 'nav',
			'container_id' => 'site-navigation-container',
			'walker' => new RHD_Walker_Nav
		);
		?>

		<div id="page" class="hfeed site">
			<header id="masthead" class="site-header">
				<div class="border-inner">
					<div class="limiter">
						<h1 class="site-title invisible"><?php bloginfo( 'name' ); ?></h1>

						<a href="<?php echo home_url(); ?>"><img id="site-title" src="<?php echo RHD_UPLOAD_URL; ?>/2016/05/copper-dot-logo-long.png" alt="<?php echo bloginfo( 'name' ); ?>"></a>

						<?php wp_nav_menu( $nav_args_main ); ?>

						<button id="hamburger" class="c-hamburger c-hamburger--htx">
							<span>Toggle nav</span>
						</button>
					</div>
				</div>
			</header>

			<?php if ( is_front_page() ) : ?>
				<?php rhd_front_page_slider(); ?>
				<?php rhd_front_page_header_message(); ?>
			<?php endif; ?>

			<main id="main">