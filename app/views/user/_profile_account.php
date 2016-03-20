<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\forms\Profile */
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

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

<?php ActiveForm::end() ?>        
