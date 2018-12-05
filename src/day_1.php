<?php
namespace AoC;

class FrequencyCalc
{
    private $list = [];

    public function __construct($filePath)
    {
        $this->list = file($filePath, FILE_IGNORE_NEW_LINES) or die('File not found');
    }

    public function calculate()
    {
        foreach ($this->list as $item) {
            $sum += $item;
        }
        return $sum;
    }

    public function reachedTwiceFrequency()
    {
        $listUniqueFrequences = [0];
        $freqValue = 0;

        while (true) {
            foreach ($this->list as $item) {
                $freqValue += $item;
                if (!in_array($freqValue, $listUniqueFrequences)) {
                    array_push($listUniqueFrequences, $freqValue);
                } else {
                    return $freqValue;
                }
            }
        }
    }
}

$obj = new FrequencyCalc(__DIR__ . "/resourses/frequency_list.txt");
echo "Resulting frequency equals ". $obj->calculate(). "\n";
echo "First frequency that reached twice is ". $obj->reachedTwiceFrequency() ."\n";
