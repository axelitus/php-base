<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.8.2
 */

namespace axelitus\Base\Tests\PropertyAccessible;

use axelitus\Base\PropertyAccessible;

/**
 * Class PropertyAccessibleDerived
 *
 * Used for testing the PropertyAccessible class.
 *
 * @package axelitus\Base
 *
 * @property string $privateRawProperty
 * @property string $protectedRawProperty
 * @property string $publicRawProperty
 *
 * @property string $privateGSProperty
 * @property string $protectedGSProperty
 * @property string $publicGSProperty
 *
 * @codeCoverageIgnore
 */
class PropertyAccessibleDerived extends PropertyAccessible
{
    //region Properties

    private $privateRawProperty;
    protected $protectedRawProperty;
    public $publicRawProperty;

    private $privateGSProperty;
    private $protectedGSProperty;
    private $publicGSProperty;

    //endregion

    // region Constructor

    public function __construct()
    {
        $this->privateRawProperty = 'private raw property';
        $this->protectedRawProperty = 'protected raw property';
        $this->publicRawProperty = 'public raw property';

        $this->privateGSProperty = 'private getter/setter property';
        $this->protectedGSProperty = 'protected getter/setter property';
        $this->publicGSProperty = 'public getter/setter property';
    }

    //endregion

    //region Getters

    private function getPrivateGSProperty()
    {
        return $this->privateGSProperty;
    }

    protected function getProtectedGSProperty()
    {
        return $this->protectedGSProperty;
    }

    public function getPublicGSProperty()
    {
        return $this->publicGSProperty;
    }

    //endregion

    //region Setters

    private function setPrivateGSProperty($value)
    {
        $this->privateGSProperty = $value;
    }

    protected function setProtectedGSProperty($value)
    {
        $this->protectedGSProperty = $value;
    }

    public function setPublicGSProperty($value)
    {
        $this->publicGSProperty = $value;
    }

    //endregion
}
