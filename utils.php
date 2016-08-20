<?php 
class Utils {

	public static function removeSpecialChars($s)
	{
		return ereg_replace("[ \\/\"\'\\\n\t();#,?.]","_",$s);
	}

	private static function getValuePlain($name)
	{
		if (isset($_REQUEST["$name"]))
		{
			return $_REQUEST["$name"]; 
		} else {
			return "";
		}
	}

	public static function getValue($name)
	{
		$s =  addslashes(htmlspecialchars(Utils::GetValuePlain($name)));
		return $s;
	}

	public static function getValueN($name)
	{
		$i = Utils::GetValue($name);
		if (!(is_numeric($i))) $i = null;
		return $i;
	}
	
	public static function getLength($s){
		return strlen($s);
	}

    public static function addToLog($s, $tag="")
    {
    	if ($tag!="") $tag.=" : ";
    	$fd = fopen("log.txt", 'a');
		fwrite($fd, $tag.$s);
		fwrite($fd, " \r\n");
		flush();
		fclose ($fd);	
    }
  
}
?>