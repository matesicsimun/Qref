<?php


namespace src\Model;


/**
 * Class UserAnswer
 * Models an choice (answer) from a specific user for a specific question.
 * @package src\Model
 */
class UserAnswer
{
    private User $user;

    private Question $question;

    private Choice $choice;

    private bool $isCorrect;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Question
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
     * @return Choice
     */
    public function getChoice(): Choice
    {
        return $this->choice;
    }

    /**
     * @param Choice $choice
     */
    public function setChoice(Choice $choice): void
    {
        $this->choice = $choice;
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


}