<?php

namespace Chevron\Argv;
/*
 * Someday, I might add strong typing or variations on arg parsing. For now Argv
 * is pretty straightforward.
 */
class Argv implements \Countable {

	/**
	 * the given argv
	 */
	protected $argv   = [];

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
		$this->argv = $array;
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
	 * get the original argv
	 */
	function getArgv(){
		return $this->argv;
	}

	/**
	 * get the argc
	 */
	function count(){
		return count($this->argv);
	}

	/**
	 * parse values from the given argv string
	 * @param array $values The keys that SHOULD have a value
	 */
	protected function parseValues(){
		$args = $this->argv;
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
		$args = $this->argv;
		while( $arg = array_shift($args) ){
			$arg = trim($arg, " -");

			if( array_key_exists($arg, $this->flags) ){
				$this->flags[$arg] = true;
				continue;
			}
		}
	}

	static public function simple_scan_args(array $args, array $values, array $flags = array()){

		// $values = array_fill_keys($values, false);
		$final = array_fill_keys($flags, false);
		$_argv = array_reverse($args);

		while( $arg = array_pop($_argv) ){
			$arg = trim($arg, " -");

			if(false !== ($pos = strpos($arg, "="))){
				$_argv[] = substr($arg, ($pos + 1));
				$arg     = substr($arg, 0, $pos);
			}

			switch(true){
				case in_array($arg, $values) :
					$final[$arg] = array_pop($_argv);
				break;
				case in_array($arg, $flags) :
					$final[$arg] = true;
				break;
			}
		}

		return $final;

	}

}

