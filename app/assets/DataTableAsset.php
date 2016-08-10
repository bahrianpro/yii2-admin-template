<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * DataTableAsset
 *
 * @author skoro
 */
class DataTableAsset extends AssetBundle
{
    
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/datatables';
    
    public $js = [
        'jquery.dataTables.min.js',
        'dataTables.bootstrap.min.js',
    ];
    
    public $css = [
        'dataTables.bootstrap.css',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
