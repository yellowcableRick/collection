<?php

namespace YellowCable\Collection\Traits\Calculation;

/**
 * MaxTrait is a trait which can be used on any Iterable class.
 * It lets you determine a maximum value based on the output
 * of either a method or the value of a property. It assumes
 * you target anything int or float based.
 */
trait MaxTrait
{
    /**
     * getMax will generate a comparison method to evaluate the larger value of 2.
     * Then it will iterate the object it's used on to apply the method on the value it
     * collects from either the property or method assigned to $s. Based on the values
     * found it will either return an int or a float.
     *
     * @param string $s Either method name or property name of the items in this object.
     * @return int|float
     */
    public function getMax(string $s): int|float
    {
        $gt = fn($x, $y) => ($x > $y) ? $x : $y;
        $v = null;
        foreach ($this as $i) {
            $v = $gt((method_exists($i, $s)) ? $i->$s() : $i->$s, $v);
        }
        return $v;
    }
}
