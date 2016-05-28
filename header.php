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
	
	<?php
	if ( is_front_page() ) {
		global $post;
		$bg_src = rhd_get_featured_img_src( $post->ID, 'full' );
		$bg_style = 'style="background-image: url(' . $bg_src . ');"';
	};
	?>

	<body <?php body_class(); echo $bg_style; ?>>
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
			<main id="main">
				<header id="masthead-mobile" class="site-header mobile-only">
					<h1 id="site-title-mobile" class="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	
					<button id="hamburger" class="c-hamburger c-hamburger--htx mobile-only">
						<span>Toggle nav</span>
					</button>
					
					<?php wp_nav_menu( $nav_args ); ?>
				</header><!-- #masthead -->
				
				<?php if ( !is_front_page() ) get_sidebar(); ?>
				
				<div id="primary" class="site-content">
					<header id="masthead-large" class="site-header large-only">
						<h1 id="site-title-large" class="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		
						<?php wp_nav_menu( $nav_args ); ?>
					</header><!-- #masthead -->