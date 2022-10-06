<?php

header('Content-Type: application/json');

require_once 'responses/nuevoResponse.php';
require_once 'request/nuevoRequest.php';
require_once '../../modelo/contacto.php';
require_once '../../modelo/vehiculo.php';

$json = file_get_contents('php://input', true);
$req = json_decode($json);

$r = new NuevoResponse();
$r->IsOk = true;
$r->Mensaje[] = '';
$cmc = 0;

if ($req->NroPoliza > 1000 and $req->NroPoliza < 0) {
    $r->IsOk = false;
    $r->Mensaje[] = 'La poliza no existe';
} elseif ($req->Vehiculo == null) {
    $r->IsOk = false;
    $r->Mensaje[] = 'Debe indicar el vehiculo. ';
}
if ($req->Vehiculo->Marca == null or $req->Vehiculo->Modelo == null or $req->Vehiculo->Version == null or $req->Vehiculo->Anio == null) {
    $r->IsOk = false;
    $r->Mensaje[] = 'Debe indicar todas las propiedades del vehiculo. ';
}

foreach ($req->ListMediosContacto as $mc) {
    $cmc = $cmc + 1;
}
if ($cmc <= 0) {
    $r->IsOk = false;
    $r->Mensaje[] = 'Debe indicar al menos un medio de contacto. ';
}
if ($req->MedioContactoDescripcion != 'Celular' or $req->MedioContactoDescripcion != 'Mail') {
    $r->IsOk = false;
    $r->Mensaje[] = 'Debe indicar medios de contacto válidos. ';
}

echo json_encode($r);
