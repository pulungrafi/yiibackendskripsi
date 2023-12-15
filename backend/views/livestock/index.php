<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LivestockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Livestocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="livestock-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Livestock', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
