<?php

use yii\db\Schema;

class m170105_102334_create_tables extends yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey()->notNull(),
            'thread_id' => $this->integer()->defaultValue('0')->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->getDb()->getSchema()->createColumnSchemaBuilder('MEDIUMTEXT')->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('FK_comment_user', '{{%comment}}', 'user_id', false);
        $this->createIndex('FK_comment_thread', '{{%comment}}', 'thread_id', false);


        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(100)->notNull(),
        ]);

        $this->createIndex('name', '{{%tag}}', 'name', true);


        $this->createTable('{{%thread}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('FK_thread_user', '{{%thread}}', 'user_id', false);
        $this->createIndex('created_at', '{{%thread}}', 'created_at', false);


        $this->createTable('{{%thread__tag}}', [
            'thread_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('PRIMARY KEY', '{{%thread__tag}}', ['thread_id', 'tag_id']);

        $this->createIndex('FK_thread_tag_tag', '{{%thread__tag}}', 'tag_id', false);


        $this->addForeignKey('FK_comment_user', '{{%comment}}', 'user_id', '{{%user}}', 'id', null, null);
        $this->addForeignKey('FK_comment_thread', '{{%comment}}', 'thread_id', '{{%thread}}', 'id', null, null);

        $this->addForeignKey('FK_thread_user', '{{%thread}}', 'user_id', '{{%user}}', 'id', null, null);

        $this->addForeignKey('FK_thread_tag_thread', '{{%thread__tag}}', 'thread_id', '{{%thread}}', 'id', null, null);
        $this->addForeignKey('FK_thread_tag_tag', '{{%thread__tag}}', 'tag_id', '{{%tag}}', 'id', null, null);


        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        $data = [
            ['id' => '1', 'thread_id' => '1', 'user_id' => '1', 'text' => 'Test comment', 'created_at' => '2017-01-05 02:42:52'],
            ['id' => '2', 'thread_id' => '1', 'user_id' => '1', 'text' => 'Test comment 2', 'created_at' => '2017-01-05 02:43:04'],
            ['id' => '3', 'thread_id' => '1', 'user_id' => '1', 'text' => 'Test comment 3', 'created_at' => '2017-01-05 03:12:18'],
            ['id' => '4', 'thread_id' => '1', 'user_id' => '1', 'text' => 'Test comment 4', 'created_at' => '2017-01-05 08:19:23'],
            ['id' => '5', 'thread_id' => '1', 'user_id' => '1', 'text' => '<b>Test</b>', 'created_at' => '2017-01-05 08:19:50'],
            ['id' => '6', 'thread_id' => '1', 'user_id' => '1', 'text' => '<b>Test 2</b>', 'created_at' => '2017-01-05 08:20:04'],
            ['id' => '7', 'thread_id' => '9', 'user_id' => '1', 'text' => 'test', 'created_at' => '2017-01-05 09:19:15'],
            ['id' => '8', 'thread_id' => '10', 'user_id' => '1', 'text' => 'test', 'created_at' => '2017-01-05 09:19:24'],
            ['id' => '9', 'thread_id' => '11', 'user_id' => '1', 'text' => 'test2', 'created_at' => '2017-01-05 09:20:13'],
            ['id' => '10', 'thread_id' => '13', 'user_id' => '2', 'text' => '22', 'created_at' => '2017-01-05 10:08:37'],
            ['id' => '11', 'thread_id' => '11', 'user_id' => '2', 'text' => 'aa', 'created_at' => '2017-01-05 10:14:07'],
            ['id' => '12', 'thread_id' => '14', 'user_id' => '2', 'text' => '22', 'created_at' => '2017-01-05 10:21:39'],
            ['id' => '13', 'thread_id' => '15', 'user_id' => '2', 'text' => '22', 'created_at' => '2017-01-05 10:21:55'],
        ];
        $this->batchInsert('{{%comment}}', [], $data);

        $data = [
            ['id' => '4', 'name' => 'a'],
            ['id' => '7', 'name' => 'aa'],
            ['id' => '6', 'name' => 'b'],
            ['id' => '8', 'name' => 'bb'],
            ['id' => '1', 'name' => 'tag1'],
            ['id' => '2', 'name' => 'tag2'],
            ['id' => '3', 'name' => 'tag3'],
        ];
        $this->batchInsert('{{%tag}}', [], $data);

        $data = [
            ['id' => '1', 'user_id' => '1', 'name' => 'Test thread 1', 'created_at' => '2017-01-03 16:39:56'],
            ['id' => '2', 'user_id' => '1', 'name' => 'Test thread 2', 'created_at' => '2017-01-03 16:39:56'],
            ['id' => '3', 'user_id' => '1', 'name' => '11', 'created_at' => '2017-01-05 08:54:23'],
            ['id' => '4', 'user_id' => '1', 'name' => 'test', 'created_at' => '2017-01-05 09:17:15'],
            ['id' => '5', 'user_id' => '1', 'name' => 'test', 'created_at' => '2017-01-05 09:17:31'],
            ['id' => '6', 'user_id' => '1', 'name' => 'test', 'created_at' => '2017-01-05 09:17:40'],
            ['id' => '7', 'user_id' => '1', 'name' => 'test', 'created_at' => '2017-01-05 09:18:17'],
            ['id' => '8', 'user_id' => '1', 'name' => 'test', 'created_at' => '2017-01-05 09:18:54'],
            ['id' => '9', 'user_id' => '1', 'name' => 'test', 'created_at' => '2017-01-05 09:19:15'],
            ['id' => '10', 'user_id' => '1', 'name' => 'test', 'created_at' => '2017-01-05 09:19:24'],
            ['id' => '11', 'user_id' => '1', 'name' => 'test2', 'created_at' => '2017-01-05 09:20:13'],
            ['id' => '12', 'user_id' => '2', 'name' => '11', 'created_at' => '2017-01-05 10:07:07'],
            ['id' => '13', 'user_id' => '2', 'name' => '11', 'created_at' => '2017-01-05 10:08:37'],
            ['id' => '14', 'user_id' => '2', 'name' => '11', 'created_at' => '2017-01-05 10:21:39'],
            ['id' => '15', 'user_id' => '2', 'name' => '22', 'created_at' => '2017-01-05 10:21:55'],
        ];
        $this->batchInsert('{{%thread}}', [], $data);

        $data = [
            ['thread_id' => '1', 'tag_id' => '1'],
            ['thread_id' => '1', 'tag_id' => '2'],
            ['thread_id' => '2', 'tag_id' => '2'],
            ['thread_id' => '2', 'tag_id' => '3'],
            ['thread_id' => '6', 'tag_id' => '4'],
            ['thread_id' => '7', 'tag_id' => '4'],
            ['thread_id' => '8', 'tag_id' => '4'],
            ['thread_id' => '9', 'tag_id' => '4'],
            ['thread_id' => '10', 'tag_id' => '4'],
            ['thread_id' => '14', 'tag_id' => '4'],
            ['thread_id' => '15', 'tag_id' => '4'],
            ['thread_id' => '7', 'tag_id' => '6'],
            ['thread_id' => '8', 'tag_id' => '6'],
            ['thread_id' => '9', 'tag_id' => '6'],
            ['thread_id' => '10', 'tag_id' => '6'],
            ['thread_id' => '13', 'tag_id' => '6'],
            ['thread_id' => '14', 'tag_id' => '6'],
            ['thread_id' => '15', 'tag_id' => '6'],
            ['thread_id' => '11', 'tag_id' => '7'],
            ['thread_id' => '13', 'tag_id' => '7'],
            ['thread_id' => '11', 'tag_id' => '8'],
        ];
        $this->batchInsert('{{%thread__tag}}', [], $data);

        $data = [
            ['id' => '1', 'username' => 'admin', 'auth_key' => 'zRVTmCnb7o0qNzn_5Y1D6cJ2YfFn1uV1', 'password_hash' => '$2y$13$2IFTqwJ221Nv8uE3sAQVAuwb4gJxPGGlO2oKCseiW5BJAy1BhOOVu', 'password_reset_token' => null, 'email' => 'a@a.aa', 'status' => '10', 'created_at' => '1483459924', 'updated_at' => '1483459924'],
            ['id' => '2', 'username' => 'test', 'auth_key' => 'o9wCjcZGi0TcJlXWUqWLlf_LVS5tExRB', 'password_hash' => '$2y$13$u7rhuZIYwkOTPDsLtz0ZBO7h3Wb3h.90LQjMNUUfMzmRi7QDSl1VO', 'password_reset_token' => null, 'email' => 'aa@aa.aa', 'status' => '10', 'created_at' => '1483610813', 'updated_at' => '1483610813'],
        ];
        $this->batchInsert('{{%user}}', [], $data);

        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        $this->dropTable('{{%user}}');
        $this->dropTable('{{%thread__tag}}');
        $this->dropTable('{{%thread}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%migration}}');
        $this->dropTable('{{%comment}}');

        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
