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
            $fatiado['DDD'],
            'O valor retornado não é igual ao esperado. Retornou ' . print_r($fatiado['DDD'], true)
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
            'mobile pessoal',
            $instance->getType(), 
            'O valor retornado não era esperado.'
        );
    }

    /**
     * @depends testGettingIsvalidFunctionShouldReturnACorrectlyBoolean
     */
    public function testGettingFormattedPhoneNumberWithoutParameterShouldWork()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertEquals(
            '+5511964821010',
            $instance->getFormat(), 
            'O valor retornado não era esperado.'
        );
    }

    /**
     * @depends testGettingIsvalidFunctionShouldReturnACorrectlyBoolean
     */
    public function testGettingFormattedPhoneNumberWithValidInternationalParameterShouldWork()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertEquals(
            '+55',
            $instance->getFormat('i'), 
            'O valor retornado não era esperado.'
        );
    }

    /**
     * @depends testGettingIsvalidFunctionShouldReturnACorrectlyBoolean
     */
    public function testGettingFormattedPhoneNumberWithValidRegionParameterShouldWork()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertEquals(
            '(11)',
            $instance->getFormat('r'), 
            'O valor retornado não era esperado.'
        );
    }

    /**
     * @depends testGettingIsvalidFunctionShouldReturnACorrectlyBoolean
     */
    public function testGettingFormattedPhoneNumberWithValidFoneParameterShouldWork()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertEquals(
            '96482-1010',
            $instance->getFormat('f'), 
            'O valor retornado não era esperado.'
        );
    }

    /**
     * @depends testGettingIsvalidFunctionShouldReturnACorrectlyBoolean
     */
    public function testGettingFormattedPhoneNumberWithValidP1OrP2ParameterShouldWork()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertEquals(
            '96482',
            $instance->getFormat('p1'), 
            'O valor retornado não era esperado.'
        );
        $this->assertEquals(
            '1010',
            $instance->getFormat('p2'), 
            'O valor retornado não era esperado.'
        );
    }


    /**
     * @depends testGettingIsvalidFunctionShouldReturnACorrectlyBoolean
     */
    public function testGettingFormattedPhoneNumberWithValidExpressionShouldWork()
    {
        $instance = new PhoneDataBR('+5511964821010');
        $this->assertEquals(
            '+55 (11) 96482-1010',
            $instance->getFormat('irf'), 
            'O valor retornado não era esperado.'
        );
    }
}