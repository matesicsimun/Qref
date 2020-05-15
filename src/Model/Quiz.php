<?php


namespace src\Model;

use src\Model\AbstractClasses\AbstractDBModel;

/**
 * Class Quiz
 * Models a quiz that contains questions.
 * One important note: this is the only model which has a string id.
 * @package src\Model
 */
class Quiz extends AbstractDBModel
{
    private string $quizId;

    private User $author;

    private string $name;

    private string $description;

    private string $commentsEnabled;

    private string $isPublic;

    private int $timeLimit = 5 * 60;

    private array $comments;

    private array $questions;

    /**
     * @return int
     */
    public function getTimeLimit(): int
    {
        return $this->timeLimit;
    }

    /**
     * @param int $timeLimit
     */
    public function setTimeLimit(int $timeLimit): void
    {
        $this->timeLimit = $timeLimit;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getQuizId(): string
    {
        return $this->quizId;
    }

    /**
     * @param string $quizId
     */
    public function setQuizId(string $quizId): void
    {
        $this->quizId = $quizId;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCommentsEnabled(): string
    {
        return $this->commentsEnabled;
    }

    /**
     * @param string $commentsEnabled
     */
    public function setCommentsEnabled(string $commentsEnabled): void
    {
        $this->commentsEnabled = $commentsEnabled;
    }

    /**
     * @return string
     */
    public function getIsPublic(): string
    {
        return $this->isPublic;
    }

    /**
     * @param string $isPublic
     */
    public function setIsPublic(string $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param array $questions
     */
    public function setQuestions(array $questions): void
    {
        $this->questions = $questions;
    }


    public function getPrimaryKeyColumn()
    {
        return "QuizId";
    }

    public function getTable()
    {
        return "quizes";
    }

    public function getColumns()
    {
        return ["QuizId", "AuthorId", "Name", "Description", "CommentsEnabled", "IsPublic", "TimeLimit"];
    }
}