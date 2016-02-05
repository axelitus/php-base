<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2016 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.9
 */

namespace axelitus\Base\Tests;

use axelitus\Base\Traverser;

/**
 * Class TestsTraverser
 *
 * @package axelitus\Base
 */
class TestsTraverser extends TestCase
{
    public function testRun()
    {
        // Test item callback only with value
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [4, 9, 16, 25],
            Traverser::run(
                $arr,
                function ($value) {
                    return pow($value, 2);
                }
            )
        );

        // Test item callback only with value (by reference)
        $arr = [2, 3, 4, 5];
        Traverser::run(
            $arr,
            function (&$value) {
                $value = pow($value, 2);
            }
        );
        $this->assertEquals([4, 9, 16, 25], $arr);

        // Test item callback with value and key (by value)
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [0, 3, 8, 15],
            Traverser::run(
                $arr,
                function ($value, $key) {
                    return $key * $value;
                }
            )
        );

        // Test item callback with value and key (by reference)
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [3 => 10, 4 => 15, 5 => 20, 6 => 25],
            Traverser::run(
                $arr,
                function ($value, &$key) {
                    $key += 3;

                    return $value * 5;
                }
            )
        );

        // Test item callback with value, key and original array (by reference)
        // cannot unset value by reference, this must be done like this.
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            [0 => 'deleted', 1 => 'deleted', 2 => 'deleted', 3 => 'deleted'],
            Traverser::run(
                $arr,
                function ($value, $key, &$arr) {
                    unset($arr[$key]);

                    return 'deleted';
                }
            )
        );
        $this->assertEquals([], $arr);

        // Test result callback with result array
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            28,
            Traverser::run(
                $arr,
                function ($value) {
                    return $value * 2;
                },
                function ($result) {
                    $count = 0;
                    foreach ($result as $value) {
                        $count += $value;
                    }

                    return $count;
                }
            )
        );

        // Test result callback with result and original array (by reference)
        $arr = [2, 3, 4, 5];
        $this->assertEquals(
            $arr,
            Traverser::run(
                $arr,
                function ($value) {
                    return $value;
                },
                function ($result, &$arr) {
                    // To be sure we need to check if both arrays are equal sized because we "don't know" if the
                    // original array got modified in the item callback.
                    if (count($result) === count($arr)) {
                        for ($i = 0; $i < count($result); $i++) {
                            $arr[$i] = $result;
                        }

                        return $result;
                    } else {
                        return false;
                    }
                }
            )
        );
    }

    public function testTraverserInstanceOnlyWithValue()
    {
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser(function ($value) {
            return pow($value, 2);
        });

        $this->assertEquals(
            [4, 9, 16, 25],
            $traverser->traverse($arr)
        );
    }

    public function testTraverserInstanceOnlyWithValueByReference()
    {
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser(function (&$value) {
            $value = pow($value, 2);
        }
        );
        $traverser->traverse($arr);
        $this->assertEquals([4, 9, 16, 25], $arr);
    }

    public function testTraverserInstanceWithKeyValue()
    {
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser(function ($value, $key) {
            return $key * $value;
        });
        $this->assertEquals(
            [0, 3, 8, 15],
            $traverser->traverse($arr)
        );
    }

    public function testTraverserInstanceWithKeyValueByReference()
    {
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser(function ($value, &$key) {
            $key += 3;

            return $value * 5;
        });
        $this->assertEquals(
            [3 => 10, 4 => 15, 5 => 20, 6 => 25],
            $traverser->traverse($arr)
        );
    }

    public function testTraverserInstanceWithKeyValueAndArrayByReference()
    {
        // Cannot unset value by reference, this must be done like this.
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser(function ($value, $key, &$arr) {
            unset($arr[$key]);

            return 'deleted';
        });
        $this->assertEquals(
            [0 => 'deleted', 1 => 'deleted', 2 => 'deleted', 3 => 'deleted'],
            $traverser->traverse($arr)
        );
        $this->assertEquals([], $arr);
    }

    public function testTraverserInstanceWithResultCallback()
    {
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser(function ($value) {
            return $value * 2;
        },
            function ($result) {
                $count = 0;
                foreach ($result as $value) {
                    $count += $value;
                }

                return $count;
            });
        $this->assertEquals(
            28,
            $traverser->traverse($arr)
        );
    }

    public function testTraverserInstanceWithResultCallbackAndArrayByReference()
    {
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser(function ($value) {
            return $value;
        },
            function ($result, &$arr) {
                // To be sure we need to check if both arrays are equal sized because we "don't know" if the
                // original array got modified in the item callback.
                if (count($result) === count($arr)) {
                    for ($i = 0; $i < count($result); $i++) {
                        $arr[$i] = $result;
                    }

                    return $result;
                } else {
                    return false;
                }
            });
        $this->assertEquals(
            $arr,
            $traverser->traverse($arr)
        );
    }

    public function testTraverserInstanceNotReadyException()
    {
        $arr = [2, 3, 4, 5];
        $traverser = new Traverser();

        $this->setExpectedException(
            '\RuntimeException',
            "The traverser is not ready, no valid item callback has been set."
        );

        $traverser->traverse($arr);
    }

    public function testTraverserInstanceGetSetHasCallbacks()
    {
        $traverser = new Traverser();
        $this->assertFalse($traverser->isReady());
        $this->assertNull($traverser->getItemCallback());
        $this->assertFalse($traverser->hasResultCallback());
        $this->assertNull($traverser->getResultCallback());

        $traverser->setItemCallback(function ($value) {
            return $value;
        });
        $this->assertTrue($traverser->isReady());
        $this->assertNotNull($traverser->getItemCallback());
        $this->assertTrue(is_callable($traverser->getItemCallback()));

        $traverser->setResultCallback(function ($result, $original) {
            return (count($result) == count($original));
        });
        $this->assertTrue($traverser->hasResultCallback());
        $this->assertNotNull($traverser->getResultCallback());
        $this->assertTrue(is_callable($traverser->getResultCallback()));
    }
}
