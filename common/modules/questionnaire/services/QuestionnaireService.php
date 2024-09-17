<?php

namespace common\modules\questionnaire\services;

use backend\responses\ProcessorResponse;
use backend\responses\QuestionnaireCreateResponse;
use common\modules\questionnaire\mappers\QuestionnaireMapperInterface;
use common\modules\questionnaire\models\Questionnaire;
use common\modules\questionnaire\repositories\QuestionnaireReposirotyInterface;
use common\modules\user\repositories\UserRepositoryInterface;
use Yii;
use yii\db\Exception;

/**
 * {@inheritdoc}
 */
class QuestionnaireService implements QuestionnaireServiceInterface
{
    private QuestionnaireReposirotyInterface $questionnaireRepository;
    private UserRepositoryInterface $userRepository;
    private QuestionnaireMapperInterface $questionnaireMapper;

    private const APPROVE_CHANCE = 10;

    public function __construct(
        QuestionnaireReposirotyInterface $questionnaireRepository,
        UserRepositoryInterface $userRepository,
        QuestionnaireMapperInterface $questionnaireMapper
    ) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->userRepository = $userRepository;
        $this->questionnaireMapper = $questionnaireMapper;
    }

    /**
     * @throws Exception
     */
    public function create(array $request): QuestionnaireCreateResponse
    {
        $requestDto = $this->questionnaireMapper->getCorrectRequest($request);

        if ($this->questionnaireRepository->hasApprovedQuestionnaire($requestDto->getUserId())) {
            return new QuestionnaireCreateResponse(false);
        }

        $newQuestionnaire = new Questionnaire();
        $newQuestionnaire->amount = $requestDto->getAmount();
        $newQuestionnaire->term = $requestDto->getTerm();
        $newQuestionnaire->user_id = $requestDto->getUserId();

        $this->questionnaireRepository->save($newQuestionnaire);

        if ($newQuestionnaire->id === null) {
            return new QuestionnaireCreateResponse(false);
        }

        Yii::$app->response->statusCode = 201;

        return new QuestionnaireCreateResponse(true, $newQuestionnaire->id);
    }

    /**
     * {@inheritdoc}
     */
    public function changeQuestionnairesStatuses(int $delay): ProcessorResponse
    {
        $users = $this->userRepository->getAll();

        try {
            foreach ($users as $user) {
                $this->setStatuses($user->id, $delay);
            }
            return new ProcessorResponse(true);
        } catch (Exception $exception) {
            return new ProcessorResponse(false);
        }
    }

    /**
     * Устанавливаем статусы заявкам клиента
     * Не может быть более одной одобренной
     * @throws Exception
     */
    private function setStatuses(int $userId, int $delay): void
    {
        $questionnaires = $this->questionnaireRepository->getAllByUserId($userId);
        $isApproved = false;

        foreach ($questionnaires as $questionnaire) {
            $questionnaire->status = $isApproved === true ?
                Questionnaire::STATUS_DECLINED : $this->getStatus();

            // Была ли одобрена хотя бы одна заявка
            if($questionnaire->status === Questionnaire::STATUS_APPROVED){
                $isApproved = true;
            }

            sleep($delay);

            $this->questionnaireRepository->save($questionnaire);
        }
    }

    /**
     * Возвращает статус одобрен или отклонен
     * Вероятность одобрения - 10%
     */
    private function getStatus(): string
    {
        $isApproved = (rand(1, 100)) <= self::APPROVE_CHANCE;

        return $isApproved ? Questionnaire::STATUS_APPROVED : Questionnaire::STATUS_DECLINED;
    }
}