<?php
namespace AoC;

ini_set('memory_limit', '1256M'); // large size of $matrix, need to optimize later
error_reporting(0);

class Coord
{
    private $coords = [];
    private $grid_max_x = 0;
    private $grid_max_y = 0;
    private $grid_min_x = 0;
    private $grid_min_y = 0;
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
        $this->grid_max_x = max(array_column($this->coords, "x"));
        $this->grid_max_y = max(array_column($this->coords, "y"));
        $this->grid_min_x = min(array_column($this->coords, "x"));
        $this->grid_min_y = min(array_column($this->coords, "y"));
    }

    public function sizeOfLargestArea()
    {
        for ($i = $this->$grid_min_x; $i <= $this->grid_max_x; $i++) {
            for ($j = $this->grid_min_y; $j <= $this->grid_max_y; $j++) {
                $distances = [];
                foreach ($this->coords as $point) {
                    $distPoint = self::caclManhattanDistance($point, ["x" => $i, "y" => $j]);
                    $distances[] = [$point, $distPoint];
                }
                // check distances for duplicates, return unique
                $matrix[$i][$j] = self::checkDuplicates($distances);
            }
        }

        $exclude = [];
        for ($i = $this->$grid_min_x; $i <= $this->grid_max_x; $i++){
            for ($j=$this->grid_min_y; $j <= $this->grid_max_y; $j++) {
                // if point is on the edge of the grid, then the area is infinity
                if ($i == $this->grid_min_x || $i == $this->grid_max_x || $j == $this->grid_min_y || $j == $this->grid_max_y) {
                    if (!in_array($matrix[$i][$j], $exclude)) {
                        array_push($exclude, $matrix[$i][$j]);
                    }
                }
                if (in_array($matrix[$i][$j], $exclude)) {
                    unset($matrix[$i][$j]);
                } else {
                    $notInfinityAreas[$matrix[$i][$j]['x']][$matrix[$i][$j]['y']] += 1;
                }
            }
        }

        $largestArea = 0;
        foreach ($notInfinityAreas as $value) {
            foreach($value as $v) {
                if ($v > $largestArea) {
                    $largestArea = $v;
                }
            }
        }

        return $largestArea;
    }

    private function caclManhattanDistance($point1, $point2)
    {
        return abs($point1["x"] - $point2["x"]) + abs($point1["y"] - $point2["y"]);
    }

    private function checkDuplicates($distances)
    {
        $minDistance = min(array_column($distances, "1"));
        $counts = array_count_values(array_column($distances, "1"));
        // make sure only one point has this minimal distance
        if ($counts[$minDistance] == 1) {
            foreach ($distances as $value) {
                if ($value[1] == $minDistance) {
                    return $value[0];
                }
            }
        }
    }
}

$obj = new Coord();
echo "Size of largest area equals " . $obj->sizeOfLargestArea();
