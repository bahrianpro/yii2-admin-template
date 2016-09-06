<?php

use app\widgets\Timeline;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $historyProvider yii\data\ActiveDataProvider */
?>

<?= Timeline::widget([
    'dataProvider' => $historyProvider,
    'dateValue' => function ($model) {
        return Yii::$app->formatter->asDate($model->created_at);
    },
    'timeView' => function ($model) {
        return Yii::$app->formatter->asRelativeTime($model->created_at);
    },
    'itemHeaderView' => function ($model) {
        return Yii::$app->formatter->asUserlink($model->user);
    },
    'itemView' => function ($model) {
        return e($model->summary);
    },
    'itemFooterView' => function ($model) {
        return Html::a(Yii::t('app', 'Edit'), ['page/update', 'id' => $model->wiki_id, 'rev' => $model->id], ['class' => 'btn btn-default btn-flat btn-xs']);
    },
]) ?>
