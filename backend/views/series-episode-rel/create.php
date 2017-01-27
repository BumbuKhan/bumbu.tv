<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SeriesEpisodeRel */

$this->title = 'Create Series Episode Rel';
$this->params['breadcrumbs'][] = ['label' => 'Series Episode Rels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="series-episode-rel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'series' => $series,
        'episodes' => $episodes
    ]) ?>

</div>
