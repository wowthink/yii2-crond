<?php

use yii\db\Migration;

/**
 * Class m190531_060712_add_crontab
 */
class m190531_060712_add_crontab extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="定时任务表"';
        }

        $this->createTable('{{%crontab}}', [
            'crontab_id' => $this->primaryKey(),
            'name' => $this->string(64)->unique()->notNull()->comment('任务名称'),
            'route' => $this->string(64)->notNull()->comment('任务路由'),
            'crontab_str' => $this->string(64)->notNull()->comment('Crontab 格式'),
            'switch' => $this->tinyInteger(1)->defaultValue(0)->comment('开关 0:关闭 1:开启'),
            'status' => $this->tinyInteger(1)->defaultValue(0)->comment('定时任务状态 0:未执行 1:正在执行'),
            'last_time' => $this->integer(11)->defaultValue(0)->comment('上次执行时间'),
            'next_time' => $this->integer(11)->defaultValue(0)->comment('下次执行时间'),
            'success_count' => $this->integer(11)->defaultValue(0)->comment('成功次数'),
            'error_count' => $this->integer(11)->defaultValue(0)->comment('失败次数'),
            'exec_memory' => $this->decimal(13,2)->defaultValue(0.00)->comment('任务执行消耗内存(单位/byte)'),
            'exec_time' => $this->decimal(13,2)->defaultValue(0.00)->comment('任务执行消耗时间'),
            'local' => $this->integer(11)->notNull()->defaultValue(0)->comment('乐观锁'),
        ],$tableOptions);

        $this->insert('{{%crontab}}',['name'=>'测试','route'=>'crond/run/test','crontab_str'=>'*/1 * * * *']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

      return  $this->dropTable('{{%crontab}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190531_060712_add_crontab cannot be reverted.\n";

        return false;
    }
    */
}
