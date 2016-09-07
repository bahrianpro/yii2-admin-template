<?php

use app\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $wiki modules\wiki\models\Wiki */

$this->title = $wiki->title;
?>
<div class="callout callout-danger">
    <h4><?= Yii::t('app', 'Are you sure to delete page ?') ?></h4>
    <p><?= Yii::t('app', 'This operation cannot be undo.') ?></p>
</div>

<?php ActiveForm::begin() ?>

<?php if ($wiki->getChildren()->count()): ?>
    <p class="lead"><?= Yii::t('app', 'These pages also affected: ') ?></p>
    <ul>
    <?php foreach ($wiki->children as $child): ?>
        <li><?= Html::a(e($child->title), ['page/view', 'id' => $child->id]) ?></li>
    <?php endforeach ?>
    </ul>
    <p class="lead"><?= Yii::t('app', 'Please select what to do with these pages: ') ?></p>
    <?= app\widgets\Check::widget([
        'type' => app\widgets\Check::TYPE_RADIO,
        'name' => 'children',
        'options' => ['class' => 'checkbox-list-vert'],
        'items' => [
            'delete' => Yii::t('app', 'Delete also'),
            'up' => ($parent = $wiki->parent) ? Yii::t('app', 'Move these pages to "{title}"', [
                'title' => $parent->title,
            ]) : false,
            'move' => Yii::t('app', 'Move to selected:'),
        ],
    ]) ?>
    <hr>
<?php endif ?>

<?php ActiveForm::endWithActions([
    'save' => [
        'label' => Yii::t('app', 'DELETE'),
        'options' => ['class' => 'btn btn-flat bg-red'],
    ],
    'cancel' => [
        'url' => ['page/view', 'id' => $wiki->id],
    ],
]) ?>
