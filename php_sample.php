<?php

# Haxe requires the mbstring extension for mb_internal_encoding
spl_autoload_register(function ($name) {
	require_once("lib/php/lib/".str_replace('\\', '/', $name).".php");
});


$data = file_get_contents('sample_data.json');
$data = json_decode($data, true);


$lp = new \logipar\Logipar();
$lp->overwrite("AND", "et");
$lp->caseSensitive = False;


print("-- Welcome to the book library --\n");
$s = readline("Please enter an input string: ");
$lp->parse($s);

$flattened = $lp->stringify(function($n) {
	if ($n->token->type == "XOR") {
		$l = call_user_func($n->f, $n->left);
		$r = call_user_func($n->f, $n->right);
		return "((" . $l . " AND NOT " . $r . ") OR (NOT " . $l . " AND " . $r . "))";
	}
	return null;
});

print("\nOkay, it looks like you're looking for: ".$flattened."\n\n");


$fancyFilter = function($row, $value) {
	$value = str_replace('"', '', $value);
	if (strpos($value, ":") === false) {
		foreach($row as $field=>$v)
			if (stripos($row[$field], $value) !== false)
				return true;
	} else {
		# We're specifying a specific field we want to look in
		$chunks = explode(":", $value);
		$field = array_shift($chunks);
		$val = implode(':', $chunks);
		if (array_key_exists($field, $row)) {
			if (stripos($row[$field], $val) !== false)
				return true;
		}
	}
	return false;
};

$f = $lp->filterFunction($fancyFilter);

$data = array_filter($data, $f);
if (count($data) == 0)
	print("No matching entries found.");

foreach($data as $k=>$book)
	print($book['title'] . " by " . $book['authors']."\n");
print("Found ".count($data)." entries.");

?>