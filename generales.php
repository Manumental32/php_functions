<?php 
//php_functions
=============
//Funciones de php comunes útiles para el desarrollo


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
    
    
    /**---------------------------------------------------------------
/**
 * curl con post y atentificacion
 * @param  string $url        [description]
 * @param  array $post_array [description]
 * @param  string $username   [description]
 * @param  string $password   [description]
 * @return json o html             [description]
 */
function curlPostAuth($url = '', $post_array = '', $username = '', $password = '') {

	//Convierte el array en el formato adecuado para cURL*/  
	if (!empty($post_array)) {
		$post_elements = array();  
		foreach ($post_array as $name=>$value) {  
		   $post_elements["$name"] = urlencode($value);  
		} 
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST,true);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_elements);  
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
	$result=curl_exec ($ch);
	curl_close ($ch);
    unset($ch); 

	return $result;
}

function validar_textarea($data) {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}

if (!isset($types)) {
	
	$types = array(
		'audio'       => array('aif', 'iff', 'm3u', 'm4a', 'mid', 'mp3', 'mpa', 'ra', 'wav', 'wma'),
		'compressed'  => array('7z', 'cbr', 'deb', 'gz', 'pkg', 'rar', 'rpm', 'sitx', 'tar.gz', 'zip', 'zipx'),
		'data'        => array('csv', 'dat', 'gbr', 'ged', 'ibooks', 'key', 'keychain', 'pps', 'ppt', 'pptx', 'sdf', 'tar', 'tax2012', 'vcf', 'xml'),
		'executable'  => array('apk', 'app', 'bat', 'cgi', 'com', 'exe', 'gadget', 'jar', 'pif', 'vb', 'wsf'),
		'image'       => array('bmp', 'dds', 'gif', 'jpg', 'png', 'psd', 'pspimage', 'tga', 'thm', 'tif', 'tiff', 'yuv'),
		'layout'      => array('indd', 'pct', 'pdf'),
		'spreadsheet' => array('xlr', 'xls', 'xlsx'),
		'text'        => array('doc', 'docx', 'log', 'msg', 'odt', 'pages', 'rtf', 'tex', 'txt', 'wpd', 'wps'),
		'video'       => array('3g2', '3gp', 'asf', 'asx', 'avi', 'flv', 'm4v', 'mov', 'mp4', 'mpg', 'rm', 'srt', 'swf', 'vob', 'wmv'),
		'web'         => array('asp', 'aspx', 'cer', 'cfm', 'csr', 'css', 'htm', 'html', 'js', 'jsp', 'php', 'rss', 'xhtml')
	);
}

/**Calculates the size in bytes*/
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function strEncrypt($string, $token)
{
	return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $token, $string, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))), "\0");
}

function strDecrypt($string, $token)
{
	return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $token, base64_decode($string), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)), "\0");
}

function obfuscate_link($file_id) {

    $temp = $file_id;
    $temp = serialize($temp);
    $temp = base64_encode($temp);
    $link = rawurlencode($temp);

    return $link;

}

function unobfuscate_link($link) {

    $temp = rawurldecode($link);
    $temp = base64_decode($temp);
    $download_array = unserialize($temp);

    return $download_array;

}

function format_price($price, $decimals = 2)
{
	return number_format($price, $decimals, ',', '.');
}

function hc($str)
{
	return crypt($str, CRYPT_MD5);
}

/**
 * Guardo el estado y el valor del alert
 * @param [string] $status success, info, warning, danger
 * @param [type] $msg    [description]
 */
function setAlert($status, $msg, $redirect = '')
{
	$_SESSION["alert"] = array('status'=>$status, 'msg' => $msg);

	if (!empty($redirect)) {
		header("location:$redirect");
		exit();
	}
}

/**
 * div para el msg de bootstrap
 * @return [html] [.alert]
 */
