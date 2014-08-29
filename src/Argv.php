<?php

namespace Chevron\Argv;
/**
 * an OOP implimentation of henderjon/simple_scan_args
 *
 * @package Chevron\Argv
 */
class Argv {

	protected $args   = [];

	protected $values = [];

	protected $flags  = [];

	protected $all    = [];

	/**
	 * parse an indexed array of args ($argv) into a set of values and
	 * flags. It takes an array, like a CLI command and parses it into meaningful
	 * key=>value pairs. Args should follow these formats:
	 *  -f
	 *  -flag
	 *  -key=value
	 *  -key value
	 *
	 * @param array $args The array to parse
	 * @param array $values The keys that SHOULD have a value
	 * @param array $flags The keys that should NOT have a value ... booleans
	 * @return array
	 */
	function __construct($args){
		$this->args = $args;
	}

	/**
	 * parse both values and flags from the given argv string
	 * @param array $values The keys that SHOULD have a value
	 * @param array $flags The keys that should NOT have a value ... booleans
	 */
	function parse(array $values, array $flags){

		if($values){ $this->parseValues($values); }

		if($flags){ $this->parseFlags($flags); }

		return $this->all();

	}

	function get($name){
		$all = $this->all();

		if(array_key_exists($name, $all)){
			return $all[$name];
		}
		return null;
	}

	/**
	 * parse values from the given argv string
	 * @param array $values The keys that SHOULD have a value
	 */
	protected function parseValues(array $values){

		$this->values = [];

		$this->values = array_fill_keys($values, null);

		$args = $this->args;
		while( $arg = array_shift($args) ){
			$arg = trim($arg, " -");

			if( false !== ($pos = strpos($arg, "=")) ){
				$key                = substr($arg, 0, $pos);
				$this->values[$key] = substr($arg, ($pos + 1));
				continue;
			}

			if( in_array($arg, $values) ){
				$this->values[$arg] = array_shift($args);
				continue;
			}

		}

	}

	/**
	 * parse flags from the given argv string
	 * @param array $flags The keys that should NOT have a value ... booleans
	 */
	protected function parseFlags(array $flags){

		$this->flags = [];

		$this->flags = array_fill_keys($flags, false);

		$args = $this->args;
		while( $arg = array_shift($args) ){
			$arg = trim($arg, " -");

			if( in_array($arg, $flags) ){
				$this->flags[$arg] = true;
				continue;
			}
		}

	}

	/**
	 * get the entire argv array, having been parsed from the given
	 * array.
	 * @return array
	 */
	function all(){

		if($this->all){ return $this->all; }

		foreach($this->values as $key => $value){
			$this->all[$key] = $value;
		}

		foreach($this->flags as $key => $value){
			$this->all[$key] = $value;
		}

		return $this->all;
	}

}


