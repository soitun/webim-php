<?php
/**
 * @package webim
 */

// Die if PHP is not new enough
if ( version_compare( PHP_VERSION, '4.3', '<' ) ) {
	die( sprintf( 'Your server is running PHP version %s but webim requires at least 4.3', PHP_VERSION ) );
}

if ( !defined( 'WEBIM_PATH' ) ) 
	define( 'WEBIM_PATH', dirname( __FILE__ ) . '/' );

if ( !defined( 'WEBIMDB_DEBUG' ) )
	define( 'WEBIMDB_DEBUG', true );

if ( !defined( 'WEBIMDB_CHARSET' ) )
	define( 'WEBIMDB_CHARSET', 'utf8' );

require_once( WEBIM_PATH . 'functions.json.php' );
require_once( WEBIM_PATH . 'functions.helper.php' );
require_once( WEBIM_PATH . 'class.webim_db.php' );

require_once( WEBIM_PATH . 'http_client.php' );
require_once( WEBIM_PATH . 'class.webim_client.php' );

//$imdb, $imuser, $ticket, $_IMC
