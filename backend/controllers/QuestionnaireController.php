<?php

namespace backend\controllers;

use backend\responses\ProcessorResponse;
use common\modules\questionnaire\services\QuestionnaireServiceInterface;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\Request;

/**
 * Контроллер для работы с заявками
 */
class QuestionnaireController extends Controller
{
    public $enableCsrfValidation = false;
    private QuestionnaireServiceInterface $questionnaireService;

    public function __construct(
        $id,
        $module,
        $config,
        QuestionnaireServiceInterface $questionnaireService
    ) {
        $this->questionnaireService = $questionnaireService;

        parent::__construct($id, $module, $config);
    }

    /**
     * Создать новую заявку
     * @throws InvalidConfigException
     */
    public function actionRequests(Request $request)
    {
        return $this->questionnaireService->create($request->getBodyParams());
    }

    /**
     * Изменить статусы заявок
     * @param int|null $delay Задержка между созданием заявок
     */
    public function actionProcessor(int $delay = null): ProcessorResponse
    {
        return $this->questionnaireService->changeQuestionnairesStatuses($delay);
    }
}