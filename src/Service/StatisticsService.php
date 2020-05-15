<?php


namespace src\Service;


use Cassandra\Date;
use DateTime;
use src\Interfaces\IStatisticsRepository;
use src\Interfaces\IStatisticsService;
use src\Model\Statistic;
use src\Model\ViewStatistic;

class StatisticsService implements IStatisticsService
{
    private IStatisticsRepository $statisticsRepository;

    public function __construct(IStatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function saveStatistic(int $solverId, string $solvedQuizid, float $percentage, DateTime $solveDate)
    {
        $statistic = new Statistic();
        $statistic->__set('SolverId', $solverId);
        $statistic->__set('QuizId', $solvedQuizid);
        $statistic->__set('AttemptNumber', 1);
        $statistic->__set('Percentage', $percentage);
        $statistic->__set('SolveDate', $solveDate->format('Y-m-d H:i:s'));

        $this->statisticsRepository->saveStatistic($statistic);

    }

    public function getStatisticById(int $id): ?Statistic
    {
        // TODO: Implement getStatisticById() method.
    }

    public function getStatisticsForUser(int $userId): array
    {
        $statistic = new Statistic();
        $all = $statistic->loadAll("where solverId = '$userId'");
        if ($all) {
            return $this->constructStatisticsShallow($all);
        } else {
            return null;
        }
    }

    private function constructStatisticsShallow(array $statistics): array{
        $constructed = [];
        foreach($statistics as $statistic){
            $constructed[] = $this->constructStatisticShallow($statistic);
        }
        return $constructed;
    }

    private function constructStatisticShallow(Statistic $statistic): Statistic{
        $statistic->setSolveDate(new DateTime($statistic->__get("SolveDate")));
        $statistic->setPercentage($statistic->__get("Percentage"));
        $statistic->setId($statistic->getPrimaryKey());
        $statistic->setAttemptNumber($statistic->__get("AttemptNumber"));
        $statistic->setQuizSolved(ServiceContainer::get("QuizService")->getQuizByIdShallow($statistic->__get("QuizId")));

        return $statistic;
    }

    public function getViewStatisticsForUser(int $userId):array{
        $statistics = $this->getStatisticsForUser($userId);

        $viewStatistics = [];
        $avgAndCnt = $this->getAveragePercentagesAndCounts($statistics);

        $averages = $avgAndCnt['averages'];
        $counts = $avgAndCnt['counts'];

        foreach(array_keys($counts) as $quizName){
            $viewStatistic = new ViewStatistic();
            $viewStatistic->setAveragePercentage($averages[$quizName]);
            $viewStatistic->setNumberOfAttempts($counts[$quizName]);
            $viewStatistic->setQuizName($quizName);
            $viewStatistics[] = $viewStatistic;
        }

        return $viewStatistics;
    }


    private function getAveragePercentagesAndCounts(array $statistics) : array{
        $sums = [];
        $counts = [];
        $names = [];
        foreach($statistics as $statistic){
            $quizName = $statistic->getQuizSolved()->getName();
            if (!in_array($quizName, $names)) $names[] = $quizName;
            isset($counts[$quizName]) ? $counts[$quizName]++ : $counts[$quizName] = 1;
            isset($sums[$quizName]) ? $sums[$quizName]+=$statistic->getPercentage() : $sums[$quizName] = $statistic->getPercentage();
        }

        $averages=[];
        for($i = 0; $i < count($sums); $i++){
            $averages[$names[$i]] = $sums[$names[$i]] / $counts[$names[$i]];
        }
     
        return ["averages"=>$averages, "counts"=>$counts];
    }


    private function constructStatistics(array $statistics): array{
        $constructed = [];
        foreach($statistics as $statistic){
            $constructed[] = $this->constructStatistic($statistic);
        }
        return $constructed;
    }

    private function constructStatistic(Statistic $statistic): Statistic{
        $statistic->setId($statistic->__get("Id"));
        $statistic->setQuizSolved(ServiceContainer::get("QuizService")->getQuiz($statistic->__get("QuizId")));
        $statistic->setSolver(ServiceContainer::get("UserService")->loadUserById($statistic->__get("SolverId")));
        $statistic->setPercentage($statistic->__get("Percentage"));
        try {
            $statistic->setSolveDate(new DateTime($statistic->__get("SolveDate")));
        } catch (\Exception $e) {
        }

        return $statistic;
    }

    public function getStatisticForUserAndQuiz(int $userId, string $quizId): array
    {
        // TODO: Implement getStatisticForUserAndQuiz() method.
    }
}