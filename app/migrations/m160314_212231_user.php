<?php

use app\base\Migration;

class m160314_212231_user extends Migration
{
    
    /**
     * @var string schema table name.
     */
    public $table = '{{%user}}';
    
    public function up()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'email' => $this->string(64)->unique(),
            'password_hash' => $this->string()->notNull(),
            'reset_token' => $this->string()->notNull()->defaultValue(''),
            'activate_token' => $this->string()->notNull()->defaultValue(''),
            'auth_key' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'logged_at' => $this->integer(),
        ]);
        
        $this->createIndex('idx_user_reset_token', $this->table, 'reset_token');
        $this->createIndex('idx_user_activate_token', $this->table, 'activate_token');
    }

    public function down()
    {
        $this->dropTable($this->table);
    }

}
