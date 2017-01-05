<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
            [['user_id', 'name', 'created_at'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
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
        return $this->hasMany(User::className(), ['id' => 'user_id'])->where(['!=', 'id', $this->user->id])
            ->viaTable(Comment::tableName(), ['thread_id' => 'id'])
            ->select('id, username');
    }
}
