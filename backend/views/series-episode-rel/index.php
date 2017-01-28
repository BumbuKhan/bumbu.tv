<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SeriesEpisodeRelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Series Episode Rels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="series-episode-rel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Series Episode Rel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'movie_id',
            'season',
            'episode',
            'episode_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
