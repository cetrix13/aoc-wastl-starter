<?php
namespace AoC;

error_reporting(0);

/**
 * Guard Duty
 */
class GuardDuty
{
    private $list = [];
    const FILE_PATH = __DIR__ . '/resources/guardDuty_list.txt';

    public function __construct()
    {
        $this->list = file(self::FILE_PATH, FILE_IGNORE_NEW_LINES) or die('File is not found');
    }

    public function sortInput()
    {
        $pattern = '/(\d{4}-\d{2}-\d{2})\s(\d{2}):(\d{2})\]\s(.*)/';
        $matches = [];
        $sortedList = [];

        foreach ($this->list as $item) {
            preg_match($pattern, $item, $matches);
            array_push($sortedList, ["date" => $matches[1], "h" => $matches[2], "m"=> $matches[3], "s" => $matches[4]]);
        }

        $dates = [];
        $hours = [];
        $minutes = [];
        foreach ($sortedList as $key => $row) {
            $hours[$key] = $row['h'];
            $dates[$key] = $row['date'];
            $minutes[$key] = (int)$row['m'] + (int)$row['h'];
        }
        array_multisort($dates, SORT_ASC, $minutes, SORT_ASC, $sortedList);

        return $sortedList;
    }

    public function findMostSleepingGuard($dutyList)
    {
        $guardID = "";
        $start = 0;
        $guards = [];

        foreach ($dutyList as $item) {
            switch (true) {
                case preg_match('/Guard (#\d+) begins shift/', $item['s'], $matches):
                    $guardID = $matches[1];
                    break;
                case preg_match('/falls asleep/', $item['s']):
                    $start = $item['m'];
                    break;
                case preg_match('/wakes up/', $item['s']):
                    $end = $item['m'];
                    foreach (range($start, $end - 1) as $minute) {
                        $sleepMatrix[$guardID][$minute] +=1;
                    }
                    break;
            }
        }

        // find the minute the guard slept the most
        $guardID = 0;
        $sleepMinute = 0;
        foreach ($sleepMatrix as $key => $val) {
            foreach ($val as $minute => $counter) {
                if ($counter > $max) {
                    $guardID = $key;
                    $sleepMinute = $minute;
                    $max = $counter;
                }
            }
        }

        return $guardID . " (the most slept minute  = ". $sleepMinute . ")";
    }
}

echo "The guard who was sleeping the most has ID = " . $obj->findMostSleepingGuard($obj->sortInput());
