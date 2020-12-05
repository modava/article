<?php

namespace modava\article\models;

use common\helpers\MyHelper;
use modava\article\models\table\ArticleTable;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $category_id
 * @property int $type_id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property string|null $description
 * @property string|null $content
 * @property int|null $position
 * @property string|null $ads_pixel
 * @property string|null $ads_session
 * @property int $status
 * @property int $hot
 * @property float $priority
 * @property int|null $views
 * @property string|null $tags
 * @property string $language Language for yii2
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property ArticleType $type
 * @property ArticleCategory $category
 */
class Article extends ArticleTable
{
    public $toastr_key = 'article';

    public function behaviors()
    {

        return array_merge(
            parent::behaviors(),
            [
                'slug' => [
                    'class' => SluggableBehavior::class,
                    'immutable' => true,
                    'ensureUnique' => true,
                    'value' => function () {
                        if ($this->slug == null) {
                            return MyHelper::createAlias($this->title);
                        }
                        return $this->slug;
                    }
                ],
                [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
                'timestamp' => [
                    'class' => 'yii\behaviors\TimestampBehavior',
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['slug'], 'unique', 'targetClass' => self::class, 'targetAttribute' => 'slug'],
            [['category_id'], 'required', 'message' => Yii::t('backend', 'Danh mục không được để trống')],
            [['type_id'], 'required', 'message' => Yii::t('backend', 'Thể loại không được để trống')],
            [['category_id', 'type_id', 'position', 'status', 'hot', 'views', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['content', 'ads_pixel', 'ads_session', 'description', 'language'], 'string'],
            [['title', 'slug', 'image'], 'string', 'max' => 255],
            ['image', 'file', 'extensions' => ['png', 'jpg', 'gif'],
                'maxSize' => 1024 * 1024],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleType::class, 'targetAttribute' => ['type_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            ['priority', 'compare', 'operator' => '<=', 'compareValue' => 1, 'message' => Yii::t('backend', 'Giá trị tối đa là 1')],
            ['priority', 'compare', 'operator' => '>=', 'compareValue' => 0, 'message' => Yii::t('backend', 'Giá trị tối thiểu là 0')],
            [['tags'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'category_id' => Yii::t('backend', 'Category ID'),
            'type_id' => Yii::t('backend', 'Type ID'),
            'title' => Yii::t('backend', 'Title'),
            'slug' => Yii::t('backend', 'Slug'),
            'image' => Yii::t('backend', 'Image'),
            'description' => Yii::t('backend', 'Description'),
            'content' => Yii::t('backend', 'Content'),
            'position' => Yii::t('backend', 'Position'),
            'ads_pixel' => Yii::t('backend', 'Ads Pixel'),
            'ads_session' => Yii::t('backend', 'Ads Session'),
            'status' => Yii::t('backend', 'Status'),
            'hot' => Yii::t('backend', 'Hot'),
            'priority' => Yii::t('backend', 'Priority'),
            'views' => Yii::t('backend', 'Views'),
            'tags' => Yii::t('backend', 'Tags'),
            'language' => Yii::t('backend', 'Language'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
            'created_by' => Yii::t('backend', 'Created By'),
            'updated_by' => Yii::t('backend', 'Updated By'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->on(yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, function (yii\db\AfterSaveEvent $e) {
            if ($this->position == null)
                $this->position = $this->primaryKey;
            $this->save();
        });
        $old_alias = $this->alias;
        $alias = '';
        if ($this->category != null) $alias = $this->category->alias;
        $alias .= '/' . $this->primaryKey;
        $change_alias = $old_alias != $alias;
        if ($change_alias) {
            $this->updateAttributes([
                'alias' => $alias
            ]);
        }
        if ($change_alias && $old_alias != null) {
            Yii::$app->db->createCommand("UPDATE " . self::tableName() . " SET alias=REPLACE(alias, '{$old_alias}/', '{$alias}/') WHERE alias LIKE '{$old_alias}/%'")->execute();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
