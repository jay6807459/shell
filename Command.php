<?php

/**
 * Created by PhpStorm.
 * User: lily
 * Date: 2019/7/24
 * Time: 21:28
 */
class Command
{
    protected $command_map = [
        'tar' => 'tar -zxvf',
        'untar' => 'tar -zcvf'
    ];

    protected function execute($command){
        $real_command = $this->getRealCommand($command);
        return shell_exec($real_command);
    }

    public function getRealCommand($command){
        if(array_key_exists($command, $this->command_map)){
            return $this->command_map[$command];
        }else{
            return $command;
        }
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([new static(), $name], $arguments);
    }
}