<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wowthink\crond\models\Crontab */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crontab-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'crontab_id')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crontab_str')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'switch')->dropDownList([0=>'关闭',1=>'开启']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
