<?php

use app\base\Migration;

class m160831_094735_module extends Migration
{

    public $table = '{{%module}}';
    
    public function up()
    {
        $this->createTable($this->table, [
            'module_id' => $this->string(32)->notNull()->unique(),
            'name' => $this->string(255)->notNull()->defaultValue(''),
            'status' => $this->char(12)->notNull(),
            'desc' => $this->text(),
            'data' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->table);
    }

}
