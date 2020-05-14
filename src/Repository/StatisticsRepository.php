<?php


namespace src\Repository;


use src\Interfaces\IStatisticsRepository;
use src\Model\Statistic;

class StatisticsRepository implements  IStatisticsRepository
{

    public function saveStatistic(Statistic $statistic)
    {
        try{
            $statistic->save();
        } catch(\PDOException $e){

        }
    }

    public function getById(int $id) : Statistic
    {
        try {
            $statistic = new Statistic();
            $statistic->load($id);
            return $statistic;
        } catch (\PDOException $e){

        }
    }

    public function getByUserId(int $userId) : array
    {
        try{
            $statistic = new Statistic();
            return $statistic->loadAll("where solverId = '$userId'");
        } catch (\PDOException $e){

        }
    }

    public function getByUserIdAndQuizId(int $userId, string $quizId): ?Statistic
    {
        try{
            $statistic = new Statistic();
            $arr =  $statistic->loadAll("where solverId = '$userId' AND quizId = '$quizId'");
            if ($arr){
                return $arr[0];
            }else{
                return null;
            }
        } catch (\PDOException $e){

        }
    }
}