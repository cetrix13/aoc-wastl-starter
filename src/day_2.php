<?php
namespace AoC;

class Checksum
{
    private $list;
    const FILE_PATH = __DIR__ . '/resources/boxIDs_list.txt';

    public function __construct()
    {
        $this->list = file(self::FILE_PATH, FILE_IGNORE_NEW_LINES) or die('File is not found');
    }

    /**
     * @return integer
     */
    public function checksumCalc()
    {
        $countDouble = 0;
        $countTripple = 0;

        foreach ($this->list as $item) {
            $isDoubleCounted = false;
            $isTrippleCounted = false;

            foreach (count_chars($item, 1) as $key => $count) {
                if ($count == 3 && !$isTrippleCounted) {
                    $countTripple++;
                    $isTrippleCounted = true;
                } elseif ($count == 2 && !$isDoubleCounted) {
                    $countDouble++;
                    $isDoubleCounted = true;
                }
            }
        }
        return $countDouble * $countTripple;
    }

    private function splitIntoLetters($arr)
    {
        $lettersList = [];

        foreach ($arr as $item) {
            array_push($lettersList, str_split($item));
        }
        return $lettersList;
    }

    public function findCorrectBoxes()
    {
        $correctBoxes = [];
        $lettersList = $this->splitIntoLetters($this->list);
        $length = count($lettersList);

        for ($i=0; $i < $length - 1; $i++) {
            for ($j = $i + 1; $j < $length; $j++) {
                $counter = 0;
                $countDifferences = 0;

                foreach ($lettersList[$i] as $letter) {
                    if ($letter != $lettersList[$j][$counter]) {
                        $countDifferences++;
                    }
                    $counter++;
                }
                if ($countDifferences == 1) {
                    array_push($correctBoxes, implode("", $lettersList[$i]));
                    array_push($correctBoxes, implode("", $lettersList[$j]));
                }
            }
        }
        return $correctBoxes;
    }

}

$obj = new Checksum();

echo "Checksum of boxs' IDs equals " . $obj->checksumCalc() . "\n";
echo "Two correct boxes are " . implode(",", $obj->findCorrectBoxes()) . "\n";

