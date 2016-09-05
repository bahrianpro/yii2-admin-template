<?php

use app\helpers\Icon;
use app\widgets\Box;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $wiki modules\wiki\models\Wiki */

$this->title = $wiki->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wiki'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'label' => $this->title,
    'actions' => [
        [
            'visible' => !empty($wiki->parent_id),
            'value' => Html::a(Icon::icon('fa fa-chevron-left'), ['default/index', 'id' => $wiki->parent_id]),
        ],
        [
            'value' => ButtonDropdown::widget([
                'label' => Yii::t('app', 'Actions'),
                'tagName' => 'a',
                'dropdown' => [
                    'items' => [
                        ['label' => Yii::t('app', 'Edit'), 'url' => ['page/update', 'id' => $wiki->id]],
                        ['label' => Yii::t('app', 'Create child page'), 'url' => ['page/create', 'id' => $wiki->id]],
                        ['label' => Yii::t('app', 'Delete'), 'url' => ['page/delete', 'id' => $wiki->id]],
                    ],
                ],
            ]),
        ],
    ],
]) ?>
    <div class="wiki-summary">
        <span class="summary-info text-muted text-sm">
            <?= Yii::t('app', 'Added by {creator}, last edit by {editor} {time}', [
                'creator' => Yii::$app->formatter->asUserlink($wiki->user),
                'editor' => Yii::$app->formatter->asUserlink($wiki->historyLatest->user),
                'time' => Yii::$app->formatter->asRelativeTime($wiki->historyLatest->created_at),
            ]) ?>
        </span>
    </div>
    <?= Yii::$app->formatter->asMarkdown($wiki->historyLatest->content) ?>
<?php Box::end() ?>

<?php if ($wiki->getChildren()->count()): ?>
<?php Box::begin([
    'label' => Yii::t('app', 'Child pages'),
]) ?>
<ul class="list-unstyled">
    <?php foreach ($wiki->children as $child): ?>
    <li><?= Html::a(Icon::icon('fa fa-file-text', e($child->title)), ['default/index', 'id' => $child->id]) ?></li>
    <?php endforeach ?>
</ul>
<?php Box::end() ?>
<?php endif ?>
