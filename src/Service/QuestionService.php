<?php


namespace src\Service;



use MongoDB\BSON\Type;
use src\Interfaces\IQuestionRepository;
use src\Interfaces\IQuestionService;
use src\Model\AbstractClasses\Types;
use src\Model\Choice;
use src\Model\Question;

class QuestionService implements IQuestionService
{
    private IQuestionRepository $questionRepository;

    public function __construct(IQuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function saveQuestionsFromFile(array $fileData, string $quizId): int
    {
        $fileContents = file_get_contents($fileData['quizFile']['tmp_name']);
        return $this->saveQuestionsFromText($fileContents, $quizId);
    }

    public function saveQuestionsFromText(string $text, string $quizId): int
    {
        $questions = [];
        $lines = getLinesFromText($text);
        foreach($lines as $line){
            $question = $this->createQuestionFromString($line, $quizId);
            $questions[] = $question;
        }

        for($i = 0; $i < count($questions); $i++){
            $questionId = $this->questionRepository->saveQuestion($questions[$i]);
            if ($questionId < 0) return -1;

            ServiceContainer::get("ChoiceService")->saveChoiceFromString($lines[$i], $questions[$i]->getPrimaryKey(),
                                    $questions[$i]->__get("Type"));

        }

        return 0;
    }

    public function getQuizQuestions(string $quizId):array{
        $questions = $this->questionRepository->getAllByQuizId($quizId);
        $constructed = [];
        foreach($questions as $question){
            $constructed[] = $this->constructQuestion($question);
        }

        return $constructed;
    }

    private function constructQuestion(Question $question){
        $question->setId($question->getPrimaryKey());
        $question->setText($question->__get("Text"));
        $question->setChoices(ServiceContainer::get("ChoiceService")->getChoicesByQuestionId($question->getId()));

        $type = $question->__get("Type");
        if ($type === '1'){
            $question->setType(Types::MULTI_ONE);
        }else if ($type === '2'){
            $question->setType(Types::MULTI_MULTI);
        }else{
            $question->setType(Types::FILL_IN);
        }


        return $question;
    }

    private function createQuestionFromString(string $line, string $quizId): Question{
        $question = new Question();
        $questionText = explode(":", $line)[0];
        $question->__set("Text", $questionText);

        $choicesAndAnswers = explode(":", $line)[1];
        $chAndAnswersArr = explode("=", $choicesAndAnswers);

        $choices = explode(",", $chAndAnswersArr[0]);
        $answers = explode(",", $chAndAnswersArr[1]);

        if ($choices[0] == ''){
            $type = Types::FILL_IN;
        } else if(count($answers) == 1 ){
            $type = Types::MULTI_ONE;
        }
        else{
            $type = Types::MULTI_MULTI;
        }
        $question->__set("Type", $type);
        $question->__set("QuizId", $quizId);

        return $question;
    }

    public function getQuestionById(int $questionId){
        return $this->constructQuestion($this->questionRepository->getQuestionById($questionId));
    }

}