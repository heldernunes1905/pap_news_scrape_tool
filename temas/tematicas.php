<html>
    <head>
	<script type="text/javascript" src="js/scripts.js"></script>
	  <link rel="stylesheet" href="css/site.css">
    <style>
    .p{width:10px;}
    #test-button{
     font-size: 1vw;
      width:100%;}
	td { cursor: pointer; }
    </style>
    </head>
    <body>
    <script type="text/javascript">
    $(document).ready(function(){
    	  $("#inputado").on("keyup", function() {
    	    var value = $(this).val().toLowerCase();
    	    $("#tableado tr").filter(function() {
    	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    	    });
    	  });
    	});
    </script>
    <?php
    
    $string=trim($text);
    $string = str_replace('(', '"', $string);
    $string = str_replace(')', '"', $string);
	$string = str_replace('/', '"', $string);
	$string = str_replace('[', '"', $string);
    $string = str_replace(']', '"', $string);
    ?>
    <div id="data">
    	<?php $data =$string;
    	?>
    </div>
    <script type="text/javascript">
        var el = document.querySelector('.new');
    	el.innerHTML = el.innerHTML.replace(/&nbsp;/g,'');
    </script>
		<?php $lista = loadtem();?>
		<?php $lista1 = loadtem();?>
		<?php $lista2 = loadtem();?>
			<h1>Themes</h1>
    		<input id="inputado" type="text" placeholder="Search..">	
        	<table id="tablea">
                <tbody id="tableado">
          			<tr> 
        			<?php while( $fetch_tema = mysqli_fetch_array( $lista)){ 
						$tematica = $fetch_tema[1];
						$id = $fetch_tema[0];
						$other_id = $fetch_tema[2];
            	        $temasa = hl($tematica,$data);?>
               			<td><div  id="<?php echo $tematica?>" class="temas" ondblclick="myFunction(this.id)" style="background:<?php echo $temasa; ?>"><?php echo $tematica?></div></td>
               		</tr> 
					<?php }?>
               	</tbody>
           </table>
        <?php 
        function hl($inp, $words){
				$inp = strtolower($inp);
				$words = strtolower($words);
            	$replace=$words; // remove duplicates			
				//$pattern[]='/\b(' . $fword . ')(?!>)\b/i';
				$replace1='yellow';
				
				if (strpos($replace, $inp) !== false){//Verifica se a tematica é igual à palavra do texto	
					
					return str_replace($inp, $replace1, $inp);//replace word from text for yellow and style of that word will be yellow
				}
		}
		
        ?>
        <br />
<button type="button" id="test-button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Delete</button>        	
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                	<h4 class="modal-title">Themes</h4>
			
            </div>
            <div class="container"></div>
            <div class="modal-body">
				    	<?php 
        				
        				while( $fetch_tema = mysqli_fetch_array( $lista1)){ 
							$tematica = $fetch_tema[1];
							$id = $fetch_tema[0];
							$other_id = $fetch_tema[2];
							?>
        				
                       	<div  id="<?php echo $id?>" class="temas_modal" onclick="clickatem(this.id)" style="background:rgb(255, 255, 255);" ><?php print $tematica;?>&nbsp</div>
                  		
						<?php }?>
                  		
            </div>

            <div class="modal-footer"><p data-dismiss="modal" class="btn" onclick="clickando()">Delete Theme</p><a href="#" data-dismiss="modal" class="btn">Close</a>
			</div>
        </div>
    </div>
</div>	
<br />
<br />
<button type="button" id="test-button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2">Create</button>        	

<div class="modal fade rotate" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create theme</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
            <form action="./temas/insert_temas.php">
				Theme name: <input type="text" name="tname">
				<input type="text" name="fonte" style="display:none" value="<?php echo $_GET['fonte'];?>">
				<input type="text" name="id" style="display:none" value="<?php echo $_GET['id'];?>">
				<input type="text" name="temas" style="display:none" value="<?php echo $_GET['temas'];?>">
            </div>
            <div class="modal-footer">	<a href="#" data-dismiss="modal" class="btn">Close</a>
			<input type="submit" value="Create Theme">
			</form>
            </div>
        </div>
    </div>
</div>
<br />
<br />

<button type="button" id="test-button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal3">Edit themes</button>        	

<div class="modal fade rotate" id="myModal3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                	<h4 class="modal-title">Edit themes</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
			<?php 
        				while( $fetch_tema = mysqli_fetch_array( $lista2)){ 
							$tematica = $fetch_tema[1];
							$id = $fetch_tema[0];
							$other_id = $fetch_tema[2];
						?>
							<div  id="<?php echo $other_id; ?>" class="temas_edit" onclick="clickatem(this.id)" style="background:rgb(255, 255, 255);" ><?php print $tematica;?></div>
						<?php };?>
            </div>
            <div class="modal-footer">	
				<a href="#" data-dismiss="modal" class="btn">Close</a>
				<p data-dismiss="modal" class="btn" onclick="edit()">Edit theme</p>
            </div>
        </div>
    </div>
