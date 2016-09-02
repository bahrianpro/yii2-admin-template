<?php

use app\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $editor modules\wiki\forms\Editor */
/** @var $form app\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($editor, 'title') ?>
    <?= $form->field($editor, 'content')->textArea(['rows' => 16]) ?>
    <?= $form->field($editor, 'summary')->textInput([
        'options' => [
            'placeholder' => Yii::t('app', 'What did you change ?'),
        ],
    ]) ?>

<?php ActiveForm::endWithActions([
    'cancel' => [
        'url' => ['default/view', 'id' => $editor->getHistory()->wiki_id],
    ]
]) ?>
