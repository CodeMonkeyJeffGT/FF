<?php
namespace FF;
use FF\Core\Config;
use FF\Core\Route;
use FF\Core\Log;
use FF\Core\Autoload;

class FF{

	public static function run() {
		//注册自动加载
		spl_autoload_register('\FF\FF::auto_load');

		//引入配置
		Config::init();

		//加载日志类
		Log::init();

		//调试模式
		if (Config::get('DEBUG')) {
			ini_set('display_error', 'On');
		} else {
			ini_set('display_error', 'Off');
		}

		//自动加载
		if (count(Config::get('AUTOLOAD')) > 0) {
			Autoload::init();
		}

		//加载用户函数
		ifile(APP . 'Vendor/functions.php');

		list($controller, $action, $param) = Route::explain();
		Config::set('CONTROLLER', $controller);
		Config::set('ACTION', $action);

		$controller = '\\App\\Controller\\' . $controller . 'Controller';
		$controller = new $controller;
		$param = $controller->init($param);
		Log::log('--START-- | url_param:' . json_encode($param) . ' | cookie:' . json_encode(cookie('.')) . ' | session:' . json_encode(session('.')) . ' | param:' . json_encode(input('.')));
		$controller->$action($param);
	}

	public static function auto_load($className) {
		ifile(ROOT . str_replace('\\', '/', $className) . '.php', true);
	}

}
