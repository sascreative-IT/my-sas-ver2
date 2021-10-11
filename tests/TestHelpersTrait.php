<?php

namespace Tests;


/**
 * Test helpers
 */

trait TestHelpersTrait
{
    /**
     * Determine if two arrays are similar
     * and they have the same indexes with identical values without respect to key ordering
     *
     * @param array $arrayA
     * @param array $arrayB
     * @return bool
     */
    public function assertArraysAreSimilar($arrayA, $arrayB)
    {
        if (count(array_diff_assoc($arrayA, $arrayB))) {
            return false;
        }
        foreach ($arrayA as $key => $value) {
            if ($value !== $arrayB[$key]) {
                return false;
            }
        }

        return true;
    }
}
