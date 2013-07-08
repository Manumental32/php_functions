php_functions
=============

Funciones de php comunes útiles para el desarrollo


    function _strlen($str, $use_encoding=FALSE, $encoding='utf8'){
        if($use_encoding){
            return mb_strlen($str, $encoding); 
        }
        return strlen($str); 
    }
  
    // usage
    $string = 'Tschüss';
    echo _strlen($string, 1); 
