<?php


namespace src\Service;


use src\Interfaces\IQuizRepository;
use src\Interfaces\IQuizService;
use src\Model\AbstractClasses\Types;
use src\Model\Choice;
use src\Model\Question;
use src\Model\Quiz;

class QuizService implements IQuizService
{
    private IQuizRepository $quizRepository;

    public function __construct(IQuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    public function saveQuiz(array $quizData, array $fileData): int
    {
        if($this->validateQuizData($quizData)){
            $quiz = $this->createQuiz($quizData);
            $code = $this->quizRepository->saveQuiz($quiz);

            $this->saveQuestions($quizData, $fileData, $quiz->getQuizId());

            return $code;
        }
        return -3;
    }

    public function saveQuestions(array $quizData, array $quizFile, string $quizId){
        if ($quizData['quizText'] != ''){
            ServiceContainer::get("QuestionService")->saveQuestionsFromText($quizData['quizText'], $quizId);
        }else{
            ServiceContainer::get("QuestionService")->saveQuestionsFromFile($quizFile, $quizId);
        }
    }

    /**
     * Creates a new Quiz object
     * and sets the $data attributes
     * of the AbstractDBModel parent class
     * to enable persistance in the database.
     * @param array $quizData
     * @return Quiz
     */
    private function createQuiz(array $quizData): Quiz{
        $quiz = new Quiz();

        $quizId = uniqid();

        $quiz->setQuizId($quizId);
        $quiz->__set("QuizId", $quizId);
        $quiz->__set("Name", $quizData['quizName']);
        $quiz->__set("Description", $quizData['quizDescription']);
        $quiz->__set("CommentsEnabled", isset($quizData['commentsEnabled']));
        $quiz->__set("IsPublic", isset($quizData['isPublic']));
        $quiz->__set("AuthorId", $quizData['authorId']);


        return $quiz;
    }

    private function constructQuizWithoutQuestions(Quiz $quiz):Quiz{
        $quiz->setQuizId($quiz->getPrimaryKey());
        $quiz->setName($quiz->__get("Name"));
        $quiz->setDescription($quiz->__get("Description"));
        $quiz->setCommentsEnabled($quiz->__get("CommentsEnabled"));
        $quiz->setIsPublic(($quiz->__get("IsPublic")));
        $quiz->setAuthor(ServiceContainer::get("UserService")->loadUserById($quiz->__get("AuthorId")));

        return $quiz;
    }

    private function constructQuizFull(Quiz $quiz){
        $quiz = $this->constructQuizWithoutQuestions($quiz);
        $quiz->setQuestions(ServiceContainer::get("QuestionService")->getQuizQuestions($quiz->getQuizId()));

        return $quiz;
    }

    private function validateQuizData(array $quizData):bool{
        $isValid = true;

        return $isValid;
    }

    public function getQuiz(string $id): ?Quiz
    {
        return $this->constructQuizFull($this->quizRepository->getQuiz($id));
    }


    public function getAll(): array
    {
        $quizzes = $this->quizRepository->getAll();
        $constructed = [];
        foreach($quizzes as $quiz){
            $constructed[] = $this->constructQuizWithoutQuestions($quiz);
        }

        return $constructed;
    }

    public function getAllByAuthor(int $authorId): array
    {
        $arr =  $this->quizRepository->getAllByAuthorId($authorId);
        $constructed = [];
        foreach($arr as $quiz){
            $constructed[] = $this->constructQuizWithoutQuestions($quiz);
        }

        return $constructed;
    }

    public function getAllByAuthorIUserName(string $authorUserName): array
    {
        // TODO: Implement getAllByAuthorIUserName() method.
    }

    private function getQuestionForSolvedQuiz(string $key): Question{
        if (strpos($key, "&") !== false){
            $questionId = explode("&", $key)[0];
        }else{
            $questionId = $key;
        }

        return ServiceContainer::get("QuestionService")->getQuestionById(intval($questionId));
    }

    private function getChoiceSolvedQuiz(string $key):Choice{
        $choiceId = explode("&", $key)[1];
        return ServiceContainer::get("ChoiceService")->getChoiceById(intval($choiceId));
    }

    private function gradeFillInQuestion($userAnswer, $correctAnswer): float{

        if (strcasecmp($correctAnswer, $userAnswer) === 0) {
            return 1;
        }
        else {
            similar_text($correctAnswer, $userAnswer, $percentage);
            if ($percentage >= 90){
                return 1;
            }else if ($percentage >= 70){
               return 0.5;
            }else{
                return 0;
            }
        }
    }

    private function updateUserAnswerCorrectAnswer(array &$userAnswerCorrectAnswer, int $questionId,
                                                                    $userAnswers, $correctAnswers){
        $userAnswerStr = '';
        $correctAnswerStr = '';
        foreach($userAnswers as $userAnswer){
            $userAnswerStr .= $userAnswer . ' ';
        }
        foreach($correctAnswers as $correctAnswer){
            $correctAnswerStr .= $correctAnswer . ' ';
        }

        $userAnswerCorrectAnswer[$questionId] = [
            "userAnswer" => $userAnswerStr,
            "correctAnswer" => $correctAnswerStr
        ];
    }

    public function getQuizResults(array $solvedQuizData, bool $isLoggedIn): array
    {
        $correct = 0;
        $multiAnswers = [];
        $correctAnswerUserAnswer = [];

        $quizId = $solvedQuizData['quizId'];
        $quiz = $this->getQuiz($quizId);

        foreach($solvedQuizData as $key => $value){
            if ($key == 'quizId') continue;

            $question = $this->getQuestionForSolvedQuiz($key);
            if ($question->getType() === Types::FILL_IN){
                $userAnswer = $value;
                $correctAnswer = $question->getCorrectChoices()[0];
                $correct += $this->gradeFillInQuestion($userAnswer, $correctAnswer->getText());

                $this->updateUserAnswerCorrectAnswer($correctAnswerUserAnswer, $question->getId(),
                                                            [$userAnswer], [$correctAnswer->getText()]);

            }else if ($question->getType() === Types::MULTI_ONE){
                $choice = ServiceContainer::get("ChoiceService")->getChoiceById(intval($value));
                if ($choice->getIsCorrect() == 1){
                    $correct++;
                }

                $this->updateUserAnswerCorrectAnswer($correctAnswerUserAnswer, $question->getId(),
                                                        [$choice->getText()], [$question->getCorrectChoices()[0]->getText()]);
            }else{
                $choice =  $this->getChoiceSolvedQuiz($key);
                $multiAnswers[$question->getId()][] = $choice->getId();
            }
        }
        $correct += $this->getPointsForMulti($multiAnswers, $correctAnswerUserAnswer);

        $results = $this->getResults($quiz->getQuestions(), $correctAnswerUserAnswer, $correct);

        if ($isLoggedIn == true){
            ServiceContainer::get("StatisticsService")->saveStatistic(getSessionData('userId'), $quizId,
                                                                    $results['percentage'], new \DateTime());
        }

        return $results;
    }

    private function getResults(array $quizQuestions, array $correctAnswerUserAnswer, float $points){
        $results = [];

        foreach($quizQuestions as $question){
            $answers[$question->getText()] = [
                "userAnswer" =>
                    isset($correctAnswerUserAnswer[$question->getId()]) ? $correctAnswerUserAnswer[$question->getId()]["userAnswer"] : "User didn't input",
                "correctAnswer" => implode(",", array_map(function($choice){
                    return $choice->getText();
                }, $question->getCorrectChoices()))];
        }

        $results['points'] = $points;
        $results['percentage'] = $this->calculatePercentage($points, count($quizQuestions));
        $results["answers"] = $answers;

        return $results;
    }

    private function calculatePercentage(float $correctNum, int $totalNum):float{
        return $correctNum/$totalNum * 100;
    }

    private function getPointsForMulti(array $multiAnswers, array &$userAnswerCorrectAnswer):int{

        $points = 0;
        foreach($multiAnswers as $questionId => $choicesIds){
            $question = ServiceContainer::get("QuestionService")->getQuestionById(intval($questionId));

            $noOfCorrectChoices = count($question->getCorrectChoices());
            $noOfUserCorrectChoices = 0;

            $choices = [];
            foreach($choicesIds as $choiceId){
                $choices[] = ServiceContainer::get("ChoiceService")->getChoiceById(intval($choiceId));
            }
            $textUserChoices = array_map(function($choice) {return $choice->getText(); }, $choices);
            $textCorrectChoices = array_map(function($choice) {return $choice->getText();}, $question->getCorrectChoices());

            $this->updateUserAnswerCorrectAnswer($userAnswerCorrectAnswer, intval($questionId),
                                                    $textUserChoices, $textCorrectChoices);

            foreach($choices as $choice){
                if ($choice->getIsCorrect() == 1) $noOfUserCorrectChoices++;
            }
            if ($noOfUserCorrectChoices === $noOfCorrectChoices){
                $points += 1;
            }else if($noOfUserCorrectChoices = $noOfCorrectChoices-1 && $noOfUserCorrectChoices !== 1){
                $points += 0.5;
            }
        }

        return $points;
    }

    public function getAllNotByAuthor(int $authorId): ?array
    {
        $all = $this->getAll();
        $byAuthor = $this->getAllByAuthor($authorId);
        $notByAuthor = [];

        foreach($all as $quiz){
            if (!in_array($quiz, $byAuthor)){
                $notByAuthor[] = $quiz;
            }
        }

        return $notByAuthor;
    }
}