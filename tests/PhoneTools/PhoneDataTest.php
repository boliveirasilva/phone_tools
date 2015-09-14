<?php 
namespace Tryout\PhoneTools;

use PhoneTools\PhoneDataBR;

class PhoneDataTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'PhoneTools\PhoneDataBR'), 
            'Classe não encontrada: ' . $class
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstantiationWithInvalidArgumentsMustFail()
    {
        $instance = new PhoneDataBR(array('123456', '123456789'));
        $this->assertInstanceOf('PhoneTools\PhoneDataBR', $instance);
    }

    public function testInstantiationWithPhoneNumberStringArgumentShouldWork()
    {
        $instance = new PhoneDataBR('0552141424568');
        $this->assertInstanceOf('PhoneTools\PhoneDataBR', $instance);
    }

    /**
     * @depends testInstantiationWithPhoneNumberStringArgumentShouldWork
     */
    public function testGettingUntreatedNumberShouldWork()
    {
        $instance = new PhoneDataBR('552141424568');
        $this->assertEquals(
            '552141424568', 
            $instance->getUntreatedNumber(), 
            'O valor retornado não é igual ao esperado.'
        );
    }

    /**
     * @depends testInstantiationWithPhoneNumberStringArgumentShouldWork
     */
    public function testGettingSlicedNumberShouldWork()
    {
        $instance = new PhoneDataBR('552141424568');
        $fatiado = $instance->getSlicedNumber();
        // fwrite(STDOUT, 'Retornando:: (' . gettype($fatiado) . ') ' . print_r($fatiado, true));
        $this->assertEquals(
            '21',
            $fatiado['ddd'],
            'O valor retornado não é igual ao esperado. Retornou ' . print_r($fatiado['ddd'], true)
        );
    }

    /**
     * @depends testInstantiationWithPhoneNumberStringArgumentShouldWork
     */
    public function testGettingIsvalidFunctionShouldReturnACorrectlyBoolean()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertTrue(
            $instance->isValid(), 
            'Deveria retornar "true" para um número de telefone válido!'
        );
    }

    /**
     * @depends testGettingIsvalidFunctionShouldReturnACorrectlyBoolean
     */
    public function testGettingTheTypeOfCommunicationWithValidNumbersShouldWork()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertEquals(
            'mobile',
            $instance->getType(), 
            'O valor retornado não era esperado.'
        );
    }
}