php_functions
=============

Funciones de php comunes útiles para el desarrollo


//cambiar el charset de la BD mysql PDO


$q = "ALTER DATABASE arte_norte DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_unicode_ci";
mysql_query($q);

$s2 ='SHOW TABLES';
$q2 = mysql_query($s2);



while( $tables = mysql_fetch_array($q2))

{

    foreach( $tables as $table )

    {

        /* Change each table collation */

        $s3 = "ALTER TABLE $table CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
        mysql_query($s3);

    }

}	

//cambiar el charset de la BD mysql_query

$q = "ALTER DATABASE arte_norte DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_unicode_ci";
$alter = $db->run($q);

if ($alter > 0) {
	$s2 ='SHOW TABLES';
	
	$alt_run = $db->run($s2, null, true);
	while( $tables = $alt_run->fetch())
	{

		foreach( $tables as $table ) 
		{

			$s3 = "ALTER TABLE $table CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
			if ($data =  $db->run($s3) ) {
				echo "ok <br>";
			} else {
				echo "bad";
				print_r($table);
				echo "<br>";
			} 

		}

	}	
}		

//pasar a utf-8

    function _strlen($str, $use_encoding=FALSE, $encoding='utf8'){
        if($use_encoding){
            return mb_strlen($str, $encoding); 
        }
        return strlen($str); 
    }
  
    // usage
    $string = 'Tschüss';
    echo _strlen($string, 1); 
