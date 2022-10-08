<?php

namespace web36\LaravelPerformance;

final class Performance
{
    
    private static ?self $instance = null;
    private array $start = [];
    private array $iterationCount = [];
    private array $totalTime = [];
    private array $averageTime = [];

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function timeStart($key): void
    {
        if (!isset($this->iterationCount[$key])) {
            $this->iterationCount[$key] = 0;
            $this->totalTime[$key] = 0;
        }

        $this->iterationCount[$key] ++;

        $this->start[$key] = microtime(true);
    }

    public function timeEnd($key): void
    {
        $endTime = microtime(true);

        $this->totalTime[$key] += round($endTime - $this->start[$key], 3) * 1000;

        $this->averageTime[$key] = $this->totalTime[$key] / max($this->iterationCount[$key], 1);
    }

    public function getAverageTime($key)
    {
        return $this->averageTime[$key];
    }

    public function clearKey($key): void
    {
        unset(
            $this->start[$key],
            $this->iterationCount[$key],
            $this->totalTime[$key],
            $this->averageTime[$key]
        );
    }

    public function reset(): void
    {
        $this->start = [];
        $this->iterationCount = [];
        $this->totalTime = [];
        $this->averageTime = [];
    }

    public function getKeys(): array
    {
        return array_keys($this->iterationCount);
    }

    public function getTotalTime($key): float
    {
        return $this->totalTime[$key];
    }

    public function getAllTotalTime(): array
    {
        return $this->totalTime;
    }

    public function getAllCounters(): array
    {
        return $this->iterationCount;
    }

    public function getAllAverageTime(): array
    {
        return $this->averageTime;
    }
    
    public function getAllCountersWithAverageTime(){
        $result = [];
        foreach($this->iterationCount as $key => $value){
            $result[$key] = [
                'count' => $value,
                'average' => $this->averageTime[$key],
            ];
        }
        return $result;
    }
}