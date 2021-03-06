<?php

use yii\helpers\Html;
use yii\helpers\Url;
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

    <?php
    if (!empty($gallery)) {
        $imgs = '';
        foreach ($gallery as $img) {
            $imgs .= "<div style='display: inline-block; margin: 0 10px 10px 0'><img src='" . Yii::getAlias('@gallery_thumb_url') . $img . "' style='margin-bottom: 5px;'/><br /><form method='post' action='". Url::toRoute(['view', 'id' => $model->id]) ."' onsubmit=\"return confirm('Do you really want to remove this image from the gallery?');\"><input type='hidden' name='" . Yii::$app->request->csrfParam."' value='" . Yii::$app->request->csrfToken . "'/><input type='hidden' name='img' value='". $img ."'/><button type='submit'>Delete</button></form></div>";
        }
    }
    ?>

    <script>
        function confirmImgDelete(e) {
            var c = confirm('Please confirm your action');
            if(!c){
                e.preventDefault();
            };
        }
    </script>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'title',
            'description:ntext',
            [
                'label' => 'Genres',
                'value' => implode(', ', $genres),
            ],
            [
                'label' => 'Countries',
                'value' => implode(', ', $countries),
            ],
            [
                'label' => 'Small poster',
                'value' => ($model->poster_small) ? Html::img(Yii::getAlias('@poster_small_url') . $model->poster_small, ['class' => 'img-responsive']) : '',
                'format' => 'raw',
            ],
            [
                'label' => 'Big poster',
                'value' => ($model->poster_big) ? Html::img(Yii::getAlias('@poster_big_url') . $model->poster_big, ['class' => 'img-responsive']) : '',
                'format' => 'raw',
            ],
            [
                'label' => 'Gallery',
                'value' => $imgs,
                'format' => 'raw',
            ],
            [
                'label' => 'Duration',
                'value' => ($model->duration) ? $model->duration . ' min' : '',
            ],

            'src',
            [
                'label' => 'Trailer',
                'value' => ($model->trailer) ? Html::a($model->trailer, $model->trailer, ['target' => '_blank']) : '',
                'format' => 'raw',
            ],
            'ted_original',
            [
                'label' => 'Subtitle',
                'value' => Html::a($model->subtitle, Yii::getAlias('@subtitles_url') . $model->subtitle, ['target' => '_blank']),
                'format' => 'raw',
            ],
            [
                'label' => 'Series Episode Shot',
                'value' => ($model->series_episode_shot) ? Html::img(Yii::getAlias('@episodes_url') . $model->series_episode_shot, ['class' => 'img-responsive']) : '',
                'format' => 'raw',
            ],
            [
                'label' => 'Series Poster Left',
                'value' => ($model->series_poster_left) ? Html::img(Yii::getAlias('@poster_small_url') . $model->series_poster_left, ['class' => 'img-responsive']) : '',
                'format' => 'raw',
            ],
            [
                'label' => 'Series Poster Right',
                'value' => ($model->series_poster_right) ? Html::img(Yii::getAlias('@poster_small_url') . $model->series_poster_right, ['class' => 'img-responsive']) : '',
                'format' => 'raw',
            ],
            'series_poster_gradient_start',
            'series_poster_gradient_end',
            [
                'label' => 'Issue Date',
                'value' => date('M Y', strtotime($model->issue_date)),
            ],
            [
                'label' => 'Add Datetime',
                'value' => date('d M Y  H:i', strtotime($model->add_datetime)),
            ],
            'view_amount',
            [
                'label' => 'Is Blocked?',
                'value' => ($model->is_blocked) ? 'Yes' : 'No',
            ],
            [
                'label' => 'Is Deleted?',
                'value' => ($model->is_deleted) ? 'Yes' : 'No',
            ],
        ],
    ]) ?>

</div>
