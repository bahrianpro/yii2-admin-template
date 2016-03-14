<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.alexei@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base;

/**
 * Migration
 *
 * @author skoro
 */
class Migration extends \yii\db\Migration
{
    
    /**
     * @var string
     */
    protected $tableOptions = null;
    
    /**
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    /**
     * @return string
     */
    protected function getTableOptions()
    {
        if ($this->tableOptions === null) {
            switch ($this->db->driverName) {
                case 'mysql':
                    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                    $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                    break;
                
                default:
                    $this->tableOptions = '';
            }
        }
        
        return $this->tableOptions;
    }
    
}
