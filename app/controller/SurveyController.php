<?php

namespace App\Controller;

use App\helpers\Utility;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class SurveyController
 *
 * @package App\Controller
 */
class SurveyController extends AppController
{
    /**
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function beforeRender()
    {
        parent::beforeRender(); // TODO: Change the autogenerated stub
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function home(Request $request, Response $response, $args)
    {
        $questions = $this->loadModel()->getQuestionsModel()->getAllQuestions();
        $data = [
            'questions' => $questions,
        ];
        return $this->getView()->render($response, 'survey/home.twig', $data);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function start(Request $request, Response $response, $args)
    {
        $questions = $this->loadModel()->getQuestionsModel()->getAllQuestions();
        $data = [
            'questions' => $questions,
        ];
        return $this->getView()->render($response, 'survey/start.twig', $data);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function collect(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $processedData = Utility::processSurveyInputData($data['data'], $this->userId, $this->surveyId);
        $saved = $this->loadModel()->getAnswerModel()->manageSurveyAnswer($processedData, $this->userId, $this->surveyId);
        $complete = $this->loadModel()->getUsersSurveysModel()->isUserCompleteSurvey($this->userId, $this->surveyId);
        if($saved){
            $this->flash->addMessage('success', 'Survey has been completed');
            return $response->withRedirect('/survey/complete');
        }
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function complete(Request $request, Response $response, $args)
    {
        $message = $this->getFlash()->getMessages();
        if(empty($message)){
            return $response->withRedirect('/survey/list');
        }

        return $this->getView()->render($response, 'survey/complete.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'survey/complete.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function view(Request $request, Response $response, $args)
    {
        $answers = $this->loadModel()->getAnswerModel()->getAnswers($this->userId, $this->surveyId);
        return $this->getView()->render($response, 'survey/view.twig', ['answers' => $answers]);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function change(Request $request, Response $response, $args)
    {
        $answers = $this->loadModel()->getAnswerModel()->getAnswers($this->userId, $this->surveyId);
        return $this->getView()->render($response, 'survey/change.twig', ['answers' => $answers]);
    }
}
