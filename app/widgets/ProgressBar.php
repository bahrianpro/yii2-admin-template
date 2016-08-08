<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * ProgressBar
 * 
 * ```php
 * echo ProgressBar::widget([
 *  'label' => 'Processing',
 *  'total' => 1200,
 *  'value' => 250,
 * ]);
 * ```
 *
 * @author skoro
 */
class ProgressBar extends Widget
{
    
    /**
     * Progress bar styles.
     */
    const STYLE_DANGER = 'danger';
    const STYLE_INFO = 'info';
    const STYLE_PRIMARY = 'primary';
    const STYLE_SUCCESS = 'success';
    const STYLE_WARNING = 'warning';
    
    /**
     * @var string
     */
    public $label;
    
    /**
     * @var string
     */
    public $number;
    
    /**
     * @var integer max progress
     */
    public $total = 100;
    
    /**
     * @var integer current value of progress.
     */
    public $value;
    
    /**
     * @var string progress bar style.
     */
    public $style = self::STYLE_PRIMARY;
    
    /**
     * @var array
     */
    public $options = [];
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $label = $this->renderLabel();
        $number = $this->renderNumber();
        $bar = $this->renderBar();
        Html::addCssClass($this->options, 'progress-group');
        return Html::tag('div', $label . $number . $bar, $this->options);
    }
    
    /**
     * Renders progress bar label.
     * @return string
     */
    protected function renderLabel()
    {
        if ($this->label) {
            return Html::tag('span', Html::encode($this->label), ['class' => 'progress-text']);
        }
        return '';
    }
    
    /**
     * Renders total number label.
     * @return string
     */
    protected function renderNumber()
    {
        if ($this->number) {
            return Html::tag('span', Html::encode($this->number), ['class' => 'progress-number']);
        }
        return '';
    }
    
    /**
     * Renders and calculate percent value.
     * @return string
     */
    protected function renderBar()
    {
        $options = ['class' => 'progress-bar'];
        if ($this->style) {
            Html::addCssClass($options, 'progress-bar-' . $this->style);
        }
        
        if ($this->value === 0 || $this->value < 0) {
            $value = 0;
        }
        elseif ($this->value > 0 && $this->total > 0) {
            $value = (int)(($this->value * 100) / $this->total);
        }
        else {
            $value = $this->total == 0 ? 100 :
                ($this->total > 100 ? 100 : $this->total);
        }
        
        Html::addCssStyle($options, ['width' => $value . '%']);
        return Html::tag('div', Html::tag('div', '', $options), ['class' => 'progress sm']);
    }
    
}
