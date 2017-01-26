<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?= $form->field($model, 'series_poster_left')->fileInput() ?>

    <?= $form->field($model, 'series_poster_right')->fileInput() ?>

    <?= $form->field($model, 'series_poster_gradient_start')->textInput() ?>

    <?= $form->field($model, 'series_poster_gradient_end')->textInput() ?>

    <?= $form->field($model, 'issue_date')->textInput() ?>

    <?= $form->field($model, 'is_blocked')->dropDownList(['0' => 'No', '1' => 'Yes'], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_deleted')->dropDownList(['0' => 'No', '1' => 'Yes'], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
