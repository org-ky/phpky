<?php
   // connect to mongodb
   //$m = new MongoClient('mongodb://192.168.12.142:27017', array("username" => "admin", "password" => "mongodb"));
	
   $m = new MongoClient('mongodb://10.10.60.23:27017');//, array("username" => "admin", "password" => "mongodb"));

   if($m->connected)
    echo "Connection to database successfully";
   else
    echo "Connection to database failed";
   
   echo("<br>");

   // select a database
   $mDB  = 'elcms';
   $db = $m->$mDB;

   // select a collection
   $corsi = $db->selectCollection("Corsi");
   $lezioni = $db->selectCollection("Lezioni"); 
   $pagine = $db->selectCollection("Pagine"); 

   //get a cursor of collection
   //$cursor = $corsi->find();
   //$cursor = $lezioni->find(array('idCorso' => "557ed1d3b656d0981500002a"));
   //$cursor = $pagine->find(array('idCorso' => "557ed1d3b656d0981500002a", 'idItem' => "557ed24fb656d0981500002d"));
   //$rangeQuery = array('x' => array( '$gt' => 5, '$lt' => 20 ));

   //Il comando seguente seleziona tutti i records individuati dalla where (filtro) definita tramite i due array, ovvero tutti quei records che hanno "idCorso" e "idItem" specificati
   //e tali che "numPagina" > "10"
   $cursor = $pagine->find(array('idCorso' => "557ed1d3b656d0981500002a", 'idItem' => "557ed24fb656d0981500002d", 'numPagina' => array( '$gt' => 10)));

   //Il comando seguente incrementa tramite $i (decrementa tramite $d) il "numPagina", definito nel secondo array, di tutti i records selezionati tramite il primo array
   $i = (int)1;
   $d = (int)-1;
   $pagine->update(array('idCorso' => "557ed1d3b656d0981500002a", 'idItem' => "557ed24fb656d0981500002d", 'numPagina' => array( '$gt' => 16)), array('$inc' => array('numPagina' => $i)));
   
   //Il comando seguente aggiorna il record (i records) individuato dalle condizioni di where(filtro) del primo array settando il campo al valore definito nel secondo array
   //$pagine->update(array('idCorso' => "557ed1d3b656d0981500002a", 'idItem' => "557ed24fb656d0981500002d", 'numPagina' => 21), array('$set' => array('numPagina' => 17)));

   //print collection's documents
   foreach ( $cursor as $id => $value )
   {
	    //echo "$id: ";
	    //var_dump( $value );
	    //echo( $value["_id"]);
      //echo( $value["titolo"]);
      //print_r($value["modelloDati"]);
	    echo( $value["numPagina"]);
      
      echo("<br>");
   }

?>
