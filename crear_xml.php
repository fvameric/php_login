<?php
    //obtencion plantas
    include_once('/crud_plantas/crud_plantas.php');
    include_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->obtenerListaPlantas();

    $xml = new SimpleXMLElement('<xml/>');

    foreach($listaPlantas as $p) {
        $planta = $xml->addChild('planta');
        $planta->addChild('id', $p->getId());
        $planta->addChild('nombre', $p->getNombre());
        $planta->addChild('descripcion', $p->getDescripcion());
        $planta->addChild('precio', $p->getPrecio());
        $planta->addChild('stock', $p->getStock());
        $planta->addChild('foto', $p->getFoto());
        $planta->addChild('compradas', $p->getCompradas());
    }
    
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;

    $contenidoXML = $xml->asXML();
    $file = fopen('plantas.xml','w');
    fwrite($file, $contenidoXML);
    fclose($file);

    header('Location: profileAdmin.php');
