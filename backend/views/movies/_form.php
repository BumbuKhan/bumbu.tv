<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Movies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'poster_small')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'poster_big')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'episode_shot')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'poster_left')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'poster_middle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'poster_right')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gradient_start_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gradient_end_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'movie' => 'Movie', 'series' => 'Series', 'cartoon' => 'Cartoon', 'ted' => 'Ted', 'episode' => 'Episode', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'level')->dropDownList([ 'beginner' => 'Beginner', 'elementary' => 'Elementary', 'pre-intermediate' => 'Pre-intermediate', 'intermediate' => 'Intermediate', 'upper-intermediate' => 'Upper-intermediate', 'advanced' => 'Advanced', 'proficient' => 'Proficient', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'issue_date')->textInput() ?>

    <?= $form->field($model, 'src')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trailer_src')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ted_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'add_datetime')->textInput() ?>

    <?= $form->field($model, 'view_amount')->textInput() ?>

    <?= $form->field($model, 'is_blocked')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_deleted')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
