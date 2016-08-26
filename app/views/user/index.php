<?php

use app\helpers\UserHelper;
use app\widgets\Box;
use app\widgets\Pjax;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $userProvider yii\data\ActiveDataProvider */

$this->title = t('Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    
]) ?>
    <?php Pjax::begin() ?>
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
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($model) {
                        return UserHelper::status($model);
                    },
                ],
                'created_at:relativeTime',
                'logged_at:relativeTime',
                [
                    'class' => app\base\grid\DeleteColumn::className(),
                ],
            ],
        ]) ?>
    <?php Pjax::end() ?>
<?php Box::end() ?>
