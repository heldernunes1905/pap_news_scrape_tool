<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
.tematicas{
	background-color:lightblue;
	display: inline-block;
	padding: 5px;
}
</style>
</head>
<body>
	<?php
	$listaArtigo = getArtigo($_GET["id"]);
	
	while( $row = mysqli_fetch_array( $listaArtigo)){  
		$id = $row[0];
		$resumo = $row[4];
		$img = $row[9];
		$text = $row[3];
		$date = $row[6];
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y h:i:s');		
		$temas = $row[13];
		$publi = $row[8];

		if($publi == 0){
			$title1 = $row[1];
		}else{
			$title1 = $row[2];
		}
		
		
		$link = $row[7];
		$date_pub = $row[15];
		if(!empty($date_pub)){
			$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y h:i:s');	
		}
	}
    ?>
    <form action="POST">
    	<div class="new">
    	<!-- Mostrar os elementos da noticia -->
        	<?php echo '<p id="titlefirst">'.$title1.'</p>'; ?>
			<?php echo '<p>'.$resumo.'</p>'; ?>
			<?php echo $img;?>      
			
			<?php if($publi == 1){ 
				echo $publi;
				echo '<p>'.$date_pub.'</p>'; 
			}else{
				
				echo '<p>'.$date.'</p>'; 
			}?>
        	<div class=text><?php echo '<p>'.$text.'</p>'; ?></div>
        		<div id="id" style="display:none"><?php echo $id?></div>
			<?php
			/* Mostra as temáticas da noticias mas não é preciso aparecer
			$temas =  explode(',',$temas);?>
			<div id ="teste"><?php 
			
        	foreach($temas as $array){?>
        	
    		<p style="display:none" id="user_name"><?php echo $logged_in[1];?></p>
        	<?php 
			echo '<p id="'.$array.'" onclick="remove(this.id)" class="tematicas">'.$array.'</p>';
			}
				$arr_edits = ['1', $logged_in[1]];
				$arr_edits = implode(",",$arr_edits);
			    $query = mysqli_query($conn,"UPDATE noticias SET editing='$arr_edits' WHERE id =".$_GET["id"]);
				?>
				

        	</div>*/?>
        </div>	
			<?php 
			if($publi == 1 && !empty($logged_in[1])){
				echo $link.'<br />';
				?><input type="button" id="despub" value="Despublicar"/>
				<script> 
				var despubli = document.getElementById('despub');
				despubli.addEventListener('click', function() {
         		document.location.href = 'noticias/noticia/despublicar.php?id='+id+'&fonte='+fonte;
    			});
				</script>
				<?php
			}else if($publi == 1 && empty($logged_in[1])){
				echo $link.'<br />';
			}else{
				$temas =  explode(',',$temas);?>
			<div id ="teste"><?php 
			
        	foreach($temas as $array){?>
        	
    		<p style="display:none" id="user_name"><?php echo $logged_in[1];?></p>
        	<?php 
			echo '<p id="'.$array.'" onclick="remove(this.id)" class="tematicas" >'.$array.'</p>';
			}
				$arr_edits = ['1', $logged_in[1]];
				$arr_edits = implode(",",$arr_edits);
			    $query = mysqli_query($conn,"UPDATE noticias SET editing='$arr_edits' WHERE id =".$_GET["id"]);
				?>
				

        	</div>
			<?php echo $link.'<br /><br />'?>
			AVE:<select id="avia" name='avia'>
				<option value="1" name="avia">1</option>
    	  		<option value="2" name="avia">2</option>
				<option value="3" name="avia">3</option>             
			   </select>
			   <br />
			Favorabilidade:<select id="favorito" name='favorito'>
				<option value="1" name="avia">1-Totalmente relacionado e altamente não favorável</option>
    	  		<option value="2" name="avia">2-Relacionado e altamente não favorável</option>
				<option value="3" name="avia">3-Totalmente relacionado e não favorável</option> 
				<option value="4" name="avia">4-Relacionado sem favorabilidade assumida</option>
				<option value="5" name="avia">5-Totalmente relacionado sem favorabilidade assumida</option> 
				<option value="6" name="avia">6-Relacionado e altamente favorável</option>
				<option value="7" name="avia">7-Totalmente relacionado e altamente favorável</option> 
			   </select>
			   <br />
			   Realcar:<input type="checkbox" id="checkselect">
			<br />
        	<input type="button" id="editar" value="Editar" class="btn btn-warning"/>
        	<input type="button" id="apagar" value="Apagar" class="btn btn-danger"/>
			<input type="button" id="publicar" value="Publicar"onclick="myAjax()" class="btn btn-success"/>
			<?php }?>
     </form>
	 

	 <script type="text/javascript">
	 
     var edit = document.getElementById('editar');
     var del = document.getElementById('apagar');
	 var pub = document.getElementById('publicar');

	 var tema = document.getElementById('ins_tema');
	 var user = document.getElementById('user_name');
	 
	 var date = '<?php echo $date;?>';
	 document.cookie = "old_data="+date;
     var id = document.getElementById('id').innerHTML;
     var fonte = "<?php echo $_GET["fonte"]?>";
     
     edit.addEventListener('click', function() {
		var user = "<?php echo $logged_in[1]?>";	
         document.location.href = 'index.php?fonte='+fonte+'&id=' + id +'&editar=0&user_name='+user+'&temas=0';
     });
     
     del.addEventListener('click', function() {
         document.location.href = 'index.php?id=' + id + '&fonte='+fonte+'&apagar=0';
     });
	 
     function myAjax() {
		var isChecked = $('#checkselect').prop('checked');
		if(isChecked == true){
			var highlight = "realcar";
		}else{
			var highlight = "nao realcar";
		}
		var title = document.getElementById("titlefirst").innerHTML;
		var imgdiv = '<?php echo $img;?> ';
		var resumo = '<?php echo $resumo;?>';
		var fonte = "<?php echo $_GET["fonte"]?>";
		var user = "<?php echo $logged_in[1]?>";
		var texto = document.getElementsByClassName("text");
		var date = '<?php echo $date;?>';

		var text = texto[0].innerHTML;
		text = text.replace("\n",' ');
		text = text.replace("\r",' ');
		text = text.replace("\t",' ');
		text = text.replace("<p>",' ');
		text = text.replace("</p>",' ');
		imgdiv = imgdiv.replace(/\//g,'barras');
		imgdiv = imgdiv.replace(/\;/g,'ponto_virg');
		imgdiv = imgdiv.replace(/\#/g,'cardinal');
		imgdiv = imgdiv.replace('<img','menor_img');
		imgdiv = imgdiv.replace('>','maior_img');
		imgdiv = imgdiv.replace(/\&/g,'outros');
		title = title.replace(/\&/g,'outros');
		title = title.replace(/\#039;/g,'peliculas');
		
		var ave = $('#avia').val();
		var favoratibilidade = $('#favorito').val();
		document.cookie="ave=" + ave;
		document.cookie="favoratibilidade=" + favoratibilidade;
		document.cookie="highlight=" + highlight;
		var temas = document.getElementsByClassName("tematicas");
		var temas_insert = [];
		 for(var i=0;i<temas.length;i++){
			temas_insert[i]=temas[i].id;
			 }	 
			 
			temas_insert = temas_insert.filter(Boolean);
			var uniqueNames = [];
			$.each(temas_insert, function(i, el){
    			if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
			var id = document.getElementById('id').innerHTML;
			var userStr = JSON.stringify(uniqueNames);
			localStorage['text'] = text;
			$.ajax({
				url: './noticias/noticia/edit.php',
				type: 'POST',
				data: {text: text},
				success: function(response){
					var localData = localStorage["text"];
					localData.replace(/\s/g,'');							
					localData=localData.replace('\n\n', '\n');
					localData=localData.replace(/\;/g, ' ');
					localData=localData.replace(/\s+/g, ' ');
					localData = localData.replace(/!/g,' ');
										
					document.cookie = "text="+localData;
					document.location.href = './noticias/noticia/edit.php?resumo='+resumo+'&img='+imgdiv+'&title='+title+'&id='+id+'&date='+date+'&fonte='+fonte+'&user_name='+user+'&tematicas='+userStr;
				}
			});
			
	 }
     
     tema.addEventListener('click', function() {
         var temas=document.getElementsByClassName('tematicas');
		 var temas_insert = [];
		 for(var i=0;i<temas.length;i++){
			temas_insert[i]=temas[i].id;
			 }	 
			 
			temas_insert = temas_insert.filter(Boolean);
			var uniqueNames = [];
			$.each(temas_insert, function(i, el){
    			if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
		var userStr = JSON.stringify(uniqueNames);
		document.location.href = './temas/temas_texto.php?id=' + id + '&fonte='+fonte+'&temas=0&tematicas='+userStr;
     });
	 
		
     </script>
</body>
</html>

