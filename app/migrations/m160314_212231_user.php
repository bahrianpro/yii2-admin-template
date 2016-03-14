<?php

use app\base\Migration;

class m160314_212231_user extends Migration
{
    
    /**
     * @var string
     */
    public $table = '{{%user}}';
    
    public function up()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'email' => $this->string()->unique(),
            'password_hash' => $this->string()->notNull(),
            'reset_token' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->table);
    }

}
