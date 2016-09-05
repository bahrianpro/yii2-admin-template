<?php

use app\widgets\ActiveForm;
use modules\wiki\widgets\MarkdownEditor;

/** @var $this yii\web\View */
/** @var $editor modules\wiki\forms\Editor */
/** @var $form app\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($editor, 'title') ?>
    <?= $form->field($editor, 'content')->widget(MarkdownEditor::className(), [
        'previewUrl' => ['page/markdown-preview'],
    ]) ?>
    <?= $form->field($editor, 'summary')->textInput([
        'placeholder' => Yii::t('app', 'What did you change ?'),
    ]) ?>

<?php ActiveForm::endWithActions([
    'cancel' => $editor->isNew() ? false : [
        'url' => ['default/index', 'id' => $editor->getWiki()->id],
    ]
]) ?>
