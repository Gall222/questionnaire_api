<?php

namespace common\modules\questionnaire\mappers;


use common\modules\questionnaire\dto\QuestionnaireCreateRequestDto;

/**
 * Класс для обработки и наполнения модели заявки
 */
interface QuestionnaireMapperInterface
{
    /**
     * Обрабатывает данные из запроса
     */
    public function getCorrectRequest(array $request): QuestionnaireCreateRequestDto;
}