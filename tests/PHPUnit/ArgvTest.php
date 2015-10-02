<?php

use Chevron\Argv\Argv;

class ArgvTest extends PHPUnit_Framework_TestCase {

	function test_argv(){

		$args = ["path/to/file", "-flag", "--value", "this-value", "-other-value=other-value"];

		$a = new Argv($args);

		$flag       =& $a->flag("flag", "This is a flag.");
		$value      =& $a->value("value", "default-value", "This is a value.");
		$otherValue =& $a->value("other-value", "default-value", "This is a value.");

		$nonFlag  =& $a->flag("nonflag", "This is a nonflag.");
		$nonValue =& $a->value("nonvalue", "default-nonvalue", "This is a value.");

		$this->assertEquals($value, "default-value");
		$this->assertEquals($otherValue, "default-value");
		$this->assertFalse($flag);
		$this->assertEquals($nonValue, "default-nonvalue");
		$this->assertFalse($nonFlag);

		$a->parse();

		$this->assertEquals($value, "this-value");
		$this->assertEquals($otherValue, "other-value");
		$this->assertTrue($flag);
		$this->assertEquals($nonValue, "default-nonvalue");
		$this->assertFalse($nonFlag);

	}

	function test_args(){

		$args = ["path/to/file", "-flag", "--value", "this-value", "-other-value=other-value"];

		$a = new Argv($args);

		$flag       =& $a->flag("flag", "This is a flag.");
		$value      =& $a->value("value", "default-value", "This is a value.");
		$otherValue =& $a->value("other-value", "default-value", "This is a value.");

		$nonFlag  =& $a->flag("nonflag", "This is a nonflag.");
		$nonValue =& $a->value("nonvalue", "default-nonvalue", "This is a value.");

		$this->assertEquals($value, "default-value");
		$this->assertEquals($otherValue, "default-value");
		$this->assertFalse($flag);
		$this->assertEquals($nonValue, "default-nonvalue");
		$this->assertFalse($nonFlag);

		$a->parse();

		$result = $a->getArgv();

		$this->assertEquals($args, $result);
		$this->assertEquals(count($a), 5);

	}

	function test_simple_scan(){

		$args = ["path/to/file", "-flag", "--value", "this-value", "-other-value=other-value"];

		$args = Argv::simple_scan_args($args, ["value"], ["flag"]);

		$this->assertEquals($args, [
			"flag" => true,
			"value" => "this-value",
		]);

	}

}
