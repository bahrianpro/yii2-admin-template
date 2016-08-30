<?php

use app\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var $this yii\web\View */
/** @var $form app\widgets\ActiveForm */
/** @var $model app\forms\Profile */
?>
<?php $form = ActiveForm::begin([
    'id' => 'user-profile-admin-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'wrapper' => 'col-sm-10',
        ],
    ],
    'action' => ['profile', 'id' => $model->getUser()->id, 'tab' => 'admin'],
]) ?>

    <?= $form->field($model, 'roles')->checkboxList(
            ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
    ) ?>

    <?= $form->field($model, 'status')->radioList($model->getUser()->getStatusLabels()) ?>

<?php ActiveForm::endWithActions([
    'cancel' => false,
]) ?>
