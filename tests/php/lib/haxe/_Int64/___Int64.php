<?php
/**
 * Generated by Haxe 4.0.0-rc.2+77068e10c
 */

namespace haxe\_Int64;

use \php\Boot;

class ___Int64 {
	/**
	 * @var int
	 */
	public $high;
	/**
	 * @var int
	 */
	public $low;

	/**
	 * @param int $high
	 * @param int $low
	 * 
	 * @return void
	 */
	public function __construct ($high, $low) {
		#C:\HaxeToolkit\haxe\std/haxe/Int64.hx:460: characters 3-19
		$this->high = $high;
		#C:\HaxeToolkit\haxe\std/haxe/Int64.hx:461: characters 3-17
		$this->low = $low;
	}
}

Boot::registerClass(___Int64::class, 'haxe._Int64.___Int64');