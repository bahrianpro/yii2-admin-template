<?php

use app\base\Migration;
use app\models\Config;

class m160902_073317_params extends Migration
{

    public function up()
    {
        $config = new Config();
        $config->name = 'wikiStartPage';
        $config->section = 'Site';
        $config->title = 'Wiki start page';
        $config->desc = 'Insert Id or Slug of wiki page which will load on access by /wiki url.';
        $config->value = '';
        $config->value_type = 'text';
        
        if (!$config->save()) {
            return false;
        }
    }

    public function down()
    {
        $config = Config::findOne([
            'name' => 'wikiStartPage',
            'section' => 'Site',
        ]);
        if ($config) {
            $config->delete();
        }
    }

}
