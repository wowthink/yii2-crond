<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use wowthink\crond\models\Crontab;

/* @var $this yii\web\View */
/* @var $searchModel wowthink\crond\models\CrontabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '定时任务';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crontab-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建 定时任务', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'route',
            [
               'attribute'=>'crontab_str',
                'filter'=> false,
            ],
            [
                'attribute'=>'switch',
                'filter' => Crontab::SWITCH_TEXT_MAP,
                'value' => function($model){
                    return Crontab::SWITCH_TEXT_MAP[$model->switch];
                }
            ],
            [
                'attribute'=>'status',
                'filter' => Crontab::STATUS_TEXT_MAP,
                'value' => function($model){
                    return Crontab::STATUS_TEXT_MAP[$model->status];
                }
            ],
            [
                'attribute' => 'last_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'next_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            'success_count',
            'error_count',
            'exec_memory',
            'exec_time',
            //'local',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
