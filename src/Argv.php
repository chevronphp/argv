<?php

namespace Chevron\Argv;
/**
 * an OOP implimentation of henderjon/simple_scan_args
 *
 * @package Chevron\Argv
 */
class Argv {

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
	function __construct($args, $values, $flags){
		// $values = array_fill_keys($values, false);
		$this->flags = array_fill_keys($flags, false);

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
	function getValue($key){
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
	function getFlag($key){
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
	function getAll(){
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
