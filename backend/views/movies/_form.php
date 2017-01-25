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

    <?= $form->field($model, 'type')->dropDownList([ 'movie' => 'Movie', 'series' => 'Series', 'series_episode' => 'Series episode', 'ted' => 'Ted', 'cartoon' => 'Cartoon', ], ['prompt' => 'Choose type']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'poster_small')->fileInput() ?>

    <?= $form->field($model, 'poster_big')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
