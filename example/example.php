<?php

$argv = new Argv($GLOBALS["argv"]);
$params = $argv->parse(["value-one", "value-two"], ["flag-one"]);

