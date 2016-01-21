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
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

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

		<!-- havenhomemedia -->
		<script>
			(function() {
				var d=document,h=d.getElementsByTagName('head')[0],s=d.createElement('script'),sc = 'https:' == document.location.protocol ? 'https://' : 'http://';
				s.type='text/javascript';
				s.async=true;
				s.src=sc+'s.dpmsrv.com/dpm_80e28a51cbc26fa4bd34938c5e593b36146f5e0c.min.js';
				h.appendChild(s);
			})();
		</script>

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

		$updir = wp_upload_dir();
		?>

		<div id="page" class="hfeed site sb-site-container">
			<header id="masthead" class="site-header">
				<div id="rhd-ad-box-header">
					<script type='text/javascript' src='//www.googletagservices.com/tag/js/gpt.js'>
						googletag.pubads().definePassback('/6178/hhm.centsationalgirl/misc', [728, 90]).setTargeting('pos', ['top']).display();
					</script>
				</div>

				<a id="site-title" href="<?php echo home_url(); ?>">
					<img src="<?php echo $updir['baseurl']; ?>/2016/01/centsational-logo-2016.png" alt="<?php bloginfo('name'); ?>" title="Centsational Girl">
				</a>

				<button id="hamburger" class="sb-toggle-left c-hamburger c-hamburger--htx">
					<span>Toggle nav</span>
				</button>

				<?php wp_nav_menu( $nav_args ); ?>
			</header><!-- #masthead -->

			<main id="main">