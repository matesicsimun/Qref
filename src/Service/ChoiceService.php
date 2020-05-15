<?php


namespace src\Service;


use src\Interfaces\IChoiceRepository;
use src\Interfaces\IChoiceService;
use src\Model\AbstractClasses\Types;
use src\Model\Choice;

class ChoiceService implements IChoiceService
{
    private IChoiceRepository $choiceRepository;

    public function __construct(IChoiceRepository $choiceRepository)
    {
        $this->choiceRepository = $choiceRepository;
    }

    public function saveChoice(Choice $choice){
        $this->choiceRepository->saveChoice($choice);
    }

    private function getChoiceByQuestionAndText(int $questionId, string $text) : ?Choice{
        $choices = $this->choiceRepository->getChoicesByQuestionid($questionId);
        foreach($choices as $choice){
            if ($choice->getText() == $text){
                return $choice;
            }
        }
        return null;
    }

    public function saveChoiceFromString(string $line, int $questionId, int $type): int
    {
        $choicePart = explode(":", $line)[1];
        $choicesAndAnswers = explode("=", $choicePart);

        $answers = explode(",", $choicesAndAnswers[1]);
        $choices = explode(",", $choicesAndAnswers[0]);

        if ($type === Types::FILL_IN){
            $choice = new Choice();
            $choice->__set("QuestionId", $questionId);
            $choice->__set("IsCorrect", true);
            $choice->__set("Text", $answers[0]);

            if($this->choiceRepository->saveChoice($choice) < 0){
                return -1;
            }
            return 0;
        }

        foreach($choices as $choiceStr){

            $choice = new Choice();
            $choice->__set("QuestionId", $questionId);
            if (in_array($choiceStr, $answers)){
                $choice->__set("IsCorrect", true);
            }else{
                $choice->__set("IsCorrect", false);
            }
            $choice->__set("Text", $choiceStr);

            if($this->choiceRepository->saveChoice($choice) < 0){
                return -1;
            }
        }

        return 0;
    }

    private function constructChoice(Choice $choice){
        $choice->setText($choice->__get("Text"));
        $choice->setId($choice->getPrimaryKey());
        $choice->setIsCorrect($choice->__get("IsCorrect"));

        return $choice;
    }

    public function saveChoices(array $choices){
        foreach($choices as $choice){
            $this->saveChoice($choice);
        }
    }

    public function getChoiceById(int $choiceId):Choice{
        return $this->constructChoice($this->choiceRepository->getChoiceById($choiceId));
    }

    public function getChoicesByQuestionId(int $questionId): array
    {
        $arr = $this->choiceRepository->getChoicesByQuestionid($questionId);
        $constructed = [];
        if (!$arr) return array();

        foreach($arr as $choice){
            $constructed[] = $this->constructChoice($choice);
        }
        return $constructed;
    }

    public function deleteFillInChoice(int $questionId)
    {
        $choices = $this->choiceRepository->getChoicesByQuestionid($questionId);
        $choice = $choices[0];

        $this->choiceRepository->deleteChoice($choice->getPrimaryKey());
    }

    public function createAndSave(int $questionId, string $text, bool $isCorrect)
    {
        $choice = new Choice();
        $choice->__set("Text", $text);
        $choice->__set("QuestionId", $questionId);
        $choice->__set("IsCorrect", true);

        $this->choiceRepository->saveChoice($choice);
    }
}