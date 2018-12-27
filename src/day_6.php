<?php
namespace AoC;

error_reporting(0);

class Coord
{
    private $coords = [];
    private $grid = [];
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
        $this->grid['max_x'] = max(array_column($this->coords, "x"));
        $this->grid['max_y'] = max(array_column($this->coords, "y"));
        $this->grid['min_x'] = min(array_column($this->coords, "x"));
        $this->grid['min_y'] = min(array_column($this->coords, "y"));
    }

    public function findSafestRegion()
    {
        for ($i = $this->$grid['min_x']; $i <= $this->grid['max_x']; $i++) {
            for ($j = $this->grid['min_y']; $j <= $this->grid['max_y']; $j++) {
                $distances = [];
                foreach ($this->coords as $point) {
                    $manhattanDistance = self::caclManhattanDistance($point, ["x" => $i, "y" => $j]);
                    $distances[] = [$point, $manhattanDistance];
                }
                // sum up all Manhattan distances for each point of grid
                if (array_sum(array_column($distances, "1")) < 10000) {
                    $matrix[$i][$j] = $distances[0];
                }
            }
        }

        return current(current(self::getNotInfinityAreas($matrix)));
    }

    public function sizeOfLargestArea()
    {
        for ($i = $this->$grid['min_x']; $i <= $this->grid['max_x']; $i++) {
            for ($j = $this->grid['min_y']; $j <= $this->grid['max_y']; $j++) {
                $distances = [];
                foreach ($this->coords as $point) {
                    $manhattanDistance = self::caclManhattanDistance($point, ["x" => $i, "y" => $j]);
                    $distances[] = [$point, $manhattanDistance];
                }
                // check distances for duplicates, return unique
                $matrix[$i][$j] = self::checkDuplicates($distances);
            }
        }

        $notInfinityAreas = self::getNotInfinityAreas($matrix);
        $largestArea = 0;
        foreach ($notInfinityAreas as $area) {
            foreach ($area as $count) {
                if ($count > $largestArea) {
                    $largestArea = $count;
                }
            }
        }

        return $largestArea;
    }

    private function getNotInfinityAreas($matrix){
        $exclude = [];
        for ($i = $this->$grid['min_x']; $i <= $this->grid['max_x']; $i++) {
            for ($j = $this->grid['min_y']; $j <= $this->grid['max_y']; $j++) {
                // if point is on the edge of the grid, then the area is infinity
                if ($i == $this->grid['min_x'] || $i == $this->grid['max_x'] || $j == $this->grid['min_y']
                    || $j == $this->grid['max_y']) {
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
        return $notInfinityAreas;
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

    private function caclManhattanDistance($point1, $point2)
    {
        return abs($point1["x"] - $point2["x"]) + abs($point1["y"] - $point2["y"]);
    }
}

$obj = new Coord();
print "Size of largest area equals " . $obj->sizeOfLargestArea() . "\n";
print "Size of safest area equals " . $obj->findSafestRegion() . "\n";
