<?php

interface Comparable
{
    /**
     * @param Comparable $a the object to compare with
     * @return int
     *    0 if both object are equal
     *    1 is $a is smaller
     *    -1 otherwise
     */
    public function compare(Comparable $a): int;
}

?>
