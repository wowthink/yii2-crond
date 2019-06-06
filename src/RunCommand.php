<?php
/**
 * Created by PhpStorm.
 * User: NiceTT
 * Date: 2019/6/5
 * Time: 14:28
 */

namespace wowthink\crond;


use Cron\CronExpression;
use React\ChildProcess\Process;
use React\EventLoop\Factory;
use wowthink\crond\models\Crontab;
use yii\console\ExitCode;

class RunCommand
{

    /**
     * 实例对象私有化
     * @var null
     */
    private static $_instance = null;

    /**
     * php文件绝对路径
     * @var string
     */
    private $php_path;

    /**
     * yii执行文件绝对路径
     * @var string
     */
    private $yii_path;

    /**
     * 私有构造方法
     * RunCommand constructor.
     */
    private function __construct($php_path,$yii_path){
        $this->php_path = $php_path;
        $this->yii_path = $yii_path;
    }

    /**
     * 私有clone方法
     */
    private function __clone(){}

    /**
     * 通过此方法获取该类
     * @return null|RunCommand
     */
    public static function getInstance($php_path,$yii_path){
        if (!(self::$_instance instanceof RunCommand)){
            self::$_instance = new RunCommand($php_path,$yii_path);
        }
        return self::$_instance;
    }

    /**
     *默认开启方法
     */
    public function start()
    {

        $loop = Factory::create();
        //创建Timer定时器 使用RectPHP Loop 事件驱动
        $periodic = $loop->addPeriodicTimer(1, function ($timer) use($loop){

            foreach ($this->getModel() as $datas){

                /**
                 * @var Process $process
                 */
                $process = $datas['process'];

                /**
                 * @var Crontab $crontab
                 */
                $crontab = $datas['crontab'];

                //启动子进程
                $process->start($loop);

                //设置子进程退出回调
                self::setProcessOnExit($process,$crontab);

                //设置子进程输出回调
                self::setProcessOnMsg($process,$crontab);

            }

        });

        //执行事件驱动 异步非阻塞
        $loop->run();
    }


    /**
     * 获取可执行模型
     */
    private function getModel()
    {
        $crontabs = Crontab::find()->executable(time());

        foreach ($crontabs as $crontab){

            //修改执行状态
            $crontab->status=Crontab::STATUS_RUN;
            //上次执行时间
            $crontab->last_time = time();
            //修改成功后在进行创建子进程对象
            if($crontab->update(false)){

                $process = new Process("{$this->php_path} {$this->yii_path} {$crontab->route}");
                yield ['process'=>$process,'crontab'=>$crontab];
            }

        }

    }


    /**
     * 设置子进程退出事件
     * @param Process $process
     * @param Crontab $crontab
     */
    private function setProcessOnExit(Process $process,Crontab $crontab)
    {
        //获取开始时间
        $startTime = $this->getCurrentTime();

        //子进程回调
        $process->on('exit', function ($code) use ($process, $crontab,$startTime) {

            //判断退出状态
            if ($code == ExitCode::OK) {
                $crontab->success_count++;
            } else {
                $crontab->error_count++;
            }

            //使用Cron解析器
            $cron = CronExpression::factory($crontab->crontab_str);
            $crontab->next_time = $cron->getNextRunDate()->getTimestamp(); //下次执行时间
            $crontab->status = Crontab::STATUS_STOP;
            $crontab->exec_time= round($this->getCurrentTime() - $startTime, 2); //计算执行时间
            $crontab->update(false); //修改状态

            echo 'EXIT with code ' . $code . PHP_EOL;
            unset($startTime);
            unset($cron);
            unset($crontab);
            unset($process);
        });
    }

    /**
     * 设置子进程输出事件
     * @param Process $process
     * @param Crontab $crontab
     */
    private function setProcessOnMsg(Process $process,Crontab $crontab)
    {
        $process->stdout->on('data', function ($chunk) {
            echo $chunk;
            unset($chunk);
        });

    }

    /**
     * 获取精度时间
     * @return float
     */
    private function getCurrentTime ()  {
        list ($msec, $sec) = explode(" ", microtime());
        return (float)$msec + (float)$sec;
    }



}