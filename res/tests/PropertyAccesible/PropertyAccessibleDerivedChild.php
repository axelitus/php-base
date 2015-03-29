<?php
/**
 * PHP Package: axelitus/base - Primitive operations and helpers.
 *
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @copyright   2015 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/base
 * @license     MIT License ({@link LICENSE.md})
 * @package     axelitus\Base
 * @version     0.9
 */

namespace axelitus\Base\Tests\PropertyAccessible;

/**
 * Class PropertyAccessibleDerivedChild
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
class PropertyAccessibleDerivedChild extends PropertyAccessibleDerived
{
    // region: Get Parent Properties

    public function getParentPrivateRawProperty()
    {
        return $this->privateRawProperty;
    }

    public function getParentPrivateGSProperty()
    {
        return $this->privateGSProperty;
    }

    public function getParentProtectedRawProperty()
    {
        return $this->protectedRawProperty;
    }

    public function getParentProtectedGSProperty()
    {
        return $this->protectedGSProperty;
    }

    public function getParentPublicRawProperty()
    {
        return $this->publicRawProperty;
    }

    public function getParentPublicGSProperty()
    {
        return $this->publicGSProperty;
    }

    // endregion

    // region: Set Parent Properties

    public function setParentPrivateRawProperty($value)
    {
        $this->privateRawProperty = $value;
    }

    public function setParentPrivateGSProperty($value)
    {
        $this->privateGSProperty = $value;
    }

    public function setParentProtectedRawProperty($value)
    {
        $this->protectedRawProperty = $value;
    }

    public function setParentProtectedGSProperty($value)
    {
        $this->protectedGSProperty = $value;
    }

    public function setParentPublicRawProperty($value)
    {
        $this->publicRawProperty = $value;
    }

    public function setParentPublicGSProperty($value)
    {
        $this->publicGSProperty = $value;
    }

    // endregion
}
