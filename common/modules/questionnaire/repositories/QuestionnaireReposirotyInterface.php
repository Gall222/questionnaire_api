<?php

namespace common\modules\questionnaire\repositories;

use common\modules\questionnaire\models\Questionnaire;
use yii\db\Exception;

/**
 * Репозиторий для работы с заявками
 */
interface QuestionnaireReposirotyInterface
{
    public function getAllByUserId(int $userId): array;

    /**
     * Есть ли одобренные заявки
     */
    public function hasApprovedQuestionnaire(int $userId): bool;
    /**
     * @throws Exception
     */
    public function save(Questionnaire $questionnaire): void;
}