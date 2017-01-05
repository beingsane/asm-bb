<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%thread}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $created_at
 *
 * @property Comment[] $comments
 * @property User $user
 * @property ThreadTag[] $threadTags
 * @property Tag[] $tags
 * @property User[] $joinedUsers
 */
class Thread extends \yii\db\ActiveRecord
{
    private $tagString;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thread}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['tagString'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => null,
                'value' => function () { return date('Y-m-d H:i:s'); },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['thread_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThreadTags()
    {
        return $this->hasMany(ThreadTag::className(), ['thread_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%thread__tag}}', ['thread_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoinedUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->where(['!=', 'id', 'thread.user_id'])
            ->viaTable(Comment::tableName(), ['thread_id' => 'id'])
            ->select('id, username');
    }

    public function getTagString()
    {
        if ($this->tagString === null) {
            $this->tagString = implode(', ', ArrayHelper::getColumn($this->tags, 'name'));
        }

        return $this->tagString;
    }

    public function setTagString($value)
    {
        $this->tagString = $value;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $res = parent::afterSave($insert, $changedAttributes);

        // just recreate all thread tags

        $transaction = Yii::$app->db->beginTransaction();

        foreach ($this->threadTags as $threadTag) {
            $threadTag->delete();
        }

        $tagNames = explode(',', $this->tagString);
        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            $tag = Tag::findOne(['name' => $tagName]);
            if (!$tag) {
                $tag = new Tag(['name' => $tagName]);
                $tag->save();
            }

            $threadTag = ThreadTag::findOne(['tag_id' => $tag->id, 'thread_id' => $this->id]);
            if (!$threadTag) {
                $threadTag = new ThreadTag(['tag_id' => $tag->id, 'thread_id' => $this->id]);
                $threadTag->save();
            }
        }

        $transaction->commit();

        return $res;
    }
}

