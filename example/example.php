<?php

$argv = new Argv($GLOBALS["argv"]);
$params = $argv->parse(["value-one", "value-two"], ["flag-one"]);



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


$argv = new Argv($GLOBALS["argv"]);
$argv = $argv->parse(["value-one", "value-two"], ["flag-one"]);