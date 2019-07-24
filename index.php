<?php
require 'Shell.php';
require 'Command.php';
Shell::command('pwd');
Shell::command('ll');
$result = Shell::execute(1, 2);
var_dump($result);