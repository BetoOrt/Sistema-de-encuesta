<?php 
	function Repetir($car, $lon)
	{   $cad=null;
	  for($i=0;$i<$lon;$i++) $cad.=$car;
	  return $cad;
	}
	function InStr($cad, $bus)
	{   $nPos=0;
		for($I=0;$I<strlen($cad);$I++)
		   if(substr($cad,$I,1)==$bus)
		   {  $nPos=$I;
			  $I=strlen($cad);
		   }
		return($nPos);
	}
	function left($cad, $nLen)
	{   return(substr($cad,0,$nLen));
	}
	
	function right($cad, $nLen)
	{   $sub=$cad;
		if(strlen($cad)>$nLen)$sub=substr($cad,strlen($cad)-$nLen,$nLen);
		return($sub);
	}
	
	function soloCampo($cad)
	{   $sub=$cad;
	    if(strrpos($cad,'.')>0)
		    $sub=substr($cad,strrpos($cad,'.')+1,strlen($cad));
	    return $sub;
	}	
?>
