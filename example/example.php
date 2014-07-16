<?php

$argv = new Argv($GLOBALS["argv"], ["value-one", "value-two"], ["flag-one"]);

if($argv->getValue("value-one") == "this-value"){
	// noop
}

if(!$argv->getFlag("flag-one")){
	// noop
}

$all = $argv->getAll();

if( $all["value-one"] == "this-value" ){
	// noop
}

if( !$all["flag-one"] ){
	// noop
}


$argv = new Argv(["value-one", "value-two"], ["flag-one"]);
$argv = $argv->parse($GLOBALS["argv"]);