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

    protected $arguments = array();

    public static function getInstance(){
        if(is_null(self::$shell)){
            self::$shell = new static();
        }
        return self::$shell;
    }

    public static function command(){
        call_user_func([self::getInstance(), 'push'], func_get_args());
    }

    public function push($arguments){
        $count = array_push($this->command, array_shift($arguments));
        if(!empty($arguments)){
            $this->arguments[$count - 1] = $arguments;
        }
    }

    protected function execute(){
        $step_id = isset($_GET['step_id']) ? $_GET['step_id'] : 0;
        if(!is_numeric($step_id)){
            return json_encode(['code' => 0, 'message' => '非法step_id', 'data' => []]);
        }elseif(!isset($this->command[$step_id])){
            return json_encode(['code' => 0, 'message' => '无效step_id', 'data' => []]);
        }
//        return Command::execute($this->command[$step_id], $this->arguments[$step_id]);
        $result = array();
        foreach($this->command as $step_id => $command){
            $result[] = Command::execute($this->command[$step_id], $this->arguments[$step_id]);
        }
        return $result;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::getInstance(), $name], $arguments);
    }
}