<?php

/** @var $this yii\web\View */
/** @var $historyProvider yii\data\ActiveDataProvider */
?>

<?= \app\widgets\Timeline::widget([
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
        return 'footer';
    },
]) ?>
