<?php
   /***************************************************************************************
	****************************************************************************************
       Class Conexion_DB -> Conecta a la base de datos Access, MySQL
		   $conexion= new Conexion_DB(Usuario,Password,BD,Tipo_Servidor,[Nombre_servidor="localhost"])
	****************************************************************************************
	****************************************************************************************/ 
    class ClassConexion_DB
	{	var $usuario;
		var $pass;
		var $base;
		var $conn;
		var $tipo;
		var $servidor;
		var $tsns;
		var $cursor;
		function ClassConexion_DB($usuariop,$passp,$basep,$tipop="mysql",$servidorp="localhost")
  		{	$this->usuario=$usuariop;
			$this->pass=$passp;
			$this->base=$basep;
			$this->tipo=$tipop;
			$this->servidor=$servidorp;
			switch ($tipop)
			{	case "access":
					 $this->conn=new COM("ADODB.Connection") or die("No se pudo conectar con ACCESS");
					 $this->conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=base\\$this->base");
					 break;
				case "mysql":
                //echo "<br>Server=".$this->servidor."<br>User=".$this->usuario."<br>Pass=".$this->pass."<br>";
				    $this->conn=@mysql_connect($this->servidor,$this->usuario,$this->pass) or die("No se pudo conectar a MySQL");
					mysql_set_charset('utf8',$this->conn);
					 break;
			}
		}
		function cerrar()
		{	switch ($tipop)
			{	case "access":
					 break;
				case "mysql":
					break;
			}
		}
	}
	
	
	
	
	/****************************************************************************************************
	*****************************************************************************************************
	*****************************************************************************************************
         Class ClassConsulta -> Conecta a las tablas de una Base de Datos de datos Access, MySQL
	*****************************************************************************************************
	*****************************************************************************************************
	****************************************************************************************************/
	class ClassConsulta
	{   var $stmt;
		var $sql;
		var $numfilas;
		var $numerocampos;
		var $nombrecampos;
		var $tipocampos;
		var $largocampos;
		var $valorcampos;
		var $tipo;
		var $conexion;
		var $resultados;
		var $curpos;
	
		function ClassConsulta($sqlq,$conexiont)
		{	$this->sql=$sqlq;
			$this->tipo=$conexiont->tipo;
			$this->conexion=$conexiont;
			$this->curpos=0;
			switch ($this->tipo)
			{	case "access":
					$this->stmt=$this->conexion->Execute($this->sql);	
					$this->numerocampos=$this->stmt->Fields->Count;
					$this->numfilas=$this->stmt->RecordCount;
					for ($contador=0;$contador<$this->numerocampos;$contador++)
					{   $this->nombrecampos[$contador]=$this->stmt->Fields($contador);
					}
					break;
				case "mysql":
                  mysql_select_db($this->conexion->base);
                  $this->stmt=mysql_query($this->sql);
                  $this->numerocampos=@mysql_num_fields($this->stmt);
                  $this->numfilas=@mysql_num_rows($this->stmt);
                  $contador=0;
                  while ($nombrecampo=@mysql_field_name($this->stmt, $contador))
                     $this->nombrecampos[$contador++]=$nombrecampo;
                  $contador=0;
                  while ($tipocampo=@mysql_field_type($this->stmt, $contador))
                     $this->tipocampos[$contador++]=$tipocampo;
                  $contador=0;
                  while ($largocampo=@mysql_field_len($this->stmt, $contador))
                     $this->largocampos[$contador++]=$largocampo;
                  //{  $this->largocampos[$contador]=($largocampo/($this->tipocampos[$contador]=="string"?3:1));
                  //   echo $this->tipocampos[$contador]."<br>"; 
                  //	  $contador++;
                  //}
					break;
			}
		}
	
		function fila()
		{	flush();
			switch ($this->conexion->tipo)
			{	case "access":
					if ($this->valorcampos = @mysql_fetch_array($this->stmt))
					{	$this->curpos++;	
					    return $this->valorcampos;
					}
					else return 0;
					break;
				case "mysql":
					if ($this->valorcampos = @mysql_fetch_array($this->stmt))
					{   $this->curpos++;	
					    return $this->valorcampos;
					}
					else return 0;
					break;
			}
		}

        function movefirst()
		{  mysql_data_seek($this->stmt, 0);
		   $this->curpos=0;
		}
        
		function movenext()
		{  if($this->curpos<$this->$numfilas-1)
		   {  mysql_data_seek($this->stmt, $this->curpos+1);
   		      $this->curpos++;
		   }
		}

		function moveprevious()
		{  if($this->curpos>0)
		   {  mysql_data_seek($this->stmt, $this->curpos-1);
   		      $this->curpos--;
		   }
		}

		function movelast()
		{  mysql_data_seek($this->stmt, $this->$numfilas-1);
   		   $this->curpos=$this->$numfilas;
		}

		function insertar()
		{	switch ($this->conexion->tipo)
			{	case "access":
					break;	
				case "mysql":
					break;
			}
		}
		
		function commit()
		{	switch ($this->conexion->tipo)
			{	case "access":
					break;	
				case "mysql":
					break;
			}
		}
		
		function numerofilas()
		{	return $this->numfilas;
		}
	}
?>
