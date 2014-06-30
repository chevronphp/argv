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

	/**
	 * method to parse an indexed array of args ($argv) into a set of values and
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
	function __construct($args, array $values = [], array $flags = []){
		$this->args = $args;
		$this->parse($values, $flags);
	}

	/**
	 * method to parse both values and flags from the given argv string
	 * @param array $values The keys that SHOULD have a value
	 * @param array $flags The keys that should NOT have a value ... booleans
	 */
	function parse(array $values, array $flags){

		if($values)	$this->parseValues($values);

		if($flags) $this->parseFlags($flags);

	}

	/**
	 * method to parse values from the given argv string
	 * @param array $values The keys that SHOULD have a value
	 */
	function parseValues(array $values){

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
	 * method to parse flags from the given argv string
	 * @param array $flags The keys that should NOT have a value ... booleans
	 */
	function parseFlags(array $flags){

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
	 * method to get the value of a provided value arg, having been parse from
	 * the given args
	 * @param string $key The key to get
	 * @return string
	 */
	function value($key){
		if(array_key_exists($key, $this->values)){
			return $this->values[$key];
		}
		return null;
	}

	/**
	 * method to get the value of a provided flag arg, having been parse from
	 * the given args
	 * @param string $key The key to get
	 * @return bool
	 */
	function flag($key){
		if(array_key_exists($key, $this->flags)){
			return $this->flags[$key];
		}
		return null;
	}

	/**
	 * method to get the entire argv array, having been parsed from the given
	 * array.
	 * @return array
	 */
	function all(){
		$all = [];

		foreach($this->values as $key => $value){
			$all[$key] = $value;
		}

		foreach($this->flags as $key => $value){
			$all[$key] = $value;
		}

		return $all;
	}

}
