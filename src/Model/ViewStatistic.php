<?php


namespace src\Model;


class ViewStatistic
{
    private string $quizName;
    private float $averagePercentage;
    private int $numberOfAttempts;

    /**
     * @return string
     */
    public function getQuizName(): string
    {
        return $this->quizName;
    }

    /**
     * @param string $quizName
     */
    public function setQuizName(string $quizName): void
    {
        $this->quizName = $quizName;
    }

    /**
     * @return float
     */
    public function getAveragePercentage(): float
    {
        return $this->averagePercentage;
    }

    /**
     * @param float $averagePercentage
     */
    public function setAveragePercentage(float $averagePercentage): void
    {
        $this->averagePercentage = $averagePercentage;
    }

    /**
     * @return int
     */
    public function getNumberOfAttempts(): int
    {
        return $this->numberOfAttempts;
    }

    /**
     * @param int $numberOfAttempts
     */
    public function setNumberOfAttempts(int $numberOfAttempts): void
    {
        $this->numberOfAttempts = $numberOfAttempts;
    }

}