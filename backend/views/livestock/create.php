<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Livestock */

$this->title = 'Create Livestock';
$this->params['breadcrumbs'][] = ['label' => 'Livestocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="livestock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
