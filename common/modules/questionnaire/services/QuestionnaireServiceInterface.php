<?php

namespace common\modules\questionnaire\services;

use backend\responses\ProcessorResponse;
use backend\responses\QuestionnaireCreateResponse;

/**
 * Сервис обработки заявок
 */
interface QuestionnaireServiceInterface
{
    /**
     * Меняем статусы заявок для всех пользователей
     * @param int $delay Задержка на принятие решения
     */
    public function changeQuestionnairesStatuses(int $delay): ProcessorResponse;

    public function create(array $request): QuestionnaireCreateResponse;
}