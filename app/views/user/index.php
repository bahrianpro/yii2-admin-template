<?php

use app\base\grid\DeleteColumn;
use app\helpers\UserHelper;
use app\widgets\Box;
use app\widgets\Modal;
use app\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $userProvider yii\data\ActiveDataProvider */
/** @var $register app\forms\user\Register */

$this->title = t('Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    
]) ?>
    <?php Pjax::begin([
        'modal' => true,
    ]) ?>
        <div class="btn-group">
            <?php if (Yii::$app->user->can('createUser')): ?>
            <?php Modal::begin([
                'header' => '<b>' . t('Create a new user') . '</b>',
                'toggleButton' => [
                    'label' => t('Create'),
                    'class' => ['btn btn-flat btn-default'],
                ],
            ]) ?>
                <?= $this->render('_create_modal', ['register' => $register]) ?>
            <?php Modal::end() ?>
            <?php endif ?>
        </div>
        <?= GridView::widget([
            'dataProvider' => $userProvider,
            'columns' => [
                'id',
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return UserHelper::userLink($model, ['data-pjax' => 0]);
                    },
                ],
                'email',
                [
                    'header' => t('Roles'),
                    'format' => 'html',
                    'value' => function ($user) {
                        return Html::ul(ArrayHelper::getColumn($user->getRoles(), 'name'));
                    },
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($model) {
                        return UserHelper::status($model);
                    },
                ],
                'created_at:relativeTime',
                'logged_at:relativeTime',
                [
                    'class' => DeleteColumn::className(),
                ],
            ],
        ]) ?>
    <?php Pjax::end() ?>
<?php Box::end() ?>
