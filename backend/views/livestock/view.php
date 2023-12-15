<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Livestock */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Livestocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="livestock-view">

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
            'eid',
            'vid',
            'name',
            'birthdate',
            'type_of_livestock_id',
            'breed_of_livestock_id',
            'maintenance_id',
            'source_id',
            'ownership_status_id',
            'reproduction_id',
            'gender',
            'age',
            'chest_size',
            'body_weight',
            'health',
            'bcs',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
