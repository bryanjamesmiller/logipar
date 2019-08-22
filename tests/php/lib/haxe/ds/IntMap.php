<?php
/**
 * Generated by Haxe 4.0.0-rc.2+77068e10c
 */

namespace haxe\ds;

use \php\Boot;
use \haxe\IMap;

/**
 * IntMap allows mapping of Int keys to arbitrary values.
 * See `Map` for documentation details.
 * @see https://haxe.org/manual/std-Map.html
 */
class IntMap implements IMap {
	/**
	 * @var mixed
	 */
	public $data;

	/**
	 * Creates a new IntMap.
	 * 
	 * @return void
	 */
	public function __construct () {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:37: characters 10-34
		$this1 = [];
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:37: characters 3-34
		$this->data = $this1;
	}

	/**
	 * See `Map.toString`
	 * 
	 * @return string
	 */
	public function toString () {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:102: characters 15-32
		$this1 = [];
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:102: characters 3-33
		$parts = $this1;
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:103: lines 103-105
		$collection = $this->data;
		foreach ($collection as $key => $value) {
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:104: characters 29-59
			$tmp = "" . ($key??'null') . " => " . (\Std::string($value)??'null');
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:104: characters 4-60
			array_push($parts, $tmp);
		}

		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/IntMap.hx:107: characters 3-49
		return "{" . (implode(", ", $parts)??'null') . "}";
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(IntMap::class, 'haxe.ds.IntMap');