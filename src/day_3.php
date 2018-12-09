<?php
namespace AoC;

error_reporting(0);
class Sheet
{
    private $list = [];
    private $overlaped = [];
    const FILE_PATH = __DIR__ . "/resources/claims_list.txt";

    public function __construct()
    {
        $this->list = file(self::FILE_PATH, FILE_IGNORE_NEW_LINES) or die("File is not found");
    }

    /**
     * @return array
     */
    public function parseInput()
    {
        $matches = [];
        $assoc_list = [];
        $pattern = '/(^#\d+)\s@\s(\d+),(\d+):\s+(\d+)x(\d+)/';

        foreach ($this->list as $item) {
            preg_match($pattern, $item, $matches);
            array_push($assoc_list, array("id" => $matches[1], "x" => $matches[2], "y" => $matches[3],
                "w" => $matches[4], "h" => $matches[5]));
        }
        return $assoc_list;
    }

    /**
     * @param  array
     * @return integer
     */
    public function countOverlaps($claims)
    {
        $totalAreaOverlaps = 0;

        foreach ($claims as $claim) {
            foreach (range(1, $claim['w']) as $xi) {
                foreach (range(1, $claim['h']) as $yi) {
                    $this->overlaped[$claim['x'] + $xi][$claim['y'] + $yi] += 1;
                }
            }
        }

        // filter through coordinates to find overlaps
        foreach ($this->overlaped as $arr1) {
            foreach ($arr1 as $val) {
                if ($val > 1) {
                    $totalAreaOverlaps += 1;
                }
            }
        }

         return $totalAreaOverlaps;
    }

    /**
     * @param  array
     * @return string
     */
    public function findClaimWithoutOverlaps($claims)
    {
        $all_claims_ids = [];
        $overlaped_claims_ids = [];

        foreach ($claims as $claim) {
            array_push($all_claims_ids, $claim['id']);
            foreach (range(1, $claim['w']) as $xi) {
                foreach (range(1, $claim['h']) as $yi) {
                    if ($this->overlaped[$claim['x'] + $xi][$claim['y'] + $yi] > 1) {
                        array_push($overlaped_claims_ids, $claim['id']);
                    }
                }
            }
        }

        return current(array_diff($all_claims_ids, $overlaped_claims_ids));
    }
}

$obj = new Sheet();
echo "Total area of overlaps is " . $obj->countOverlaps($obj->parseInput()) . " inches \n";
echo "Claim without overlaps has id = " . $obj->findClaimWithoutOverlaps($obj->parseInput()) . "\n";
