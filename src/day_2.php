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
}

$obj = new Checksum();
echo "Checksum of boxs' IDs equals " . $obj->checksumCalc();
