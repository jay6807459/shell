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
        'cd' => 'cd %s',
        'tar' => 'tar -zxvf %s',
        'untar' => 'tar -zcvf %s'
    ];

    protected function execute($command, $arguments){
        $real_command = $this->getRealCommand($command);
        var_dump(vsprintf($real_command, $arguments));
        return shell_exec(vsprintf($real_command, $arguments));
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