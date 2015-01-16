php_functions
=============
Funciones de php comunes útiles para el desarrollo


     /**
     * Logs messages/variables/data to browser console from within php
     *
     * @param $name: message to be shown for optional data/vars
     * @param $data: variable (scalar/mixed) arrays/objects, etc to be logged
     * @param $jsEval: whether to apply JS eval() to arrays/objects
     *
     * @return none
     * @author Sarfraz
     */
     function logConsole($name, $data = NULL, $jsEval = FALSE)
     {
          if (! $name) return false;
 
          $isevaled = false;
          $type = ($data || gettype($data)) ? 'Type: ' . gettype($data) : '';
 
          if ($jsEval && (is_array($data) || is_object($data)))
          {
               $data = 'eval(' . preg_replace('#[\s\r\n\t\0\x0B]+#', '', json_encode($data)) . ')';
               $isevaled = true;
          }
          else
          {
               $data = json_encode($data);
          }
 
          # sanitalize
          $data = $data ? $data : '';
          $search_array = array("#'#", '#""#', "#''#", "#\n#", "#\r\n#");
          $replace_array = array('"', '', '', '\\n', '\\n');
          $data = preg_replace($search_array,  $replace_array, $data);
          $data = ltrim(rtrim($data, '"'), '"');
          $data = $isevaled ? $data : ($data[0] === "'") ? $data : "'" . $data . "'";
 
$js = <<<JSCODE
\n<script>
     // fallback - to deal with IE (or browsers that don't have console)
     if (! window.console) console = {};
     console.log = console.log || function(name, data){};
     // end of fallback
 
     console.log('$name');
     console.log('------------------------------------------');
     console.log('$type');
     console.log($data);
     console.log('\\n');
</script>
JSCODE;
 
          echo $js;
     } # end logConsole
     
   //  ejemplo: logConsole('$name var', $name, true);


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
