<?php
/**
 * Generated by Haxe 4.0.0-rc.3+e3df7a448
 */

namespace logipar;

use \php\Boot;
use \haxe\ds\GenericCell;
use \haxe\ds\StringMap;
use \php\_Boot\HxException;
use \php\_NativeIndexedArray\NativeIndexedArrayIterator;
use \haxe\ds\GenericStack;

class Logipar {
	/**
	 * @var bool
	 */
	public $caseSensitive;
	/**
	 * @var bool
	 */
	public $mergeAdjacentLiterals;
	/**
	 * @var \Array_hx
	 */
	public $quotations;
	/**
	 * @var StringMap
	 */
	public $syntax;
	/**
	 * @var Node
	 */
	public $tree;

	/**
	 * Empty constructor.
	 * 
	 * @return void
	 */
	public function __construct () {
		#src/logipar/Logipar.hx:17: lines 17-24
		$_g = new StringMap();
		$_g->data["AND"] = "AND";
		$_g->data["OR"] = "OR";
		$_g->data["XOR"] = "XOR";
		$_g->data["NOT"] = "NOT";
		$_g->data["OPEN"] = "(";
		$_g->data["CLOSE"] = ")";
		$this->syntax = $_g;
		#src/logipar/Logipar.hx:16: characters 42-46
		$this->mergeAdjacentLiterals = true;
		#src/logipar/Logipar.hx:15: characters 34-38
		$this->caseSensitive = true;
		#src/logipar/Logipar.hx:14: characters 26-36
		$this->quotations = \Array_hx::wrap([
			"\"",
			"'",
		]);
	}

	/**
	 * Sometimes you just want to filter a list of rows, right?
	 * This function creates a filter function for you, based on your needs.
	 * It takes a function as its param, which in turn takes a row (an object of your data), and a value.
	 * The value is a particular literal on the tree - so you can deal with them however you want.
	 * I dunno, it's kind of hard to explain.. Check out the repo's readme for an example, hopefully that will help!
	 * 
	 * @param \Closure $f
	 * 
	 * @return \Closure
	 */
	public function filterFunction ($f) {
		#src/logipar/Logipar.hx:81: characters 3-23
		$enclosed = $this->tree;
		#src/logipar/Logipar.hx:82: lines 82-86
		return function ($a)  use (&$f, &$enclosed) {
			#src/logipar/Logipar.hx:83: lines 83-84
			if ($enclosed === null) {
				#src/logipar/Logipar.hx:84: characters 5-16
				return true;
			}
			#src/logipar/Logipar.hx:85: characters 4-31
			return $enclosed->check($a, $f);
		};
	}

	/**
	 * @param \Array_hx $tokens
	 * 
	 * @return \Array_hx
	 */
	public function mergeLiterals ($tokens) {
		#src/logipar/Logipar.hx:97: characters 3-32
		$merged = new \Array_hx();
		#src/logipar/Logipar.hx:98: lines 98-106
		$_g = 0;
		$_g1 = $tokens->length;
		while ($_g < $_g1) {
			$i = $_g++;
			#src/logipar/Logipar.hx:99: lines 99-104
			if (($tokens->arr[$i] ?? null)->type === "LITERAL") {
				#src/logipar/Logipar.hx:100: lines 100-103
				if (($i > 0) && (($merged->arr[$merged->length - 1] ?? null)->type === "LITERAL")) {
					#src/logipar/Logipar.hx:101: characters 6-64
					$merged[$merged->length - 1]->literal = ($merged[$merged->length - 1]->literal??'null') . " " . (($tokens->arr[$i] ?? null)->literal??'null');
					#src/logipar/Logipar.hx:102: characters 6-14
					continue;
				}
			}
			#src/logipar/Logipar.hx:105: characters 4-26
			$merged->arr[$merged->length] = ($tokens->arr[$i] ?? null);
			++$merged->length;

		}

		#src/logipar/Logipar.hx:107: characters 3-16
		return $merged;
	}

	/**
	 * Overwrite a particular operator with your own.
	 * 
	 * @param string $op
	 * @param string $value
	 * 
	 * @return void
	 */
	public function overwrite ($op, $value) {
		#src/logipar/Logipar.hx:39: lines 39-40
		if (array_key_exists($op, $this->syntax->data)) {
			#src/logipar/Logipar.hx:40: characters 4-25
			$this->syntax->data[$op] = $value;
		}
	}

