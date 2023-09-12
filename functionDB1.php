    <?php  
     $conn = new mysqli("localhost", "root", "", "test"); 
    if($conn === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

function CloseCon($conn){
    $conn -> close();
}

    function insert_auto($table,$d){
        global $conn;
        $title = $d['title'];
        $old_title = $d['old_title'];
        $resumo = $d['resumo'];
        
        $date = $d['date'];
        $img = $d['img'];
        $text = $d['text'];
        $fonte_id = $d['fonte_id'];
        $link = $d['link'];
        $tsql = "INSERT INTO noticias(title,old_title,text, resumo, estado,date,link,publicado,img,fonte_id,user1,editing,temat_id) VALUES('$title','$old_title','$text','$resumo',1,'$date','$link',0,'$img','$fonte_id','0','0','0')";
        $result = $conn->query($tsql);
    }
    function insert(){
        global $conn;
        $fonte = array('a','b','c','d','e');
        $link = array(1,2,3,4,5);
        $exe = array('f','g','h','i','j');

        for($i = 0;$i<5;$i++){
            $tsql = "INSERT INTO fontes(fonte,url,exe_url) values('$fonte[$i]','$link[$i]','$exe[$i]')";  
            /* Execute the query. */  
            $result = $conn->query($tsql);

        }
    }
    /*function delete(){
        global $conn;
        $link = array(1,2,3,4,5);

        for($i = 0;$i<5;$i++){
            $tsql = "DELETE FROM fontes WHERE url='$link[$i]'";
            /* Execute the query.  
            $result = $conn->query($tsql);
        }
    }
    function update(){
        global $conn;
        $link = array(1,2,3,4,5);

        for($i = 0;$i<5;$i++){
            $tsql = "UPDATE fontes SET url='2' WHERE url = '6'";
            /* Execute the query. 
            $result = $conn->query($tsql);
        }
    }*/
    function relatorio(){
        global $conn;
        
        $tsql="SELECT fontes.*, erros.* FROM fontes JOIN erros ON fontes.id=erros.fonte_id ";
        /* Execute the query. */  

        $stmt = mysqli_query( $conn, $tsql);  
        
        return $stmt; 
    }
    function get_jmnum_npub($id,$sd1,$sd2){
        global $conn;
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 0 AND noticias.fonte_id='$id' AND `estado`=1 AND `date` BETWEEN '$sd1'AND '$sd2'";
        $stmt = mysqli_query( $conn, $tsql);  
        $tudo = array();
        $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 
    }
    
function url(){
    global $conn;
    
    $tsql="SELECT url FROM fontes";
    $result = mysqli_query( $conn, $tsql);  
    
    return $result;
}

function get_jmnum_pub($id,$s_u,$s_t,$sd1,$sd2){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 

}
function get_user_publ($id,$s_u,$s_t,$sd1,$sd2,$save){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND user1='$s_u' AND ave='$save' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 

}
function get_user_publ1($id,$s_u,$s_t,$sd1,$sd2,$shigh){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND noticias.highlighted='$shigh' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 

}
function get_user_publ2($id,$s_u,$s_t,$sd1,$sd2,$sfar){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND user1='$s_u' AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 

}
function get_user_publ7($id,$s_u,$s_t,$sd1,$sd2,$sfar,$save){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND user1='$s_u' AND favoratibilidade='$sfar' AND ave='$save' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 

}
function get_user_publ3($id,$s_u,$s_t,$sd1,$sd2,$sfar,$shigh,$save){
    global $conn;
    $i =0;
    
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$tem%' AND new_date BETWEEN '$sd1' AND '$sd2'";

        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    $l = count($server);
    /* Execute the query. */  
    for($a = 0;$a <$l;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        $number[$a] = $numberOfRows;
    }
    $numberOfRows =array_sum($number);
    return $numberOfRows; 

}    

function get_user_publ4($id,$s_u,$s_t,$sd1,$sd2,$sfar,$shigh){
    global $conn;
    $i =0;
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND user1='$s_u' AND favoratibilidade='$sfar' AND highlighted='$shigh' AND temat_id LIKE '%$tem%' AND date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    /* Execute the query. */  
    for($a = 0;$a <2;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        $number[$a] = $numberOfRows;
    }
    $numberOfRows =array_sum($number);
    return $numberOfRows; 

}

function get_news_tema($id,$s_t,$sd1,$sd2,$savi,$shigh,$sfar){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$savi' AND highlighted='$shigh' AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        return $numberOfRows; 

    
}
function get_news_avi($id,$s_t,$sd1,$sd2){
    global $conn;

    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    return $numberOfRows; 
    
}

function get_news_avi_fav($id,$s_t,$sd1,$sd2,$sfar){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 
    
}

function get_news_avi_fav1($id,$s_t,$sd1,$sd2,$save){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    
    return $numberOfRows; 
    
}
function get_news_avi_fav6($id,$s_t,$sd1,$sd2,$sfar,$shigh){
    global $conn;
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND favoratibilidade='$sfar' AND highlighted='$shigh' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2' ";
    /* Execute the query. */  

    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    return $numberOfRows; 

}
function get_news_avi_fav2($id,$s_t,$sd1,$sd2,$sfar){
    global $conn;
    $i =0;
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1  AND temat_id LIKE '%$tem%'  AND date BETWEEN '$sd1' AND '$sd2' ";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    /* Execute the query. */  
    for($a = 0;$a <2;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        $number[$a] = $numberOfRows;
    }
    $numberOfRows =array_sum($number);
    return $numberOfRows; 
}
function get_news_avi_fav3($id,$s_t,$sd1,$sd2,$save,$sfar){
    global $conn;
    
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND highlighted='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    /* Execute the query. */  

    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    return $numberOfRows; 

    
}    

function get_news_avi_fav44($id,$s_t,$sd1,$sd2,$save,$shigh,$sfar){
    global $conn;
    $i =0;
    $server = array();
    foreach($s_t as $tem){ 
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1  AND temat_id LIKE '%$tem%' AND new_date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    $counting = count($server);
    /* Execute the query. */  
    for($a = 0;$a <$counting;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        $number[$a] = $numberOfRows;
    }
    $numberOfRows =array_sum($number);
    return $numberOfRows; 
    
}   

function get_news_avi_fav4($id,$s_t,$sd1,$sd2,$save,$shigh,$sfar){
    global $conn;
    $i =0;
    $s_t = explode(",",$s_t);
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND highlighted='$shigh' AND favoratibilidade='$sfar' AND temat_id LIKE '%$tem%' AND date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    /* Execute the query. */  
    for($a = 0;$a <2;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        $number[$a] = $numberOfRows;
    }
    $numberOfRows =array_sum($number);
    return $numberOfRows; 
    
}    
function get_news_avi_fav4_one($id,$s_t,$sd1,$sd2,$save,$shigh,$sfar){
    global $conn;
    $i =0;
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND temat_id LIKE '%$tem%' AND new_date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    $l = count($server);
    /* Execute the query. */  
    for($a = 0;$a <$l;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        $number[$a] = $numberOfRows;
    }
    $numberOfRows =array_sum($number);
    return $numberOfRows; 
    
}  

function get_news_avi_fav12($id,$s_t,$sd1,$sd2,$save,$shigh,$sfar){
    global $conn;
    $i =0;
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND highlighted='$shigh' AND favoratibilidade='$sfar' AND temat_id LIKE '%$tem%' AND date BETWEEN '$sd1' AND '$sd2'";                $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    /* Execute the query. */  
    for($a = 0;$a <2;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        $tudo = array();
        $i = 0;
        while( $row = mysqli_fetch_array($stmt)){  
            $tudo[$i] = $row[0];
            $i++;
        }
        $numberOfRows = count($tudo);
        $number[$a] = $numberOfRows;
    }
    $numberOfRows =array_sum($number);
    return $numberOfRows; 
}
function get_news_avi_fav5($id,$s_t,$sd1,$sd2,$save,$sfar){
    global $conn;
    
    if($save == 0){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    }else{
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    }
    
    /* Execute the query. */  
    
    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    return $numberOfRows; 
    
}
function get_news_avi_fav50($id,$s_t,$sd1,$sd2,$save,$sfar){
    global $conn;
    
    $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    /* Execute the query. */  

    $stmt = mysqli_query( $conn, $tsql);  
    $tudo = array();
    $i = 0;
    while( $row = mysqli_fetch_array($stmt)){  
        $tudo[$i] = $row[0];
        $i++;
    }
    $numberOfRows = count($tudo);
    return $numberOfRows; 
    
}
function get_noticias(){
    global $conn;
    
    $tsql="SELECT title, count(*) AS c FROM noticias GROUP BY title HAVING c > 1 ORDER BY c DESC WHERE noticias.estado=1";
    $query=mysqli_query($conn,$tsql);
    
    if (mysqli_num_rows($query) > 0) {
        $resultado = mysqli_fetch_assoc($query);
        return $query;
        //return $resultado;
    }else{
        exit;
    }
    
}

function getfonte_id($fonte){
    global $conn;
    
    $tsql="SELECT id FROM fontes where fonte = '$fonte'";
    $result = mysqli_query( $conn, $tsql);
    while( $row = mysqli_fetch_array( $result)){  
        $tudo = $row[0];
    }
    return $tudo;
}

function seenews($id,$sd1,$sd2){
    global $conn;
    $tsql = "SELECT fontes.id, noticias.*, fontes.fonte FROM fontes INNER JOIN noticias ON fontes.id=noticias.fonte_id WHERE publicado = 1 AND noticias.fonte_id=$id AND date BETWEEN '$sd1'AND '$sd2' ORDER BY date DESC";
    $result = mysqli_query( $conn, $tsql);
    
    return $result;
   
}

function nonews($id,$s_t,$sd1,$sd2){
    global $conn;
    
    $tsql = "SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 0 AND noticias.fonte_id='$id' AND estado=1 AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    
    return $stmt;
}

function usernews($user,$id,$s_t,$sd1,$sd2){
    global $conn;
    
    $tsql = "SELECT * FROM noticias where publicado=1 AND user1='$user' AND noticias.fonte_id=$id AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2' ORDER BY date DESC";
    $stmt = mysqli_query( $conn, $tsql);  
    
    return $stmt;
}
function get_user_publ_new($id,$s_u,$s_t,$sd1,$sd2,$save){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND noticias.ave='$save' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    
    return $stmt; 

}
function get_user_publ_new1($id,$s_u,$s_t,$sd1,$sd2,$shigh){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND noticias.highlighted='$shigh' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    
    return $stmt; 

}
function get_user_publ_new2($id,$s_u,$s_t,$sd1,$sd2,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND noticias.favoratibilidade='$sfar' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    
    return $stmt;

}
function get_user_publ_new7($id,$s_u,$s_t,$sd1,$sd2,$sfar,$save){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND noticias.favoratibilidade='$sfar' AND ave='$save' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    
    return $stmt;

}
function get_user_publ_new3($id,$s_u,$s_t,$sd1,$sd2,$sfar,$shigh){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND noticias.favoratibilidade='$sfar' AND noticias.highlighted='$shigh' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    
    return $stmt; 

}
function get_user_publ_new4($id,$s_u,$s_t,$sd1,$sd2,$sfar,$shigh,$save){
    global $conn;
    $i =0;
    $s_t = explode(",",$s_t);
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND user1='$s_u' AND temat_id LIKE '%$tem%' AND new_date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    $tudo = array();
    $counting = count($server);

    /* Execute the query. */  
    for($a = 0;$a <$counting;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        while( $row = mysqli_fetch_array($stmt)){  
            $number[$i] = $row[1];
            $i++;            
        }
    }
    $l = count($number);

    foreach($number as $id){
        $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 temat_id LIKE '%$tem%' AND new_date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    for($a = 0;$a < $l;$a++){
        $tudo[$a] = mysqli_query( $conn, $server[$a]);
    }
    
    return $tudo;

}
function get_avi($id,$s_t,$sd1,$sd2){
    global $conn;
    
    $tsql = "SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $result = mysqli_query( $conn, $tsql);
    
    return $result;
   
}

function get_news_tema1($id,$s_t,$sd1,$sd2,$savi,$shigh,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$savi' AND highlighted='$shigh' AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    
    $result = mysqli_query( $conn, $tsql);
    
    return $result;
    
}
function get_avi_fav($id,$s_t,$sd1,$sd2,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2' ";

    $result = mysqli_query( $conn, $tsql);
    
    return $result;
    
}

function get_avi_fav1($id,$s_t,$sd1,$sd2,$save){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    
    $result = mysqli_query( $conn, $tsql);
    
    return $result;
    
}

function get_avi_fav2($id,$s_t,$sd1,$sd2,$sfar){
    global $conn;
    $i =0;
    $s_t = explode(",",$s_t);
    $server = array();
    foreach($s_t as $tem){
        $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND highlighted='$sfar'  AND temat_id LIKE '%$tem%' AND date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    $tudo = array();

    /* Execute the query. */  
    for($a = 0;$a <2;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        while( $row = mysqli_fetch_array($stmt)){  
            $number[$i] = $row[1];
            $i++;            
        }
    }
    foreach($number as $id){
        $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 temat_id LIKE '%$tem%' AND date BETWEEN '$sd1' AND '$sd2'";
        $server[$i] = $tsql;
        $i++;
    }
    $l = count($number);
    for($a = 0;$a < $l;$a++){
        $tudo[$a] = mysqli_query( $conn, $server[$a]);
    }
    
    return $tudo;

}
function get_avi_fav3($id,$s_t,$sd1,$sd2,$save,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND highlighted='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);  
    return $stmt;

}    

function get_avi_fav4($id,$s_t,$sd1,$sd2,$save,$shigh,$sfar){
    global $conn;
    $i =0;
    
    $s_t = explode(",",$s_t);
    $server = array();
    
    
    foreach($s_t as $tem){
        $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND temat_id LIKE '%$tem%' AND new_date BETWEEN '$sd1'AND '$sd2' ";
        $server[$i] = $tsql;
        $i++;
    }
    $number = array();
    $tudo = array();
    $counting = count($server);
    /* Execute the query. */  
    for($a = 0;$a <$counting;$a++){
        $stmt = mysqli_query( $conn, $server[$a]);  
        while( $row = mysqli_fetch_array($stmt)){  
            $number[$i] = $row[1];
            $i++;            
        }
    }
    
    $l = count($server);
    foreach($number as $id){
        $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id'";
        $server[$i] = $tsql;
        $i++;
    }
    
    
    
    for($a = 0;$a < $l;$a++){
        $tudo[$a] = mysqli_query( $conn, $server[$a]);
    }
    return $tudo;

}
function get_avi_fav5($id,$s_t,$sd1,$sd2,$save,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);  
    return $stmt;


}
function get_avi_fav50($id,$s_t,$sd1,$sd2,$save,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);  
    return $stmt;


}
function get_avi_fav6($id,$s_t,$sd1,$sd2,$sfar,$shigh){
    global $conn;
    
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id=$id AND estado=1 AND favoratibilidade='$sfar' AND highlighted='$shigh' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);
    
    return $stmt;
}
function get_avi_fav12($id,$s_t,$sd1,$sd2,$save,$shigh,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND highlighted='$shigh' AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1' AND '$sd2'";
    $stmt = mysqli_query( $conn, $tsql);
    
    return $stmt;
}
function get_avi_fav7($id,$s_t,$sd1,$sd2,$sfar){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND ave='$save' AND favoratibilidade='$sfar' AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2' ";
    $stmt = mysqli_query( $conn, $tsql);  
       
    return $stmt; 

}
function news_tema($id,$s_t,$sd1,$sd2){
    global $conn;
    $tsql="SELECT fontes.id, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1 AND noticias.fonte_id='$id' AND estado=1 AND temat_id LIKE '%$s_t%' AND date BETWEEN '$sd1'AND '$sd2'";
    $result = mysqli_query( $conn, $tsql);
    
    return $result;    
    
}
    function sendinfo(){
        global $conn;
        $tsql = "INSERT INTO noticias(title,old_title,text, resumo, estado,date,link,publicado,img,fonte_id,user1,editing,temat_id) VALUES('title','old_title','text','resumo',1,'2019-03-22 18:42:45','link',0,'img','1','0','0','0')";
        $result = $conn->query($tsql);

    }
    function sendinfocomplete($t,$d,$st,$date,$id,$link,$img){
        global $conn;
        if($t === ' '){
            $error = "Por favor verifique o link:".$link;
            $tsql = "INSERT INTO erros(error_log,title) VALUES('$error','$t')"; 
            $result = $result = $conn->query($tsql);
        } else {
            $tsql = "INSERT INTO noticias(title,old_title,text, resumo, estado,date,link,publicado,img,fonte_id,user1,editing,temat_id) VALUES('$t','$t','$d','$st',1,'$date','$link',0,'$img','$id','0','0','')";
            $result = $result = $conn->query($tsql);
            if($result === False){
                $error = "Por favor verifique o link:".$link;
                $tsql = "INSERT INTO erros(error_log,title,fonte_id) VALUES('$error','$t','$id')"; 
                $result = $result = $conn->query($tsql);   
            }
        }
    }
    function meter_noticias($nome_antes,$nome_novo){
        global $conn;
        
        $tsql = "UPDATE tematicas set tematica = '$nome_novo' WHERE tematica = '$nome_antes'";
        
        $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
        
    }function insertem($id){
        global $conn;
        $rand = rand(1,999999999);
        $tsql="INSERT INTO tematicas(tematica,other_id) VALUES ('$id','$rand')";
        
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    }
    
    function insert_tema_not($tema,$id,$d,$od){
        global $conn;
        
        $tsql = "UPDATE noticias set temat_id = '$tema', new_date = '$d' WHERE id = $id";
        
        $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    
    }
    
    function getArtigo($artigoID){
        global $conn;
        $tsql = "SELECT * FROM noticias WHERE id = $artigoID";
        $stmt = mysqli_query( $conn, $tsql);  
        
        return $stmt;
    }
    
    function checked($ch){
        global $conn;
        echo $ch;
        $tsql = "UPDATE noticias set estado = 0 WHERE id = $ch";
        
        $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
            
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    }
    function checked1($ch){
        global $conn;
        
        $tsql = "UPDATE noticias set publicado = 0, editing = 0 WHERE id = $ch";
        
        $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    }
    
    
    function update($t,$d,$tt,$img,$res,$ch,$user,$od,$ave,$high,$fav){
        global $conn;
        $tsql = "UPDATE noticias set title = '$t',new_date = '$d',text = '$tt', img = '$img',user1='$user',resumo = '$res', publicado = 1, editing='0' ,ave = '$ave',highlighted = '$high',favoratibilidade = '$fav' WHERE id = $ch";
       $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    }
    function delete($id,$user,$d,$od){
        global $conn;
        
        $tsql = "UPDATE noticias set publicado = 1, user1='$user', new_date = '$d', editing=0  WHERE id = '$id'";
        
        $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    }
    function loadtem(){
        global $conn;
        
        $tsql = "SELECT * FROM tematicas ORDER BY tematica ASC ";
		$stmt = $conn->query($tsql);
        
        return $stmt;
        
    }
    function loadfonte(){
        global $conn;
        
        $tsql = "SELECT * FROM fontes ORDER BY id ASC ";
		$result = $conn->query($tsql);
        
        return $result;
        
    }
    
    function deletetemas($tema){
        global $conn;
        
        $tsql = "DELETE FROM tematicas WHERE tematica='$tema'";
        $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    }
    function delete_rel($tema){
        global $conn;
        
        $tsql = "DELETE FROM erros WHERE id='$tema'";
        $query=mysqli_query($conn,$tsql);
        if(mysqli_query($conn, $tsql)){
        } else{
            //e unico por isso aqui devia aparecer uma mensagem a avisar o erro que nao consegue meter valores porque esses ja existem
        }
    }
    
    function getfontes(){
        global $conn;
        
        $tsql="SELECT * FROM fontes";
        $result = mysqli_query( $conn, $tsql);
        return $result;
        
    }

    function useredit($id){
        global $conn;
        
        $tsql="SELECT user_name FROM usuario where user_id = $id";
        $result = mysqli_query( $conn, $tsql);
        return $result;
        
    }

    function temas_choose($id){
        global $conn;
        $tsql= "SELECT fonte FROM fontes WHERE id='$id'";
        $result = mysqli_query($conn,$tsql);
        return $result;
    }
    function joining(){
        global $conn;
            $tsql = "SELECT fontes.id, noticias.*  FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 0 AND noticias.fonte_id='1' ";
            /* Execute the query. */  
            $stmt = $result = $conn->query($tsql);
            return $stmt;
    }
    function get1(){
        global $conn;
        $tsql = "SELECT * FROM noticias";  

        /* Execute the query. */  

        $stmt = mysqli_query( $conn, $tsql);  

        /* Iterate through the result set printing a row of data upon each iteration.*/ 
        return $stmt; 
    }
    //SELECT fontes.*, noticias.* FROM fontes JOIN noticias ON fontes.id=noticias.fonte_id WHERE noticias.publicado = 1
    //$insert = insert();
    //$update = update();
    //$delete = delete();
    //$sit = get();
    //$not = sendinfocomplete(); 
    //$sita = get1();
    //https://www.dn.pt/ultimas.html 
    /*$mysongs[0] = 'https://www.jornaldenegocios.pt/noticias-no-minuto?ref=Menu_header';
    $days = ["Mon,", "Tue,", "Wed,","Thu","Fri","Sat","Sun","GMT"];
    $months = ["jan","fev","mar","abr","mai","jun","jul","ago","set","out","nov","dez"];
    $months_num = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    $context = stream_context_create(array(
        'http' => array(
            'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
        ),
    ));
    $k=0;
    require('noticias/simple_html_dom.php');
    
    $array_length = sizeof($mysongs);
    for($a = 0; $a < $array_length; $a++){
        $id=$a+1;
        $tudo=$mysongs[$a]; 
        $html = file_get_html($tudo,false, $context);
        if($a == 0){
           
    
    }
}
    /*$sit = joining();

    while( $row = sqlsrv_fetch_array( $sit, SQLSRV_FETCH_NUMERIC)){  
        $id = $row[1];  
        $title = $row[2];
        $old_title = $row[3];  
        $resumo = $row[4];
        $text = $row[5];
        $estado = $row[7];
        $date = $row[8];
        //$new_date = $row[9];
        $date = $date->format('Y-m-d H:i:s');

        $link = $row[10];
        $publicado = $row[11];
        $user = $row[12];
        $img = $row[13];
        $temat_id = $row[14];
        $fonte_id = $row[15];
        $editing = $row[16];
        //$ave = $row[17];
        //$favoratibilidade = $row[18];

    }*/   
     //Free statement and connection resources. 
    /*sqlsrv_free_stmt( $sit);  
    sqlsrv_close( $conn);*/
    ?>  