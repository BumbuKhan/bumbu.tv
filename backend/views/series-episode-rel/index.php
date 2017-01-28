<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SeriesEpisodeRelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Series Episode Relations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="series-episode-rel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'movie_id',
                    'value' => 'movie.title'
                ],
                'season',
                'episode',
                [
                    'attribute' => 'episode_id',
                    'value' => 'episode0.title'

                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
