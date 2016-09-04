<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $history modules\wiki\models\History */

$this->title = $history->wiki->title;
?>
<div class="wiki-summary">
    <span class="summary-info text-muted text-sm">
        <?= Yii::t('app', 'Added by {creator}, last edit by {editor} {time}', [
            'creator' => Yii::$app->formatter->asUserlink($history->wiki->user),
            'editor' => Yii::$app->formatter->asUserlink($history->user),
            'time' => Yii::$app->formatter->asRelativeTime($history->created_at),
        ]) ?>
    </span>
    <span class="pull-right">
        <?= yii\bootstrap\ButtonDropdown::widget([
            'label' => Yii::t('app', 'Actions'),
            'options' => ['class' => 'btn btn-flat btn-default'],
            'dropdown' => [
                'items' => [
                    ['label' => Yii::t('app', 'Edit'), 'url' => ['default/update', 'id' => $history->wiki_id]],
                    ['label' => Yii::t('app', 'Create page'), 'url' => ['default/create', 'id' => $history->wiki_id]],
                    ['label' => Yii::t('app', 'Delete'), 'url' => ['default/delete', 'id' => $history->wiki_id]],
                ],
            ],
        ]) ?>
    </span>
</div>

<?= Yii::$app->formatter->asMarkdown($history->content) ?>

