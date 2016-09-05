<?php

use app\widgets\Tabs;

/** @var $this yii\web\View */
/** @var $editor modules\wiki\forms\Editor */
/** @var $historyProvider yii\data\ActiveDataProvider */
?>

<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Editor'),
            'content' => $this->render('_editor', ['editor' => $editor]),
        ],
        [
            'label' => Yii::t('app', 'History'),
            'content' => $this->render('_history', [
                'historyProvider' => $historyProvider,
            ]),
        ],
    ],
]) ?>
