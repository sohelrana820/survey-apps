<?php

namespace App\Model;

use Monolog\Logger;

class ModelLoader
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var \Memcache;
     */
    private $cache;

    /**
     * @var UsersModel
     */
    private $userModel;

    /**
     * @var QuestionsModel
     */
    private $questionModel;

    /**
     * @var AnswersModel
     */
    private $answerModel;

    /**
     * @var UsersSurveysModel
     */
    private $usersSurveysModel;

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Memcache $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return UsersModel
     */
    public function getUserModel()
    {
        $this->userModel = new UsersModel();
        return $this->userModel->setLogger($this->logger);
    }

    /**
     * @return QuestionsModel
     */
    public function getQuestionsModel()
    {
        $this->questionModel = new QuestionsModel();
        $this->questionModel->setLogger($this->logger);
        $this->questionModel->setCache($this->cache);
        return $this->questionModel;
    }

    /**
     * @return AnswersModel
     */
    public function getAnswerModel()
    {
        $this->answerModel = new AnswersModel();
        $this->answerModel->setLogger($this->logger);
        $this->answerModel->setCache($this->cache);
        return $this->answerModel;
    }

    /**
     * @return UsersSurveysModel
     */
    public function getUsersSurveysModel()
    {
        $this->usersSurveysModel = new UsersSurveysModel();
        $this->usersSurveysModel->setLogger($this->logger);
        $this->usersSurveysModel->setCache($this->cache);
        return $this->usersSurveysModel;
    }
}
