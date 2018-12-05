<?php
namespace AoC;

class FrequencyCalc
{
    private $list = [];
    const FILE_PATH = __DIR__ . "/resourses/frequency_list.txt";

    public function __construct()
    {
        $this->list = file(self::FILE_PATH, FILE_IGNORE_NEW_LINES) or die('File not found');
    }

    /**
     * @return integer
     */
    public function calculate()
    {
        $sum = 0;
        foreach ($this->list as $item) {
            $sum += $item;
        }
        return $sum;
    }

    /**
     * @return integer
     */
    public function reachedTwiceFrequency()
    {
        $uniqueFrequences = [0];
        $freqValue = 0;

        while (true) {
            foreach ($this->list as $item) {
                $freqValue += $item;
                if (!in_array($freqValue, $uniqueFrequences)) {
                    array_push($uniqueFrequences, $freqValue);
                } else {
                    return $freqValue;
                }
            }
        }
    }
}

$obj = new FrequencyCalc();
echo "Resulting frequency equals ". $obj->calculate(). "\n";
echo "First frequency that was reached twice is ". $obj->reachedTwiceFrequency() ."\n";
