<?php

namespace wowthink\crond\models;

/**
 * This is the ActiveQuery class for [[Crontab]].
 *
 * @see Crontab
 */
class CrontabQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Crontab[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Crontab|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * 获取可执行的命令
     * @param $time
     * @return Crontab
     * @internal param null $db
     */
    public function executable($time = null){

        //获取可执行的
        $crontabs = $this->where(['status'=>Crontab::STATUS_STOP,'switch'=>Crontab::SWITCH_ON])->andWhere(['<=','next_time',time()])->all();

//        exit;
        foreach ($crontabs as $crontab){
//
//            if($crontab->next_time <= time()){
                yield $crontab;
//            }
//
        }
    }
}
