<?php

use yii\db\Migration;

/**
 * Class m200501_153918_create_table_category_article
 */
class m200501_153918_create_table_category_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article_category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'parent_id' => $this->integer(11)->null(),
            'image' => $this->string(255)->null(),
            'description' => $this->string()->null(),
            'position' => $this->integer(11)->null(),
            'ads_pixel' => $this->text()->null(),
            'ads_session' => $this->text()->null(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'language' => $this->string(25)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->null(),
            'updated_by' => $this->integer(11)->null(),
        ], $tableOptions);

        $this->createIndex('index-slug', 'article_category', 'slug');
        $this->createIndex('index-language', 'article_category', 'language');
        $this->addForeignKey('fk_category_created_by_article_user', 'article_category', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_category_updated_by_article_user', 'article_category', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_category}}');
    }
}
