<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wowthink\crond\models\CrontabSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crontab-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'crontab_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'route') ?>

    <?= $form->field($model, 'crontab_str') ?>

    <?= $form->field($model, 'switch') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'last_time') ?>

    <?php // echo $form->field($model, 'next_time') ?>

    <?php // echo $form->field($model, 'success_count') ?>

    <?php // echo $form->field($model, 'error_count') ?>

    <?php // echo $form->field($model, 'exec_memory') ?>

    <?php // echo $form->field($model, 'exec_time') ?>

    <?php // echo $form->field($model, 'local') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
