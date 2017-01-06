<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Genres */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genres-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'add_datetime',
            'is_blocked',
            'is_deleted',
        ],
    ]) ?>

</div>
