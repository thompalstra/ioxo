<?php
namespace console\migrations;

use io\db\Schema;

class m1508331427_add_news_tables extends \io\db\Migration{
    public function up(){
        // $this->createTable('news_item', [
        //     'id' => Schema::TYPE_PK,
        //     'title' => 'VARCHAR(255)',
        //     'url' => 'VARCHAR(255)',
        //     'news_category_id' => 'INT(11)',
        //     'is_enabled' => Schema::TYPE_BOOLEAN . " DEFAULT 0 NOT NULL",
        //     'is_deleted' => Schema::TYPE_BOOLEAN . " DEFAULT 0 NOT NULL"
        // ]);
        // $this->createTable('news_category', [
        //     'id' => Schema::TYPE_PK,
        //     'title' => 'VARCHAR(255)',
        //     'url' => 'VARCHAR(255)',
        //     'is_enabled' => Schema::TYPE_BOOLEAN . " DEFAULT 0 NOT NULL",
        //     'is_deleted' => Schema::TYPE_BOOLEAN . " DEFAULT 0 NOT NULL"
        // ]);
        //
        // $this->createTable('news_content', [
        //     'id' => Schema::TYPE_PK,
        //     'news_item_id' => 'INT(11)',
        //     'type' => 'INT(11)',
        //     'sort_index' => 'INT(11)',
        //     'content' => 'TEXT',
        //     'is_enabled' => Schema::TYPE_BOOLEAN . " DEFAULT 0 NOT NULL",
        //     'is_deleted' => Schema::TYPE_BOOLEAN . " DEFAULT 0 NOT NULL"
        // ]);

        $this->insert('news_category', [
            'id' => 1,
            'title' => 'Internet',
            'url' => 'internet',
            'is_enabled' => 1,
            'is_deleted' => 0
        ]);
        $this->insert('news_item', [
            'id' => 1,
            'title' => 'WPA security breach',
            'url' => 'wpa-security-breach',
            'news_category_id' => 1,
            'is_enabled' => 1,
            'is_deleted' => 0
        ]);
    }
    public function down(){
        $this->dropTable('news_item');
        $this->dropTable('news_category');
        $this->dropTable('news_content');
    }
}
?>
