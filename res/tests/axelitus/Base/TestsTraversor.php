<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.6.0
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Traversor;

/**
 * Class TestsTraversor
 *
 * @package axelitus\Base
 */
class TestsTraversor extends TestCase
{
    public function testRun()
    {
        // Test item callback only with value
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [4, 9, 16, 25],
            Traversor::run(
                $arr,
                function ($value) {
                    return pow($value, 2);
                }
            )
        );

        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [0, 3, 8, 15],
            Traversor::run(
                $arr,
                function ($value, $key) {
                    return $key * $value;
                }
            )
        );

        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [3 => 10, 4 => 15, 5 => 20, 6 => 25],
            Traversor::run(
                $arr,
                function ($value, &$key) {
                    $key += 3;
                    return $value * 5;
                }
            )
        );

        // Test by reference array item callback manipulation
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [0 => 'deleted', 1 => 'deleted', 2 => 'deleted', 3 => 'deleted'],
            Traversor::run(
                $arr,
                function ($value, $key, &$arr) {
                    unset($arr[$key]);
                    return 'deleted';
                }
            )
        );
        $this->assertEquals([], $arr);

        // Test by reference array post item callback manipulation
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            $arr,
            Traversor::run(
                $arr,
                function ($value) {
                    return $value;
                },
                function (&$arr, $result) {
                    for ($i = 0; $i < count($arr); $i++) {
                        $arr[$i] = $result;
                    }

                    return $result;
                }
            )
        );
    }
}
