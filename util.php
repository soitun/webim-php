<?php

/**
 * Add json_encode and json_decode in php4
 *
 */
if( !function_exists('json_encode') ) {
	require_once 'json.php';
	function json_encode($data) {
		$json = new Services_JSON();
		return( $json->encode($data) );
	}
}

// Future-friendly json_decode
if( !function_exists('json_decode') ) {
	require_once 'json.php';
	function json_decode($data) {
		$json = new Services_JSON();
		return( $json->decode($data) );
	}
}

/**
 * Provide a simple method for the $_GET and $_POST
 *
 */
function g($key = '') {
	return $key === '' ? $_GET : (isset($_GET[$key]) ? $_GET[$key] : null);
}

function p($key = '') {
	return $key === '' ? $_POST : (isset($_POST[$key]) ? $_POST[$key] : null);
}

function gp($key = '',$def = null) {
	$v = g($key);
	if(is_null($v)){
		$v = p($key);
	}
	if(is_null($v)){
		$v = $def;
	}
	return $v;
}

/**
 * 
 *
 */
function _iconv($s,$t,$data){
	if( function_exists('iconv') ) {
		return iconv($s,$t,$data);
	}else{
		require_once 'chinese.class.php';
		$chs = new Chinese($s,$t);
		return $chs->convert($data);
	}
}

function to_unicode($s){ 
	return preg_replace("/^\"(.*)\"$/","$1",json_encode($s));
}

function unicode_val($ob){
	foreach($ob as $k => $v){
		$ob[$k] = to_unicode($v);
	}
	return $ob;
}

/**
 * Handle dir
 */

function scan_subdir($dir){
	$d = dir($dir."/");
	$dn     = array();
	while (false !== ($f = $d->read())) {
		if(is_dir($dir."/".$f) && $f!='.' && $f!='..') $dn[]=$f;
	}
	$d->close();
	return $dn;
}

function clean_dir($dir){
	if(!file_exists($dir)){
		return ;
	}
	$directory = dir($dir);
	while($entry = $directory->read()) {
		$filename = $dir.'/'.$entry;
		if(is_file($filename)) {
			@unlink($filename);
		}
	}
	$directory->close();
}

/** 
 * url helper 
 */

function is_remote() {
	$remote = false;
	if ( strlen($_SERVER['HTTP_REFERER']) ) {
		$referer = parse_url( $_SERVER['HTTP_REFERER'] );
		$referer['port'] = isset( $referer['port'] ) ? $referer['port'] : "80";
		if ( $referer['port'] != $_SERVER['SERVER_PORT'] || $referer['host'] != $_SERVER['SERVER_NAME'] || $referer['scheme'] != ( (@$_SERVER["HTTPS"] == "on") ? "https" : "http" ) ){
			$remote = true;
		}
	}
	return $remote;
}

function urlname() {
	global $_SERVER;
	$name = htmlspecialchars($_SERVER['SCRIPT_NAME'] ? $_SERVER['SCRIPT_NAME'] : $_SERVER['PHP_SELF']);
	return ( (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://" ) . ( ( $_SERVER["SERVER_PORT"] != "80" ) ? ( $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] ) : $_SERVER["SERVER_NAME"] ) . substr( $name, 0, strrpos( $name, '/' ) ) . "/";
}

/**
 * Output
 */

function callback( $data, $funciton = "callback" ){
	$data = json_encode( $data );
	if( gp( $funciton ) ){
		return gp( $funciton ) . "($data);";
	}else{
		return $data;
	}
}

?>
