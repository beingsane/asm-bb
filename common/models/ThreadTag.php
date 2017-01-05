<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%thread__tag}}".
 *
 * @property integer $thread_id
 * @property integer $tag_id
 *
 * @property Tag $tag
 * @property Thread $thread
 */
class ThreadTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thread__tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'tag_id'], 'required'],
            [['thread_id', 'tag_id'], 'integer'],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
            [['thread_id'], 'exist', 'skipOnError' => true, 'targetClass' => Thread::className(), 'targetAttribute' => ['thread_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thread_id' => Yii::t('app', 'Thread ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThread()
    {
        return $this->hasOne(Thread::className(), ['id' => 'thread_id']);
    }

    /**
     * Returns information about thread count by tags ordered by tag name asc
     * @return array
     */
    public static function getTagsCountInfo()
    {
        $tags = ThreadTag::find()
            ->select('tag_id, COUNT(thread_id) thread_count, tag.name')
            ->join('INNER JOIN', 'tag', 'tag_id = tag.id')
            ->groupBy('tag_id')
            ->orderBy('tag.name ASC')
            ->limit(100)
            ->asArray()
            ->all();

        return $tags;
    }
}
