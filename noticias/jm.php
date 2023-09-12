<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		

	</head>
	<body>
		<h1>News</h1>	
		<!--<div class="dropdown">
			<button onclick="myFunction1()" class="dropbtn"><i class="fas fa-search"></i></button>
			<div id="myDropdown1" class="dropdown-content">-->
				<input id="myInput" type="text" placeholder="Search..">		
			<!--</div>
		</div>-->
		<?php
		$fonte=$_GET["fonte"];
		$ida = getfonte_id($fonte);
		
		?>
        
               
		<?php
		$id = $ida;
		$lista = nonews($id,$selected_tema2,$selected_data1,$selected_data2);
		$selected_val = $_COOKIE['estado'];
		$selected_user = $_COOKIE['user'];
		$selected_tema = $_COOKIE['tematica'];
		$selected_data1 = $_COOKIE['data1'];
		$selected_data2 = $_COOKIE['data2'];
		$id_not = array();
			$title = array();
			$resumo = array();
			$date = array();
			$img = array();
			$editing = array();
			$i=0;
			
    				if($selected_val === "publicado" && $selected_user === "a" || $selected_val === "publicado" && $selected_user === "s"){
						
						if($selected_avi === '0' && $selected_favorito === '0' && $selected_highlight === '0'){
							
							$lista = usernews($selected_user,$id,$selected_tema,$selected_data1,$selected_data2);
							while($row = mysqli_fetch_array( $lista)){	
								
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}
								$i++;
							}
						}else if($selected_avi === '0' && $selected_favorito === '0' || $selected_avi === '1' && $selected_favorito === '0' || $selected_avi === '2' && $selected_favorito === '0' || $selected_avi === '3' && $selected_favorito === '0'){
							if($selected_highlight === '0'){
								$lista = get_user_publ_new($id,$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_avi);
							}else{
								$lista = get_user_publ_new1($id,$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_highlight);
							}
							while($row = mysqli_fetch_array( $lista)){				
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}
								$i++;
							}
						}else if($selected_avi === '0' && $selected_highlight === '0' || $selected_avi === '1' && $selected_highlight === '0' || $selected_avi === '2' && $selected_highlight === '0' || $selected_avi === '3' && $selected_highlight === '0'){
							if($selected_avi === '0'){
								$lista = get_user_publ_new2($id,$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_favorito);
							}else{
								$lista = get_user_publ_new7($id,$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_favorito,$selected_avi);
							}
							
							while($row = mysqli_fetch_array( $lista)){						
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}
								$i++;
							}
						}else{
							
							if($selected_avi === '0'){
								
								$lista = get_user_publ_new3($id,$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight);
								while($row = mysqli_fetch_array( $lista)){						
									$editing[$i] = $row["editing"];
									$id_not[$i] = $row[1];
									$title[$i] = $row["title"];	
									$resumo[$i] = $row["resumo"];
									$date[$i] = $row["date"];
									$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
									$date_pub = $row["new_date"];
									if(!empty($date_pub)){
										$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
									}	
									$i++;
								}
							}else{
								//echo 'fsafas';
								$lista = get_user_publ_new4($id,$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight,$selected_avi);
								foreach($lista as $listagem){	
								while($row = mysqli_fetch_array( $listagem)){
									
									$editing[$i] = $row["editing"];
									$id_not[$i] = $row[1];
									$title[$i] = $row["title"];	
									$resumo[$i] = $row["resumo"];
									$date[$i] = $row["new_date"];
									
									$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
									$date_pub = $row["new_date"];
									if(!empty($date_pub)){
										$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
									}
									$i++;
								}
					
								}
							}
							
						}
						
						}else if($selected_val === "nao_publicado"){
							$lista = nonews($id,$selected_tema,$selected_data1,$selected_data2);
							while($row = mysqli_fetch_array( $lista)){						
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}
								$i++;
							}
						}else if($selected_val === "publicado" && $selected_tema === "1"){
		           			$lista = seenews($id,$selected_data1,$selected_data2);
						}else if($selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "0" && $selected_highlight === "0"){
							$lista = get_avi($id,$selected_tema,$selected_data1,$selected_data2);
							while($row = mysqli_fetch_array( $lista)){						
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}	
								$i++;
							}
						}else if($selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "nao favoravel" || $selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "favoravel"){
							//$lista = get_avi_fav($id,$selected_tema,$selected_data1,$selected_data2,$selected_favorito);
							
							if($selected_highlight === "0"){  
        
								$lista = get_avi_fav($id,$selected_tema,$selected_data1,$selected_data2,$selected_favorito);
							}else{
								$lista = get_avi_fav6($id,$selected_tema,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight);
							
							}
							while($row = mysqli_fetch_array( $lista)){						
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}	
								$i++;
							}
						}else if($selected_val === "publicado" && $selected_avi === "0"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "0" && $selected_highlight === "realcar"){
							$lista = get_avi_fav2($id,$selected_tema,$selected_data1,$selected_data2,$selected_highlight);
								foreach($lista as $list){								
								while($row = mysqli_fetch_array( $list)){						
									$editing[$i] = $row["editing"];
									$id_not[$i] = $row[1];
									$title[$i] = $row["title"];	
									$resumo[$i] = $row["resumo"];
									$date[$i] = $row["date"];
									$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
									$date_pub = $row["new_date"];
									if(!empty($date_pub)){
										$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
									}	
									$i++;
							}	
						}
						}else if($selected_val === "publicado" && $selected_avi === "1"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "1" && $selected_highlight === "realcar"){
							if($selected_favorito === "0"){  
									$lista = get_avi_fav3($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
							}else{
									$lista = get_avi_fav12($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
							}
							while($row = mysqli_fetch_array( $lista)){						
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}
								$i++;
							}
						}else if($selected_val === "publicado" && $selected_avi === "2"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "2" && $selected_highlight === "realcar"){
							
							if($selected_favorito === "0"){  
								$lista = get_avi_fav3($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
							}else{
								//echo 'asfa';
								
								$lista = get_avi_fav4($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
							}
							foreach($lista as $listagem){
							while($row = mysqli_fetch_array( $listagem)){
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}
								$user[$i] = $row[12];

								$i++;
							}
							}
						}else if($selected_val === "publicado" && $selected_avi === "3"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "3" && $selected_highlight === "realcar"){
							if($selected_favorito === "0"){  
									$lista = get_avi_fav3($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
							}else{
									$lista = get_avi_fav4($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
							}
							while($row = mysqli_fetch_array( $lista)){						
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}	
								$i++;
							}
						}else if($selected_val === "publicado" && $selected_highlight === "0" ){
							if($selected_favorito === "0"){
								$lista = get_avi_fav50($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_favorito);

							}else{
								$lista = get_avi_fav5($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_favorito);
							}
								while($row = mysqli_fetch_array($lista)){						
									$editing[$i] = $row["editing"];
									$id_not[$i] = $row[1];
									$title[$i] = $row["title"];	
									$resumo[$i] = $row["resumo"];
									$date[$i] = $row["date"];
									$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
									$date_pub = $row["new_date"];
									if(!empty($date_pub)){
										$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
									}	
									$i++;
								}
						}else if($selected_val === "publicado" && $selected_favorito === "0"){
								$lista = get_avi_fav1($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi);
								while($row = mysqli_fetch_array($lista)){						
									$editing[$i] = $row["editing"];
									$id_not[$i] = $row[1];
									$title[$i] = $row["title"];	
									$resumo[$i] = $row["resumo"];
									$date[$i] = $row["date"];
									$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');
									$date_pub = $row["new_date"];
									if(!empty($date_pub)){
										$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
									}	
									$i++;
								}
						}else if($selected_val === "publicado"){
							$lista = get_news_tema1($id,$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
							while($row = mysqli_fetch_array($lista)){						
								$editing[$i] = $row["editing"];
								$id_not[$i] = $row[1];
								$title[$i] = $row["title"];	
								$resumo[$i] = $row["resumo"];
								$date[$i] = $row["date"];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
								$date_pub = $row["new_date"];
								if(!empty($date_pub)){
									$date_pub = DateTime::createFromFormat('Y-m-d H:i:s', $date_pub)->format('d-m-Y H:i:s');	
								}
								$i++;
							}
					}	
					
					/*while( $row = mysqli_fetch_array($lista)){  
						$stuff[$a] = $row[2];
						$a++;
					}*/
			?>
			
        	<input type="submit" name="submit" value="Remove news" onclick="delete_varias()"/>
        		<table id="table">
            		<thead>
                		<tr>
                			<th>Articles</th>
                			<th><input type="checkbox"  onClick="toggle(this)"></th>
                		</tr>
                	</thead>
         			<tbody id="myTable">
          				<tr>
							   <?php
							   	$stuff = array();
								$a = 0;	 
								$count = count($id_not);
								
							   for($i = 0;$i<$count;$i++){	
								if($editing[$i] == 0){
									?>
									<td id=<?php echo $id_not[$i];?>><a href="index.php?fonte=<?php echo $fonte;?>&id=<?php echo $id_not[$i];?>&temas=0"><?php echo "<p>".$title[$i]."<p/>";?></a><p><?php 
									echo $resumo[$i].'<br/>';
									if($selected_val === "publicado"){
										if($editing[$i] === '0'){
											echo 'Published by:'.$logged_in[1].'<br />';
											echo 'Data:'.$date_pub.'<br />';

										}else{
											?>
											<p>Being Edited by: <?php
											$stuffff = explode(",",$editing[$i]);
											$userediting = useredit($stuffff[0]);
											$row = mysqli_fetch_array($userediting);
											
											
											echo $row["user_name"];?> </p>
											</td>
											<?php
										}
									}
									
									?></a><br/></td>
                					<td><input type="checkbox" name="check[]" class="delete_varias"  id ="myCheck[]" value="<?php echo $id_not[$i];?>"></td>	
									<?php
									
								 }else{
									?>
									<td id=<?php echo $id_not[$i];?>><?php echo "<p>".$title[$i]."<p/>";?>
									<p>Being Edited by: <?php

									
									/*
								while($row = mysqli_fetch_array( $lista)){						
								$editing[$i] = $row[13];
								$id_not[$i] = $row[1];
								$title[$i] = $row[2];	
								$resumo[$i] = $row[4];
								$date[$i] = $row[7];
								$date[$i] = DateTime::createFromFormat('Y-m-d H:i:s', $date[$i])->format('d-m-Y H:i:s');	
								$date_pub = $row[16];
								
							
									*/
									$stuffff = explode(",",$editing[$i]);
									$userediting = useredit($stuffff[0]);
									$row = mysqli_fetch_array($userediting);
									
									
									echo $row["user_name"];?> </p>
									</td>
                					<td><input type="checkbox" name="check[]" class="delete_varias" id ="myCheck[]" value="<?php echo $id_not[$i];?>"></td>	
									<?php
								 }
								
								?>
                				
								</tr><?php } ?>
         			 </tbody>
        		</table>
        
	</body>
	<script>
		function delete_varias(){
			var favorite = [];
            $.each($("input[name='check[]']:checked"), function(){            
                favorite.push($(this).val());
            });
			favorite.join(", ");
			var fonte = "<?php echo $_GET["fonte"]?>"
			window.location.href = "./noticias/noticia/apagar.php?id=" + favorite+"&fonte="+fonte; 
		}
	</script>
</html>

