<?php

namespace wowthink\crond\models;

use Cron\CronExpression;
use Yii;

/**
 * This is the model class for table "{{%crontab}}".
 *
 * @property int $crontab_id
 * @property string $name 任务名称
 * @property string $route 任务路由
 * @property string $crontab_str Crontab 格式
 * @property int $switch 开关 0:关闭 1:开启
 * @property int $status 定时任务状态 0:未执行 1:正在执行
 * @property int $last_time 上次执行时间
 * @property int $next_time 下次执行时间
 * @property int $success_count 成功次数
 * @property int $error_count 失败次数
 * @property string $exec_memory 任务执行消耗内存(单位/byte)
 * @property string $exec_time 任务执行消耗时间
 * @property int $local 乐观锁
 */
class Crontab extends \yii\db\ActiveRecord
{

    /**
     * 执行中
     */
    const STATUS_RUN = 1;

    /**
     * 未执行
     */
    const STATUS_STOP = 0;

    /**
     * 关闭
     */
    const SWITCH_OFF = 0;

    /**
     * 开启
     */
    const SWITCH_ON = 1;


    /**
     * STATUS状态命名
     */
    const STATUS_TEXT_MAP = [
        self::STATUS_STOP => '未运行',
        self::STATUS_RUN => '运行中'
    ];

    /**
     * SWITCH状态命名
     */
    const SWITCH_TEXT_MAP = [
        self::SWITCH_OFF => '关闭',
        self::SWITCH_ON => '开启',
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%crontab}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'route', 'crontab_str'], 'required'],
            [['switch', 'status', 'last_time', 'next_time', 'success_count', 'error_count', 'local'], 'integer'],
            [['exec_memory', 'exec_time'], 'number'],
            [['name', 'route', 'crontab_str'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['crontab_str'],'validateExpression'],
        ];
    }

    /**
     * 验证Cron解析式 格式
     * @param $attribute
     */
    public function validateExpression($attribute)
    {
        if(!$this->hasErrors()) {
            if(!CronExpression::isValidExpression($this->crontab_str)){
                $this->addError($attribute,'Cron格式不正确');
            }
        }
    }

    /**
     * 乐观锁
     * @return string
     */
    public function optimisticLock()
    {
        return 'local';
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'crontab_id' => 'Crontab ID',
            'name' => '任务名称',
            'route' => '任务路由',
            'crontab_str' => '格式',
            'switch' => '开关',
            'status' => '任务状态',
            'last_time' => '上次执行时间',
            'next_time' => '下次执行时间',
            'success_count' => '成功',
            'error_count' => '失败',
            'exec_memory' => '内存消耗',
            'exec_time' => '执行时间',
            'local' => '乐观锁',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CrontabQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrontabQuery(get_called_class());
    }

}