function showAlert()
{
    if (!empty($_SESSION["alert"])) {
    	$_SESSION["alert"]["status"] = ($_SESSION["alert"]["status"] == 'error') ? 'danger' : $_SESSION["alert"]["status"]; 
        ?>
        <div class="alert alert-<?php echo $_SESSION["alert"]["status"]?>" role="alert"><?php echo $_SESSION["alert"]["msg"]?></div>
        <?php
        unset($_SESSION["alert"]);
    }
}

function getAlert()
{	
	if (!empty($_SESSION["alert"])) {
		pdump($_SESSION["alert"],true);
	} else {
		die('alert vacia!!');
	}
}


function jsonSetAlert($status = "error", $msg = "error"){
	$response = array('status'=>$status, 'msg' => $msg);
	return json_encode($response);
}

// function dmail($title = '[DEBUG]', $content, $only_to = false)
// {
// 	require_once(GENERIC_PATH .'classes' . DS . 'class.phpmailer.php');

// 	$mail = new PHPMailer();

// 	$mail->IsSMTP();
// 	$mail->Host     = config('mails.host');
// 	$mail->SMTPAuth = config('mails.smtpauth');
// 	$mail->Username = config('mails.username');
// 	$mail->Password = config('mails.password');

// 	$mail->From     = 'debug@dytar.com.ar';
// 	$mail->FromName = 'Debug Dytar Systems';

// 	if ($only_to != false && is_numeric($only_to)) {
// 		$to = config('debug.mails.'.$only_to);
// 	}  else {
// 		$to = config('debug.default_mail');
// 	}

// 	$mail->AddAddress($to);

// 	$mail->WordWrap = 0;
// 	$mail->IsHTML(true);

// 	$mail->Subject 	= $title;
// 	$mail->Body    	= "<pre>" . $content . "</pre>";
// 	$mail->AltBody 	= $content;


// 	if ($mail->Send()) {
// 		return true;
// 	} else {
// 		return false;
// 	}

// }

function lastId(){
	return mysql_insert_id();
}

function getLastPathSegment($url)
{
    $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
    $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
    $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

    if (substr($path, -1) !== '/') {
        array_pop($pathTokens);
    }
    return end($pathTokens); // get the last segment
}

function pdump($value, $die = false)
{
	echo "<pre>";
	print_r($value);
	echo "</pre>";

	if ($die) {
		die();
	}
}

function redirect($url)
{
    ?>
	<script>
	 location.href = '<?php echo $url?>';
	 exit();
	</script>
    <?php
}

function config($string)
{
    return Config::get($string);
}

