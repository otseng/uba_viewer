<?php
class Log 
{
	/**

	{m}  - message
	{n}  - detail
	{l}  - level
	{f}  - filename (exceptions only)
	{c}  - code (exceptions only)
	{i}  - line (exceptions only)

	{ip} - ip address
	{id} - user id
	{s}  - session id
	{r}  - referer
	{ua} - user agent
	
	%Y   - year
	%m   - month
	%d   - day
	%H   - hour
	%i   - minute
	%s   - second
	%u   - millsecond
	
	More at:
	http://php.net/function.date.html
	**/
	
    public static function fatal($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('fatal', $msg1, $msg2, $e);
    }

    public static function hack($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('hack', $msg1, $msg2, $e);
    }

    public static function security($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('security', $msg1, $msg2, $e);
    }

    public static function error($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('error', $msg1, $msg2, $e);
    }
      
    public static function warn($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('warn', $msg1, $msg2, $e);
    }
    
    public static function info($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('info', $msg1, $msg2, $e);
    }
    
    public static function debug($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('debug', $msg1, $msg2, $e);
    }
    
    public static function trace($msg1='', $msg2='') 
    {
        $e = null;
        if ($msg1 instanceof Exception)
        {
            $e = $msg1;
            $msg1 = '';
        }
        
        Log::logIt('trace', $msg1, $msg2, $e);
    }
    
    private static function logIt($level, $msg1, $msg2, $e) 
    {
        global $PW;
                    
        if (isset($PW['log'][$level])) {
	        foreach ($PW['log'][$level] as $entry) {
	            
	            switch($entry['type']) 
	            {
	                case 'file':
	                    $msg = Log::convertMsg($entry['format'], $msg1, $msg2, $level, $e);
	                    try
	                    {
	                        $filename = $entry['filename'];
	                        if (!StringUtil::contains($filename,'/')) {
	                        	$filename = $PW['dir']['log'].'/'.$filename;
	                        }
	                        FileUtil::append($filename, $msg);
	                    }
	                    catch (PWException $e)
	                    {
	                        echo $e->getMessage() . '<br />';
	                    }
	                    break;
	                    
	                case 'screen':
	                    $msg = Log::convertMsg($entry['format'], $msg1, $msg2, $level, $e);
	                    $msg = str_replace("\n", "<br />\n", $msg);
	                    echo $msg;
	                    break;
	                    
	                case 'shell':
	                    exec($entry['command']);
	                    break;
	                    
	                case 'db':
	                    include_once($PW[dir]['util'] . '/database.php');
	                    $sql = Log::convertMsg($entry['statement'], $msg1, $msg2, $level, $e);
	                                          
	                    $d = new Database($entry['database']);
	                    
	                    if ($d->isInitialized()) {
	                        $d->connect();  
	                        $d->execute($sql); 
	                        $d->close();
	                    }
	                    break;
	                    
	                case 'session':
	                    $msg = Log::convertMsg($entry['format'], $msg1, $msg2, $level, $e);
	                    $_SESSION[$entry['name']] = $msg;
	                    break;
	                         
	                case 'email':
						if ($PW['env']['type'] != Env::DEV) { 			
		                    $msg = Log::convertMsg($entry['format'], $msg1, $msg2, $level, $e);
		
						    mail($entry['recipient'],
					        '[Site logging ('.$level.')]',
					        $msg,
					        "From: ".$entry['from']
					        );
						}
					    break;
	                                       
	                default:
	                    echo 'unknown log handler';
	            
	            }
	        }
        }
    } 
    
    private static function convertMsg($format, $msg1, $msg2, $level, $e) 
    {    
        $new = $format;
        for ($i=0; $i<strlen($format); $i++) {
            if ($format[$i] == '%') {
                $letter = $format[$i+1];
                if ($letter == '%') {
                    $new = str_replace('%%', '%', $new); 
                    $i++;  
                }
                else {
                    $new = str_replace('%'.$letter, date($letter), $new);
                }
            }
        }
        
        $new = str_replace("{n}", $msg2, $new);
        $new = str_replace("{l}", $level, $new);

		$ip = $_SERVER['REMOTE_ADDR'];
        $new = str_replace("{ip}", $ip, $new);

		if (isset($_SESSION['user'])) {
			$id = $_SESSION['user']['userId'];
			$new = str_replace("{id}", $id, $new);
		}
		
		$session = session_id();
		$new = str_replace("{s}", $session, $new);

		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
		$new = str_replace("{r}", $referer, $new);

		$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
		$new = str_replace("{ua}", $userAgent, $new);

        if ($e instanceof Exception)
        {
            $new = str_replace("{f}", $e->getFile(), $new);
            $new = str_replace("{c}", $e->getCode(), $new);
            $new = str_replace("{m}", $e->getMessage(), $new);
            $new = str_replace("{i}", $e->getLine(), $new);
        }
        else
        {
            $new = str_replace("{f}", "NA", $new);
            $new = str_replace("{c}", "NA", $new);
            $new = str_replace("{m}", $msg1, $new);
            $new = str_replace("{i}", "NA", $new);
        }
        
        return $new;
    }
}
?>
