<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
	<link rel="stylesheet" href="docsupport/style.css">
  <link rel="stylesheet" href="docsupport/prism.css">
  <link rel="stylesheet" href="css/chosen.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="./src/richtext.min.css">
	<link rel="stylesheet" href="css/site.css">


 </head>
  <body ng-app="staticSelect">
<form method= "POST">
			<?php $lista = loadtem();
								
				  $fontes = loadfonte();

				
				  $fonte_break = $_COOKIE['fonte'];
				  $fonte_break = explode(",",$fonte_break);
				  $fontes_break = array();

				  $tema_break = $_COOKIE['tematica'];
				  $tema_break = explode(",",$tema_break);
				  $temas_break = array();
				  
				  $i=0;
				  $j=0;
				  foreach($fonte_break as $fonte_b){
					  $fontes_break[$i] = $fonte_b;
					  
					  $i+=1;
				  }
				foreach($tema_break as $tema_b){
					$temas_break[$j] = $tema_b;
					$j+=1;
				}
			?>
    		<select id="estado" name='estado'>
    				<option value="nao_publicado" name="estado">Nao Publicado</option>
    	    	<option value="publicado" name="estado">Publicado</option>            
   			</select>
			   <?php $options = mysqli_query($conn,"SELECT * FROM usuario");?>
   			<select id="user" name='user'>
   			    <option value="0" name="user">Todos os utilizadores</option>  			
				<?php while( $option = mysqli_fetch_array($options)){  ?>
					<option value="<?php echo $option[1]; ?>" name="user"><?php echo $option[1]?></option>            
				<?php }?>
       			</select>
				   <select data-placeholder="Tematicas" multiple class="chosen-select" tabindex="18" id="tematicas">
				 <?php $p=0;
					 sort($temas_break);
					 while( $row = mysqli_fetch_array( $lista)){ ?>
			 <?php
			   if($row[1] == $temas_break[$p]){ ?>
   			    <option value="<?php echo $row[1]?>" <?php echo 'selected '; ?> name="tematica"><?php echo $row[1];$p+=1;?></option>
			   <?php }else{?>
				<option value="<?php echo $row[1]?>" name="tematica"><?php echo $row[1]?></option>
				 <?php } 
				}?>
   			</select>
			   <select data-placeholder="Fontes" multiple class="chosen-select" tabindex="18" id="multiple-label-example">
			   <?php $j=0;
			   sort($fontes_break);
				 while( $fetch_fonte = mysqli_fetch_array( $fontes)){ ?>
					<?php
				if($fetch_fonte[0] == $fontes_break[$j]){ ?>
				   <option value="<?php echo $fetch_fonte[1];?>" <?php echo 'selected '; ?>name="fonte"><?php echo $fetch_fonte[0].', ';echo $fetch_fonte[1];$j+=1;?></option>
				  <?php }else{?>
					<option value="<?php echo $fetch_fonte[1];?>" name="fonte"><?php echo $fetch_fonte[0].', ';echo $fetch_fonte[1]?></option>
					<?php } 
				};?>
          </select>
			<input type="date" name="1ª data" id="data_1">
			<input type="date" name="2ª data" id="data_2">

			<!--<select id="avia" name='avia'>
			<option value="0" name="avia">todos os graus</option>	
				<option value="1" name="avia">1</option>
    	  <option value="2" name="avia">2</option>
				<option value="3" name="avia">3</option>             
   		</select>

			<select id="favorito" name='favorito'>
				<option value="1" name="avia">1-Totalmente relacionado e altamente não favorável</option>
    	  		<option value="2" name="avia">2-Relacionado e altamente não favorável</option>
				<option value="3" name="avia">3-Totalmente relacionado e não favorável</option> 
				<option value="4" name="avia">4-Relacionado sem favorabilidade assumida</option>
				<option value="5" name="avia">5-Totalmente relacionado sem favorabilidade assumida</option> 
				<option value="6" name="avia">6-Relacionado e altamente favorável</option>
				<option value="7" name="avia">7-Totalmente relacionado e altamente favorável</option> 
   			</select>
				 
			<select id="highlighted" name='highlighted'>
						<option value="0" name="highlighted">realcados e nao realcados</option>
						<option value="realcar" name="highlighted">realcar</option>
    	    	<option value="nao realcar" name="highlighted">nao realcar</option>            
   			</select>-->
   			<input type="submit" name="submit" onclick="clickar()" value="Filtrar" id="submit" />	
				
			<input type="button" data-toggle="modal" data-target="#ModalRelatorio" value ="Relatorio"/>        	
			<div class="modal fade" id="ModalRelatorio">
				<div class="modal-dialog1">
					<div class="modal-content">
						<div class="modal-header">
								<h4 class="modal-title">Relatorio de Erros</h4>
						</div>
						<div class="container"></div>
						<div class="modal-body">
									<?php 
									$lista = relatorio();
									while( $fetch_tema = mysqli_fetch_array( $lista)){ 
										$fonte = $fetch_tema[1];
										$id = $fetch_tema[0];
										$link = $fetch_tema[4];
										$id_rel = $fetch_tema[7];
										?>
									<div>Fonte:<?php echo $fonte ?></div>
									<div  id="<?php echo $id_rel?>" class="rel_modal" onclick="clicka(this.id)" style="background:rgb(255, 255, 255);" ><?php echo $link ?></div>
									
									<?php }?>
									
						</div>

						<div class="modal-footer"><p data-dismiss="modal" class="btn" onclick="remove_rel()">Eliminar as tematicas</p><a href="#" data-dismiss="modal" class="btn">Close</a>
						</div>
					</div>
				</div>
			</div>	
			<i class="fas fa-sync-alt" onclick="refresh()"></i>
   			<script type="text/javascript">
			   	function clicka(id){
					var e = document.getElementById(id);
					var c = window.getComputedStyle(e).backgroundColor;
					if (c === "rgb(237, 67, 55)") {
						document.getElementById(id).style.background = "white";
					} else{
						document.getElementById(id).style.background = "rgb(237, 67, 55)";
					}
				}
				function remove_rel(){
				var e = document.getElementsByClassName('rel_modal');
				var tema_del= [];
				for(var i=0;i<e.length;i++){
				var c = window.getComputedStyle(e[i]).backgroundColor;
					if(c==="rgb(237, 67, 55)") {	
						tema_del[i]=e[i].id;
						tema_del[i]=tema_del[i].replace(/&nbsp;/g, "");
						
					}
				}
				var tema_del = tema_del.filter(function (el) {
					return el != null;
					});
				var userStr = JSON.stringify(tema_del);
				$.ajax({
					url: './remove_rel.php',
					type: 'post',
					data: {user: userStr},
					success: function(response){
						window.location.href = "remove_rel.php?id=" + userStr ;
					}
				});
						
        	}
			document.getElementById("estado").onchange = function() {
            	localStorage['estado'] = document.getElementById("estado").value;
            }
			document.getElementById("user").onchange = function() {
				localStorage['user'] = document.getElementById("user").value;
            }
			document.getElementById("multiple-label-example").onchange = function() {
				localStorage['multiple-label-example'] = document.getElementById("multiple-label-example").value;
            }
			document.getElementById("tematicas").onchange = function() {
				localStorage['tematicas'] = document.getElementById("tematicas").value;
            }
			document.getElementById("data_1").onchange = function() {
				localStorage['data_1'] = document.getElementById("data_1").value;
            }
			document.getElementById("data_2").onchange = function() {
				localStorage['data_2'] = document.getElementById("data_2").value;
            }

			/*document.getElementById("avia").onchange = function() {
				localStorage['avia'] = document.getElementById("avia").value;
				document.cookie = "avia="+localStorage['avia'];

            }

			document.getElementById("favorito").onchange = function() {
				localStorage['favorito'] = document.getElementById("favorito").value;
				document.cookie = "favorito="+localStorage['favorito'];

            }

			document.getElementById("highlighted").onchange = function() {
				localStorage['highlight'] = document.getElementById("highlighted").value;
				document.cookie = "highlight="+localStorage['highlight'];

            }*/

			var data1,data2;
            window.onload= function(){

            	if(localStorage['user'])
                    document.getElementById("user").value = localStorage['user'];
                
                if(localStorage['estado'])
                    document.getElementById("estado").value = localStorage['estado'];
                
				if(localStorage['multiple-label-example'])
                    document.getElementById("multiple-label-example").value = localStorage['multiple-label-example']; 
			
				if(localStorage['tematicas'])
                    document.getElementById("tematicas").value = localStorage['tematicas']; 
				
				if(localStorage['data_1']){
                    document.getElementById("data_1").value = localStorage['data_1']; 
					data1 = $('#data_1').val();
					
					document.cookie = "data1="+data1;

				}
				if(!data1){
					document.cookie = "data1=1900-01-01";
				}
				if(localStorage['data_2']){
                    document.getElementById("data_2").value = localStorage['data_2'];            
					data2 = $('#data_2').val();
					document.cookie = "data2="+data2;
				}
				if(!data2){
					
					var d = new Date();
					var month = d.getMonth()+1;
					var day = d.getDate()+1;

					var output = d.getFullYear() + '-' +
						((''+month).length<2 ? '0' : '') + month + '-' +
						((''+day).length<2 ? '0' : '') + day;
					document.cookie = "data2="+output;
				}
				if(localStorage['avia'])
            document.getElementById("avia").value = localStorage['avia'];

					if(localStorage['favorito'])
									document.getElementById("favorito").value = localStorage['favorito'];
						
					if(localStorage['highlight'])
									document.getElementById("highlighted").value = localStorage['highlight'];
				
				

				
				
			}
			function clickar(){
				
				var fonte=$("#multiple_label_example_chosen").find("ul").find("li").find("span");
				var slice = [];
				for(var i = 0; i<fonte.length;i++){
					slice[i]=fonte[i].innerHTML;
				}
				var energy = [];
				for(var i = 0; i<fonte.length;i++){
					energy[i]=slice[i].slice(0, 1);
				}
				var energy = energy.join();
				document.cookie = "fonte="+energy;

				var tema=$("#tematicas_chosen").find("ul").find("li").find("span");
				var temas = [];
				for(var i = 0; i<tema.length;i++){
					temas[i]=tema[i].innerHTML;
				}
				var temas = temas.join();
				document.cookie = "tematica="+temas;
				document.location.reload(true)
			}
			function refresh(){
				window.location = './noticias/refreshes.php';
			}
			
			
        </script>
		</form>

		<script src="docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="js/chosen.jquery.js" type="text/javascript"></script>
  <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script src="docsupport/init.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>