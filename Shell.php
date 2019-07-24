<?php

/**
 * Created by PhpStorm.
 * User: lily
 * Date: 2019/7/24
 * Time: 21:27
 */
class Shell
{
    private static $shell = null;

    protected $command = array();

    public static function getInstance(){
        if(is_null(self::$shell)){
            self::$shell = new static();
        }
        return self::$shell;
    }

    public static function command($command){
        call_user_func([self::getInstance(), 'push'], $command);
    }

    public function push($command){
        array_push($this->command, $command);
    }

    protected function execute(){
        $step_id = isset($_GET['step_id']) ? $_GET['step_id'] : 0;
        if(!is_numeric($step_id)){
            return json_encode(['code' => 0, 'message' => '非法step_id', 'data' => []]);
        }elseif(!isset($this->command[$step_id])){
            return json_encode(['code' => 0, 'message' => '无效step_id', 'data' => []]);
        }
        return Command::execute($this->command[$step_id]);
    }

    public static function __callStatic($name, $arguments)
    {
//        var_dump($name, $arguments);die;
        return call_user_func_array([self::getInstance(), $name], $arguments);
    }
}