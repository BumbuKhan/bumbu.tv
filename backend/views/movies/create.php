<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Movies */

$this->title = 'Create Movies';
$this->params['breadcrumbs'][] = ['label' => 'Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'series_model' => $series_model,
        'series' => $series,
        'genres' => $genres,
        'checked_genres' => $checked_genres,
        'genres_field_has_errors' => $genres_field_has_errors,
        'countries' => $countries,
        'checked_countries' => $checked_countries,
        'countries_field_has_errors' => $countries_field_has_errors,
    ]) ?>

</div>
