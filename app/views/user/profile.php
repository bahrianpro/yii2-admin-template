<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\forms\Profile */

$this->title = Yii::t('app', 'User Profile');
$this->params['breadcrumbs'] = [
    ['label' => 'User Profile'],
];

// TODO: used for demo.
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>

<div class="row">
    <div class="col-md-3">
        <!-- Profile image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= $directoryAsset ?>/img/user2-160x160.jpg">
                <h3 class="profile-username text-center">
                    <?= Html::encode($model->name) ?>
                </h3>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div>
    
    <div class="col-md-9">
    <?php $form = ActiveForm::begin([
        'id' => 'user-profile-form',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
    ]) ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'password') ?>

        <?= $form->field($model, 'password_repeat') ?>

    <?php ActiveForm::end() ?>        
    </div>
    
</div>

