<?php

/**
	* System configuration
*/
class Config
{
	public static $HOST        = "localhost";
	public static $DATEBASE    = "datebase";
	public static $DB_USER     = "root";
	public static $DB_PASSWORD = "";


	// smarty configuration
	public static $debugging = true;
	public static $caching = false;
	public static $cache_lifetime = '';
	public static $cache_dir = 'app/Cache/';//'./cache/';
	public static $template_dir= 'app/Views/';
	public static $compile_dir = 'app/Views_c/';//'./templates_c/';
}