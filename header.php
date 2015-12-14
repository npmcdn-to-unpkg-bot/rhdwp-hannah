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
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

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

		<div class="sb-slidebar sb-left sb-style-overlay sb-width-custom sb-momentum-scrolling" data-sb-width="45%">
			<?php wp_nav_menu( $nav_args_sb ); ?>
		</div>
		
		<header id="masthead" class="site-header">
			<?php if ( is_front_page() ) : ?>
				<div id="front-page-logo">
					<div class="overlay"></div>
					<div class="front-page-title">
						<img src="<?php echo RHD_IMG_DIR; ?>/lambs-logo.png" alt="The Lambs crest">
						<h1 class="front-page-subtitle"><?php bloginfo( 'description' ); ?></h1>
					</div>
				</div>
			<?php else : ?>
				<div id="page-thumbnail-wide">
					<?php
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'full', array( 'alt' => single_post_title( '', false ) ) );
					else :
						$updir = wp_upload_dir();
						?>
						<img src="<?php echo $updir['baseurl']; ?>/2015/11/gambol.jpg" alt="The Lambs&reg;">
						<?php
					endif;
					?>						
				</div>
			<?php endif; ?>
			
			<div id="navbar">
				<h1 id="site-title" class="site-title">
					<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?><sup class="r">&reg;</sup></a>
				</h1>

				<?php wp_nav_menu( $nav_args_main ); ?>

					<button id="hamburger" class="sb-toggle-left c-hamburger c-hamburger--htla">
						<span>Toggle nav</span>
					</button>
				</div>
			</header><!-- #masthead -->
			
			<div id="page" class="hfeed site sb-site-container">
				<main id="main" class="clearfix">