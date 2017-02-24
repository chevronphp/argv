<?php

use Chevron\Argv\Argv;

class ArgvTest extends PHPUnit_Framework_TestCase {

	function test_argv(){

		$args = [
			"path/to/file.php",
			"-flag1",
			"--int-value",
			"1234",
			"-string-value=bbq",
			"--flag2"
		];

		$a = new Argv($args, []);

		$this->assertEquals($a->get("int-value"), 1234);
		$this->assertEquals($a->get("not-a-thing"), null);
		$this->assertEquals($a->requireInt("int-value"), 1234);
		$this->assertEquals($a->requireStr("string-value"), "bbq");
		$this->assertTrue($a->requireBool("flag1"));
		$this->assertTrue($a->requireBool("flag2"));
		$this->assertFalse($a->requireBool("flag8"));

	}

	/**
	 * @expectedException \OutOfBoundsException
	 */
	function test_bad(){

		$args = [
			"path/to/file.php",
			"-flag1",
			"--int-value",
			"1234",
			"-string-value=bbq",
			"--flag2"
		];

		$a = new Argv($args);

		$this->assertEquals($a->requireInt("inter-value"), 1234);

	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	function test_bad2(){

		$args = [
			"path/to/file.php",
			"-flag1",
			"--int-value",
			"1234",
			"-string-value=bbq",
			"--flag2"
		];

		$a = new Argv($args);

		$this->assertEquals($a->requireInt("string-value"), "bbq");

	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	function test_not_bool(){

		$args = [
			"path/to/file.php",
			"-flag1",
			"--int-value",
			"1234",
			"-string-value=bbq",
			"--flag2"
		];

		$a = new Argv($args);

		$this->assertTrue($a->requireBool("string-value"));

	}

	function test_defaults(){

		$args = [
			"path/to/file.php",
			"-flag1",
			"--int-value",
			"1234",
			"-string-value=bbq",
			"--flag2"
		];

		$a = new Argv($args, [
			"int-value"       => 2345,
			"other-int-value" => 9876,
			"flag2"           => false,
			"flag3"           => true,
		]);

		$this->assertEquals($a->requireInt("int-value"), 1234);
		$this->assertEquals($a->requireStr("string-value"), "bbq");
		$this->assertTrue($a->requireBool("flag2"));
		$this->assertTrue($a->requireBool("flag3"));

	}

}
