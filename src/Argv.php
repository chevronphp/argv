<?php

namespace Chevron\Argv;
/*
 * Someday, I might add strong typing or variations on arg parsing. For now Argv
 * is pretty straightforward.
 */
class Argv {

	/**
	 * the given argv
	 */
	protected $args   = [];

	/**
	 * an array of values
	 */
	protected $values = [];

	/**
	 * an array of flags
	 */
	protected $flags  = [];

	/**
	 * create a new instance around a given $argv
	 * @param array $array the argv to parse
	 * @return Chevron\Argv\Argvx
	 */
	function __construct(array $array){
		$this->args = $array;
	}

	/**
	 * set an expected flag value to false and return it via reference for parsing
	 * @param string $name the name of the flag
	 * @param string $message an unused value for missing flags
	 * @return reference
	 */
	function &flag($name, $message){
		$this->flags[$name] = false;
		return $this->flags[$name];
	}

	/**
	 * set an expected value to the default and return it via reference for parsing
	 * @param string $name the name of the flag
	 * @param string $message an unused value for missing flags
	 * @return reference
	 */
	function &value($name, $default, $message){
		$this->values[$name] = $default;
		return $this->values[$name];
	}

	/**
	 * do the parsing
	 * @return void
	 */
	function parse(){
		$this->parseFlags();
		$this->parseValues();
	}

	/**
	 * parse values from the given argv string
	 * @param array $values The keys that SHOULD have a value
	 */
	protected function parseValues(){
		$args = $this->args;
		while( $arg = array_shift($args) ){
			$arg = trim($arg, " -");

			if( false !== ($pos = strpos($arg, "=")) ){
				$key                = substr($arg, 0, $pos);
				$this->values[$key] = substr($arg, ($pos + 1));
				continue;
			}

			if( array_key_exists($arg, $this->values) ){
				$this->values[$arg] = array_shift($args);
				continue;
			}

		}

	}

	/**
	 * parse flags from the given argv string
	 * @param array $flags The keys that should NOT have a value ... booleans
	 */
	protected function parseFlags(){
		$args = $this->args;
		while( $arg = array_shift($args) ){
			$arg = trim($arg, " -");

			if( array_key_exists($arg, $this->flags) ){
				$this->flags[$arg] = true;
				continue;
			}
		}

	}

}

