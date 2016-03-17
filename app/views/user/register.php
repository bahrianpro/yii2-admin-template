<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\forms\Register */

$this->title = Yii::t('app', 'User register');

$fieldOptions = function ($icon) {
    return [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-$icon form-control-feedback'></span>"
    ];
};
?>

<div class="register-box">
    <div class="register-logo">
        <a href="<?= Url::home(true) ?>"><b><?= Yii::$app->name ?></b></a>
    </div> <!-- /.register-logo -->
    
    <div class="register-box-body">
        <p class="register-box-msg"><?= Yii::t('app', 'Register a new account') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'register-form', 'enableClientValidation' => false]); ?>

        <?= $form
                ->field($model, 'name', $fieldOptions('user'))
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('name')]) ?>

        <?= $form
                ->field($model, 'email', $fieldOptions('envelope'))
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
        
        <?= $form
            ->field($model, 'password', $fieldOptions('lock'))
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form
            ->field($model, 'password_repeat', $fieldOptions('lock'))
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]) ?>
        
        <div class="row">
            <div class="col-xs-12">
                <?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'register-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.register-box-body -->
    
</div><!-- /.register-box -->