<?php 
namespace Tryout\PhoneTools;

require_once '../../vendor/autoload.php';

use PhoneTools\PhoneDataBR;

$telefone = new PhoneDataBR($_REQUEST['txt_phone']);
// $telefone = new PhoneTools();
// $telefone->setPhoneNumber($_REQUEST['txt_phone']);

if ($telefone->isValid()) {
    echo '<span style="color:green;">Número de telefone válido no Brasil.</span>', '<br />';
    echo '<span style="color:green;">Número Formatado: ', $telefone->getFormat('irf'), '</span>';
} else {
    echo '<span style="color:red;">O número de telefone não foi reconhecido!</span>';
}
