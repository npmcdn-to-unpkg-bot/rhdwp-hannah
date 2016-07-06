<?php
/**
 * The donation processing template file.
 *
 * @package WordPress
 * @subpackage rhd
 */


// Set up Classy redirect
if ( isset( $_GET['classy-url'] ) )
	$url = $_GET['classy-url'];

if ( isset( $_GET['eid'] ) )
	$eid = $_GET['eid'];

if ( isset( $_GET['amount'] ) )
	$amt = $_GET['amount'];

if ( isset( $_GET['recurring'] ) )
	$recur = $_GET['recurring'];

$pass_to = "$url&amount=$amt&recurring=$recur";
wp_redirect( $pass_to, 302 );