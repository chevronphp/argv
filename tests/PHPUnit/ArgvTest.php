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

		$argv->parse(
			["key1", "key2", "key3", "key4", "key5"],
			["f1", "f2", "f3", "flag1", "flag2", "flag3"]
		);

		$this->assertEquals("value",  $argv->get("key1"));
		$this->assertEquals("value2", $argv->get("key2"));
		$this->assertEquals("value",  $argv->get("key3"));
		$this->assertEquals("value4", $argv->get("key4"));
		$this->assertEquals(null,     $argv->get("key5"));

		$this->assertSame(true,     $argv->get("flag1"));
		$this->assertSame(true,     $argv->get("flag2"));
		$this->assertSame(false,    $argv->get("flag3"));

		$this->assertSame(true,  $argv->get("f1"));
		$this->assertSame(true,  $argv->get("f2"));
		$this->assertSame(false, $argv->get("f3"));

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
			"key5"  => null,
		];

		$this->assertEquals($expected, $all, "get all");

	}

}