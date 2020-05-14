<?php


namespace src\Interfaces;


use DateTime;
use src\Model\Statistic;

interface IStatisticsService
{
    public function saveStatistic(int $solverId, string $solvedQuizid, float $percentage, DateTime $solveDate);

    public function getStatisticById(int $id) :?Statistic;

    public function getStatisticsForUser(int $userId) :array;

    public function getStatisticForUserAndQuiz(int $userId, string $quizId):array;
    public function getViewStatisticsForUser(int $userId):array;
}