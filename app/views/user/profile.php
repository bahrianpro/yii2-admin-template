<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model app\forms\Profile */

$this->title = Yii::t('app', 'User Profile');
$this->params['breadcrumbs'] = [
    ['label' => 'User Profile'],
];
?>

<div class="row">
    
    <div class="col-md-3">
        <!-- Profile image -->
        <div class="box box-primary profile-image">
            <div class="box-body box-profile">
                <?= Html::img(Yii::$app->params['noAvatarImage'], ['class' => 'profile-user-img img-responsive img-circle']) ?>
                <h3 class="profile-username text-center">
                    <?= Html::encode($model->name) ?>
                </h3>
                <p class="text-muted text-center">
                    <?= Yii::t('app', 'Member since {date}', ['date' => Yii::$app->formatter->asDate(Yii::$app->user->identity->created_at)]) ?>
                </p>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div>
    
    <div class="col-md-9">
        <div class="nav-tabs-custom profile-tabs">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => 'Account',
                        'content' => $this->render('_profile_account', ['model' => $model]),
                        'active' => true,
                    ],
                ],
            ]) ?>
        </div>
    </div>
    
</div>

