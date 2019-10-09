    <div class="wraper">
        <header class="encabezado">
             <div class="imagen1"> <img src="estilo/css/images/logotecpie2.png" style="max-width:150px;"></div>
             <div class="titulo1"><p><?php echo utf8_decode("$tec");?></p></div>
             <div class="titulo2"><p>"<?php echo $lema;?>"</p></div>
         </header>
    </div><!--wraper-->
    <div class="wraper"> <!--inicia envoltura -->
        <section id="navigation-main">
          <div class="navbar">
            <div class="navbar-inner"> <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span></a>
              <div class="nav-collapse" style="font-family:TrojanServer; size:5">
                <ul class="nav">
                  <li class="dropdown"> <a href="<?php echo $index;?>"><i class="icon-home"></i></a></li>
                  <li class="dropdown"> <a class="dropdown-toggle" href="<?php echo $index;?>">P&aacute;gina Principal <!--<b class="caret"></b>--></a> 
                    <!--<ul class="dropdown-menu"></ul>--> 
                  </li>
                  <li class="dropdown" style="width:400px">&nbsp;</li>
                  <?php if(isset($imprimir))echo '<li class="dropdown"><a class="dropdown-toggle" href="javascript:window.close()">Cerrar</a></li>';
								else echo isset($_POST["grafDepto"])?'<li class="dropdown"><a href="javascript:void(0);" id="regresarDepto">Regresar</a></li>':''; ?>
                  <li class="dropdown"><a class="dropdown-toggle" href="<?php echo (isset($imprimir)?"javascript:window.print()":(isset($DesAca)&&$DesAca!=""?"evaldocAgradece.php":$index));?>"><?php echo isset($DesAca)&&$DesAca!=""?"Cerrar sesi&oacute;n":(isset($imprimir)?"Imprimir":"Salir");?></a></li>
                </ul>
              </div><!-- /.nav-collapse --> 
            </div><!-- /#div navbar-inner -->
          </div><!-- /#div navbar -->
        </section><!-- /#navigation-main -->
    </div><!-- cierra la envoltura del menu -->