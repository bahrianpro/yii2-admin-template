<?php

use app\base\Migration;

class m160818_075724_config extends Migration
{

    public $table = '{{%config}}';
    
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'value' => $this->binary(),
            'value_type' => $this->char(8)->notNull(),
            'title' => $this->string(255)->notNull(),
            'desc' => $this->text(),
            'section' => $this->string(32)->notNull()->defaultValue('global'),
            'required' => $this->boolean()->notNull()->defaultValue(0),
        ]);
        
        $this->createIndex('idx_config_name', $this->table, ['name', 'section'], true);
        
        echo 'Insert default parameters...'.PHP_EOL;
        $this->insertParam([
            'name' => 'passwordResetTokenExpire',
            'title' => 'Password reset token expire',
            'value' => 3600,
            'value_type' => 'text',
            'section' => 'User',
            'desc' => 'How long (in seconds) password reset token will be actual.',
            'required' => true,
        ]);
        
        $this->insertParam([
            'name' => 'disableUserRegister',
            'title' => 'Disable user registration',
            'value' => false,
            'value_type' => 'switch',
            'section' => 'User',
        ]);
        
        $this->insertParam([
            'name' => 'noAvatarImage',
            'title' => 'Default user avatar image',
            'value' => '@web/images/avatars/avatar2.png',
            'value_type' => 'text',
            'section' => 'User',
            'desc' => 'Default user avatar picture.',
            'required' => true,
        ]);
        
        $this->insertParam([
            'name' => 'adminEmail',
            'title' => 'Site email',
            'value' => 'admin@example.com',
            'value_type' => 'email',
            'section' => 'Site',
            'desc' => 'Email address used for replies.',
            'required' => true,
        ]);
    }

    public function down()
    {
        $this->dropTable($this->table);
    }

    protected function insertParam($data)
    {
        $data['value'] = serialize($data['value']);
        Yii::$app->db->createCommand()
                ->insert($this->table, $data)
                ->execute();
    }
}
