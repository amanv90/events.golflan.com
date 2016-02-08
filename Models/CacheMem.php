<?php

/**
 * \brief This class contains CacheMem Details [Ex : Create, Set, Get etc.]
 * \n Features:
 * \li Create MemObj
 * \li Get Previously Stored Data
 * \li Stores an item var with key on the memcached server
 * \li Delete item from the server
 * \n
 * \author Sahil Saggar
 * \version 2.1
 * \date 23-Feb-2011
 * \note (C) 2011 Fermion Infotech Private Limited. All rights reserved. (info@fermion.in)
 */
final class CacheMem {

	/**
	 * @var Connection Object $memConnectionObj
	 */
	private static $memConnectionObj;

	/**
	 * @var Array $servers
	 */
	private static $servers = array(
		array('127.0.0.1'=>'11211')
	);

	/**
	 *  _construct don't permit an explicit call of the constructor (like $v = new Singleton()
	 */
	private function __construct()
    { }

	/**
	 *  _clone don't permit cloning the singleton (like $x = clone $v)
	 */
    private function __clone()
    { }

	/**
	 * createMemObj Accepts the 2 Dimenssional array with details of memcached servers
	 * @param Array $servers
	 * <p>This function calls addServer() - adds servers to the server pool. Each entry in servers is supposed to be an array containing hostname, port, and, optionally, weight of the server. No connection is established to the servers at this time.</p>
	 * @return Boolean [Returns TRUE on success or FALSE on failure]
	 */
	private static function createMemObj() {
		if(!is_object(self::$memConnectionObj)) {
			self::$memConnectionObj = new Memcache;
			if(self::$memConnectionObj === false) {
				return false;
			}

			foreach(self::$servers as $val) {
				self::$memConnectionObj->addServer(key($val), current($val), false, 1, 1, -1, TRUE);
			}
		}
		return true;
	}

	/**
	 * flush Clear the cache
	 * <p>This function flush the ob output buffers if you are using those</p>
	 * @return void
	 */
	public static function flush() {
		if(self::createMemObj()) {
			self::$memConnectionObj->flush();
		}
	}

	/**
	 * get returns previously stored data if an item with such key exists on the server at this moment
	 * @param Array $key contains key or array of keys to fetch
	 * <p> This function returns previously stored data if an item with such key exists on the server at this moment.You can pass array of keys to get() to get array of values. The result array will contain only found key-value pairs</p>
	 * @return mix [Returns the string associated with the key or FALSE on failure or if such key was not found]
	 */
	public static function get($key) {
		if(self::createMemObj()) {
			if (is_array($key)) {
				$dest = array();
				foreach ($key as $subkey) {
					$val = self::$memConnectionObj->get($subkey);
					if (!($val === false)) $dest[$subkey] = $val;
				}
				return $dest;
			} else {
				return self::$memConnectionObj->get($key);
			}
		} else {
			return;
		}
	}

	/**
	 * set stores an item var with key on the memcached server (overwrite if key exists)
	 * @param string $key contains key that will be associated with the item
	 * @param mix $var contains variable to store. Strings and integers are stored as is, other types are stored serialized
	 * @param bool $compress Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib)
	 * @param int $expire contains Expiration time of the item. If it's equal to zero, the item will never expire. You can also use Unix timestamp or a number of seconds starting from current time, but in the latter case the number of seconds may not exceed 2592000 (30 days).
	 * <p>This function stores an item var with key on the memcached server</p>
	 * @return boolean [Returns TRUE on success or FALSE on failure]
	 */
	public static function set($key, $var, $compress=0, $expire=0) {
		if(self::createMemObj()) {
			return self::$memConnectionObj->set($key, $var, $compress?MEMCACHE_COMPRESSED:null, $expire);
		} else {
			return false;
		}
	}

	/**
	 * add Set the value in memcache if the value does not exist
	 * @param sting $key contains The key that will be associated with the item
	 * @param mix $var contains The variable to store. Strings and integers are stored as is, other types are stored serialized
	 * @param boolean $compress Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib)
	 * @param int $expire contain Expiration time of the item
	 * <p>This function stores variable var with key only if such key doesn't exist at the server yet</p>
	 * @return boolean [Returns TRUE on success or FALSE on failure. Returns FALSE if such key already exist]
	 */
	public static function add($key, $var, $compress=0, $expire=0) {
		if(self::createMemObj()) {
			return self::$memConnectionObj->add($key, $var, $compress?MEMCACHE_COMPRESSED:null, $expire);
		} else {
			return false;
		}
	}

	/**
	 * replace used to replace value of existing item with key
	 * @param sting $key contains The key that will be associated with the item
	 * @param mix $var contains The variable to store. Strings and integers are stored as is, other types are stored serialized
	 * @param boolean $compress Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib)
	 * @param int $expire contain Expiration time of the item
	 * <p>This function should be used to replace value of existing item with key. In case if item with such key doesn't exists, replace() returns FALSE.</p>
	 * @return boolean [Returns TRUE on success or FALSE on failure. ]
	 */
	public static function replace($key, $var, $compress=0, $expire=0) {
		if(self::createMemObj()) {
			return self::$memConnectionObj->replace($key, $var, $compress?MEMCACHE_COMPRESSED:null, $expire);
		} else {
			return false;
		}
	}

	/**
	 * delete Delete item from the server or set a timeout
	 * @param string $key contains the key associated with the item to delete.
	 * @param int $timeout - this deprecated parameter is not supported, and defaults to 0 seconds. Do not use this parameter
	 * <p>This function deletes an item with the key</p>
	 * @return boolean [Returns TRUE on success or FALSE on failure]
	 */
	public static function delete($key, $timeout=0) {
		if(self::createMemObj()) {
			return self::$memConnectionObj->delete($key, $timeout);
		} else {
			return false;
		}
	}

	/**
	 * increament Increments existing integer value of an item by the specified value
	 * @param string $key contains Key of the item to increment.
	 * @param mix $value contains the value to increment the item by value
	 * <p>This function increments value of an item by the specified value. If item specified by key was not numeric and cannot be converted to a number, it will change its value to value</p>
	 * @return boolean [Returns new items value on success or FALSE on failure]
	 */
	public static function increment($key, $value=1) {
		if(self::createMemObj()) {
			return self::$memConnectionObj->increment($key, $value);
		} else {
			return false;
		}
	}

	/**
	 * decrement decrements value of the item by value
	 * @param string $key contains Key of the item do decrement
	 * @param mix $value contains the value to decrement the item by value
	 * <p>This function decrements value of an item by the specified value. Current value of the item is being converted to numerical and after that value is substracted</p>
	 * @return boolean [Returns item's new value on success or FALSE on failure. ]
	 */
	public static function decrement($key, $value=1) {
		if(self::createMemObj()) {
			return self::$memConnectionObj->decrement($key, $value);
		} else {
			return false;
		}
	}
}
?>