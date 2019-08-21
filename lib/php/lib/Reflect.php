<?php
/**
 * Generated by Haxe 4.0.0-rc.2+77068e10c
 */

use \php\Boot;
use \php\_Boot\HxClass;

/**
 * The Reflect API is a way to manipulate values dynamically through an
 * abstract interface in an untyped manner. Use with care.
 * @see https://haxe.org/manual/std-reflection.html
 */
class Reflect {
	/**
	 * Returns the value of the field named `field` on object `o`.
	 * If `o` is not an object or has no field named `field`, the result is
	 * null.
	 * If the field is defined as a property, its accessors are ignored. Refer
	 * to `Reflect.getProperty` for a function supporting property accessors.
	 * If `field` is null, the result is unspecified.
	 * (As3) If used on a property field, the getter will be invoked. It is
	 * not possible to obtain the value directly.
	 * 
	 * @param mixed $o
	 * @param string $field
	 * 
	 * @return mixed
	 */
	static public function field ($o, $field) {
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:45: lines 45-47
		if (is_string($o)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:46: characters 24-45
			$tmp = Boot::dynamicString($o);
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:46: characters 4-53
			return $tmp->{$field};
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:48: characters 3-34
		if (!is_object($o)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:48: characters 23-34
			return null;
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:50: lines 50-52
		if (property_exists($o, $field)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:51: characters 24-25
			$tmp1 = $o;
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:51: characters 4-33
			return $tmp1->{$field};
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:53: lines 53-55
		if (method_exists($o, $field)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:54: characters 4-44
			return Boot::getInstanceClosure($o, $field);
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:57: lines 57-68
		if (($o instanceof HxClass)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:58: characters 4-54
			$phpClassName = $o->phpClassName;
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:59: lines 59-61
			if (defined("" . ($phpClassName??'null') . "::" . ($field??'null'))) {
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:60: characters 5-52
				return constant("" . ($phpClassName??'null') . "::" . ($field??'null'));
			}
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:62: lines 62-64
			if (property_exists($phpClassName, $field)) {
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:63: characters 25-26
				$tmp2 = $o;
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:63: characters 5-34
				return $tmp2->{$field};
			}
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:65: lines 65-67
			if (method_exists($phpClassName, $field)) {
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:66: characters 5-54
				return Boot::getStaticClosure($phpClassName, $field);
			}
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:70: characters 3-14
		return null;
	}

	/**
	 * Returns the value of the field named `field` on object `o`, taking
	 * property getter functions into account.
	 * If the field is not a property, this function behaves like
	 * `Reflect.field`, but might be slower.
	 * If `o` or `field` are null, the result is unspecified.
	 * 
	 * @param mixed $o
	 * @param string $field
	 * 
	 * @return mixed
	 */
	static public function getProperty ($o, $field) {
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:78: lines 78-87
		if (is_object($o)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:79: lines 79-86
			if (($o instanceof HxClass)) {
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:80: characters 5-55
				$phpClassName = $o->phpClassName;
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:81: lines 81-83
				if (Boot::hasGetter($phpClassName, $field)) {
					#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:82: characters 31-43
					$tmp = $phpClassName;
					#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:82: characters 6-58
					return $tmp::{"get_" . ($field??'null')}();
				}
			} else if (Boot::hasGetter(get_class($o), $field)) {
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:85: characters 24-25
				$tmp1 = $o;
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:85: characters 5-40
				return $tmp1->{"get_" . ($field??'null')}();
			}
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:89: characters 3-33
		return Reflect::field($o, $field);
	}

	/**
	 * Tells if structure `o` has a field named `field`.
	 * This is only guaranteed to work for anonymous structures. Refer to
	 * `Type.getInstanceFields` for a function supporting class instances.
	 * If `o` or `field` are null, the result is unspecified.
	 * 
	 * @param mixed $o
	 * @param string $field
	 * 
	 * @return bool
	 */
	static public function hasField ($o, $field) {
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:33: characters 3-35
		if (!is_object($o)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:33: characters 23-35
			return false;
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:34: characters 3-44
		if (property_exists($o, $field)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:34: characters 33-44
			return true;
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:36: lines 36-39
		if (($o instanceof HxClass)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:37: characters 4-54
			$phpClassName = $o->phpClassName;
			#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:38: characters 11-142
			if (!(property_exists($phpClassName, $field) || method_exists($phpClassName, $field))) {
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:38: characters 103-142
				return defined("" . ($phpClassName??'null') . "::" . ($field??'null'));
			} else {
				#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:38: characters 11-142
				return true;
			}
		}
		#C:\HaxeToolkit\haxe\std/php/_std/Reflect.hx:41: characters 3-15
		return false;
	}
}

Boot::registerClass(Reflect::class, 'Reflect');
