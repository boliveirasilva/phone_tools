<?php 
namespace PhoneTools;

interface PhoneDataInterface
{
    function __construct($phone_number);

    public function getUntreatedNumber();

    public function getSlicedNumber();

    public function isValid();

    public function getType();

}