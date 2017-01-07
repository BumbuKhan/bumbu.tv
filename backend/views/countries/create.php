<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Countries */

$this->title = 'Create Countries';
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $view_file = (Yii::$app->controller->action->id == 'create')? '_form_create': '_form';?>

    <?= $this->render($view_file, [
        'model' => $model,
    ]) ?>

</div>