	/**
	 * Parse the logic string!  It returns a logipar.Node (the root of the tree), but you can pretty much ignore this.
	 * The tree is stored in the instance anyway.
	 * 
	 * @param string $logic_string
	 * 
	 * @return Node
	 */
	public function parse ($logic_string) {
		#src/logipar/Logipar.hx:49: characters 3-39
		$tokens = $this->tokenize($logic_string);
		#src/logipar/Logipar.hx:50: characters 3-31
		$types = $this->typeize($tokens);
		#src/logipar/Logipar.hx:51: lines 51-52
		if ($this->mergeAdjacentLiterals) {
			#src/logipar/Logipar.hx:52: characters 4-32
			$types = $this->mergeLiterals($types);
		}
		#src/logipar/Logipar.hx:53: characters 3-36
		$reversepolish = $this->shunt($types);
		#src/logipar/Logipar.hx:54: characters 3-32
		$this->tree = $this->treeify($reversepolish);
		#src/logipar/Logipar.hx:55: characters 3-14
		return $this->tree;
	}

	/**
	 * @param \Array_hx $tokens
	 * 
	 * @return \Array_hx
	 */
	public function shunt ($tokens) {
		#src/logipar/Logipar.hx:146: characters 3-48
		$output = new \Array_hx();
		#src/logipar/Logipar.hx:147: characters 3-65
		$operators = new GenericStack();
		#src/logipar/Logipar.hx:148: lines 148-182
		$_g = 0;
		$_g1 = $tokens->length;
		while ($_g < $_g1) {
			$i = $_g++;
			#src/logipar/Logipar.hx:149: characters 4-26
			$token = ($tokens->arr[$i] ?? null);
			#src/logipar/Logipar.hx:150: characters 11-21
			$__hx__switch = ($token->type);
			if ($__hx__switch === "CLOSE") {
				#src/logipar/Logipar.hx:156: lines 156-163
				while (true) {
					#src/logipar/Logipar.hx:157: characters 16-31
					$k = $operators->head;
					$op = null;
					if ($k === null) {
						$op = null;
					} else {
						$operators->head = $k->next;
						$op = $k->elt;
					}
					#src/logipar/Logipar.hx:157: characters 7-32
					$op1 = $op;
					#src/logipar/Logipar.hx:158: lines 158-159
					if ($op1->type === "OPEN") {
						#src/logipar/Logipar.hx:159: characters 8-13
						break;
					}
					#src/logipar/Logipar.hx:160: lines 160-161
					if ($operators->head === null) {
						#src/logipar/Logipar.hx:161: characters 8-13
						throw new HxException("Mismatched parentheses.");
					}
					#src/logipar/Logipar.hx:162: characters 7-22
					$output->arr[$output->length] = $op1;
					++$output->length;

				}
			} else if ($__hx__switch === "LITERAL") {
				#src/logipar/Logipar.hx:152: characters 6-24
				$output->arr[$output->length] = $token;
				++$output->length;
			} else if ($__hx__switch === "OPEN") {
				#src/logipar/Logipar.hx:154: characters 6-26
				$operators->head = new GenericCell($token, $operators->head);
			} else {
				#src/logipar/Logipar.hx:165: lines 165-178
				while ($operators->head !== null) {
					#src/logipar/Logipar.hx:169: characters 7-36
					$prev = ($operators->head === null ? null : $operators->head->elt);
					#src/logipar/Logipar.hx:171: lines 171-172
					if ($prev->type === "OPEN") {
						#src/logipar/Logipar.hx:172: characters 8-13
						break;
					}
					#src/logipar/Logipar.hx:174: lines 174-175
					if ($prev->precedence() <= $token->precedence()) {
						#src/logipar/Logipar.hx:175: characters 8-13
						break;
					}
					#src/logipar/Logipar.hx:177: characters 19-34
					$k1 = $operators->head;
					$x = null;
					if ($k1 === null) {
						$x = null;
					} else {
						$operators->head = $k1->next;
						$x = $k1->elt;
					}
					#src/logipar/Logipar.hx:177: characters 7-35
					$output->arr[$output->length] = $x;
					++$output->length;

				}
				#src/logipar/Logipar.hx:179: characters 6-26
				$operators->head = new GenericCell($token, $operators->head);
			}
		}

		#src/logipar/Logipar.hx:185: lines 185-190
		while ($operators->head !== null) {
			#src/logipar/Logipar.hx:186: characters 12-27
			$k2 = $operators->head;
			$o = null;
			if ($k2 === null) {
				$o = null;
			} else {
				$operators->head = $k2->next;
				$o = $k2->elt;
			}
			#src/logipar/Logipar.hx:186: characters 4-28
			$o1 = $o;
			#src/logipar/Logipar.hx:187: lines 187-188
			if ($o1->type === "OPEN") {
				#src/logipar/Logipar.hx:188: characters 5-10
				throw new HxException("Mismatched parentheses.");
			}
			#src/logipar/Logipar.hx:189: characters 4-18
			$output->arr[$output->length] = $o1;
			++$output->length;

		}
		#src/logipar/Logipar.hx:191: characters 3-16
		return $output;
	}

