<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SeriesEpisodeRel */

$this->title = 'Update Series Episode Rel: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Series Episode Rels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="series-episode-rel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'series' => $series,
        'episodes' => $episodes
    ]) ?>

</div>
