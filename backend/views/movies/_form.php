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
        'enableClientScript' => false
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList(['movie' => 'Movie', 'series' => 'Series', 'series_episode' => 'Series episode', 'ted' => 'Ted', 'cartoon' => 'Cartoon',], ['prompt' => 'Choose type']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'poster_small')->fileInput() ?>

    <?= $form->field($model, 'poster_big')->fileInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'src')->textInput() ?>

    <?= $form->field($model, 'trailer')->textInput() ?>

    <?= $form->field($model, 'ted_original')->textInput() ?>

    <?= $form->field($model, 'subtitle')->fileInput() ?>

    <?= $form->field($model, 'series_episode_shot')->fileInput() ?>

    <?= $form->field($model, 'series_episode_shot')->fileInput() ?>

    <?= $form->field($model, 'series_poster_left')->fileInput() ?>

    <?= $form->field($model, 'series_poster_right')->fileInput() ?>

    <?= $form->field($model, 'series_poster_gradient_start')->widget(
        ColorInput::classname(), [
        'options' => ['placeholder' => 'Select color ...'],
    ]) ?>

    <?= $form->field($model, 'series_poster_gradient_end')->widget(
        ColorInput::classname(), [
        'options' => ['placeholder' => 'Select color ...'],
    ]) ?>

    <?= $form->field($model, 'issue_date')->widget(
        DatePicker::className(), [
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'is_blocked')->dropDownList([
        '0' => 'No',
        '1' => 'Yes'
    ],
        ['options' =>
            ['1' => ['Selected' => true]]
        ]
    ) ?>

    <?= $form->field($model, 'is_deleted')->dropDownList([
        '0' => 'No',
        '1' => 'Yes'
    ],
        ['options' =>
            ['0' => ['Selected' => true]]
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
