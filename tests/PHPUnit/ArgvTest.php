<?php

use Chevron\Argv\Argv;

class ArgvTest extends PHPUnit_Framework_TestCase {

	function test_Argv(){

		$argv = new Argv([
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
		]);

		$_argv = $argv->parse(
			["key1", "key2", "key3", "key4", "key5"],
			["f1", "f2", "f3", "flag1", "flag2", "flag3"]
		);

		$this->assertEquals("value",  $argv->value("key1"), "value");
		$this->assertEquals("value2", $argv->value("key2"), "value");
		$this->assertEquals("value",  $argv->value("key3"), "value");
		$this->assertEquals("value4", $argv->value("key4"), "value");
		$this->assertEquals(null,     $argv->value("key5"), "null");

		$this->assertSame(true,     $argv->flag("flag1"), "long flag");
		$this->assertSame(true,     $argv->flag("flag2"), "long flag");
		$this->assertSame(false,    $argv->flag("flag3"), "long flag");

		$this->assertSame(true,  $argv->is("f1", true), "short flag");
		$this->assertSame(false, $argv->is("f2", "true", true), "short flag");
		$this->assertSame(true,  $argv->is("f3", false), "short flag");

		$all = $argv->all();

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

		$this->assertEquals($expected, $_argv, "get all");

	}

}