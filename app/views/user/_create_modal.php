<?php

/** @var $register app\forms\user\Register */
?>

<?php $form = \app\widgets\ActiveForm::begin([
    'pjax' => true,
    'enableAjaxValidation' => true,
]) ?>
    <?= $form->field($register, 'name') ?>
    <?= $form->field($register, 'email') ?>
    <?= $form->field($register, 'password')->passwordInput() ?>
    <?= $form->field($register, 'password_repeat')->passwordInput() ?>
<?php \app\widgets\ActiveForm::endWithActions([
    'cancel' => [
        'options' => ['data-dismiss' => 'modal'],
    ],
]) ?>