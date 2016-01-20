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

		<!--
									   _  _
                                      | || |
         ____  ___   _   _  ____    _ | || | _    ___   _   _   ___   ____
        / ___)/ _ \ | | | ||  _ \  / || || || \  / _ \ | | | | /___) / _  )
       | |   | |_| || |_| || | | |( (_| || | | || |_| || |_| ||___ |( (/ /
       |_|    \___/  \____||_| |_| \____||_| |_| \___/  \____|(___/  \____)

                                     _               _
                                    | |             (_)
                                  _ | |  ____   ___  _   ____  ____    ___
                                 / || | / _  ) /___)| | / _  ||  _ \  /___)
                                ( (_| |( (/ / |___ || |( ( | || | | ||___ |
                                 \____| \____)(___/ |_| \_|| ||_| |_|(___/
                                                       (_____|

		-->

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
		$nav_args_sb = array(
			'theme_location' => 'slidebar',
			'menu_id' => 'site-navigation-sb',
			'menu_class' => 'site-navigation',
			'container' => 'nav',
			'container_id' => 'site-navigation-sb-container'
		);
		?>

<!--
		<div class="sb-slidebar sb-right sb-style-overlay sb-width-thin">
			<?php wp_nav_menu( $nav_args_sb ); ?>
		</div>
-->

		<div id="page" class="hfeed site sb-site-container">
			<header id="masthead" class="site-header">
				<h1 id="site-title-text" class="site-title invisible"><?php bloginfo( 'name' ); ?></h1>
				<?php $img = wp_get_attachment_image_src( 5, 'full' );  ?>
				<a href="<?php echo home_url(); ?>"><img id="site-title-header" alt="Kelly Bernier Designs" class="site-title" src="<?php echo $img[0]; ?>"></a>

				<?php rhd_nav_menu( true ); ?>
			</header><!-- #masthead -->

			<main id="main">