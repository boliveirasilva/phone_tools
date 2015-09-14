<?php 
namespace PhoneTools;

use \invalidArgumentException;

/**
 * Classe para validação de número telefônico brasileiro
 */
class PhoneDataBR implements PhoneDataInterface
{
    private $regex = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?0?([1-9][0-9])\)?\s?)?(?:(\d{4,5})\-?(\d{4}))$/';
    private $untreated = null;
    private $sliced = null;
    private $is_valid = false;
    private $communication_type = null;


    function __construct($phone_number)
    {
        if (is_string($phone_number) || is_numeric($phone_number)) {

            $this->untreated = $phone_number;
            $this->validate($phone_number);

            if ($this->is_valid) {
                $this->getCommunicationType();
            }
        } else {

            throw new invalidArgumentException("Um argumento do tipo string era esperado.", 1);
        }
    }

    public function getUntreatedNumber()
    {
        return $this->untreated;
    }

    public function getSlicedNumber()
    {
        return $this->sliced;
    }

    public function isValid()
    {
        return $this->is_valid;
    }

    public function getType()
    {
        return $this->communication_type;
    }

    protected function validate($phone_number)
    {
        $sliced_phone_fields = array('ddi', 'ddd', 'p1', 'p2');

        if (preg_match($this->regex, $phone_number, $regex_returned) == 1) {
            $this->is_valid = true;
        }

        if (array_shift($regex_returned) !== null) {
            $this->sliced = array_combine($sliced_phone_fields, $regex_returned);
        } else {
            $this->sliced = array_fill_keys($sliced_phone_fields, null);
        }
    }

    protected function getCommunicationType()
    {
        // Carrega identificador de serviço
        $servico_id = substr($this->sliced['p1'], 0, 1);

        if (strlen($this->sliced['p1']) == 5) {
            $this->communication_type = 'mobile';
        } elseif ($servico_id > 2 && $servico_id <= 5) {
            $this->communication_type = 'fixa';
        } elseif ($servico_id == 7) {
            $this->communication_type = 'mobile';
        } else {
            $this->communication_type = 'n/i';
        }
    }
}