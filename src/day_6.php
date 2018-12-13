<?php
namespace AoC;

ini_set('memory_limit', '1556M');
//error_reporting(0);

class Coord
{
    private $coords = [];
    private $grid_x = 0;
    private $grid_y = 0;
    const FILE_PATH = __DIR__ . '/resources/locations_list.txt';

    public function __construct()
    {
        $locations = file(self::FILE_PATH, FILE_IGNORE_NEW_LINES) or die("File is not found");
        $pattern = '/(\d+),\s(\d+)/';

        foreach ($locations as $item) {
             preg_match($pattern, $item, $matches);
             $this->coords[] = ["x" => $matches[1], "y" => $matches[2]];
        }

        // Determine the size of the grid
        $this->grid_x = max(array_column($this->coords, "x"));
        $this->grid_y = max(array_column($this->coords, "y"));
    }

    public function sizeOfLargestArea()
    {
        $distances = [];
        for ($i=0; $i <= $this->grid_x; $i++) {
            for ($j=0; $j <= $this->grid_y; $j++) {
                foreach ($this->coords as $point) {
                    //$distPoint = self::caclManhattanDistance($point, ["x" => $i, "y" => $j]);
                    $distPoint = abs($point["x"] - $i) + abs($point["y"] - $j);
                    //echo $distPoint;
                    //if ($distPoint < $distances[$i][$j])
                    $distances[] = [$point, $distPoint];
        //print_r($distances);
                    //die();
                }
            }
        }
        //print_r($distances);
        die();
    }

    private function caclManhattanDistance($point1, $point2)
    {
        return abs($point1["x"] - $point2["x"]) + abs($point1["y"] - $point2["y"]);
    }
}

$obj = new Coord();
echo "Size of largest area equals " . $obj->sizeOfLargestArea();