function get_base_url()
{
    $url = config('site.url');

    if (empty($url)) {
        $url = 'http' . (($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://') . $_SERVER['HTTP_HOST'] . '/';
    }

    return $url;
}

function rstr_replace($replacethis, $withthis, $inthis)
{
	$inthis = str_replace($replacethis ,$withthis, $inthis);

	if(stristr($inthis, $replacethis)!== false) {
		return rstr_replace($replacethis, $withthis, $inthis);
	}

	return $inthis;
}


function validateDate($date,$prev_character){
	$regex = "/^(0[1-9]|[1-2][0-9]|3[0-1])".$prev_character."(0[1-9]|1[0-2])".$prev_character."[0-9]{4}$/";
	if (preg_match($regex, $date) === 1) {
		return true;
	}
	return 0;
}

function rotateDate($date, $prev_character = '[-]', $next_character = '-', $cut_year = false)
{
	if (empty($date) || $date == '0000-00-00') {
		$new_date = "";
	} else {
		$split = preg_split($prev_character, $date);
		if ($cut_year == true) {
			$split[0] = substr($split[0],2,2);
		}
		$new_date = $split[2].$next_character.$split[1].$next_character.$split[0];
	}

	return $new_date;
}

function rotateDateTime($datetime, $prev_character = '[-]', $next_character = '-', $bla = false)
{
	if (empty($datetime)) {
		$new_datetime = "";
	} else {
		$split_datetime = preg_split("[ ]", $datetime);
		$date = $split_datetime[0];
		$time = $split_datetime[1];
		if ($bla == true) {
			$time = explode(':', $time);
			$time = $time[0] . ':' . $time[1];

			$date = explode('-', $date);
			$date = substr($date[0], 2) . '-' . $date[1] . '-' . $date[2];//2013-11-15
		}
		$split_date = preg_split($prev_character, $date);
		$new_datetime = $split_date[2].$next_character.$split_date[1].$next_character.$split_date[0]." ".$time;
	}

	return $new_datetime;
}

function rotateDateTimeNoSeconds($datetime)
{
	return rotateDateTime($datetime, $prev_character = '[-]', $next_character = '-', true);
}

//Start Functions used on Sales and Project
function getNameD($date)
{
	if($date == "Monday") return "Lunes";
	if($date == "Tuesday") return "Martes";
	if($date == "Wednesday") return "Miercoles";
	if($date == "Thursday") return "Jueves";
	if($date == "Friday") return "Viernes";
	if($date == "Saturday") return "Sabado";
	if($date == "Sunday") return "Domingo";
}

function getNameM($mes)
{
	if($mes == "01") return "Enero";
	if($mes == "02") return "Febrero";
	if($mes == "03") return "Marzo";
	if($mes == "04") return "Abril";
	if($mes == "05") return "Mayo";
	if($mes == "06") return "Junio";
	if($mes == "07") return "Julio";
	if($mes == "08") return "Agosto";
	if($mes == "09") return "Septiembre";
	if($mes == "10") return "Octubre";
	if($mes == "11") return "Noviembre";
	if($mes == "12") return "Diciembre";
}

function getNameMShort($mes)
{
	if($mes == "01") return "Ene";
	if($mes == "02") return "Feb";
	if($mes == "03") return "Mar";
	if($mes == "04") return "Abr";
	if($mes == "05") return "May";
	if($mes == "06") return "Jun";
	if($mes == "07") return "Jul";
	if($mes == "08") return "Ago";
	if($mes == "09") return "Sep";
	if($mes == "10") return "Oct";
	if($mes == "11") return "Nov";
	if($mes == "12") return "Dic";
}

function query($qy)
{
	return mysql_query($qy);
}

function fetch($result)
{
	return mysql_fetch_array($result);
}

function size($result)
{
	return mysql_num_rows($result);
}

function contains($texto, $caracterAConsultar)
{
	if(strpos($texto, $caracterAConsultar) == false){
		return 'false';
	} else {
		return 'true';
	}
}

//This function will process the xml received, returning the value contained in the element passed by parameter.
function getValueIn($element_name, $xml, $content_only = true)
{
	if ($xml == false) {
		return false;
	}
	$found = preg_match('#<'.$element_name.'(?:\s+[^>]+)?>(.*?)'.
			'</'.$element_name.'>#s', $xml, $matches);
	if ($found != false) {
		if ($content_only) {
			return $matches[1];  //ignore the enclosing tags
		} else {
			return $matches[0];  //return the full pattern match
		}
	}
	// No match found: return false.
	return false;
}

function validarVarFecha($campo)
{
	if (isset($_REQUEST[$campo])) {
		$fecha = $_REQUEST[$campo];
		$campo = rotateDate($fecha, '[-]', '-');

	} else {
		$campo = "";
	}

	return $campo;
}

//This function will return 1 if the string start with the character sended.
function startsWith($character, $stringCheck)
{
	return !strncmp($stringCheck, $character, strlen($character));
}
//End Functions used on Sales and Project

function separateCuit($cuit, $part)
{
	if (empty($cuit)) {
		$new_cuit = "";
	} else {
		$split_cuit = preg_split("[-]", $cuit);
		if (isset($split_cuit[$part])) {
			$new_cuit = $split_cuit[$part];
		} else {
			$new_cuit = "";
		}
	}

	return $new_cuit;
}

function separateTime($time, $part)
{
	if (empty($time)) {
		$new_time = "";
	} else {
		$split_time = preg_split("[:]", $time);
		$new_time = $split_time[$part];
	}

	return $new_time;
}

/**
 * Send an email, using data from config.php file
 */
function sendmail($title = 'From Dytar.com.ar', $content, $to, $fromName, $fromEmail, $attachment = null)
{
	require_once(GENERIC_PATH .'classes' . DS . 'class.phpmailer.php');

	$mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->Host     = config('mails.host');
	$mail->SMTPAuth = config('mails.smtpauth');
	$mail->Username = config('mails.username');
	$mail->Password = config('mails.password');
	$mail->CharSet = "UTF-8";
	// $mail->SMTPDebug = 2;


	$mail->From     = $fromEmail;
	$mail->FromName = $fromName;

	if(contains($to, ',')){
		$to_exploded = explode(',', $to);

		foreach ($to_exploded as $value) {
			$mail->AddAddress($value);
		}
	} else {
		$mail->AddAddress($to);
	}

	$mail->WordWrap = 0;
	$mail->IsHTML(true);
	$mail->Subject 	= $title;
	$mail->Body    	= "<div>" . $content . "</div>";
	$mail->AltBody 	= $content;

	if (! is_null($attachment) && ! empty($attachment)) {
		$attachment = ! is_array($attachment)  ? array($attachment) : $attachment;

		foreach ($attachment as $attachment_file) {
			$mail->addAttachment($attachment_file);
		}
	}

	if ($mail->Send()) {
		return true;
	} else {
		return false;
	}
}

function comprimir_pagina($buffer)
{
	$busca = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
	$reemplaza = array('>','<','\\1');
	return preg_replace($busca, $reemplaza, $buffer);
}

/**
 * Validate format of user names
 */
function validateUserName($string)
{
    return (bool)preg_match('/^[A-Za-z][A-Za-z0-9]{0,14}$/', $string);
}

/**
 * Encrypt a $str with a speceific $key
 */
function encrypt($str, $key)
{
    return mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $str, MCRYPT_MODE_CBC, md5(md5($key)));
}


/**
 * Decrypt a $str with a speceific $key
 */
function decrypt($str, $key)
{
    return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), $str, MCRYPT_MODE_CBC, md5(md5($key)));
}

