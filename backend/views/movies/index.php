<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MoviesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Movies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movies-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Movies', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            'poster_small',
            'poster_big',
            // 'episode_shot',
            // 'poster_left',
            // 'poster_middle',
            // 'poster_right',
            // 'gradient_start_color',
            // 'gradient_end_color',
            // 'type',
            // 'level',
            // 'duration',
            // 'issue_date',
            // 'src',
            // 'trailer_src',
            // 'ted_original',
            // 'subtitle',
            // 'add_datetime',
            // 'view_amount',
            // 'is_blocked',
            // 'is_deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