	/**
	 * Sometimes you want your logic tree represented as a string.  Either for display,
	 * or maybe to use with SQL.  Hey, I'm not judging - this function should provide for
	 * all your stringifying needs.
	 * It takes a function as its param, which in turn takes a Node and provides a String.
	 * In this way you can have it display in pretty much any way you want.
	 * Anything you don't account for will use the default toString() function.
	 * Confused?  Don't worry, there should be an example on the repo's readme.
	 * 
	 * @param \Closure $f
	 * 
	 * @return string
	 */
	public function stringify ($f = null) {
		#src/logipar/Logipar.hx:69: characters 10-51
		if ($this->tree === null) {
			#src/logipar/Logipar.hx:69: characters 25-29
			return null;
		} else {
			#src/logipar/Logipar.hx:69: characters 32-51
			return $this->tree->fancyString($f);
		}
	}

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public function tentativelyLower ($s) {
		#src/logipar/Logipar.hx:197: characters 10-57
		if ($this->caseSensitive) {
			#src/logipar/Logipar.hx:197: characters 26-27
			return $s;
		} else {
			#src/logipar/Logipar.hx:197: characters 30-57
			return mb_strtolower(\Std::string($s));
		}
	}

	/**
	 * @return string
	 */
	public function toString () {
		#src/logipar/Logipar.hx:91: characters 3-21
		return $this->stringify();
	}

	/**
	 * @param string $token
	 * 
	 * @return Token
	 */
	public function tokenType ($token) {
		#src/logipar/Logipar.hx:245: characters 14-27
		$key = new NativeIndexedArrayIterator(array_values(array_map("strval", array_keys($this->syntax->data))));
		while ($key->hasNext()) {
			#src/logipar/Logipar.hx:245: lines 245-248
			$key1 = $key->next();
			#src/logipar/Logipar.hx:246: lines 246-247
			if ($this->tentativelyLower($token) === $this->tentativelyLower(($this->syntax->data[$key1] ?? null))) {
				#src/logipar/Logipar.hx:247: characters 5-26
				return new Token($key1);
			}
		}

		#src/logipar/Logipar.hx:250: characters 3-41
		return new Token("LITERAL", $token);
	}

	/**
	 * @param string $str
	 * 
	 * @return \Array_hx
	 */
	public function tokenize ($str) {
		#src/logipar/Logipar.hx:205: characters 3-33
		$tokens = new \Array_hx();
		#src/logipar/Logipar.hx:206: characters 28-66
		$_g = new \Array_hx();
		#src/logipar/Logipar.hx:206: characters 38-44
		$x = new NativeIndexedArrayIterator(array_values($this->syntax->data));
		while ($x->hasNext()) {
			#src/logipar/Logipar.hx:206: characters 29-65
			$x1 = $x->next();
			#src/logipar/Logipar.hx:206: characters 46-65
			$x2 = $this->tentativelyLower($x1);
			$_g->arr[$_g->length] = $x2;
			++$_g->length;
		}

		#src/logipar/Logipar.hx:206: characters 3-67
		$keys = $_g;
		#src/logipar/Logipar.hx:207: characters 3-31
		$quotation = null;
		#src/logipar/Logipar.hx:209: characters 3-27
		$current = "";
		#src/logipar/Logipar.hx:210: lines 210-236
		$_g1 = 0;
		$_g2 = mb_strlen($str);
		while ($_g1 < $_g2) {
			$i = $_g1++;
			#src/logipar/Logipar.hx:211: characters 4-26
			$c = ($i < 0 ? "" : mb_substr($str, $i, 1));
			#src/logipar/Logipar.hx:214: lines 214-220
			if ($this->quotations->indexOf($c) !== -1) {
				#src/logipar/Logipar.hx:215: lines 215-219
				if ($quotation === null) {
					#src/logipar/Logipar.hx:216: characters 6-19
					$quotation = $c;
				} else if ($quotation === $c) {
					#src/logipar/Logipar.hx:218: characters 6-22
					$quotation = null;
				}
			}
			#src/logipar/Logipar.hx:222: lines 222-235
			if (($quotation !== null) || ($keys->indexOf($this->tentativelyLower($c)) === -1)) {
				#src/logipar/Logipar.hx:223: lines 223-228
				if (\StringTools::isSpace($c, 0) && ($quotation === null)) {
					#src/logipar/Logipar.hx:224: lines 224-225
					if (mb_strlen($current) > 0) {
						#src/logipar/Logipar.hx:225: characters 7-27
						$tokens->arr[$tokens->length] = $current;
						++$tokens->length;
					}
					#src/logipar/Logipar.hx:226: characters 6-18
					$current = "";
				} else {
					#src/logipar/Logipar.hx:228: characters 6-18
					$current = ($current??'null') . ($c??'null');
				}
			} else {
				#src/logipar/Logipar.hx:230: lines 230-232
				if (mb_strlen($current) > 0) {
					#src/logipar/Logipar.hx:231: characters 6-26
					$tokens->arr[$tokens->length] = $current;
					++$tokens->length;
				}
				#src/logipar/Logipar.hx:233: characters 5-17
				$current = "";
				#src/logipar/Logipar.hx:234: characters 5-19
				$tokens->arr[$tokens->length] = $c;
				++$tokens->length;

			}
		}

		#src/logipar/Logipar.hx:237: lines 237-238
		if (mb_strlen(trim($current)) > 0) {
			#src/logipar/Logipar.hx:238: characters 4-31
			$x3 = trim($current);
			$tokens->arr[$tokens->length] = $x3;
			++$tokens->length;
		}
		#src/logipar/Logipar.hx:239: characters 3-16
		return $tokens;
	}

