<?php

use app\widgets\Timeline;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $historyProvider yii\data\ActiveDataProvider */
modules\wiki\assets\DiffAsset::register($this);
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
        return Yii::$app->formatter->asUserlink($model->user) . ' ' . Html::tag('span', e($model->summary), ['class' => 'text-muted summary-change']);
    },
    'itemView' => function ($model) {
        return Html::tag('pre', modules\wiki\helpers\DiffHelper::diff($model));
    },
    'itemFooterView' => function ($model) {
        return Html::a(Yii::t('app', 'Edit'), ['page/update', 'id' => $model->wiki_id, 'rev' => $model->id], ['class' => 'btn btn-default btn-flat btn-xs']);
    },
]) ?>
