<?php
/**
 * Generated by Haxe 4.0.0-rc.2+77068e10c
 */

namespace php\_Boot;

use \php\Boot;

/**
 * For Dynamic access which looks like String.
 * Instances of this class should not be saved anywhere.
 * Instead it should be used to immediately invoke a String field right after instance creation one time only.
 */
class HxDynamicStr extends HxClosure {
	/**
	 * @var string
	 */
	static public $hxString;

	/**
	 * @param string $str
	 * @param string $method
	 * @param mixed $args
	 * 
	 * @return mixed
	 */
	static public function invoke ($str, $method, $args) {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:846: characters 3-34
		array_unshift($args, $str);
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:847: characters 3-69
		return call_user_func_array((HxDynamicStr::$hxString??'null') . "::" . ($method??'null'), $args);
	}

	/**
	 * Returns HxDynamicStr instance if `value` is a string.
	 * Otherwise returns `value` as-is.
	 * 
	 * @param mixed $value
	 * 
	 * @return mixed
	 */
	static public function wrap ($value) {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:838: lines 838-842
		if (is_string($value)) {
			#C:\HaxeToolkit\haxe\std/php/Boot.hx:839: characters 4-34
			return new HxDynamicStr($value);
		} else {
			#C:\HaxeToolkit\haxe\std/php/Boot.hx:841: characters 4-16
			return $value;
		}
	}

	/**
	 * @param string $str
	 * 
	 * @return void
	 */
	public function __construct ($str) {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:851: characters 3-19
		parent::__construct($str, null);
	}

	/**
	 * @param string $method
	 * @param mixed $args
	 * 
	 * @return mixed
	 */
	public function __call ($method, $args) {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:867: characters 10-38
		array_unshift($args, $this->target);
		return call_user_func_array((HxDynamicStr::$hxString??'null') . "::" . ($method??'null'), $args);
	}

	/**
	 * @param string $field
	 * 
	 * @return mixed
	 */
	public function __get ($field) {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:856: lines 856-862
		if ($field === "length") {
			#C:\HaxeToolkit\haxe\std/php/Boot.hx:858: characters 5-34
			return mb_strlen($this->target);
		} else {
			#C:\HaxeToolkit\haxe\std/php/Boot.hx:860: characters 5-17
			$this->func = $field;
			#C:\HaxeToolkit\haxe\std/php/Boot.hx:861: characters 5-16
			return $this;
		}
	}

	/**
	 * @see http://php.net/manual/en/language.oop5.magic.php#object.invoke
	 * 
	 * @return mixed
	 */
	public function __invoke () {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:875: characters 10-54
		$str = $this->target;
		$method = $this->func;
		$args = func_get_args();
		array_unshift($args, $str);
		return call_user_func_array((HxDynamicStr::$hxString??'null') . "::" . ($method??'null'), $args);
	}

	/**
	 * Invoke this closure with `newThis` instead of `this`
	 * 
	 * @param mixed $newThis
	 * @param mixed $args
	 * 
	 * @return mixed
	 */
	public function callWith ($newThis, $args) {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:892: lines 892-894
		if ($newThis === null) {
			#C:\HaxeToolkit\haxe\std/php/Boot.hx:893: characters 4-20
			$newThis = $this->target;
		}
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:895: characters 10-37
		$method = $this->func;
		array_unshift($args, $newThis);
		return call_user_func_array((HxDynamicStr::$hxString??'null') . "::" . ($method??'null'), $args);
	}

	/**
	 * Generates callable value for PHP
	 * 
	 * @param mixed $eThis
	 * 
	 * @return mixed
	 */
	public function getCallback ($eThis = null) {
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:882: lines 882-884
		if ($eThis === null) {
			#C:\HaxeToolkit\haxe\std/php/Boot.hx:883: characters 4-49
			return [$this, $this->func];
		}
		#C:\HaxeToolkit\haxe\std/php/Boot.hx:885: characters 3-67
		return [new HxDynamicStr($eThis), $this->func];
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;


		self::$hxString = Boot::getClass(HxString::class)->phpClassName;
	}
}

Boot::registerClass(HxDynamicStr::class, 'php._Boot.HxDynamicStr');
HxDynamicStr::__hx__init();
