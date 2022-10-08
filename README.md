This package is a simple package designed for measuring performance in Laravel applications.


## Installation

You can install the package via composer:

```bash
composer require web36/performance
```

## Usage 

### example

``` php

use web36\LaravelPerformance\Performance;

class PerformanceTest
{
    public function index()
    {

        $unit = Performance::getInstance();

        $counterKey1 = 'test_counter1';
        $counterKey2 = 'test_counter2';


        $unit->timeStart($counterKey1);

        // do something
        //example
        usleep(random_int(100, 100000));

        for ($i = 1; $i <= 5; $i++) {
            $unit->timeStart($counterKey2);
            // do something
            //example
            usleep(random_int(100, 100000));
            $unit->timeEnd($counterKey2);
        }

        $unit->timeEnd($counterKey1);

        // if you want to see total time for $counterKey1
        $counterKey1Time = $unit->getTotalTime($counterKey1);


        // if you want to see total time of all counters
        $totalTimes[] = $unit->getAllTotalTime();


        // if you want to see average time for $counterKey2
        $averageTime = $unit->getAverageTime($counterKey2);

        // if you want to see average time for all counters
        $averageTime = $unit->getAllAverageTime();


        // if you want to see all counters
        $allCounters = $unit->getAllCounters();

        // if you want to see all counters with average time
        $allCountersWithAverageTime = $unit->getAllCountersWithAverageTime();




}
```