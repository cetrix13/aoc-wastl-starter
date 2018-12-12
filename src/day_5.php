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

    /**
     * @param  array $polymerSequence
     * @return integer
     */
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

        return count($polymerSequence);
    }

    public function countPolymerUnitsWhenUnitTypeRemoved($type)
    {
        $copyPolymerSequence = $this->polymerSequence;
        $copyPolymerSequence = str_split(str_replace($type, "", implode("", $copyPolymerSequence)));
        $copyPolymerSequence = str_split(str_replace(strtolower($type), "", implode("", $copyPolymerSequence)));

        return self::countPolymerUnits($copyPolymerSequence);
    }
}

$obj = new Polymer();
echo "Number of units in shortest polymer = " . $obj->countPolymerUnits($obj->polymerSequence) . "\n";
echo "Remove units of type A and get polymer of lenght = " . $obj->countPolymerUnitsWhenUnitTypeRemoved("A") . "\n";
echo "Remove units of type B and get polymer of lenght = " . $obj->countPolymerUnitsWhenUnitTypeRemoved("B") . "\n";
echo "Remove units of type C and get polymer of lenght = " . $obj->countPolymerUnitsWhenUnitTypeRemoved("C") . "\n";
echo "Remove units of type D and get polymer of lenght = " . $obj->countPolymerUnitsWhenUnitTypeRemoved("D") . "\n";