</div>
    </body>
    <script>
		fundo();
		
    	//cria o elemento dentro do div teste
    	function myFunction(p) {
    		var node = document.createElement("p");
    		
    		node.setAttribute("id", p);
    		var tema=p;
    		node.setAttribute("onclick", 'remove(this.id)');
    		node.setAttribute("class", 'tematicas');
    	    var textnode = document.createTextNode(p);
    	    node.appendChild(textnode);
    	    document.getElementById("teste").appendChild(node);
    	}
    	function edit(){
			var e = document.getElementsByClassName('temas_edit');
    		var tema_del= [];
    		for(var i=0;i<e.length;i++){
       		var c = window.getComputedStyle(e[i]).backgroundColor;
        		if(c==="rgb(237, 67, 55)") {	
    				tema_del[i]=e[i].innerHTML;
    				tema_del[i]=tema_del[i].replace(/&nbsp;/g, "");	
        		}
    		}
    		 var tema_del = tema_del.filter(function (el) {
    			  return el != null;
    			});
				var foo = [];
				var nome_novo = [];
				var nome_velho = [];
				for(var i=0;i<tema_del.length;i++){
				foo[i] = prompt('Previous Value: ' + tema_del[i]);
				var bar = confirm('Confirm name change');
				if(bar === true){
					nome_novo[i]=foo[i];
					nome_velho[i]=tema_del[i];
				}
				}
				var nome_novo = nome_novo.filter(function (el) {return el != null;});
				if(nome_novo.length===0){
					alert('No theme selected');
				}else{
					var userStr = JSON.stringify(nome_velho);
					var fooStr = JSON.stringify(nome_novo);
					var fonte = "<?php echo $_GET["fonte"]?>";
					var id = "<?php echo $_GET["id"]?>";
					var temas = "<?php echo $_GET["temas"]?>";
					$.ajax({
						url: './temas/action_page.php',
						type: 'post',
						data: {tema: userStr, novo: fooStr},
						success: function(response){
							window.location.href = "./temas/action_page.php?tema=" + userStr + "&novo=" +fooStr+ "&fonte=" +fonte+ "&id=" +id+ "&temas=" +temas;
						}
					});
				}
			
    	}
    	//funcao dentro do modal window
    	function clickatem(id){
        	 var e = document.getElementById(id);
        	 var c = window.getComputedStyle(e).backgroundColor;
        	 if (c === "rgb(237, 67, 55)") {
        		 document.getElementById(id).style.background = "white";
        	 } else{
        	     document.getElementById(id).style.background = "rgb(237, 67, 55)";
			 }
    	}
    	function clickando(){
    		var e = document.getElementsByClassName('temas_modal');
    		var tema_del= [];
    		for(var i=0;i<e.length;i++){
       		var c = window.getComputedStyle(e[i]).backgroundColor;
        		if(c==="rgb(237, 67, 55)") {	
    				tema_del[i]=e[i].innerHTML;
    				tema_del[i]=tema_del[i].replace(/&nbsp;/g, "");
    				
        		}
    		}
    		var tema_del = tema_del.filter(function (el) {
    			  return el != null;
    			});
    		var userStr = JSON.stringify(tema_del);
    		var fonte = "<?php echo $_GET["fonte"]?>";
    		var id = "<?php echo $_GET["id"]?>";
    		var temas = "<?php echo $_GET["temas"]?>";
    		$.ajax({
    		    url: './temas/upload_temas.php',
    		    type: 'post',
    		    data: {user: userStr},
    		    success: function(response){
    		    	window.location.href = "./temas/upload_temas.php?user=" + userStr + "&fonte=" +fonte+ "&id=" +id+ "&temas=" +temas;
    		    }
    		});
    				
        	}
        //remover a tag se for inserida por engano no texto
		function remove(gov){
			var final = confirm('Deseja retirar a temática:'+ gov + ' da noticia' );
			if(final === true){
				var parent = document.getElementById("teste");
				var child = document.getElementById(gov);
				parent.removeChild(child);
			}
		}
		function fundo(){
		//sort
    	$("#tableado tr").sort(function (a, b){
			var stuff = $("div", b).css("background") < $("div", a).css("background") ? 1 : -1;   
			var node = document.createElement("p");
    		
    		
			return stuff;
    	}).appendTo('#tablea');

		}
		var temas_cor = document.getElementsByClassName('temas');
		//insere automatico as tematicas na noticia
		/*for(var i = 0; i<temas_cor.length;i++){
			if ($(temas_cor[i]).css('background-color')=="rgb(255, 255, 0)"){
			var p = temas_cor[i].innerHTML;
			
			var node = document.createElement("p");
    		node.setAttribute("id", p);
    		var tema=p;
    		node.setAttribute("onclick", 'remove(this.id)');
    		node.setAttribute("class", 'tematicas');
    	    var textnode = document.createTextNode(p);
    	    node.appendChild(textnode);
    	    document.getElementById("teste").appendChild(node);
			} 

		}*/

    </script>
</html>