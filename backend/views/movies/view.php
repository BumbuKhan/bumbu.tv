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
            'title',
            'description:ntext',
            'poster_small',
            'poster_big',
            'episode_shot',
            'poster_left',
            'poster_middle',
            'poster_right',
            'gradient_start_color',
            'gradient_end_color',
            'type',
            'level',
            'duration',
            'issue_date',
            'src',
            'trailer_src',
            'ted_original',
            'subtitle',
            'add_datetime',
            'view_amount',
            'is_blocked',
            'is_deleted',
        ],
    ]) ?>

</div>
