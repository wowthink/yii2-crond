<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use wowthink\crond\models\Crontab;

/* @var $this yii\web\View */
/* @var $model wowthink\crond\models\Crontab */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '定时任务', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="crontab-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->crontab_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->crontab_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'crontab_id',
            'name',
            'route',
            'crontab_str',
            [
                'attribute' => 'switch',
                'value' => function($model){
                    return Crontab::SWITCH_TEXT_MAP[$model->switch];
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return Crontab::STATUS_TEXT_MAP[$model->switch];
                }
            ],
            [
                'attribute' => 'last_time',
                'format' => ['date', 'Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'next_time',
                'format' => ['date', 'Y-m-d H:i:s'],
            ],
            'success_count',
            'error_count',
            'exec_memory',
            'exec_time',
            'local',
        ],
    ]) ?>

</div>
