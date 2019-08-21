<?php
/**
 * Generated by Haxe 4.0.0-rc.2+77068e10c
 */

namespace logipar;

use \php\Boot;
use \php\_Boot\HxException;

class Node {
	/**
	 * @var \Closure
	 */
	public $f;
	/**
	 * @var Node
	 */
	public $left;
	/**
	 * @var Node
	 */
	public $right;
	/**
	 * @var Token
	 */
	public $token;

	/**
	 * Construct a new node.  That is all.
	 * 
	 * @param Token $token
	 * 
	 * @return void
	 */
	public function __construct ($token) {
		#src/logipar/Node.hx:18: characters 3-21
		$this->token = $token;
	}

	/**
	 * @param Node $n
	 * @param \Closure $f
	 * 
	 * @return string
	 */
	public function _fancyString ($n, $f = null) {
		#src/logipar/Node.hx:39: characters 3-16
		$s = null;
		#src/logipar/Node.hx:40: lines 40-44
		if ($f !== null) {
			#src/logipar/Node.hx:41: characters 10-27
			$f1 = Boot::getInstanceClosure($this, '_fancyString');
			$f2 = $f;
			#src/logipar/Node.hx:41: characters 4-33
			$n->f = function ($n1)  use (&$f1, &$f2) {
				#src/logipar/Node.hx:41: characters 10-27
				return $f1($n1, $f2);
			};
			#src/logipar/Node.hx:42: characters 4-12
			$s = $f($n);
			#src/logipar/Node.hx:43: characters 4-14
			$n->f = null;
		}
		#src/logipar/Node.hx:45: lines 45-46
		if ($s !== null) {
			#src/logipar/Node.hx:46: characters 4-12
			return $s;
		}
		#src/logipar/Node.hx:47: characters 10-22
		$__hx__switch = ($n->token->type);
		if ($__hx__switch === "LITERAL") {
			#src/logipar/Node.hx:49: characters 5-39
			return "{" . ($n->token->literal??'null') . "}";
		} else if ($__hx__switch === "NOT") {
			#src/logipar/Node.hx:51: characters 5-49
			return "NOT(" . ($n->right->fancyString($f)??'null') . ")";
		} else {
			#src/logipar/Node.hx:53: characters 5-109
			return "(" . ($n->left->fancyString($f)??'null') . " " . (\Std::string($n->token->type)??'null') . " " . ($n->right->fancyString($f)??'null') . ")";
		}
	}

	/**
	 * This function lets us execute the tree.  You know, to actually check against data.
	 * You shouldn't have to call it directly, but if you want to, look at
	 * Logipar.filterFunction() examples in the repo's readme.
	 * 
	 * @param mixed $a
	 * @param \Closure $f
	 * 
	 * @return bool
	 */
	public function check ($a, $f) {
		#src/logipar/Node.hx:64: characters 10-20
		$__hx__switch = ($this->token->type);
		if ($__hx__switch === "AND") {
			#src/logipar/Node.hx:66: characters 12-47
			if ($this->left->check($a, $f)) {
				#src/logipar/Node.hx:66: characters 31-47
				return $this->right->check($a, $f);
			} else {
				#src/logipar/Node.hx:66: characters 12-47
				return false;
			}
		} else if ($__hx__switch === "LITERAL") {
			#src/logipar/Node.hx:76: characters 5-31
			return $f($a, $this->token->literal);
		} else if ($__hx__switch === "NOT") {
			#src/logipar/Node.hx:74: characters 5-29
			return !$this->right->check($a, $f);
		} else if ($__hx__switch === "OR") {
			#src/logipar/Node.hx:68: characters 12-47
			if (!$this->left->check($a, $f)) {
				#src/logipar/Node.hx:68: characters 31-47
				return $this->right->check($a, $f);
			} else {
				#src/logipar/Node.hx:68: characters 12-47
				return true;
			}
		} else if ($__hx__switch === "XOR") {
			#src/logipar/Node.hx:70: characters 5-29
			$l = $this->left->check($a, $f);
			#src/logipar/Node.hx:71: characters 5-30
			$r = $this->right->check($a, $f);
			#src/logipar/Node.hx:72: characters 12-34
			if (!(!$l && $r)) {
				#src/logipar/Node.hx:72: characters 25-34
				if ($l) {
					#src/logipar/Node.hx:72: characters 31-33
					return !$r;
				} else {
					#src/logipar/Node.hx:72: characters 25-34
					return false;
				}
			} else {
				#src/logipar/Node.hx:72: characters 12-34
				return true;
			}
		} else {
			#src/logipar/Node.hx:78: characters 5-10
			throw new HxException("Unexpected token encountered.");
		}
	}

	/**
	 * Maybe you want to display a node in a certain way.  This function allows for that.
	 * You shouldn't have to call it directly, but if you want to, look at
	 * Logipar.stringify() examples in the repo's readme.
	 * 
	 * @param \Closure $f
	 * 
	 * @return string
	 */
	public function fancyString ($f = null) {
		#src/logipar/Node.hx:34: characters 3-31
		return $this->_fancyString($this, $f);
	}

	/**
	 * The toString() function is just an un-fancy version of fancyString().
	 * 
	 * @return string
	 */
	public function toString () {
		#src/logipar/Node.hx:25: characters 38-58
		return $this->fancyString();
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Node::class, 'logipar.Node');