function cleanSpaces($input)
{
	$input = htmlspecialchars($input);
	$output = preg_replace('!\s+!', ' ', $input);
	$output = str_replace(array(' ','&nbsp;'), ' ', $output);
	return trim($output);
}

function stringToArray($str)
{
	$s = trim($str);
    $r = array();

    for($i=0; $i<strlen($s); $i++) {
		if(ctype_alpha($s[$i])){
			$r[] = $s[$i];
		}
	}

    return $r;
}

function time2text($time, $default = false) {
	$b_time = $time;
    if( !is_numeric($time) ) {
    	$time = strtotime($time);
	}

    $elapsed = time() - $time;
    $a = array(
        12 * 30 * 24 * 60 * 60  =>  'año|s',
        30 * 24 * 60 * 60       =>  'mes|es',
        24 * 60 * 60            =>  'día|s',
        60 * 60                 =>  'hora|s',
        60                      =>  'minuto|s',
        1                       =>  'segundo|s'
    );

    foreach ($a as $secs => $str) {
        $d = $elapsed / $secs;

        $string = explode('|', $str);

        if ($d >= 1) {
            $r = round($d);

            if($string[0] == 'día' and $r == 1) {
            	return 'Ayer';
            }
            return 'Hace ' . $r . ' ' . $string[0] . ($r > 1 ? $string[1] : '');
        }
	}

	if ($default == true) {
		return $b_time;
	}
	return "Hace instantes";
}

function get_ip_address() {
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }

    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}


/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }
    return true;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


?>
