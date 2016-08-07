<?php

use app\widgets\ActiveForm;
use app\widgets\Pjax;

/** @var $this yii\web\View */
/** @var $form app\widgets\ActiveForm */
/** @var $model app\forms\user\Profile */
?>
<?php Pjax::begin() ?>
    <?php $form = ActiveForm::begin([
        'id' => 'user-profile-form',
        'pjax' => true,
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
<?php Pjax::end() ?>
