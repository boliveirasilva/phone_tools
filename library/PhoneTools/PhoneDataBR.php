<?php 
namespace PhoneTools;

use \invalidArgumentException;

/**
 * Classe para validação de número telefônico brasileiro
 */
class PhoneDataBR implements PhoneDataInterface
{
    private $regex = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?0?([1-9][0-9])\)?\s?)?(?:(9?[2-9]\d{3})\-?(\d{4}))$/';

    private $untreated = null;

    private $sliced = null;
    private $sliced_phone_fields = array('DDI', 'DDD', 'P1', 'P2');

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
        if (preg_match($this->regex, $phone_number, $regex_returned) == 1) {
            $this->is_valid = true;
        }

        if (array_shift($regex_returned) !== null) {
            $this->sliced = array_combine($this->sliced_phone_fields, $regex_returned);
        } else {
            $this->sliced = array_fill_keys($this->sliced_phone_fields, null);
        }
    }

    protected function getCommunicationType()
    {
        // Carrega identificador de serviço
        $servico_id = substr($this->sliced['P1'], 0, 1);

        $tamanho = strlen($this->sliced['P1']);

        if ($tamanho == 5 && $servico_id == 9) {
            $this->communication_type = 'mobile pessoal';
        } elseif ($servico_id > 2 && $servico_id <= 5) {
            $this->communication_type = 'fixa';
        } elseif ($servico_id == 7) {
            $this->communication_type = 'mobile especializado';
        } else {
            $this->communication_type = 'n/i';
        }
    }

    public function getFormat($format = null)
    {
        $formatted_number = $this->untreated;
        if ($format !== null) {
            $formatted_number = '';

            if (strpos($format, 'i') !== false) {
                $formatted_number .= '+' . (empty($this->sliced['DDI']) ? '55' : $this->sliced['DDI']) . ' ';
            }

            if (strpos($format, 'r') !== false) {
                $formatted_number .= '(' . (empty($this->sliced['DDD']) ? '11' : $this->sliced['DDD']) . ') ';
            }

            if (strpos($format, 'f') !== false || strpos($format, 'p1') !== false) {
                $formatted_number .= $this->sliced['P1'];
            }

            if (strpos($format, 'f') !== false) $formatted_number .= '-';

            if (strpos($format, 'f') !== false || strpos($format, 'p2') !== false) {
                $formatted_number .= $this->sliced['P2'];
            }

            $formatted_number = trim($formatted_number);
        }

        return $formatted_number;
    }
}