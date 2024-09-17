<?php

use \yii\db\Migration;

class M240916143512CreateQuestionnaireTable extends Migration
{
    private const TABLE_NAME = '{{%questionnaires}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Id клиента'),
            'amount' => $this->integer()->notNull()->comment('Сумма займа'),
            'term' => $this->integer()->notNull()->comment('Срок займа в днях'),
            'status' => $this->string()->null()->comment('Статус заявки'),
            'created_at' => $this
                ->dateTime()
                ->notNull()
                ->defaultValue(date('Y-m-d H:i:s'))
                ->comment('Дата создания записи'),
        ]);

        $this->addCommentOnTable(self::TABLE_NAME,'Таблица займов');

        $this->addForeignKey(
            'fk-questionnaire-user_id',
            self::TABLE_NAME,
            'user_id',
            '{{%users}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
