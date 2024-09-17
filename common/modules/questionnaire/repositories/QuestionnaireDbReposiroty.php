<?php

namespace common\modules\questionnaire\repositories;

use common\modules\questionnaire\models\Questionnaire;
use yii\db\Exception;

/**
 * {@inheritdoc}
 */
class QuestionnaireDbReposiroty implements QuestionnaireReposirotyInterface
{
    public function getAllByUserId(int $userId): array
    {
        return Questionnaire::find()->where(['user_id' => $userId])->all();
    }

    /**
     * {@inheritdoc}
     */
    public function hasApprovedQuestionnaire(int $userId): bool
    {
        $count = Questionnaire::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => Questionnaire::STATUS_APPROVED])
            ->limit(1)
            ->count();

        return $count > 0;
    }

    /**
     * @throws Exception
     */
    public function save(Questionnaire $questionnaire): void
    {
        $questionnaire->save();
    }
}