<?php

namespace common\modules\questionnaire\models;

use yii\db\ActiveRecord;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\validators\StringValidator;

/**
 * Модель кредитной заявки
 *
 * @property integer $id
 * @property integer $user_id Id клиента
 * @property integer $amount Сумма займа
 * @property integer $term  Срок займа в днях
 * @property string $status  Статус заявки
 * @property string $created_at Дата создания записи
 */
class Questionnaire extends ActiveRecord
{
    public const STATUS_APPROVED = 'approved';
    public const STATUS_DECLINED = 'declined';

    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return '{{%questionnaires}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'amount', 'term'], RequiredValidator::class],
            [['user_id', 'amount', 'term'], NumberValidator::class],
            [['status'], StringValidator::class],
            [['created_at'], SafeValidator::class],
        ];
    }
}
