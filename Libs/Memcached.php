<?php

Class Memcached {

	protected static $memObj = null;
    
	private function __construct() { }

	public static function getInstance() {
		if(static::$memObj == null) {
			global $memcachedServers;
			static::$memObj = new Memcache;
			static::$memObj->connect($memcachedServers[0][0], $memcachedServers[0][1]);
		}
		return static::$memObj;
	}

}