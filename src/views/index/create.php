<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wowthink\crond\models\Crontab */

$this->title = '创建 定时任务';
$this->params['breadcrumbs'][] = ['label' => '定时任务', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crontab-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
