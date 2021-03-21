<?php
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE ||
   		strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) {
	 	echo 'Stai usando Internet Explorer<br />';
	} else {
		echo "Stai usando " . $_SERVER["HTTP_USER_AGENT"];
	}
?>

<p><b>$_SERVER</b> è una variabile riservata che automaticamente viene resa diponibile da PHP</p>
<p>È possibile visualizzare la lista delle variabili riservate utilizzando la pagina  <a href="info.php">INFO</a> </p>

<p><b>strpos</b> è una funzione sviluppata in PHP che cerca una stringa all'interno di un'altra stringa</p>

<p>La funzione <b>glob()</b> restituisce un array contenente i files/directories presenti nella cartella specificata, un array vuoto se non trova nessun files o FALSE se va in errore</p>

<?php
//La funzione "glob()" restituisce un array contenente i files/directories
//presenti nella cartella specificata, un array vuoto se non trova nessun files
//o FALSE se va in errore
//La cartella specificata (/files) in tal caso si trova nella cartella principale
//del progetto

foreach (glob("files/*.txt") as $filename) {
    echo "$filename size " . filesize($filename) . "\n";
    echo "<br>";
}
?>