<?php
/**
 * Generated by Haxe 4.0.0-rc.2+77068e10c
 */

namespace logipar;

use \php\Boot;
use \php\_Boot\HxException;

class Node {
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
		#src/logipar/Node.hx:15: characters 3-21
		$this->token = $token;
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
		#src/logipar/Node.hx:53: characters 10-20
		$__hx__switch = ($this->token->type->index);
		if ($__hx__switch === 0) {
			#src/logipar/Node.hx:55: characters 12-47
			if ($this->left->check($a, $f)) {
				#src/logipar/Node.hx:55: characters 31-47
				return $this->right->check($a, $f);
			} else {
				#src/logipar/Node.hx:55: characters 12-47
				return false;
			}
		} else if ($__hx__switch === 1) {
			#src/logipar/Node.hx:57: characters 12-47
			if (!$this->left->check($a, $f)) {
				#src/logipar/Node.hx:57: characters 31-47
				return $this->right->check($a, $f);
			} else {
				#src/logipar/Node.hx:57: characters 12-47
				return true;
			}
		} else if ($__hx__switch === 2) {
			#src/logipar/Node.hx:59: characters 5-29
			$l = $this->left->check($a, $f);
			#src/logipar/Node.hx:60: characters 5-30
			$r = $this->right->check($a, $f);
			#src/logipar/Node.hx:61: characters 12-34
			if (!(!$l && $r)) {
				#src/logipar/Node.hx:61: characters 25-34
				if ($l) {
					#src/logipar/Node.hx:61: characters 31-33
					return !$r;
				} else {
					#src/logipar/Node.hx:61: characters 25-34
					return false;
				}
			} else {
				#src/logipar/Node.hx:61: characters 12-34
				return true;
			}
		} else if ($__hx__switch === 3) {
			#src/logipar/Node.hx:63: characters 5-29
			return !$this->right->check($a, $f);
		} else if ($__hx__switch === 6) {
			#src/logipar/Node.hx:65: characters 5-31
			return $f($a, $this->token->literal);
		} else {
			#src/logipar/Node.hx:67: characters 5-10
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
		#src/logipar/Node.hx:31: characters 3-16
		$s = null;
		#src/logipar/Node.hx:32: lines 32-33
		if ($f !== null) {
			#src/logipar/Node.hx:33: characters 4-15
			$s = $f($this);
		}
		#src/logipar/Node.hx:34: lines 34-35
		if ($s !== null) {
			#src/logipar/Node.hx:35: characters 4-12
			return $s;
		}
		#src/logipar/Node.hx:36: characters 10-20
		$__hx__switch = ($this->token->type->index);
		if ($__hx__switch === 3) {
			#src/logipar/Node.hx:40: characters 5-32
			return "NOT(" . (\Std::string($this->right)??'null') . ")";
		} else if ($__hx__switch === 6) {
			#src/logipar/Node.hx:38: characters 5-37
			return "{" . ($this->token->literal??'null') . "}";
		} else {
			#src/logipar/Node.hx:42: characters 5-73
			return "(" . (\Std::string($this->left)??'null') . " " . (\Std::string($this->token->type)??'null') . " " . (\Std::string($this->right)??'null') . ")";
		}
	}

	/**
	 * The toString() function is just an un-fancy version of fancyString().
	 * 
	 * @return string
	 */
	public function toString () {
		#src/logipar/Node.hx:22: characters 38-58
		return $this->fancyString();
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Node::class, 'logipar.Node');
