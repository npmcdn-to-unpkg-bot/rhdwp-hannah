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

		<!-- Google Analytics -->
		<script>
			(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
			e=o.createElement(i);r=o.getElementsByTagName(i)[0];
			e.src='//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
			ga('create','');ga('send','pageview');
		</script>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="//browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		
		<?php
			$nav_args_main = array(
				'menu_location' => 'primary',
				'menu_id' => 'site-navigation',
				'menu_class' => 'blue',
				'container' => 'nav',
				'container_id' => 'site-navigation-container'
			);
			
			$nav_args_sb = array(
				'menu_location' => 'primary',
				'menu_id' => 'sb-site-navigation',
				'container' => 'nav',
				'container_id' => 'sb-site-navigation-container'
			);
		?>
		
		<div class="sb-slidebar sb-left sb-style-push">
			<?php wp_nav_menu( $nav_args_sb ); ?>
		</div>
		
		<div id="page" class="hfeed site sb-site-container">
			<header id="masthead" class="site-header" role="banner">
				<div class="wrapper">
					<h1 id="site-title-mast" class="site-title blue"><?php echo get_bloginfo( 'name' ); ?></h1>

					<?php wp_nav_menu( $nav_args_main ); ?>
				</div>
				
				<a class="hamburger sb-toggle-left">
					hamburger
				</a>
			</header><!-- #masthead -->

			<div id="main" class="clearfix">