<?php

use yii\db\Migration;

/**
 * Class m200507_111020_create_talbe_article
 */
class m200507_111020_create_talbe_article extends Migration
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

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(11)->notNull(),
            'type_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'image' => $this->string(255)->null(),
            'description' => $this->text()->null(),
            'content' => $this->text()->null(),
            'position' => $this->integer(11)->null(),
            'ads_pixel' => $this->text()->null(),
            'ads_session' => $this->text()->null(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'views' => $this->bigInteger(20)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->null(),
            'updated_by' => $this->integer(11)->null(),
        ], $tableOptions);

        $this->addForeignKey("fk_article_category", "article", "type_id", "article_type", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey("fk_news_cate_cid", "article", "category_id", "article_category", "id", "RESTRICT", "CASCADE");
        $this->createIndex('index-slug', 'article', 'slug');
        $this->addColumn('article', 'language', "ENUM('vi', 'en', 'jp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vi' COMMENT 'Language for yii2' AFTER `views`");
        $this->createIndex('index-language', 'article', 'language');
        $this->addForeignKey('fk_article_created_by_user', 'article', 'created_by', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_article_updated_by_user', 'article', 'updated_by', 'user', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }

}
