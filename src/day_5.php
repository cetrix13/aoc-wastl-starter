<?php
namespace AoC;

error_reporting(0);

class Polymer
{
    public $polymerSequence = [];
    const FILE_PATH = __DIR__ . '/resources/polymer.txt';

    public function __construct()
    {
        $this->polymerSequence = str_split(trim(file_get_contents(self::FILE_PATH)));
    }

    public function countPolymerUnits($polymerSequence)
    {

        do {
            $removed = false;
            foreach ($polymerSequence as $key => $current) {
                $next = next($polymerSequence);
                if ($current != $next && strtoupper($current) == strtoupper($next)) {
                    array_splice($polymerSequence, $key, 2);
                    $removed = true;
                    break;
                }
            }
        } while ($removed);

        return $polymerSequence;
    }
}

$obj = new Polymer();
echo "Number of units in shortest polymer = " . count($obj->countPolymerUnits($obj->polymerSequence)) . "\n";
