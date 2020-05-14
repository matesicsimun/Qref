<?php


namespace src\Interfaces;


use src\Model\Statistic;

interface IStatisticsRepository
{
    public function saveStatistic(Statistic $statistic);
    public function getById(int $id):Statistic;
    public function getByUserIdAndQuizId(int $userId, string $quizId):?Statistic;
    public function getByUserId(int $userId):array;
}