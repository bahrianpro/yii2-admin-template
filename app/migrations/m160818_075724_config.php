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
            'desc' => $this->text(),
            'section' => $this->string(32)->notNull()->defaultValue('global'),
        ]);
        
        $this->createIndex('idx_config_name', $this->table, ['name', 'section'], true);
        
        echo 'Insert default parameters...'.PHP_EOL;
        $this->insertParam([
            'name' => 'passwordResetTokenExpire',
            'value' => 3600,
            'value_type' => 'text',
            'section' => 'User',
            'desc' => 'How long (in seconds) password reset token will be actual.',
        ]);
        
        $this->insertParam([
            'name' => 'disableUserRegister',
            'value' => false,
            'value_type' => 'switch',
            'section' => 'User',
            'desc' => 'Disable user registration at site.',
        ]);
        
        $this->insertParam([
            'name' => 'noAvatarImage',
            'value' => '@web/images/avatars/avatar2.png',
            'value_type' => 'url',
            'section' => 'User',
            'desc' => 'Default user avatar picture.',
        ]);
        
        $this->insertParam([
            'name' => 'adminEmail',
            'value' => 'admin@example.com',
            'value_type' => 'email',
            'section' => 'Site',
            'desc' => 'Email address used for replies.',
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
