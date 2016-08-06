<?php

use app\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $form app\widgets\ActiveForm */
/** @var $model app\forms\user\Profile */
?>
<?php $form = ActiveForm::begin([
    'id' => 'user-profile-form',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'wrapper' => 'col-sm-10',
        ],
    ],
]) ?>

    <?= $form->field($model, 'email')->textInput(['disabled' => 'disabled']) ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

<?php ActiveForm::endWithActions([
    'cancel' => false,
]) ?>        
