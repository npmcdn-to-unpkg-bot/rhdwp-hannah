<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage rhd
 */

// TESTING PURPOSES ONLY

if ( isset( $_GET['classy-url'] ) )
	$url = $_GET['classy-url'];


if ( isset( $_GET['eid'] ) )
	$eid = $_GET['eid'];

if ( isset( $_GET['amount'] ) )
	$amt = $_GET['amount'];


if ( isset( $_GET['recurring'] ) )
	$recur = $_GET['recurring'];

$pass_to = "$url&amount=$amt&recurring=$recur";

//echo $pass_to;

wp_redirect( $pass_to, 302 );