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

    <?php $view_file = (Yii::$app->controller->action->id == 'create')? '_form_create': '_form';?>

    <?= $this->render($view_file, [
        'model' => $model,
    ]) ?>

</div>
