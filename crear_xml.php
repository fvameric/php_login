<?php
    //obtencion plantas
    require_once('/crud_plantas/crud_plantas.php');
    require_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->mostrar();

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

    Header('Content-type: text/xml');
    print($xml->asXML());

    $contenidoXML = $xml->asXML();
    $file = fopen('plantas.xml','w');
    fwrite($file, $contenidoXML);
    fclose($file);
?>