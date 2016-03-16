<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\components;

use Yii;
use yii\base\Component;

/**
 * Application menu.
 */
class Menu extends Component
{

    /**
     * @var array menu titles.
     */
    public $title = ['main' => 'Main menu'];
    
    /**
     * @var array menu items.
     */
    public $items = [];
    
    /**
     * @var boolean translate menu items by Yii::t().
     */
    public $translateItems = true;
    
    /**
     * Add item to menu.
     * @params string $menu
     * @params array $items likewise Menu::items property with special
     * additional property:
     * - guest: filter menu item by whether current user guest or not.
     * @return Menu
     */
    public function addItems($menu, array $items)
    {
        if (!isset($this->items[$menu])) {
            $this->items[$menu] = [];
        }
        $this->items[$menu] = array_merge($this->items[$menu], $items);
        return $this;
    }
    
    /**
     * Get menu items.
     * @param string $menu
     * @param boolean $filter filter menu items or return as is.
     * @return Menu
     */
    public function getItems($menu, $filter = true)
    {
        $items = isset($this->items[$menu]) ? $this->items[$menu] : [];
        if ($filter) {
            $items = $this->processMenuItems($items);
        }
        if ($title = $this->getTitle($menu)) {
            array_unshift($items, ['label' => $title, 'options' => ['class' => 'header']]);
        }
        return $items;
    }
    
    /**
     * Process menu items.
     * @param array $items
     * @return array
     */
    protected function processMenuItems($items)
    {
        foreach ($items as $i => &$item) {
            // Filter menu items by user Guest attribute.
            if (isset($item['guest'])) {
                if (Yii::$app->user->isGuest && !$item['guest']) {
                    unset($items[$i]);
                    continue;
                }
                if (!Yii::$app->user->isGuest && $item['guest']) {
                    unset($items[$i]);
                    continue;
                }
            }
            if ($this->translateItems) {
                $item['label'] = Yii::t('app', $item['label']);
            }
            if (isset($item['items'])) {
                $item['items'] = $this->processMenuItems($item['items']);
            }
        }
        return $items;
    }
    
    /**
     * @param string $menu
     * @return Menu
     */
    public function clearItems($menu)
    {
        $this->items[$menu] = [];
        return $this;
    }
    
    /**
     * Set menu title.
     * @param string $menu
     * @param string $title
     * @return Menu
     */
    public function setTitle($menu, $title)
    {
        $this->title[$menu] = $title;
        return $this;
    }
    
    /**
     * @param string $menu
     * @return string
     */
    public function getTitle($menu)
    {
        return isset($this->title[$menu]) ? $this->title[$menu] : '';
    }
    
}
