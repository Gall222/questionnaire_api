<?php

namespace common\modules\questionnaire\mappers;

use common\modules\questionnaire\dto\QuestionnaireCreateRequestDto;

/**
 * {@inheritdoc}
 */
class QuestionnaireMapper implements QuestionnaireMapperInterface
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getCorrectRequest(array $request): QuestionnaireCreateRequestDto
    {
        try {
            return new QuestionnaireCreateRequestDto(
                $request['user_id'],
                $request['amount'],
                $request['term'],
            );
        } catch (\Exception $e) {
            throw new \Exception('Неверно переданы данные для создания заявки');
        }
    }
}