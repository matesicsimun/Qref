<?php


namespace src\Model;


use src\Model\AbstractClasses\AbstractDBModel;

class Statistic extends AbstractDBModel
{
    private int $id;

    private User $solver;

    private Quiz $quizSolved;

    private float $percentage;

    private \DateTime $solveDate;

    private int $attemptNumber;

    public function getPrimaryKeyColumn()
    {
        return "Id";
    }

    public function getTable()
    {
        return "statistics";
    }

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
     * @return User
     */
    public function getSolver(): User
    {
        return $this->solver;
    }

    /**
     * @param User $solver
     */
    public function setSolver(User $solver): void
    {
        $this->solver = $solver;
    }

    /**
     * @return Quiz
     */
    public function getQuizSolved(): Quiz
    {
        return $this->quizSolved;
    }

    /**
     * @param Quiz $quizSolved
     */
    public function setQuizSolved(Quiz $quizSolved): void
    {
        $this->quizSolved = $quizSolved;
    }

    /**
     * @return float
     */
    public function getPercentage(): float
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     */
    public function setPercentage(float $percentage): void
    {
        $this->percentage = $percentage;
    }

    /**
     * @return \DateTime
     */
    public function getSolveDate(): \DateTime
    {
        return $this->solveDate;
    }

    /**
     * @param \DateTime $solveDate
     */
    public function setSolveDate(\DateTime $solveDate): void
    {
        $this->solveDate = $solveDate;
    }

    /**
     * @return int
     */
    public function getAttemptNumber(): int
    {
        return $this->attemptNumber;
    }

    /**
     * @param int $attemptNumber
     */
    public function setAttemptNumber(int $attemptNumber): void
    {
        $this->attemptNumber = $attemptNumber;
    }

    public function getColumns()
    {
        return ["SolverId", "QuizId", "Percentage", "SolveDate", "AttemptNumber"];
    }
}