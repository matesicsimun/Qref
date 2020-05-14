<?php


namespace src\Repository;


use src\Interfaces\IChoiceRepository;
use src\Model\Choice;

class ChoiceRepository implements IChoiceRepository
{

    public function saveChoice(Choice $choice): int
    {
        try{
            $choice->save();
        } catch (\Exception $e){
            return -1;
        }

        return 0;
    }

    public function getChoiceById(int $choiceId): Choice{
        $choice = new Choice();
        $choice->load($choiceId);
        return $choice;
    }

    public function getChoicesByQuestionid(int $questionId): array
    {
        $choice = new Choice();
        return $choice->loadAll("where QuestionId = '$questionId'");
    }
}