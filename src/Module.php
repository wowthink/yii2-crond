<?php

namespace wowthink\crond;

use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;


/**
 * crond module definition class
 */
class Module extends BaseModule implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'wowthink\crond\controllers';

    public $defaultRoute = 'index';

    /**
     * php文件绝对路径
     * @var string
     */
    public  $php_path = 'php';

    /**
     * yii执行文件绝对路径
     * @var string
     */
    public  $yii_path = 'yii';


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application){
            $this->controllerNamespace = 'wowthink\crond\controllers';
        }elseif ($app instanceof \yii\console\Application){
            $this->controllerNamespace = 'wowthink\crond\commands';
        }
    }
}
