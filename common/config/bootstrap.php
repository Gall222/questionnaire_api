<?php

use common\modules\questionnaire\mappers\QuestionnaireMapper;
use common\modules\questionnaire\mappers\QuestionnaireMapperInterface;
use common\modules\questionnaire\repositories\QuestionnaireDbReposiroty;
use common\modules\questionnaire\repositories\QuestionnaireReposirotyInterface;
use common\modules\questionnaire\services\QuestionnaireService;
use common\modules\questionnaire\services\QuestionnaireServiceInterface;
use common\modules\user\repositories\UserDbRepository;
use common\modules\user\repositories\UserRepositoryInterface;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');


Yii::$container->set(QuestionnaireServiceInterface::class, QuestionnaireService::class);
Yii::$container->set(QuestionnaireReposirotyInterface::class, QuestionnaireDbReposiroty::class);
Yii::$container->set(UserRepositoryInterface::class, UserDbRepository::class);
Yii::$container->set(QuestionnaireMapperInterface::class, QuestionnaireMapper::class);