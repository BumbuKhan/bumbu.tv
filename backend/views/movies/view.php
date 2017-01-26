<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Movies */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movies-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'title',
            'description:ntext',
            'poster_small',
            'poster_big',
            'duration',
            'src',
            'trailer',
            'ted_original',
            'subtitle',
            'series_episode_shot',
            'series_poster_left',
            'series_poster_right',
            'series_poster_gradient_start',
            'series_poster_gradient_end',
            'issue_date',
            'add_datetime',
            'view_amount',
            'is_blocked',
            'is_deleted',
        ],
    ]) ?>

</div>
