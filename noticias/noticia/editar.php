<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/site.css">
        <link rel="stylesheet" href="./src/richtext.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="./src/jquery.richtext.js"></script>
	<style>
		.text_editor{
			border-bottom: 0.5px solid grey;
			border-top: 0.5px solid grey;
		}
	</style>
</head>
<body>

    <h1>Article</h1> 
    <?php
	$listaArtigo = getArtigo($_GET['id']);
	while( $row = mysqli_fetch_array( $listaArtigo)){  
		$id = $row[0];
		$title = $row[1];
		$resumo = $row[4];
		$img = $row[9];
		$text = $row[3];
		
		$date = $row[6];
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y h:i:s');		
		$temas = $row[13];
		$link = $row[7];
	}
    ?>
        	<div id="page-wrapper box-content">
        	<textarea class="content" name="example">
				<div class="text_editor" id="link"><?php echo $link ?></div>
				<div class="text_editor" id="title" ><?php echo $title; ?></div>
				<div class="text_editor" id="resumo"><?php echo $resumo;?></div>
        		<div class="text_editor" id="imgdiv" style="width:100%;height:140%;"><?php echo $img;?></div>
        		<div class="text_editor" id="date"><?php echo $date; ?></div>
				<div class="text"><?php echo $text;?></div>
				<?php $temas =  explode(',',$temas);?>
				<div class="text_editor" id ="teste"><?php 
					foreach($temas as $array){
						
						echo '<p class="text_editor" id="'.$array.'" onclick="remove(this.id)" class="tematicas">'.$array.'</p>';
					}?>
				</div><hr>
          	    <div id="id" style="display:none"><?php echo $id; ?></div>
				  <select id="avia" name='avia'>
				<option value="1" name="avia">1</option>
    	  		<option value="2" name="avia">2</option>
				<option value="3" name="avia">3</option>             
   			</select>
			<select id="favorito" name='favorito'>
			<option value="1" name="avia">1-Totally related and highly not favorable</option>
    	  		<option value="2" name="avia">2-Related and highly not favorable</option>
				<option value="3" name="avia">3-Totally related and not favorable</option> 
				<option value="4" name="avia">4-Related with unassumed favorability</option>
				<option value="5" name="avia">5-Totally related without favorability assumed</option> 
				<option value="6" name="avia">6-Related and highly favorable</option>
				<option value="7" name="avia">7-Totally related and highly favorable</option> 
   			</select>
			   Highlight:<input type="checkbox" id="checkselect">
        	</textarea>
        	</div>
    	    <button id ="btnStatus" type="button" onclick="myAjax()">Save</button>
			    
	<p style="display:none" id="user_name"><?php echo $logged_in[1];?></p>
	
    <script>
    $(document).ready(function() {
        $('.content').richText();
    });
    function myAjax() {
		var isChecked = $('#chkSelect').prop('checked');
		if(isChecked == true){
			var highlight = "realcar";
		}else{
			var highlight = "nao realcar";
		}
		
		var user = document.getElementById('user_name');
		var id = document.getElementById("id").innerHTML;
		document.cookie="id="+id;
		var title = document.getElementById("title").innerHTML;
		document.cookie="title="+title;
		var resumo = document.getElementById("resumo").innerHTML;
		document.cookie="resumo="+resumo;
		var date = document.getElementById("date").innerHTML;
		var ave = $('#avia').val();
		var favoratibilidade = $('#favorito').val();
		document.cookie="ave=" + ave;
		document.cookie="favoratibilidade=" + favoratibilidade;
		document.cookie="highlight=" + highlight;
		var texto = document.getElementsByClassName("text");
		var text = texto[0].innerHTML;
		text = text.replace(/&nbsp;/g, ' ');
		var teste=[];
		for(var i=0;i<texto.length;i++){
			teste[i]=text;
		} 
		teste=teste.join('|');
		teste.replace(/\s/g,'');
		
		while (teste.indexOf('\n\n')>-1){
			teste=teste.replace('\n\n', '\n');
		}
		teste=teste.replace(/\s+/g, '!');
		teste = teste.replace(/!/g,' ');
		localStorage['text'] = teste;

		var img = document.getElementById("imgdiv").innerHTML;

		text = text.replace("\n",' ');
		text = text.replace("\r",' ');
		text = text.replace("\t",' ');
		text = text.replace("<p>",' ');
		text = text.replace("</p>",' ');
		
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
			var userStr = JSON.stringify(uniqueNames);
			img = img.replace(/\//g,'barras');
			img = img.replace(/\;/g,'ponto_virg');
			img = img.replace(/\#/g,'cardinal');
			img = img.replace('<img','menor_img');
			img = img.replace('>','maior_img');
			img = img.replace(/\&/g,'outros');
			img = img.replace(/;/g,'|');
			document.cookie="img="+img;
			var fonte = "<?php echo $_GET["fonte"]?>"
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
					document.location.href = './noticias/noticia/edit.php?resumo='+resumo+'&img='+img+'&title='+title+'&id='+id+'&date='+date+'&fonte='+fonte+'&user_name='+user+'&tematicas='+userStr;
				}
			});
		
	}
		var ave = '<?php echo $row[16] ?>';
		var favoratibilidade = '<?php echo $row[17] ?>';
		var highlighted = '<?php echo $row[18] ?>';
		
		localStorage['ave'] = ave;
		localStorage['favoratibilidade'] = favoratibilidade;
		localStorage['highlighted'] = highlighted;
		
		window.onload= function(){
		if(localStorage['ave'])
            document.getElementById("ave").value = localStorage['ave'];

		if(localStorage['favoratibilidade'])
            document.getElementById("favoratibilidade").value = localStorage['favoratibilidade'];
			
		if(localStorage['highlighted'])
            document.getElementById("highlight").value = localStorage['highlighted'];
		}
    </script>
</body>
</html>
