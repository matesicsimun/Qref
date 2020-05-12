<?php


namespace src\Service;


use src\Interfaces\IQuizRepository;
use src\Interfaces\IQuizService;
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

    private function validateQuizData(array $quizData):bool{
        $isValid = true;

        return $isValid;
    }

    public function getQuiz(int $id): ?Quiz
    {
        // TODO: Implement getQuiz() method.
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function getAllByAuthor(int $authorId): array
    {
        // TODO: Implement getAllByAuthor() method.
    }

    public function getAllByAuthorIUserName(string $authorUserName): array
    {
        // TODO: Implement getAllByAuthorIUserName() method.
    }
}