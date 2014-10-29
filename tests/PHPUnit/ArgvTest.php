<?php

use Chevron\Argv\Argv;

class ArgvTest extends PHPUnit_Framework_TestCase {

	function test_argv(){

		$args = ["path/to/file", "flag", "value", "this-value"];

		$a = new Argv($args);

		$flag  =& $a->flag("flag", "This is a flag.");
		$value =& $a->value("value", "default-value", "This is a value.");

		$nonFlag  =& $a->flag("nonflag", "This is a nonflag.");
		$nonValue =& $a->value("nonvalue", "default-nonvalue", "This is a value.");

		$this->assertEquals($value, "default-value");
		$this->assertFalse($flag);
		$this->assertEquals($nonValue, "default-nonvalue");
		$this->assertFalse($nonFlag);

		$a->parse();

		$this->assertEquals($value, "this-value");
		$this->assertTrue($flag);
		$this->assertEquals($nonValue, "default-nonvalue");
		$this->assertFalse($nonFlag);

	}

}