<?php

namespace Chevron\Argv;

class Argv {

	protected $map;

	const TYPE_STR  = 1;
	const TYPE_INT  = 2;
	const TYPE_BOOL = 3;

	public function __construct(array $argv, array $defaults = []){
		$this->map = $this->parse($argv);
		$this->map = array_merge($defaults, $this->map);
	}

	public function get($key){
		try{
			return $this->required($key);
		}catch(\Exception $e){
			return null;
		}
	}

	public function requireInt($key){
		$val = $this->required($key);
		if(!ctype_digit($val)){
			throw new \InvalidArgumentException("non-numeric value: {$val}");
		}
		return intval($val);
	}

	public function requireBool($key){
		$val = $this->get($key);
		if(!is_bool($val) && !is_null($val)){
			throw new \InvalidArgumentException("non-bool value: {$val}");
		}
		return $val === true;
	}

	public function requireStr($key){
		$val = $this->required($key);
		if(!is_string($val) && !is_int($val)){
			throw new \InvalidArgumentException("non-string value: {$val}");
		}
		return (string)$val;
	}

	public function getAll(){
		return $this->map;
	}

	protected function parse(array $map){
		$final = [];

		for($i = 1; $i < count($map); $i += 1){
			$val = $this->softTrim($map[$i]);

			if(strpos($val, "=") !== false){
				$val = $this->hardTrim($val);
				$pos = strpos($val, "=");

				$key         = substr($val, 0, $pos);
				$final[$key] = substr($val, ($pos + 1));
				continue;
			}

			if(strpos($val, "-") === 0){
				$val  = $this->hardTrim($val);
				if(empty($map[$i + 1])){
					$final[$val] = true;
					continue;
				}

				$nVal = $this->softTrim($map[$i + 1]);
				if(strpos($nVal, "-") === 0){
					$final[$val] = true;
					continue;
				}

				$nVal = $this->hardTrim($nVal);
				$final[$val] = $nVal;
				$i += 1;
			}
		}

		return $final;
	}

	protected function softTrim($val){
		return trim($val);
	}

	protected function hardTrim($val){
		return trim($val, " \t\n\r\0\x0B-");
	}

	protected function required($key){
		if(!isset($this->map[$key])){
			throw new \OutOfBoundsException("unknown key: {$key}");
		}
		return $this->map[$key];
	}

}



