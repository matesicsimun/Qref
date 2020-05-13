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

    public function getChoicesByQuestionId(int $questionId): array
    {
        $arr = $this->choiceRepository->getChoicesByQuestionid($questionId);
        $constructed = [];
        foreach($arr as $choice){
            $constructed[] = $this->constructChoice($choice);
        }
        return $constructed;
    }
}