	/**
	 * @param \Array_hx $tokens
	 * 
	 * @return Node
	 */
	public function treeify ($tokens) {
		#src/logipar/Logipar.hx:112: characters 3-59
		$stack = new GenericStack();
		#src/logipar/Logipar.hx:113: lines 113-134
		$_g = 0;
		$_g1 = $tokens->length;
		while ($_g < $_g1) {
			$i = $_g++;
			#src/logipar/Logipar.hx:114: characters 4-26
			$token = ($tokens->arr[$i] ?? null);
			#src/logipar/Logipar.hx:115: characters 4-28
			$n = new Node($token);
			#src/logipar/Logipar.hx:120: lines 120-132
			if ($token->type !== "LITERAL") {
				#src/logipar/Logipar.hx:122: lines 122-123
				if ($stack->head === null) {
					#src/logipar/Logipar.hx:123: characters 6-11
					throw new HxException("An '" . (($this->syntax->data[$token->type] ?? null)??'null') . "' is missing a value to operate on (on its right).");
				}
				#src/logipar/Logipar.hx:124: characters 15-26
				$k = $stack->head;
				$tmp = null;
				if ($k === null) {
					$tmp = null;
				} else {
					$stack->head = $k->next;
					$tmp = $k->elt;
				}
				#src/logipar/Logipar.hx:124: characters 5-26
				$n->right = $tmp;
				#src/logipar/Logipar.hx:127: lines 127-131
				if ($token->type !== "NOT") {
					#src/logipar/Logipar.hx:128: lines 128-129
					if ($stack->head === null) {
						#src/logipar/Logipar.hx:129: characters 7-12
						throw new HxException("An '" . (($this->syntax->data[$token->type] ?? null)??'null') . "' is missing a value to operate on (on its left).");
					}
					#src/logipar/Logipar.hx:130: characters 15-26
					$k1 = $stack->head;
					$tmp1 = null;
					if ($k1 === null) {
						$tmp1 = null;
					} else {
						$stack->head = $k1->next;
						$tmp1 = $k1->elt;
					}
					#src/logipar/Logipar.hx:130: characters 6-26
					$n->left = $tmp1;
				}
			}
			#src/logipar/Logipar.hx:133: characters 4-16
			$stack->head = new GenericCell($n, $stack->head);
		}

		#src/logipar/Logipar.hx:135: characters 19-30
		$k2 = $stack->head;
		$parsetree = null;
		if ($k2 === null) {
			$parsetree = null;
		} else {
			$stack->head = $k2->next;
			$parsetree = $k2->elt;
		}
		#src/logipar/Logipar.hx:135: characters 3-31
		$parsetree1 = $parsetree;
		#src/logipar/Logipar.hx:136: lines 136-137
		if ($stack->head !== null) {
			#src/logipar/Logipar.hx:137: characters 4-9
			throw new HxException("Uhoh, the stack isn't empty.  Do you have neighbouring literals?");
		}
		#src/logipar/Logipar.hx:139: characters 3-19
		return $parsetree1;
	}

	/**
	 * @param \Array_hx $tokens
	 * 
	 * @return \Array_hx
	 */
	public function typeize ($tokens) {
		#src/logipar/Logipar.hx:256: characters 10-65
		$_g = new \Array_hx();
		#src/logipar/Logipar.hx:256: characters 11-64
		$_g1 = 0;
		$_g2 = $tokens->length;
		while ($_g1 < $_g2) {
			$i = $_g1++;
			#src/logipar/Logipar.hx:256: characters 39-64
			$x = $this->tokenType(($tokens->arr[$i] ?? null));
			$_g->arr[$_g->length] = $x;
			++$_g->length;

		}

		#src/logipar/Logipar.hx:256: characters 10-65
		return $_g;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Logipar::class, 'logipar.Logipar');
