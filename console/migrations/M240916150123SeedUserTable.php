<?php

use \yii\db\Migration;

class M240916150123SeedUserTable extends Migration
{
    private const TABLE_NAME = '{{%users}}';

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $this->insert(self::TABLE_NAME, [
            'name' => 'Goodman',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->delete(self::TABLE_NAME);
    }
}
