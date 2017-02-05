<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\color\ColorInput;
use backend\assets\Select2Asset;

Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\Movies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movies-form" xmlns="http://www.w3.org/1999/html">

    <?php $form = ActiveForm::begin([
        'enableClientScript' => false
    ]); ?>

    <?php
    $type_options = ['prompt' => 'Choose type'];

    if (Yii::$app->controller->action->id == 'update') {
        $type_options['disabled'] = 'disabled';
    }
    ?>

    <?= $form->field($model, 'type')->dropDownList(Yii::$app->params['movie_types'], $type_options) ?>

    <?php if (Yii::$app->controller->action->id == 'create') { ?>
        <div class="panel panel-default">
            <div class="panel-heading">Bind episode to series</div>
            <div class="panel-body">
                <?= $form->field($series_model, 'movie_id')->dropDownList(ArrayHelper::map($series, 'id', 'title'), ['prompt' => 'Choose series']) ?>
                <?= $form->field($series_model, 'season')->textInput() ?>
                <?= $form->field($series_model, 'episode')->textInput() ?>
            </div>
        </div>
    <?php } ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group <?= ($genres_field_has_errors) ? 'has-error' : '' ?>">
        <label for="genres" class="control-label">Genres</label>
        <div>
            <?php if (!empty($genres)) { ?>
                <select name="genres[]" multiple="multiple" id="genres" style="width: 100%">
                    <?php foreach ($genres as $genre) { ?>
                        <option
                            value="<?= $genre['id'] ?>" <?= (in_array($genre['id'], $checked_genres)) ? 'selected="selected"' : '' ?>><?= $genre['title'] ?></option>
                    <? } ?>
                </select>
            <?php } ?>
        </div>
        <?= ($genres_field_has_errors) ? '<div class="help-block">Choose at least one genre</div>' : '' ?>
    </div>

    <div class="form-group <?= ($countries_field_has_errors) ? 'has-error' : '' ?>">
        <label for="countries" class="control-label">Countries</label>
        <div>
            <?php if (!empty($countries)) { ?>
                <select name="countries[]" multiple="multiple" id="countries" style="width: 100%">
                    <?php foreach ($countries as $country) { ?>
                        <option
                            value="<?= $country['id'] ?>" <?= (in_array($country['id'], $checked_countries)) ? 'selected="selected"' : '' ?>><?= $country['title'] ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>
        <?= ($countries_field_has_errors) ? '<div class="help-block">Choose at least one country</div>' : '' ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#countries, #genres").select2();
        })
    </script>

    <?= $form->field($model, 'poster_small')->fileInput() ?>

    <?= $form->field($model, 'poster_big')->fileInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'src')->textInput() ?>

    <?= $form->field($model, 'trailer')->textInput() ?>

    <?= $form->field($model, 'ted_original')->textInput() ?>

    <?= $form->field($model, 'subtitle')->fileInput() ?>

    <?= $form->field($model, 'series_episode_shot')->fileInput() ?>

    <?= $form->field($model, 'series_poster_gradient_start')->widget(
        ColorInput::classname(), [
        'options' => ['placeholder' => 'Select color ...'],
    ]) ?>

    <?= $form->field($model, 'series_poster_gradient_end')->widget(
        ColorInput::classname(), [
        'options' => ['placeholder' => 'Select color ...'],
    ]) ?>

    <?= $form->field($model, 'series_poster_left')->fileInput() ?>

    <?= $form->field($model, 'series_poster_right')->fileInput() ?>

    <?= $form->field($model, 'issue_date')->widget(
        DatePicker::className(), [
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($gallery_model, 'img_src[]')->fileInput(['multiple' => true, 'accept' => '*']) ?>

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
