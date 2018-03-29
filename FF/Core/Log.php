<?php
namespace FF\Core;
use FF\Core\Config;

class Log{

	private static $drive;

	/**
	 * 1.确定日志的存储方式
	 *
	 * 2.写日志
	 */

	public static function init() {
		//确定存储方式
		$drive = Config::get('LOG_DRIVE');
		$drive = '\\FF\\Core\\Log\\' . ucfirst($drive) . 'Log';
		self::$drive = new $drive();
	}

	public static function log($message, $options = array()) {
		self::$drive->log($message);
	}

}
