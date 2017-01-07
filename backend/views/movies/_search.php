<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MoviesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movies-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'poster_small') ?>

    <?= $form->field($model, 'poster_big') ?>

    <?php // echo $form->field($model, 'episode_shot') ?>

    <?php // echo $form->field($model, 'poster_left') ?>

    <?php // echo $form->field($model, 'poster_middle') ?>

    <?php // echo $form->field($model, 'poster_right') ?>

    <?php // echo $form->field($model, 'gradient_start_color') ?>

    <?php // echo $form->field($model, 'gradient_end_color') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'issue_date') ?>

    <?php // echo $form->field($model, 'src') ?>

    <?php // echo $form->field($model, 'trailer_src') ?>

    <?php // echo $form->field($model, 'ted_original') ?>

    <?php // echo $form->field($model, 'subtitle') ?>

    <?php // echo $form->field($model, 'add_datetime') ?>

    <?php // echo $form->field($model, 'view_amount') ?>

    <?php // echo $form->field($model, 'is_blocked') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
