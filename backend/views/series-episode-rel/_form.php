<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SeriesEpisodeRel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="series-episode-rel-form">

    <?php $form = ActiveForm::begin([
        'enableClientScript' => false
    ]); ?>

    <?= $form->field($model, 'movie_id')->dropDownList(ArrayHelper::map($series, 'id', 'title'), ['prompt' => 'Choose movie']) ?>

    <?= $form->field($model, 'season')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'episode')->textInput() ?>

    <?= $form->field($model, 'episode_id')->dropDownList(ArrayHelper::map($episodes, 'id', 'title'), ['prompt' => 'Choose episode']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
