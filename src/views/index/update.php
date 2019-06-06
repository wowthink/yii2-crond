<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wowthink\crond\models\Crontab */

$this->title = 'Update Crontab: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '定时任务', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->crontab_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="crontab-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
