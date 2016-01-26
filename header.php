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
			<?php wp_nav_menu( $nav_args_sb ); ?>

			<?php if ( $type == 'portfolio' || is_page( 10 ) ) : ?>
				<div class="portfolio-nav-sb">
					<h2 class="page-title">Portfolio</h2>
					<?php rhd_portfolio_nav( 'slidebar' ); ?>
				</div>
			<?php endif; ?>

		</div>

		<div id="page" class="hfeed site sb-site-container">
			<header id="masthead" class="site-header">
				<?php
				$type = get_post_type();

				if ( $type != 'portfolio' && ( $type != 'post' && ! is_single() ) ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full', true );
					$bg = $thumb_url[0];
				} else {
					$bg = '';
					$header_class = 'header-bg-short';
				}
				?>

				<div class="header-bg <?php echo $header_class; ?>" style="background-image: url(<?php echo $bg; ?>);">
					<h1 id="site-title-seo"><?php bloginfo( 'name' ); ?></span></h1>

					<h2 class="page-title page-title-nav"><?php the_title(); ?></h2>

					<svg id="site-title" viewBox="0 0 574 129" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
					    <!-- Generator: Sketch 3.4.4 (17249) - http://www.bohemiancoding.com/sketch -->
					    <g id="Home" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
					        <g id="Desktop" sketch:type="MSArtboardGroup" transform="translate(-231.000000, -254.000000)" sketch:alignment="middle" fill="#CF1B1E" font-weight="normal">
					            <g id="Vanessa-Leuck-+-Costume-Design" sketch:type="MSLayerGroup" transform="translate(234.000000, 203.000000)">
					                <text id="Vanessa-Leuck" sketch:type="MSTextLayer" font-family="Manhattan Darling" font-size="134">
					                    <tspan x="0.115" y="181">Vanessa Leuck</tspan>
					                </text>
					                <text id="Costume-Design" sketch:type="MSTextLayer" font-family="Ale Pro" font-size="32">
					                    <tspan x="331.039062" y="180">Costume Design</tspan>
					                </text>
					            </g>
					        </g>
					    </g>
					</svg>
				</div>

				<?php wp_nav_menu( $nav_args_main ); ?>

				<button id="hamburger" class="sb-toggle-right c-hamburger c-hamburger--htra">
					<span>Toggle nav</span>
				</button>
			</header><!-- #masthead -->

			<main id="main" class="clearfix">
