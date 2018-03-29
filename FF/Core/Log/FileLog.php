<?php
namespace FF\Core\Log;
use FF\Core\Config;

class FileLog{

	private $log;

	public function __construct() {
		$this->log = Config::get('LOG');
		if ( ! is_dir($this->log)) {
			mkdir($this->log, '0777', true);
		}
		$this->log .= date('YmdH', time()) . '.log';
		if ( ! is_file($this->log)) {
			touch($this->log);
		}
	}

	public function log($message, $options = array()) {
		if (is_array($message)) {
			$message = json_encode($message);
		}
		$message = date('H:i:s', time()) . ' | ' . Config::get('CONTROLLER') . ' | ' . Config::get('ACTION') . ' | ' . $message . PHP_EOL;
		$file = ele($options, 'filename', $this->log);
		file_put_contents($file, $message, FILE_APPEND);
	}

}