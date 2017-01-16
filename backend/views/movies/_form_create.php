<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Movies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movies-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList(['movie' => 'Movie', 'series' => 'Series', 'episode' => 'Series episode', 'cartoon' => 'Cartoon', 'ted' => 'Ted'], ['prompt' => '']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'poster_small')->fileInput() ?>

    <?= $form->field($model, 'poster_big')->fileInput() ?>

    <?= $form->field($model, 'episode_shot')->fileInput() ?>

    <?= $form->field($model, 'poster_left')->fileInput() ?>

    <?= $form->field($model, 'poster_middle')->fileInput() ?>

    <?= $form->field($model, 'poster_right')->fileInput() ?>

    <?= $form->field($model, 'gradient_start_color')->widget(
        ColorInput::classname(), [
            'options' => ['placeholder' => 'Select color ...'],
        ]) ?>

    <?/*= $form->field($model, 'gradient_end_color')->textInput(['maxlength' => true]) */?>
    <?= $form->field($model, 'gradient_end_color')->widget(
        ColorInput::classname(), [
            'options' => ['placeholder' => 'Select color ...'],
        ]) ?>

    <?= $form->field($model, 'level')->dropDownList(['beginner' => 'Beginner', 'elementary' => 'Elementary', 'pre-intermediate' => 'Pre-intermediate', 'intermediate' => 'Intermediate', 'upper-intermediate' => 'Upper-intermediate', 'advanced' => 'Advanced', 'proficient' => 'Proficient',], ['prompt' => '']) ?>

    <?= $form->field($model, 'duration', [
        'template' => '{label}<div class="input-group">{input}<span class="input-group-addon">min</span></div>{error}'
    ])->textInput([
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'issue_date')->widget(
        DatePicker::className(), [
            // inline too, not bad
            'inline' => false,
            // modify template for custom rendering
            //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]
    ) ?>

    <?= $form->field($model, 'src')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trailer_src')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ted_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->fileInput() ?>

    <?= $form->field($model, 'is_blocked')->dropDownList(['0', '1',], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_deleted')->dropDownList(['0', '1',], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
