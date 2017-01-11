<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?= $form->field($model, 'gradient_start_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gradient_end_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->dropDownList(['beginner' => 'Beginner', 'elementary' => 'Elementary', 'pre-intermediate' => 'Pre-intermediate', 'intermediate' => 'Intermediate', 'upper-intermediate' => 'Upper-intermediate', 'advanced' => 'Advanced', 'proficient' => 'Proficient',], ['prompt' => '']) ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'issue_date')->textInput() ?>

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
