<?php 
namespace PhoneTools;

class PhoneTools
{
    private $telefones;

    public function __construct()
    {
        
    }

    public function setPhoneNumber($phone_number)
    {
        $this->telefones[] = new PhoneDataBR($phone_number);
        return $this;
    }
}
