<?php

require_once "vendor/autoload.php";

use Chevron\Argv\Argv;

FUnit::test("Argv::__construct()", function(){

	$input = array(
		"filename.txt",
		"-f1",
		"-flag1",
		"--f2",
		"--flag2",
		"-key1=value",
		"-key2",
		"value2",
		"JUNK-IGNORE-ME",
		"--key3=value",
		"--key4",
		"value4",
	);

	$argv = new Argv($input,
		array("key1", "key2", "key3", "key4", "key5"),
		array("f1", "f2", "f3", "flag1", "flag2", "flag3")
	);

	FUnit::equal("value",  $argv->getValue("key1"), "value");
	FUnit::equal("value2", $argv->getValue("key2"), "value");
	FUnit::equal("value",  $argv->getValue("key3"), "value");
	FUnit::equal("value4", $argv->getValue("key4"), "value");
	FUnit::equal(null,     $argv->getValue("key5"), "null");

	FUnit::equal(true,     $argv->getFlag("f1"), "short flag");
	FUnit::equal(true,     $argv->getFlag("f2"), "short flag");
	FUnit::equal(false,    $argv->getFlag("f3"), "short flag");

	FUnit::equal(true,     $argv->getFlag("flag1"), "long flag");
	FUnit::equal(true,     $argv->getFlag("flag2"), "long flag");
	FUnit::equal(false,    $argv->getFlag("flag3"), "long flag");

	$all = $argv->getAll();

	$expected = [
		"key1"  => "value",
		"key2"  => "value2",
		"key3"  => "value",
		"key4"  => "value4",
		"f1"    => true,
		"f2"    => true,
		"f3"    => false,
		"flag1" => true,
		"flag2" => true,
		"flag3" => false,
	];

	FUnit::equal($expected, $all, "get all");

});