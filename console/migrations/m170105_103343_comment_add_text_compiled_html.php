<?php

use yii\db\Migration;

class m170105_103343_comment_add_text_compiled_html extends Migration
{
    public function up()
    {
        $this->addColumn('{{%comment}}', 'text_compiled_html',
            $this->getDb()->getSchema()->createColumnSchemaBuilder('MEDIUMTEXT')->notNull()->after('text')
        );

        $comments = \common\models\Comment::find()->all();
        foreach ($comments as $comment) {
            $comment->text_compiled_html = Yii::$app->formatter->asHtml($comment->text);
            $comment->save();
        }
    }

    public function down()
    {
        $this->dropColumn('{{%comment}}', 'text_compiled_html');
    }
}
