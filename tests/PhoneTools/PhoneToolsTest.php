<?php 
namespace Tryout\PhoneTools;

use PhoneTools\PhoneTools;

class PhoneToolsTest extends \PHPUnit_Framework_TestCase
{

    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'PhoneTools\PhoneTools'), 
            'Classe não encontrada: ' . $class
        );
    }

    public function testInstantiationWithoutArgumentsShouldWork()
    {
        $instance = new PhoneTools();
        $this->assertInstanceOf('PhoneTools\PhoneTools', $instance);
    }

    public function testSettingPhoneToValidateMustReturnThisObjectForFluentInterface()
    {
        $instance = new PhoneTools();
        $this->assertInstanceOf(
            'PhoneTools\PhoneTools',
            $instance->setPhoneNumber('+551146341205')
        );
        $this->assertInstanceOf(
            'PhoneTools\PhoneTools',
            $instance->setPhoneNumber('46341221')->setPhoneNumber('21990857264')
        );
    }
}