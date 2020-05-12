<?php


namespace src\Model;

use src\Model\AbstractClasses\AbstractDBModel;

/**
 * Class Choice
 * Models a choice for a question.
 * It contains text which is the content of the
 * choice, and also contains a flag which indicates
 * if it is a correct choice.
 * @package src\Model
 */
class Choice extends AbstractDBModel
{
    private int $id;

    private Question $question;

    private string $text;

    private bool $isCorrect;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * @param bool $isCorrect
     */
    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
    }

    public function getPrimaryKeyColumn()
    {
        return "Id";
    }

    public function getTable()
    {
        return "choices";
    }

    public function getColumns()
    {
        return ["QuestionId", "Text", "IsCorrect"];
    }
}