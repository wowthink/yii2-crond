<?php

namespace wowthink\crond\commands;

use wowthink\crond\RunCommand;
use yii\console\Controller;
use yii\console\ExitCode;


/**
 * Run controller for the `crond` module
 */
class RunController extends Controller
{
    /**
     * This is Run Crond
     * @return string
     */
    public function actionIndex()
    {
        RunCommand::getInstance($this->module->php_path,$this->module->yii_path)->start();
        return ExitCode::OK;
    }

    /**
     * 测试例子1
     * @return int
     */
    public function actionTest(){
       return ExitCode::OK;
    }

    /**
     * 测试例子2
     * @return int
     */
    public function actionTest2(){

        $i=0;
        while ($i<10){
            echo $i;
            $i++;
            sleep(2);
        }

        return ExitCode::OK;
    }

}
