<?php
require 'Shell.php';
require 'Command.php';
Shell::command('cd', '/etc/nginx');
Shell::command('pwd');
$result = Shell::execute();
var_dump($result);