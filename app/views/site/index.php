<?php

use app\widgets\Box;
use app\widgets\ItemList;
use app\widgets\ProgressBar;
use app\widgets\Select2;
use app\widgets\Tabs;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var $this yii\web\View */

$this->title = 'Demo page';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row demo-page">
    
    <div class="col-md-6">
        <?php Box::begin([
            'box' => Box::BOX_DEFAULT,
            'label' => 'Table',
        ]) ?>
            <?= GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => [
                        ['id' => 1, 'task' => 'Update software', 'progress' => 20, 'label' => '55'],
                        ['id' => 2, 'task' => 'Clean database', 'progress' => 40, 'label' => '15'],
                        ['id' => 3, 'task' => 'Cron job running', 'progress' => 80, 'label' => '84'],
                        ['id' => 4, 'task' => 'Fix and squish bugs', 'progress' => 15, 'label' => '18'],
                    ],
                ]),
                'columns' => [
                    'id',
                    'task',
                    [
                        'attribute' => 'progress',
                        'format' => ['progressBar', [
                            'size' => ProgressBar::SIZE_SM,
                            'style' => ProgressBar::STYLE_INFO,
                        ]],
                    ],
                    [
                        'attribute' => 'label',
                        'value' => function ($model) {
                            $color = '';
                            if ($model['label'] < 20) {
                                $color = 'bg-red';
                            } 
                            if ($model['label'] > 50) {
                                $color = 'bg-yellow';
                            } 
                            if ($model['label'] > 80) {
                                $color = 'bg-green';
                            }
                            return Html::tag('span', $model['label'] . '%', ['class' => 'badge ' . $color]);
                        },
                        'format' => 'html',
                    ],
                ],
            ]) ?>
        <?php Box::end() ?>
        
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => 'Tab 1',
                    'content' => 'Content 1...',
                ],
                [
                    'label' => 'Tab 2',
                    'content' => 'Content 2...',
                ],
                [
                    'label' => 'Tab 3',
                    'content' => 'Content 3...',
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Label',
                            'content' => '....',
                        ],
                        [
                            'label' => 'Label',
                            'content' => '....',
                        ],
                    ],
                ],
            ],
        ]) ?>
        
    </div>
    
    <div class="col-md-6">
        <?php Box::begin([
            'box' => Box::BOX_PRIMARY,
            'label' => 'Box 1',
            'collapsable' => true,
            'solid' => true,
        ]) ?>
            The body of the box. The body of the box. The body of the box.
        <?php Box::end() ?>
        
        <?php Box::begin([
            'box' => Box::BOX_WARNING,
            'label' => 'Box 2',
            'removable' => true,
        ]) ?>
            The body of the box. The body of the box. The body of the box.
        <?php Box::end() ?>
            
        <?php Box::begin([
            'box' => Box::BOX_SUCCESS,
            'label' => 'Select2 widget',
        ]) ?>
            <?= Select2::widget([
                'name' => 'demo-select2',
                'items' => [
                    1 => 'Zoo',
                    2 => 'Park',
                    3 => 'Cinema',
                ],
            ]) ?>
            <hr>
            <?= Select2::widget([
                'name' => 'demo-select2',
                'hideSearch' => false,
                'items' => [
                    1 => 'Zoo',
                    2 => 'Park',
                    3 => 'Cinema',
                    4 => 'Shop',
                    5 => 'Market',
                ],
            ]) ?>
        <?php Box::end() ?>
            
        <?php Box::begin([
            'label' => 'Item list',
            'box' => Box::BOX_DANGER,
        ]) ?>
            <?= ItemList::widget([
                'items' => [
                    [
                        'title' => 'Created by',
                        'value' => 'user',
                    ],
                    [
                        'title' => 'Date',
                        'value' => '2016.08.09',
                    ],
                    [
                        'title' => 'Status',
                        'value' => 'Enabled',
                    ],
                ],
            ]) ?>
        <?php Box::end() ?>
    </div>
    
</div> <!-- /.demo-page -->
