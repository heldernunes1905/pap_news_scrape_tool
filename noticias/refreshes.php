
<?php 
include_once '../functionDB1.php';
//require_once './teste_p3.php';
require('simple_html_dom.php');
$days = ["Mon,", "Tue,", "Wed,","Thu","Fri","Sat","Sun","GMT"];
$months = ["jan","fev","mar","abr","mai","jun","jul","ago","set","out","nov","dez"];
$months_num = ["01","02","03","04","05","06","07","08","09","10","11","12"];
$b = 0;
$lista = url();
while( $row = mysqli_fetch_array( $lista)){  
    $mysongs[$b] = $row[0];
    $b++;
}
$context = stream_context_create(array(
    'http' => array(
        'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
    ),
));

$array_length = sizeof($mysongs);

for($a = 0; $a < $array_length; $a++){
    $id=$a+1;
    echo $a;
    $tudo=$mysongs[$a]; 
    $feeds = file_get_contents($mysongs[$a],false, $context);
    $html = file_get_html($tudo,false, $context);
    if($a == 0){
        $rss = simplexml_load_string($feeds);
        $x=$rss;
        for($i = 0;$i<5;$i++) {
            $entry = $x->channel->item[$i];
            $title = $entry->title;
            $guid = $entry->guid;
            $date = $entry->pubDate;
            $link = $entry->link; 
            $html = file_get_html($link);
            $k=0;
            $title = $entry->title;
            $guid = $entry->guid;
            $link = $entry->link;
            $date = $entry->pubDate;
            $html = file_get_html($link);   
            $img = $html->find('div.article_image')[0];
            if(empty($img)){
                $img = ' ';
            }else{
                $img = $img->find('img')[0]->src;
                $img = "<img style=width:100% src=$img>";
            }
            

            $subtext = $html->find('div.article_text')[0]->find('p')[0];
            $text = $html->find('div.article_text_2')[0]->find('p')[0]->plaintext;
            //remove o dia da week (Mon,Tues) e o gmt do final
            $date = str_replace('/', '-', $date);
            //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
            $date = date('Y-m-d H:i:s', strtotime($date));
            $text = str_replace('\'', '-', $text);
           
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    }else if($a == 1){
        $dom = new DOMDocument();
        $dom->load($tudo);
        $errorNodes = $dom->getElementsByTagName('encoded');
        $feeds = file_get_contents($tudo);
        if($errorNodes->length > 0){
            $feeds = str_replace("<content:encoded>","<contentEncoded>",$feeds);
            $feeds = str_replace("</content:encoded>","</contentEncoded>",$feeds);
            $rss = simplexml_load_string($feeds);
            $x=$rss;
            for($i = 0;$i<5;$i++) {
                $entry = $x->channel->item[$i];
                $title = $entry->title;
                $subtext = ' ';
                $guid = $entry->guid;
                $date = $entry->pubDate;
                $text = $entry->contentEncoded;
                $link = $entry->link;
                $inside = file_get_html($link);
                $img = '';
                //remove o dia da week (Mon,Tues) e o gmt do final
                $date = str_replace($days, '', $date);
                $date = str_replace('/', '-', $date);
                //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
                $date = date('Y-m-d H:i:s', strtotime($date));
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            }
        }
    }else if($a == 2){

        for($i=0;$i<5;$i++){
            
            $link = $html->find('h2.post-sub-title')[$i]->find('a')[0]->href;
            $inside = file_get_html($link);
            $subtext = ' ';
            $title = $inside->find('h1.mb-0.artigo-titulo')[0]->plaintext;
            $img = $inside->find('div.item')[0]->find('img')[0]->src;
            $text = $inside->find('div.post-content')[0]->find('div')[3];
            $date = $inside->find('li.pb-20')[0]->plaintext;
            $date = str_replace("Artigo |                          ","","$date");
            $date = str_replace('/','-',$date);
            $hours = substr($date, -5);
            $date = date("Y-m-d", strtotime($date));
            $date = $date." $hours";
            $img = "<img style=width:100% src=$img>";
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            
        }
}else if($a == 3){
    $dom = new DOMDocument();
   $dom->load($tudo);
   $errorNodes = $dom->getElementsByTagName('encoded');
   $feeds = file_get_contents($mysongs[$a]);
           $rss = simplexml_load_string($feeds);
           $x=$rss;
           for($i = 0;$i<5;$i++) {
               $entry = $x->channel->item[$i];
   
               $title = $entry->title;
               $guid = $entry->guid;
               $date = $entry->pubDate;
               $link = $entry->link;                    
               $html = file_get_html($link);
                   foreach($html->find('div.entry-content') as $element){
                       for($l = 0;$l<count($element->find('p'));$l++) {
                           $desc[$l] = $element->find('p')[$l]->plaintext;
                       }  
                       $img = $element->find('img')[0]->src;
                       if(empty($img)){
                       $img = $html->find('body')[0];
                       $up = $html->find('header#masthead')[0];
                       $other = $html->find('div.robots-nocontent.sd-block.sd-social.sd-social-icon.sd-sharing')[0];
                       $foot = $html->find('footer.entry-footer')[0];
                       $first = $html->find('div#secondary')[0];
                       $top = $html->find('div.entry-meta')[0];
                       $below = $html->find('div.sharedaddy.sd-block.sd-like.jetpack-likes-widget-wrapper.jetpack-likes-widget-unloaded')[0];
                       $belower = $html->find('div#likes-other-gravatars')[0];
                       $tema = $html->find('div.site-info')[0];
                       $rela = $html->find('div#jp-relatedposts')[0];
                       $p = $html->find('div.entry-content')[0]->find('p')[0];
                       $title = $html->find('h1.entry-title')[0];
   
                       $img = str_replace($up,$up->remove,$img); 
                       $img = str_replace($other,$other->remove,$img); 
                       $img = str_replace($foot,$foot->remove,$img); 
                       $img = str_replace($first,$first->remove,$img); 
                       $img = str_replace($top,$top->remove,$img); 
                       $img = str_replace($below,$below->remove,$img); 
                       $img = str_replace($belower,$belower->remove,$img); 
                       $img = str_replace($tema,$tema->remove,$img); 
                       $img = str_replace($rela,$rela->remove,$img); 
                       $img = str_replace($p,$p->remove,$img); 
                       $img = str_replace($title,$title->remove,$img); 
                       }
                       $text = implode(' ', $desc);
                       //remove '' das news
                       $title = str_replace('\'', '', $title);
                       $text = str_replace('\'', '', $text);
                       
                       //remove o dia da week (Mon,Tues) e o gmt do final
                       $date = str_replace($days, '', $date);
                       $date = str_replace('/', '-', $date);
                       
                       //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
                       $date = date('Y-m-d H:i:s', strtotime($date));
                       $img = "<img src=$img>";
                       $subtext = '';
                       
                       sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
   
                   }
           }   
   }else if($a == 4 ){
    $destaque = $html->find('div.noticiaDestaque')[0]->find('a.h2')[0]->href;
    $link = "https://www.jornaldenegocios.pt".$destaque;
    $inside = file_get_html($link);
    $title = $inside->find('div.noticiaTitle')[0]->find('h1')[0];
    $subtext = $inside->find('span.noticiaLead')[0];
    $date = $inside->find('span.dataAutor')[0];
    $text = $inside->find('div.newsContent')[0];
    $text = preg_replace('/\<div id=\"escondec\" class=\"lerMais\"\>(.*?)\<\/div\>/', '', $text);
    
    for($i=1;$i<5;$i++){
        $link = $html->find('div.newsRow')[$i]->find('a.h2')[0]->href.'<br />';
        $link = "https://www.jornaldenegocios.pt".$link;
        if(substr($link, 0, 50) === 'https://www.jornaldenegocios.pt/opiniao/cartoon-sa'){
            $inside = file_get_html($link);
            $title = $inside->find('div.noticiaTitle')[0]->find('h1')[0];
            $subtext = $inside->find('div.noticiaTitle')[0]->find('span.noticiaLead')[0];
            $img = $html->find('figure.imgNoticiaBloco')[0]->find('img')[0]->src;
            $img = "<img style=width:100% src=$img>";
            $date = $inside->find('span.dataAutor')[0];
            $hours = substr($date, -5);
            $date = date('Y-m-d ').$hours;
            $text = '';
        }else{
            $inside = file_get_html($link);
            $title = $inside->find('div.noticiaTitle')[0]->find('h1')[0]->plaintext;
            $subtext = $inside->find('span.noticiaLead')[0];
            $date = $inside->find('span.dataAutor')[0]->plaintext;
            $text = $inside->find('div.newsContent')[0];
            $text = preg_replace('/\<div id=\"escondec\" class=\"lerMais\"\>(.*?)\<\/div\>/', '', $text);
            $img = $inside->find('div.videoNoticia')[0];
            $gal = $inside->find('div.galeria')[0];
            if(!empty($img)){
                $img = ' ';
                $title = $inside->find('div.noticiaTitle')[0]->find('h1')[0]->plaintext;
                $subtext = $inside->find('span.noticiaLead')[0]->plaintext;
                $text = '';
                $date = $inside->find('span.dataAutor')[0]->plaintext;
            }else if(!empty($gal)){
                $img = $inside->find('div.galeria')[0];
            }
            
            $hours = substr($date, -5);
            $date = date('Y-m-d ');
            $date = $date.$hours;
            //remove '' das news
            $title = str_replace('\'', '', $title);
            $text = str_replace('\'', '', $text);
            $text = str_replace("<p>"," ",$text);
            $text = str_replace("</p>"," ",$text);   
        }
        $img = ' ';
        sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
    
    }
    }else if($a == 5){
    for($i=0;$i<5;$i++){
            $link = $html->find('li.last_post'.$i)[0]->find('a')[0]->href;
            $inside = file_get_html($link);
            $title = $inside->find('header.article-header.cf')[0]->find('h1')[0]->plaintext;
            $img = $inside->find('header.article-header.cf')[0]->find('img')[0]->src;
            $img = "<img style=width:100% src=$img>";
            $date =  $inside->find('span.time')[0]->plaintext;
            $text = $inside->find('div.entry-content.cf')[0];        
            $text = preg_replace('/\<div data-readmore class=\"read-more-btn\"\>(.*?)\<\/div\>/', '', $text);
            $text = preg_replace('/\<div class=\"fb-share\"\>(.*?)\<\/div\>/', '', $text);
            $subtext = $inside->find('div.article-excerpt')[0]->find('h2')[0]->plaintext;
            $date = str_replace('.','-',$date);
            $date = str_replace('/','',$date);
            $fram = $inside->find('iframe#iframeMREC2')[0];
                
            $text = str_replace($fram,$fram->remove,$text); 
            $text = str_replace('\'', '', $text);
    
            $hours = substr($date, -5);
            $date = date("Y-m-d", strtotime($date));
            $date = $date." $hours";
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    }else if($a == 6){
    for($i=0;$i<5;$i++){
            $link = $html->find('ul.latest')[0]->find('a')[$i]->href;
            $title = $html->find('ul.latest')[0]->find('h1.title')[$i]->plaintext;
            $inside = file_get_html($link);
            $subtext = $inside->find('div.lead')[0];
            $text = $inside->find('div.content')[0];
            $date = $inside->find('div.meta')[0]->find('time')[0]->datetime;
            $text = preg_replace('/\<div class=\"abusos-na-igreja-form\"\>(.*?)\<\/div\>/', '', $text);
            $text = preg_replace('/\<div class=\"textcomment-container\"\ id=\"textcomment-container-id\"\>(.*?)\<\/div\>/', '', $text);
            $text = preg_replace('/\<ol\>(.*?)\<\/ol\>/', '', $text);
            $text = preg_replace('/\<button class=\"read-more-modal button\"\>(.*?)\<\/button\>/', '', $text);
            $date = str_replace('T',' ',$date);
            $date = str_replace('+00:00','',$date);
            $date = str_replace('+01:00','',$date);
            
            $src = 'data-src';
            $img = $inside->find('div.image')[0]->find('img')[0]->$src;
            $img = "<img style=width:100% src=$img>";
            //remove '' das news
            $title = str_replace('\'', '', $title);
            $text = str_replace('\'', '', $text);
            $text = str_replace("<p>"," ",$text);
            $text = str_replace("</p>"," ",$text);
            
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    }else if($a == 7){
    for($i=0;$i<5;$i++){
            $link = $html->find('div.noticiaRow')[$i]->find('a')[0]->href;
            if(substr( $link, 0, 4 ) === "http"){
            }else{
                $link = 'https://tvi24.iol.pt'.$link;
            }
    
            $inside = file_get_html($link);
            
            $title = $html->find('div.noticiaRow')[$i]->find('div.newsTitle')[0]->plaintext;
            $subtext = $html->find('div.noticiaRow')[$i]->find('p')[0]->plaintext;
            $subtext = preg_replace('/\<span class=\"labelEditoria bck_internacional\"\>(.*?)\<\/span\>/', '', $subtext);
            $subtext = preg_replace('/\<h2\>(.*?)\<\/h2\>/', '', $subtext);
            $subtext = preg_replace('/\<div class=\"picture-wrapper\"\>(.*?)\<\/div\>/', '', $subtext);
            $subtext = preg_replace('/\<em class=\"small\"\>(.*?)\<\/em\>/', '', $subtext);
            $meta = 'cXenseParse:recs:publishtime';
            if(substr( $link, 0, 28 ) === "https://tvi24.iol.pt/videos/"){
                $src = 'data-src';
                $img = $html->find('div.noticiaRow')[$i]->find('div.picture-wrapper')[0]->find('div')[0]->$src;
            }else if(substr( $link, 0, 20 ) === "https://tvi24.iol.pt"){
                $img = $inside->find('img.imgArtigo')[0]->src;
                $date = $inside->find('time.date')[0];
            }else{
                $img = $inside->find('div.imgArtigo')[0];
                if(!empty($img)){   
                    $img = $img->find('img')[0]->src;
    
                }else{
                    $img = '';
                }
            }
            $text = $inside->find('div.articleBody')[0];
            $date = $inside->find( "meta[name=$meta]" );
            $date = $date[0]->content;
            $date = str_replace('T',' ',$date);
            //remove '' das news
            $title = str_replace('\'', '', $title);
            $text = str_replace('\'', '', $text);
            $text = str_replace("<p>"," ",$text);
            $text = str_replace("</p>"," ",$text);
            $img = "<img style=width:100% src=$img>";
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    }else if($a == 8){
    $rss = simplexml_load_string($feeds);
        $x=$rss;
        for($i = 0;$i<5;$i++) {
            $entry = $x->channel->item[$i];
            $title = $entry->title;
            $guid = $entry->guid;
            $link = $entry->link;
            $date = $entry->pubDate;
            $subtext = $entry->description;
            $html = file_get_html($link);
            if(!empty($html->find('div.video-container')[0])){
                $img = $html->find('div.video-container')[0];
                $img = preg_replace('/\<h1 class=\"playlist-hover-title\"\>(.*?)\<\/h1\>/', '', $img);
            }else{
                $img = $html->find('picture.landscape')[0];
                if(empty($img)){
                    $img = $html->find('div.main-media.mainMediaGallery')[0];
                }
            }
            $text = $html->find('div.article-content')[0];
            //remove o dia da week (Mon,Tues) e o gmt do final
            $date = str_replace($days, '', $date);
            $date = str_replace('/', '-', $date);
            //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
            $date = date('Y-m-d H:i:s', strtotime($date));
            //remove '' das news
            $title = str_replace('\'', '', $title);
            $text = str_replace('\'', '', $text);
            $text = str_replace("<p>"," ",$text);
            $text = str_replace("</p>"," ",$text);
            //remove '' das news
            $img = str_replace('\'', '', $img);
            
            $img = str_replace("<p>"," ",$img);
            $img = str_replace("</p>"," ",$img);
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
    
        }
    }else if($a == 9){
        $rss = simplexml_load_string($feeds);
        $x=$rss;
        for($i = 0;$i<5;$i++) {
            $entry = $x->channel->item[$i];
            $title = $entry->title;
            $guid = $entry->guid;
            $link = $entry->link;
            $date = $entry->pubDate;
            $subtext = $entry->description;
            $html = file_get_html($link);
            $img = $html->find('div.featured-image')[0]->find('img')[0]->src;
            $img = "<img width=100% src=$img>";
            //remove o dia da week (Mon,Tues) e o gmt do final
            $date = str_replace($days, '', $date);
            $date = str_replace('/', '-', $date);
            
            //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
            $date = date('Y-m-d H:i:s', strtotime($date));
            $title = $html->find('h1.entry-title')[0]->plaintext;
            $text = $html->find('div.entry-content.clearfix')[0];
            
            $top = $html->find('div#ess-main-wrapper')[0];
            $image = $html->find('div.entry-content.clearfix')[0]->find('img')[0];
            $image1 = $html->find('div.code-block.code-block-4')[0];
    
            $text = str_replace($top,$top->remove,$text); 
            $text = str_replace($image,$image->remove,$text); 
            $text = str_replace($image1,$image1->remove,$text); 
            $text = str_replace('\'', '', $text);
    
            $subtext = '';
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    
    }else if($a == 10){
        for($i=0;$i<5;$i++){
            $link = $html->find('div.[.quarter-bottom-space.].thumb.tiny-four-by-three.small-four-by-three')[$i]->href;
            $link = 'https://24.sapo.pt/'.$link;
            $inside = file_get_html($link);
            $title = $inside->find('div.[.all-100.].article-title-ctn')[0]->find('h1')[0]->plaintext;
            $date = $inside->find('div.[.medium.].date')[0]->plaintext;
            $subtext = $inside->find('div.[.vertical-space.large.].article-excerpt')[0]->plaintext;
            $img = $inside->find('figure#article-image')[0];
            if(!empty($img)){
                $img = $img->find('img')[0]->src;
                $img = "<img style=width:100% src=$img>";
            }else{
                $img = '';
            }
            $text = $inside->find('div.[.bottom-space._clearfix.].article-body')[0];
            $text->find('div.[.column-group.hide-all.].button--see-more')[0]->innertext = '';
            $text->find('div#features-promotion')[0]->innertext = '';
            $newString = substr($date, -5);
            $data = date("Y-m-d ");
            $date = $data.$newString;
            $text = str_replace('\'', '', $text);
    
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }   
    }else if($a == 11){
        for($i=0;$i<5;$i++){
            $subtext = ' ';
            $src="data-src";
            $img = $html->find('article.et_pb_post.clearfix.et_pb_has_overlay')[$i]->find('img')[0]->$src;
            $title = $html->find('article.et_pb_post.clearfix.et_pb_has_overlay')[$i]->find('h2.entry-title')[0]->plaintext;
            $link = $html->find('article.et_pb_post.clearfix.et_pb_has_overlay')[$i]->find('h2.entry-title')[0]->find('a')[0]->href;
            $inside = file_get_html($link,false, $context);
            $date = $inside->find('div.post-meta.vcard')[0]->find('span.updated')[0]->plaintext;
            $text = $inside->find('div.post-content.entry-content')[0];
            if(empty($text)){
                $text = $inside->find('div.et_pb_text_inner')[0];
            }
            //remove o dia da week (Mon,Tues) e o gmt do final
            $date = str_replace($days, '', $date);
            $date = str_replace('/', '-', $date);
            $data = $date;
            $data = str_replace(',', ' ', $data);
            //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
            $data = date('Y-m-d H:i:s', strtotime($data));
            $date = $data;
            $img = "<img style=width:100% src=$img>";
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            
        }
    }else if($a == 12){
        
        for($i=0;$i<5;$i++){
                $link = $html->find('div.content')[$i]->find('a')[0]->href;
                $link = 'https://sol.sapo.pt'.$link;
                $inside = file_get_html($link);
                $title = $inside->find('div#article-full')[0]->find('header')[0]->find('h1')[0];
                $subtext = $inside->find('div#article-full')[0]->find('header')[0]->find('p')[1];
                $text = $inside->find('div#article-full')[0]->find('div.large-8.column.corpo')[0];
                $img = $inside->find('div.relative.mainimg')[0];
                $date = date('Y-m-d');
                $text = str_replace('\'', '', $text);
    
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        
        }
    }else if($a == 13){
        $rss = simplexml_load_string($feeds);
        $x=$rss;
        for($i = 0;$i<5;$i++) {
            $entry = $x->channel->item[$i];
            $title = $entry->title;
            $guid = $entry->guid;
    
            $link = $entry->link;
            $date = $entry->pubDate;
            $date = str_replace($days, '', $date);
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d H:i:s', strtotime($date));
    
            $inside = file_get_html($link);
            $subtext = '';
            $img = $inside->find('div.td-post-featured-image')[0]->find('img')[0]->src;
            $img = "<img style=width:100% src=$img>";
    
            $text = $inside->find('div.td-post-content.td-pb-padding-side')[0];
            
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    }else if($a == 14){
        $rss = simplexml_load_string($feeds);
        $x=$rss;
        for($i = 0;$i<5;$i++) {
            $entry = $x->channel->item[$i];
            $title = $entry->title;
            $guid = $entry->guid;
    
            $link = $entry->link;
            $date = $entry->pubDate;
            $date = str_replace($days, '', $date);
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d H:i:s', strtotime($date));
    
            $inside = file_get_html($link);
            $subtext = $inside->find('div.blog-post')[0]->find('p')[0];
            $img =  $inside->find('div.blog-post')[0]->find('img')[0];
            if(!empty($img)){
                $img = 'http://www.industriaeambiente.pt'.$img->src;
                $img = "<img style=width:100% src=$img>";
            }else{
                $img = '';
            }
            $text = $entry->description;
            $text = preg_replace("/<img[^>]+\>/i", " ", $text); 
            $subtext = preg_replace("/<img[^>]+\>/i", " ", $subtext); 
    
            //remove '' das news
            $title = str_replace('\'', '', $title);
            $text = str_replace('\'', '', $text);
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
    
        }
    }/*else if($a == 15){
        for($i=0;$i<5;$i++){
            $id=16;
            $title = $html->find('article.t-gc1-am1')[0]->find('a')[0]->plaintext;
            $link = $html->find('section.t-grp-comp-1')[0]->find('article')[$i]->find('a')[0]->href;
            $link = 'https://www.tsf.pt'.$link;
            /*$inside = file_get_html($link);
            
            $date = $inside->find('div.t-a-info-pubtime')[0]->find('time')[0]->datetime;
            $date = str_replace("T"," ",$date);
            $subtext = $inside->find('div.t-ap-lead')[0];
            $src = "data-src";
            $img = $inside->find('div.t-ap-feature-media')[0]->find('img')[0]->$src;
            $img = "<img style=width:100% src=$img>";
    
            $text = $inside->find('div.t-ap-b-content-1')[0];
            $texto = $text->find('div.t-pubbox-inread.js-pubinread')[0]; 
            $text = str_replace($texto,$texto->remove,$text);   
            $text = str_replace('\'', '', $text);
            
            sendinfocomplete($title,$text,$subtext,$date,$id,$link,$img);   
        }
}*/else if($a == 16){
        for($i=0;$i<5;$i++){
            $link = $html->find('div.row')[8]->find('a.newslink.news_title')[$i]->href;
            $link = 'https://www.diarioaveiro.pt'.$link;
            $inside = file_get_html($link);
            $title = $inside->find('h1.page_title')[0];
            $img = $inside->find('img.img-responsive')[3]->src;
            $img ='https://www.diarioaveiro.pt'.$img;
            $img = "<img style=width:100% src=$img>";
    
            $text = $inside->find('div.col-md-12.news_resume')[0];
            $date = date("Y-m-d");
            $subtext = ' ';
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    }else if($a == 17){
        for($i=0;$i<5;$i++){
            $link = $html->find('div.row')[8]->find('a.newslink.news_title')[$i]->href;
            $link = 'https://www.diarioviseu.pt'.$link;
            $inside = file_get_html($link);
            $title = $inside->find('h1.page_title')[0]->plaintext;
            $img = $inside->find('img.img-responsive')[3]->src;
            $img ='https://www.diarioviseu.pt'.$img;
            $img = "<img style=width:100% src=$img>";
    
            $text = $inside->find('div.col-md-12.news_resume')[0];
            $subtext = ' ';
            $date = date('Y-m-d 00:00:00');
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }  
    }/*else if($a == 18){
        for($i=0;$i<3;$i++){
            $link = $html->find('article.minutoRight')[$i]->find('h2')[0]->find('a')[0]->href;
            echo $link;
            if(substr( $link, 0, 1 ) === "/"){
            $link = 'https://www.cmjornal.pt'.$link;
            $date = $html->find('span.dateTime')[$i]->plaintext;
            $inside = file_get_html($link);
            $subtext = $inside->find('span.lead')[0]->plaintext;
            $img = $inside->find('img.img-responsive')[0]->src;
            $img = "<img style=width:100% src=$img>";
                
            $title = $inside->find('div.row')[2]->find('h1')[0]->plaintext;
            $text = $inside->find('div.textoDetalhe.textoDetalheNovasPartilhas')[0];
            $text = preg_replace('/\<ul class=\"detalheSocialShares\"\>(.*?)\<\/ul\>/', '', $text);
            $texto = $inside->find('span.shapeTit')[0];
            $text = str_replace($texto,$texto->remove,$text); 
            //$text = $text.$inside->find('div.showLerMais')[0]->plaintext;
            $data = substr($date, 0, 5);
            $date = date("Y-m-d ").$data;
            $text = str_replace('\'', '', $text);
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
    
        }
        for($i=0;$i<3;$i++){
            $link = $html->find('article.minutoLeft')[$i]->find('h2')[0]->find('a')[0]->href;
            if(substr( $link, 0, 1 ) === "/"){
                $link = 'https://www.cmjornal.pt'.$link;
                $date = $html->find('span.dateTime')[$i]->plaintext;
                $inside = file_get_html($link);
                $subtext = $inside->find('span.lead')[0]->plaintext;
                $img = $inside->find('img.img-responsive')[0]->src;
                $img = "<img style=width:100% src=$img>";
        
                $title = $inside->find('div.row')[2]->find('h1')[0]->plaintext;
                $text = $inside->find('div.textoDetalhe.textoDetalheNovasPartilhas')[0];
                $text = preg_replace('/\<ul class=\"detalheSocialShares\"\>(.*?)\<\/ul\>/', '', $text);
                $texto = $inside->find('span.shapeTit')[0];
                $text = str_replace($texto,$texto->remove,$text); 
                //$text = $text.$inside->find('div.showLerMais')[0]->plaintext;
                $data = substr($date, 0, 5);
                $date = date("Y-m-d ").$data;
                $text = str_replace('\'', '', $text);
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            }
            }
        }
    }*/else if($a == 19){
        for($i=0;$i<5;$i++){
            $id = 20;
            $link = 'https://ionline.sapo.pt'.$html->find('div.content.active')[0]->find('article')[$i]->find('a')[0]->href;
            $inside = file_get_html($link);
            if(substr($link, -9) === 'Opiniao_i'){
                $img = $inside->find('img.autor')[0]->src;
                $title = $inside->find('h1.nobg')[0]->plaintext;
                $text = $inside->find('div#content')[0]->find('div.large-9.medium-12.small-12.columns')[0];
                $top = $inside->find('h1.nobg')[0];
                $text = str_replace($top,$top->remove,$text);
                $subtext = '';
                $img = "<img style=width:100% src=$img>";
                $text = str_replace('\'', '', $text);

            }else{
                $title = $html->find('div.content.active')[0]->find('article')[$i]->find('h3')[0]->find('a')[0]->plaintext;
                
                $img = $inside->find('section#content')[0];
                if(!empty($img)){
                    $img = $img->find('img')[0]->src;
                }else{
                    $img = $inside->find('img.autor')[0]->src;
                    
                }
                $date = $inside->find('span.publicacao')[0]->plaintext;
                $date = str_replace('/','-',$date);
                $hours = substr($date, -5);
                $subtext = $inside->find('span.lead')[0]->plaintext;
                $text = $inside->find('section#corpo')[0];
                
                
                $img = "<img style=width:100% src=$img>";
        
                $date = date("Y-m-d", strtotime($date));
                $date = $date." $hours";
                $text = str_replace('\'', '', $text);
            }
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
    }
    }else if($a == 20){
        for($i=0;$i<5;$i++){
            if(substr( $html->find('div.textDetails')[$i]->find('h1')[0]->find('a')[0]->href, 0, 17 ) === "https://vidaextra"){
                $i++;
            }
            $title = $html->find('ul.listArticles.latestList.itemCount_10')[0]->find('li')[$i]->find('h1.title')[0]->plaintext;
            $subtext = $html->find('ul.listArticles.latestList.itemCount_10')[0]->find('li')[$i]->find('h2.lead')[0]->plaintext;
            $link = $html->find('div.textDetails')[$i]->find('h1')[0]->find('a')[0]->href;
            if(substr( $link, 0, 1 ) === "/"){
            $link = 'https://expresso.pt'.$link;
            $inside = file_get_html($link);
            echo $link;

            $text = $inside->find('div.articleContent')[0];
            if(empty($text)){
                $text = $inside->find('div.article-content')[0];
                $head = $inside->find('div.read-more-button-wrapper')[0];
                $text = str_replace($head,$head->remove,$text);
                $text = substr($text, 0, strpos($text, "Siga Vida Extra"));
            }
            $img =$inside->find('section.content.fullArticle')[0];
            $vid = $inside->find('picture.landscape')[0];
            $nada = $inside->find('titleZone.darkStyle')[0];

            if(!empty($img)){
                if(empty($nada)){ 
                    $img = '';
                }else{
                    
                    $img = $inside->find('div.videoContainer')[0]->find('video')[0];
                }
                
            }else if(!empty($vid)){
                $img = $inside->find('picture.landscape')[0]->find('img')[0]->src;
                $img = "<img style=width:100% src=$img>";
            }else{
                $img = '';
            }
            
            }
            $date = $inside->find('div.articleToolsContainer')[0]->find('p')[0]->datetime;
            
            $date = str_replace('T',' ',$date);
            $date = str_replace('Z',' ',$date);
            $date = substr($date,0, -5);
            //remove '' das news
            $title = str_replace('\'', '', $title);
            $text = str_replace('\'', '', $text);
            $text = str_replace("<p>"," ",$text);
            $text = str_replace("</p>"," ",$text);
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        }
    }else if($a == 21){
        $html = file_get_html($mysongs[$a],false, $context);
        for($i=0;$i<5;$i++){
            $title = $html->find('div.noticiaRow')[$i]->find('h3')[0]->plaintext;
            
            $link = 'https://www.sabado.pt'.$html->find('div.noticiaRow')[$i]->find('h3')[0]->find('a')[0]->href;
            $subtext = $html->find('div.lead')[$i];
            $inside = file_get_html($link);
            $text = $inside->find('div.col-md-12.contentDestaque')[0];
            $text = preg_replace('/\<div id=\"escondec\" class=\"lerMais\"\>(.*?)\<\/div\>/', '', $text);
            $date = $inside->find('span.horaNoticia')[0]->plaintext;
            $date = substr($date,0, 5);
            $date = date("Y-m-d ").$date;
            $img = $inside->find('figure.destaqueImg')[0];
            $foto = $inside->find('div.blocoGaleria.galeria')[0];
            if(!empty($img)){
                $img = $img->src;
                $img = "<img style=width:100% src=$img>";
            }else if(!empty($foto)){
                $img = $foto;
            }else{
                $img ='';
            }
            //remove '' das news
            $title = str_replace('\'', '', $title);
            $text = str_replace('\'', '', $text);
            $text = str_replace("<p>"," ",$text);
            $text = str_replace("</p>"," ",$text);
            sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
           
        }
        }else if($a == 22){
            for($i=0;$i<5;$i++){
                $link = 'https://www.acorianooriental.pt'.$html->find('ul.article-list')[3]->find('li')[$i]->find('a')[0]->href;
                $inside = file_get_html($link);
                $title = $inside->find('article.read.video-article')[0]->find('header')[0]->find('h1')[0]->plaintext;
    
                $img = 'https://www.acorianooriental.pt'.$inside->find('img.main-image')[0]->src;
                $img = "<img style=width:100% src=$img>";
    
                $subtext = $inside->find('div.article-lead')[0];
                $text = $inside->find('div.article-body')[1];
                $date = $inside->find('span.date-published')[0]->plaintext;
                if(substr( $date, 0, 4 ) === "Hoje"){
                    $date = str_replace("Hoje,",date("Y/m/d"),$date);
                    $date = str_replace('/','-',$date);
                }
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            }
        }else if($a == 23){
            for($i=0;$i<5;$i++){
                $link = 'http://www.destak.pt'.$html->find('div#col1')[0]->find('li')[$i]->find('a')[0]->href;
                $inside = file_get_html($link);
                $title = $inside->find('div#col1')[0]->find('h2')[0]->plaintext;
                $text = $inside->find('div#col1')[0]->find('div.text')[0];
                $date = $inside->find('div.date')[0]->plaintext;
                $date = str_replace(' | ', '-', $date);
                $date = str_replace('H', '', $date);
                $date = str_replace(' ', '', $date);
                $date = str_replace('.', ':', $date);            
                $subtext = ' ';
                $img = ' ';
                $hours = substr($date, -5);
                $text = str_replace('\'', '', $text);
                $date = date("Y-m-d");
                $date = $date." $hours";
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        
            }
        }else if($a == 24){
            for($i=0;$i<4;$i++){
                $element = $html->find('div#post_category_home_last_news')[$i];
                $link = $element->find('a')[0]->href;
                $date = $html->find('span#hora_post_last_news')[$k]->plaintext;
                $c = date("Y-m-d").' '.$date;
                $site=file_get_html($link);
                $text = $site->find('div#post_content_1')[0];
                $src = 'data-lazy-src';
                $img = $site->find('div.featured-image-wrap')[0];
                $gal = $site->find('div#fotogaleria_fullsize')[0];
                $auto = $site->find('div#div_img_post')[0];
                if(!empty($img)){ 
                    $subtext = $site->find('div#resumo')[0]->plaintext;
                    $img = $img->find('img')[0]->$src;
                    $img = "<img style=width:100% src=$img >";
                    $title = $site->find('div#title_post')[0]->plaintext;
                    if($img === 'https://www.diariodominho.pt/wp-content/themes/diariominho/img/resources/opiniao_aspas2.png'){
                        $img = ' ';
                    }
                }else if(!empty($gal)){
                    $img =  $site->find('div#mySlides-1')[0];
                    $title = $site->find('span#fotogaleria_title_post1')[0]->plaintext;
                    $subtext = $site->find('div.col-md-12.fotogaleria_content_texto.fotog_parte1')[0]->plaintext;
                    $text = '';
                }else if(!empty($auto)){
                    $title = $site->find('div#opiniao_post_title')[0]->find('div')[0]->plaintext;
                    $img =  $site->find('div#div_img_post')[0]->style;
                    $img = str_replace('background-image: url(','',$img);
                    $img = "<img style=width:100% src=$img >";

                    $img = str_replace(');','',$img);
                    $subtext = ' ';
                    $text =  $site->find('div#post_content_1')[0];
                }
                $text = str_replace('\'', '', $text);

                $date = date("Y-m-d ").$date;
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                $k++;
            }
        }else if($a == 25){
            for($i=0;$i<5;$i++){
                $link = $html->find('div.t-g1-l4-i-i')[0]->find("article")[$i]->find('a')[0]->href;
                if(substr( $link, 0,5 ) === "https"){
                    
                }else{
                    $link = 'https://www.jn.pt'.$link;
                }
                $title = $html->find('div.t-g1-l4-i-i')[0]->find("article")[$i]->find('h2')[0]->plaintext;
                $inside = file_get_html($link);
                $subtext = $inside->find('div.t-article-content-inner.js-select-and-share-1')[0]->find('p')[0]->plaintext;
                $text = $inside->find('div.t-article-content-inner.js-select-and-share-1')[0];
                $text = preg_replace('/\<aside class=\"t-article-funcs-2\"\>(.*?)\<\/aside\>/', '', $text);
                $text = preg_replace('/\<p class=\"t-article-content-intro-1\"\>(.*?)\<\/p\>/', '', $text);
                $img = $inside->find('picture.js-article-media-pic.lazyload')[0];
                if(!empty($img)){
                    $img = $img->find('img')[0]->src;
                    $img = "<img style=width:100% src=$img>";
                }else{
                    $img = '';
                }
                $date = $inside->find('div.t-article-funcs-theme-1')[0]->find('time')[0]->content;
                $date = str_replace('T', ' ', $date);
                //remove '' das news
                $title = str_replace('\'', '\\', $title);
                $text = str_replace('\'', '\\', $text);
               
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            }
        }else if($a == 26){
            for($i=0;$i<5;$i++){
                $link = $html->find('ul.je-post-list-container')[0]->find('li')[$i]->find('a')[0]->href;
                $inside = file_get_html($link);
                
                $title = $html->find('ul.je-post-list-container')[0]->find('li')[$i]->find('div.je-title')[0]->plaintext;
                $subtext = $inside->find('h2.je-post-excerpt')[0]->plaintext;
                $src ='data-src';
                $img = $inside->find('div.col-12.col-lg-8')[0]->find('div.je-post-thumbnail.je-lazy')[0];
                if(!empty($img)){
                    $img = $img->find('img')[0]->$src;
                    $img = "<img style=width:100% src=$img>";
                }else{
                    $img = $inside->find('article#je-post')[0];
                    $foot = $inside->find('article#je-post')[0]->find('div.row')[0];
                    $img = str_replace($foot,$foot->remove,$img);
                }
                
                $text = $inside->find('div.je-post-content')[0];
                $text = preg_replace('/\<div class=\"je-btn-readmore\"\>(.*?)\<\/div\>/', '', $text);
                $date = $inside->find('time.je-post-date')[0]->datetime;
                $date = str_replace('T',' ',$date);
                $date = str_replace('+00:00','',$date);
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            }
        }else if($a == 27){
            for($i=0;$i<4;$i++){
                $link = $html->find('div.col-lg-4.col-md-6.col-sm-6.col-xs-12.article-thumb-block.ultima-hora')[$i]->find('a')[0]->href;
                $inside = file_get_html($link,false, $context);
                $title = $inside->find('h1.news-headline')[0]->plaintext;
                $subtext = $inside->find('h2.news-subheadline')[0]->plaintext;
                $img = $inside->find('div.news-main-image')[0]->find('img')[0]->src;
                $img = "<img style=width:100% src=$img>";
    
                $date = $inside->find( "meta[property='article:modified_time']" )[0]->content;
                $date = str_replace("T"," ",$date);
                $date = str_replace("+00:00","",$date);
                $text = $inside->find('div.news-main-text')[0];
                $text = preg_replace('/\<div class=\"row hidden-sm hidden-md hidden-lg\"\>(.*?)\<\/div\>/', '', $text);
                $text = preg_replace('/\<div class=\"article-thumb-description\"\>(.*?)\<\/div\>/', '', $text);
                $text = preg_replace('/\<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"\>(.*?)\<\/div\>/', '', $text);
                $text = preg_replace('/\<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\" style=\"padding-left: 0px\"\>(.*?)\<\/div\>/', '', $text);
                 //remove '' das news
                $title = str_replace('\'', '', $title);
                $text = str_replace('\'', '', $text);
                $recomend = $inside->find('h1.max-width-50')[0];
                $recomend1 = $inside->find('ul.nm-custom-subheader')[0];
    
                $text = str_replace($recomend,$recomend->remove,$text); 
                $text = str_replace($recomend1,$recomend1->remove,$text); 
                
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                
            }
        }else if($a == 28){
            for($i=0;$i<5;$i++){
                $link = 'https://rr.sapo.pt/'.$html->find('div#ultimas')[0]->find('li')[$i]->find('div.all-85.push-right')[0]->find('a')[0]->href;
                $inside = file_get_html($link);
                if(substr( $link, 0,26 ) === "https://rr.sapo.pt/artigo/"){
                    $minuto = $html->find('div.all-10.txtGrey.fw-400.push-left')[$i]->plaintext;
                    $title = $inside->find('div.column-group.half-left-padding')[0]->find('div.xlarge-100.large-100.medium-100.small-100.tiny-100.half-bottom-space')[0]->find('h1')[0]->plaintext;
                    $subtext = $inside->find('div.column-group.half-left-padding')[0]->find('div.xlarge-100.large-100.medium-100.small-100.tiny-100.half-bottom-space')[0]->find('span.large.fw-500')[0]->plaintext;
                    $text = $inside->find('div#bodyDinamico')[0];
                    $date = $inside->find('span.pull-left')[0]->plaintext;
                    $date = substr( $date, 0,12 );
                    $date = str_replace(',','',$date);
                    $date = $date." $minuto";
                    $img = $inside->find('div.overImageCx')[0];
                    if( empty($img)){
                        $img = $inside->find('div#sticker')[0]->find('img')[0];

                    }else{
                        $img = $img->find('a')[1]->href;

                        $img = "<video controls= autoplay= name=media><source src=$img type=audio/mpeg></video>";        

                    }
                   
                }else if(substr( $link, 0,25 ) === "https://rr.sapo.pt/video/"){
                    
                }else{
                    $title = $inside->find('div.column-group.half-left-padding')[0]->find('div.xlarge-100.large-100.medium-100.small-100.tiny-100.half-bottom-space')[0]->find('h1')[0]->plaintext;
                    $subtext = $inside->find('div.column-group.half-left-padding')[0]->find('div.xlarge-100.large-100.medium-100.small-100.tiny-100.half-bottom-space')[0]->find('span.large.fw-500')[0]->plaintext;
                    $text = $inside->find('div#bodyDinamico')[0];
                    $date = $inside->find('p.small.txtGrey.fw-400')[0]->plaintext;
                    $img = $inside->find('div.overImageCx')[0]->find('figure.ink-image')[0]->find('img')[0]->src;
                    $img = "<img style=width:100% src=$img>";
    
                    $date = substr( $date, 0,20 );
                    $date = str_replace(',','',$date);
                    $date = str_replace('-','',$date);
                    //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
                    $date = date('Y-m-d H:i:s', strtotime($date));
                    $recomend = $inside->find('div#bodyDinamico')[0]->find('p')[0];
                    $recomend1 = $inside->find('div#bodyDinamico')[0]->find('ul')[0];
                    $recomend2 = $inside->find('div#bodyDinamico')[0]->find('hr')[0];
    
                    $text = str_replace($recomend,$recomend->remove,$text); 
                    $text = str_replace($recomend1,$recomend1->remove,$text); 
                    $text = str_replace($recomend2,$recomend2->remove,$text); 
                }
                //remove '' das news
                $title = str_replace('\'', '', $title);
                $text = str_replace('\'', '\\', $text);
                
               sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            }  
        }else if($a == 29){
                for($i=0;$i<5;$i++){
                    $conta = $i+1;
                    $link = 'http://visao.sapo.pt'.$html->find('li.js-list-articles-entry.entry_'.$conta)[0]->find('h1.title')[0]->find('a')[0]->href;
                    $inside = file_get_html($link);
                    $date = $inside->find('p.timeStamp.publishedDate')[0]->datetime;
                    $date = str_replace('T',' ',$date);
                    $date = str_replace('Z',' ',$date);
                    $title = $inside->find('h1.title')[0]->plaintext;
                    $subtext = $inside->find('h2.lead')[0]->plaintext;
                    $img = $inside->find('picture.landscape')[0];
                    if(!empty($img)){
                        $img = $img->find('img')[0]->src;
                        $img = "<img style=width:100% src=$img>";
                    }else{
                        $img=' ';
                    }
                    $text = $inside->find('div.articleContent')[0];
                    $text = preg_replace('/\<figure class=\"placement-full-width\"\>(.*?)\<\/figure\>/', '', $text);
                    $text = preg_replace('/\<figure class=\"placement-right\"\>(.*?)\<\/figure\>/', '', $text);
                    $date = substr($date, 0, -8);
            
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            
                }
        }else if($a == 30){
            for($i = 0;$i<4;$i++) {
                $element =  $html->find('ul.headline-list.headline-list--compact')[0]->find('li.headline-list__item')[$i]->find('a')[0]->href;
                if(substr( $element, 0,22 ) === "https://www.publico.pt"){
                    $link =$element;
                }else{
                    $link ='https://www.publico.pt'.$element;
                    //echo $link;

                $title = $html->find('ul.headline-list.headline-list--compact')[0]->find('li.headline-list__item')[$i]->find('h5')[0]->plaintext;
                //$link = "<a href=$link>$title</a><br />";
                $inside = file_get_html($link);
                //echo $inside->find('time.dateline')[0].'<br />';
                $date = $inside->find('time.dateline')[0]->datetime;
                $date = str_replace($days, '', $date);
                $hours = substr($date, -9);
                $date = date("Y-m-d ").$hours;
                $src = 'data-media-viewer';      
                //echo "<img src=$img>";
                $img = $inside->find('div.flex-media.camera')[0];
                $sound = $inside->find('div#story-content')[0]->find('iframe')[0];
                $vid =  $inside->find('div#story-content')[0]->find('figure')[0];
                if(!empty($img)){
                    $img = $img->find('img')[0]->$src;
                    $img = "<img style=width:100% src=$img>";
                    $subtext = $inside->find('div.story__blurb')[0]->plaintext;
                    $k=0;
                    $count = count($inside->find('div#story-body')[0]->children);
                    $count1 = count($inside->find('figure.story__callout.story__callout--image'));
                    for($l=0;$l<$count;$l++){
        
                    $text = $inside->find('div#story-body')[0]->children($l);
                    
                    $pop = $inside->find('section.module')[0];
                    $ad2 = $inside->find('div.rmp-content')[0];
                
                    
                    $ler = $inside->find('div#supplemental-slot_container')[0];
                    $continuar = $inside->find('div.story__show-full')[0];
        
                    
                    $text = str_replace($pop,$pop->remove,$text);
                    $text = str_replace($ad2,$ad2->remove,$text);
                    
                    $text = str_replace($ler,$ler->remove,$text);
                    
                    $text = str_replace($continuar,$continuar->remove,$text);
        
                    $fasfasf = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
        
                    
                    foreach($inside->find('figure.story__callout.story__callout--image') as $elementar){
                        $image = $elementar->find('img')[0];
                        if($image->src == $fasfasf){
                            $image->src = $image->$src;
                        }else{
                            $image->src = $image->src;
                        }
                    }
                    $array[$l] = $text;
                    }
                    $text = implode('',$array);

                }else if(!empty($sound)){
                    $img = $inside->find('div#story-content')[0]->find('figure')[0];
                    $title = $inside->find('h1.headline.story__headline')[0]->plaintext;
                    $date = $inside->find('time.dateline')[0]->datetime;
                    $date = str_replace($days, '', $date);
                    $date = str_replace(',', '', $date);
                    $date = date('Y-m-d H:i:s', strtotime($date));
                    $text = $inside->find('div#story-body')[0];
                }else if(!empty($vid)){
                    $img =  $inside->find('div.flex-media.widescreen')[0]->find('div.video-holder')[1]->find('video')[0]->find('source')[0]->src;
                    $img = '<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"width="788.54" height="443" type="text/html" src="https://www.youtube.com/embed/zdWoJI5v94Q?autoplay=0&fs=0&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0&origin=https://youtubeembedcode.com"><div><small><a href="https://youtubeembedcode.com/de/">youtubeembedcode de</a></small></div><div><small><a href="http://add-link-exchange.com">check this out</a></small></div></iframe>';
                    $title = $inside->find('h1.headline.story__headline')[0]->plaintext;
                    $date = $inside->find('time.dateline')[0]->datetime;
                    $date = str_replace($days, '', $date);
                    $date = str_replace(',', '', $date);
                    $date = date('Y-m-d H:i:s', strtotime($date));
                    $text = $inside->find('div#story-body')[0];
                }else{
                    $subtext = '';
                    $src = 'data-interchange';
                    $img = $inside->find('span.avatar__pad')[0]->find('img')[0]->$src;
                    $img = str_replace('[','',$img);
                    $img = str_replace(',','',$img);
                    $img = "<img src=$img>";
                    $k=0;
                    $count = count($inside->find('div#story-body')[0]->children);
                    $count1 = count($inside->find('figure.story__callout.story__callout--image'));
                    for($l=0;$l<$count;$l++){
        
                    $text = $inside->find('div#story-body')[0]->children($l);
                    
                    $pop = $inside->find('section.module')[0];
                    $ad2 = $inside->find('div.rmp-content')[0];
                
                    
                    $ler = $inside->find('div#supplemental-slot_container')[0];
                    $continuar = $inside->find('div.story__show-full')[0];
        
                    
                    $text = str_replace($pop,$pop->remove,$text);
                    $text = str_replace($ad2,$ad2->remove,$text);
                    
                    $text = str_replace($ler,$ler->remove,$text);
                    
                    $text = str_replace($continuar,$continuar->remove,$text);
        
                    $fasfasf = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
        
                    
                    foreach($inside->find('figure.story__callout.story__callout--image') as $elementar){
                        $image = $elementar->find('img')[0];
                        if($image->src == $fasfasf){
                            $image->src = $image->$src;
                        }else{
                            $image->src = $image->src;
                        }
                    }
                    $array[$l] = $text;
                    }
                    $text = implode('',$array);
                }
                
                    
                    $title = str_replace('\'', '', $title);
                    $text = str_replace('\'', '', $text);
                    $text = str_replace("<p>"," ",$text);
                    $text = str_replace("</p>"," ",$text);
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        
            }
        }
            }else if($a == 31){
                for($i = 0;$i<5;$i++) {
                    $element =  $html->find('a.card__faux-block-link')[$i]; 
                    if(substr( $element->href, 0,28 ) === "https://www.publico.pt/fugas"){
                        $link =$element->href;
                    }else{
                    $link ='https://www.publico.pt'.$element->href;
                    $title = $element->plaintext;
                    //$link = "<a href=$link>$title</a><br />";
                    $inside = file_get_html($link);
                    $date = $inside->find('time.dateline')[0]->datetime;
                    //remove o dia da week (Mon,Tues) e o gmt do final
                    $date = str_replace($days, '', $date);
                    $hours = substr($date, -9);
                    $date = date('Y-m-d H:i:s', strtotime($date));
            
                    //echo $inside->find('time.dateline')[0].'<br />';
                    $subtext = $inside->find('div.story__blurb')[0]->plaintext;

                        $src = 'data-media-viewer';      
                        //echo "<img src=$img>";
                        $img = $inside->find('div.flex-media.camera')[0];
                        if(!empty($img)){
                            $img = $img->find('img')[0]->$src;
                            $img = "<img style=width:100% src=$img>";
                        }else{
                            $img = $inside->find('figure.story__media.media.media--video.media--action.media--horizontal-medium')[0]->find('source')[0]->src;
                            $img = "<iframe src='$img' width='100%' height='300px' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
                            //$img =  "<iframe widt='100%' src=$img>";    
                        }
                        $k=0;
                        $count = count($inside->find('div#story-body')[0]->children);
                        $count1 = count($inside->find('figure.story__callout.story__callout--image'));
                        $teste = $inside->find('div#story-body')[0];

                        $texto = $teste;
                        $fasfasf = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
                        
                        foreach($inside->find('img') as $elementar){
                            $image = $elementar;
                            if($image->src == $fasfasf){
                                $image->src = $image->$src;
                                
                            }else{
                                $image->src = $image->src;
                            }
                        }  
                        $sec = $inside->find('section.module')[0];
                        $ad = $inside->find('figure.story__callout.story__callout--embed.story__callout--inline')[0];
                        $cap = $inside->find('div.rmp-content')[0];
                        $ler = $inside->find('div.story__show-full')[0];
                        $text = str_replace($sec,$sec->remove,$texto);
                        $text = str_replace($ad,$ad->remove,$text);
                        $text = str_replace($cap,$cap->remove,$text);
                        $text = str_replace($ler,$ler->remove,$text);
                        
                        //remove '' das news
                        $title = str_replace('\'', '', $title);
                        $text = str_replace('\'', '', $text);
    
                        $ler = $inside->find('div#supplemental-slot_container')[0];
                            
                        $text = str_replace($ler,$ler->remove,$text); 
                        
                        sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                    }
                }
            }else if($a == 32){
                for($i=0;$i<5;$i++){
                    $link = $html->find('div.col-sm-3.col-xs-6.margin-bottom-30')[$i]->find('a')[0]->href;
                    $inside = file_get_html($link);
                    $title = $inside->find('h1.h2.margin-bottom-0')[0]->plaintext;
                    $subtext = $inside->find('h3.margin-top-0.text-light')[0]->plaintext;
                    $text = $inside->find('div.sizearticle.padding-top-20.padding-bottom-30')[0];
                    $img = $inside->find('article')[0]->find('img.img-responsive')[0]->src;
                    if(empty($img)){
                        $img = $inside->find( "link[itemprop=thumbnailUrl]" )[0]->href;
                    }
                    $date = $inside->find('p.small.text-light')[0]->find('time')[1]->datetime;
                    $date = str_replace('T',' ',$date);
                    $date = str_replace('+00:00','',$date);
                    $img = "<img style=width:100% src=$img>";
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                }
            }else if($a == 33){
                for($i=0;$i<5;$i++){
                    $link = $html->find('div.margin-bottom-10.clearfix')[$i]->find('a')[0]->href;
                    echo $link;
    
                    $inside = file_get_html($link);
                   
                    $img = $inside->find('div.relative.relative-image.margin-bottom-20')[0];
                    if(!empty($img)){
                        $img = $img->find('img')[0]->src;
                        $img = "<img style=width:100% src=$img>";
                        $date = $inside->find('time')[0]->datetime;
                        $date = str_replace("T"," ",$date);
                        $date = str_replace("+00:00","",$date);
                        $title = $inside->find('div.col-sm-8.article')[0]->find('h1')[0]->plaintext;
                        $subtext = $inside->find('h2.lead.sizearticle')[0]->plaintext;
                        $text = $inside->find('div.sizearticle.col-md-9.col-sm-12.pull-right')[0];
                    }else if(substr( $link, 0, 42 ) === "https://www.rtp.pt/noticias/imagem-do-dia/"){
                        $title = $inside->find('article')[0]->find('h1')[0]->plaintext;
                        $text = $inside->find('article')[0]->find('div.row')[0]->find('p')[0];
                        $date = $inside->find('time')[0]->datetime;
                        $date = str_replace("T"," ",$date);
                        $date = str_replace("+00:00","",$date);
                        $img = $inside->find('article')[0]->find('img')[0]->src;
                        $img = "<img style=width:100% src=$img>";
                        $subtext = '';
                    }else{
                        $img = '';
                        $date = $inside->find('time')[0]->datetime;
                        $date = str_replace("T"," ",$date);
                        $date = str_replace("+00:00","",$date);
                        $title = $inside->find('div.col-sm-8.article')[0]->find('h1')[0]->plaintext;
                        $subtext = $inside->find('h2.lead.sizearticle')[0]->plaintext;
                        $text = $inside->find('div.sizearticle.col-md-9.col-sm-12.pull-right')[0];
                    }
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);            
                    }
            }else if($a == 34){
                for($i=0;$i<5;$i++){
                    $link = $html->find('div.td-block-row')[1]->find('h3.entry-title.td-module-title')[$i]->find('a')[0]->href;
                    $inside = file_get_html($link);
                    $title = $inside->find('h1.entry-title')[0]->plaintext;
                    $subtext = $inside->find('p.td-post-sub-title')[0];
                    $img = $inside->find('div.td-post-featured-image')[0]->find('img')[0]->src;
                    $img = "<img style=width:100% src=$img>";
                    $text = $inside->find('div.td-post-content')[0];
                    $text = preg_replace('/\<div class=\"td-post-featured-image\"\>(.*?)\<\/div\>/', '', $text);
                    $date = $inside->find('time.entry-date.updated.td-module-date')[0]->datetime;
                    $date = str_replace('T',' ',$date);
                    $date = str_replace('+00:00','',$date);
                    $newstring = substr($date, -3);
                    $date = str_replace($newstring,'',$date);
                    //remove '' das news
                    $title = str_replace('\'', '', $title);
                    $text = str_replace('\'', '', $text);
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                }
            }else if($a == 35){
                for($i=0;$i<5;$i++){
                    $link = 'https://www.abola.pt'.$html->find('div.media.mt-15')[$i]->find('div.media-body')[0]->find('a')[0]->href;
                    $inside = file_get_html($link);
                    $date = date("Y-m-d ").$inside->find('span#body_Ver_lblHora')[0]->plaintext;
                    $img = $inside->find('img#body_Ver_imgNoticia')[0]->src;
                    $img = "<img style=width:100% src=$img>";
        
                    $title = $inside->find('h1.titulo')[0]->plaintext;
                    $text = $inside->find('div.corpo-noticia')[0];
                    $subtext = ' ';
                    $text = str_replace('\'', '', $text);
        
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                    
                }
            }else if($a == 36){
                for($i=0;$i<5;$i++){
                    $link = 'https://www.record.pt'.$html->find('ul.ultimasLista')[0]->find('li')[$i]->find('a')[1]->href;
                    $inside = file_get_html($link);
                    $title = $inside->find('div.article_titles')[0]->find('h1')[0]->plaintext;
                    $date = date("Y-m-d ");
                    $date = $date.$html->find('ul.ultimasLista')[0]->find('li')[$i]->find('a')[0]->find('span')[0]->plaintext;
                    
                    $img = $inside->find('figure.image.multimediaAbertura')[0];
                    $gallery =  $inside->find('div.moduloFotogaleria')[0];
                    
                    $img = preg_replace('/\<ul class=\"fotoUtils\"\>(.*?)\<\/ul\>/', '', $img);
                    if(!empty($img)){
                        $subtext = $inside->find('div.article_titles')[0]->find('h2')[0];
                        $text = $inside->find('div.text_container')[0];
                        $text = preg_replace('/\<div class=\"relacionadas\"\>(.*?)\<\/div\>/', '', $text);
                        $text = preg_replace('/\<div class=\"ultimas_info\"\>(.*?)\<\/div\>/', '', $text);
                        $text = preg_replace('/\<div class=\"lerMais\"\>(.*?)\<\/div\>/', '', $text);
                        $text = preg_replace('/\<article\>(.*?)\<\/article\>/', '', $text);
                    }else if(!empty($gallery)){
                        $img = $inside->find('div.moduloFotogaleria')[0];
                        $gal = $inside->find('div.thumbsMain')[0];
                    
                        $img = str_replace($gal,$gal->remove,$img);
                        $gal1 = $inside->find('div.fotogaleria_Fotos_nav')[0];
                    
                        $img = str_replace($gal1,$gal1->remove,$img);
                        $li = $inside->find('div.moduleMiddle')[0];
                    
                        $img = str_replace($li,$li->remove,$img);
                        $btn = $inside->find('button.closeThumbs')[0];
                    
                        $img = str_replace($btn,$btn->remove,$img);
                        $count = count($inside->find('div.fotogaleria_Fotos')[0]->find('img'));
                        for($u = 0;$u<$count;$u++){
                            $img = $inside->find('div.fotogaleria_Fotos')[0]->find('img')[$u]->src;
                            if(empty($img)){
                                $src = 'data-lazy';
                                $img = $inside->find('div.fotogaleria_Fotos')[0]->find('img')[$u]->$src;
                            }
                            $img = "<img style=width:100% src=$img>";
        
                        }
                        $subtext = $inside->find('div.article_titles')[0]->find('h2')[0];
                        $text = $inside->find('div.text_container')[0];
                        $text = preg_replace('/\<div class=\"relacionadas\"\>(.*?)\<\/div\>/', '', $text);
                        
                        $text = preg_replace('/\<article\>(.*?)\<\/article\>/', '', $text);
                    }else{
                    }
                    $title = str_replace('\'', '', $title);
                    $text = str_replace('\'', '', $text);
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                }
            }else if($a == 37){
                for($i=0;$i<5;$i++){
                    $link = 'https://www.ojogo.pt'.$html->find('section.t-section-list-7')[0]->find('li')[$i]->find('a')[0]->href;
                    $inside = file_get_html($link);
                    $title = $inside->find('header.t-a-head-1.js-select-and-share-1')[0]->find('h1')[0]->plaintext;
                    $date = $inside->find('div.t-a-info-1')[0]->find('time')[0]->datetime;
                    $img = $inside->find('aside.t-a-media-1')[0];
                    if(!empty($img)){
                        $img = $img->src;
                        $img = "<img style=width:100% src=$img >";
                        
                    }else{
                        $img = '';
                        
                    }
                    $img = preg_replace('/\<figcaption\>(.*?)\<\/figcaption\>/', '', $img);
                    $subtext = $inside->find('div.t-a-c-wrap.js-select-and-share-1')[0]->find('p')[0];
                    $text = $inside->find('div.t-a-c-wrap.js-select-and-share-1')[0];
                    $text = preg_replace('/\<section class=\"t-section-list-15\"\>(.*?)\<\/section\>/', '', $text);
                    $text = preg_replace('/\<div class=\"t-a-footer-1\"\>(.*?)\<\/div\>/', '', $text);
                    $text = preg_replace('/\<p class=\"t-a-c-intro-1\"\>(.*?)\<\/p\>/', '', $text);
                    $text = preg_replace('/\<aside role=\"complementary\" class=\"t-a-mmedia-box-2\"\>(.*?)\<\/aside\>/', '', $text);
                    $title = str_replace('\'', '', $title);
                    $text = str_replace('\'', '', $text);
                    $text = str_replace("<p>"," ",$text);
                    $text = str_replace("</p>"," ",$text);
                   
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                }
            }else if($a == 38){
                for($i=0;$i<4;$i++){
                    $link = 'https://www.dn.pt'.$html->find('div.t-article-list-1-body')[0]->find('ul')[0]->find('li')[$i]->find('a')[0]->href;
                    $date = $html->find('div.t-article-list-1-body')[0]->find('li')[$i]->find('time')[0]->datetime;
                    $inside = file_get_html($link);
                    $title = $inside->find('h1.t-af1-head-title')[0]->plaintext;
                    $subtext = $inside->find('div.t-af1-head-desc')[0];
                    $src ='data-src';
                    $text = $inside->find('div.t-af1-c1-body.js-a-content-body-elm-targ.js-article-readmore-resize-watch')[0];
                    $text = preg_replace('/\<aside class=\"t-af-callout-5 js-contentcollapse-root newslettercapping\"\>(.*?)\<\/aside\>/', '', $text);
                    $text = preg_replace('/\<aside role=\"complementary"\ class=\"t-af-share-2\"\>(.*?)\<\/aside\>/', '', $text);
                    $text = preg_replace('/\<aside role=\"complementary\" class=\"t-af-comments-1\"\>(.*?)\<\/aside\>/', '', $text);
                    $img = $inside->find('img.lazy-hidden')[0]->$src;
                    $img = "<img style=width:100% src=$img>";
    
                    $data = substr($date, 0, -8);
                    $hour = substr($date,-8);
                    $date = $data." $hour";
                    $date = substr($date, 0, -3);
                     //remove '' das news
                     $title = str_replace('\'', '', $title);
                     $text = str_replace('\'', '', $text);
                     $text = str_replace("<p>"," ",$text);
                     $text = str_replace("</p>"," ",$text);
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                }
            }else if($a == 39){
                $link = $html->find('div.home-widget')[0]->find('div.category3-text')[0]->find('a')[0]->href;
                $inside = file_get_html($link);
                $title = $inside->find('h1.headline')[0]->plaintext;
                $img = $inside->find('div.post-image')[0];
                $text = $inside->find('div.pf-content')[0];
                $date = $inside->find("meta[property=article:published_time]", 0)->content;
                $date = str_replace('T',' ',$date);
                $date = str_replace('+00:00','',$date);
                $subtext = '';
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            
                for($i=0;$i<3;$i++){
                    $link = $html->find('ul#home-last-news-list')[0]->find('li')[$i]->find('div.category3-text')[0]->find('a.main-headline')[0]->href;
                    $inside = file_get_html($link);
                    $title = $inside->find('h1.headline')[0]->plaintext;
                    $img = $inside->find('div.post-image')[0];
                    $text = $inside->find('div.pf-content')[0];
                    $date = $inside->find("meta[property=article:published_time]", 0)->content;
                    $date = str_replace('T',' ',$date);
                    $date = str_replace('+00:00','',$date);
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
             
                }
                header('Content-Type: text/html; charset=utf-8');
                $text = array();
                exec("login.py", $output);
            
                $title = $output[0];
                $date = date("Y-m-d");
                $subtext = $output[2];
                $img = $output[3];
                array_splice($output, 0, 4);
                $text = implode("",$output);
                $title = utf8_encode($title);
                $subtext = utf8_encode($subtext);
                $img = utf8_encode($img);
                $text = utf8_encode($text);   
                $title = str_replace('<h1>','',$title);
                $title = str_replace('</h1>','',$title);
                $subtext = str_replace('<strong>','',$subtext);
                $subtext = str_replace('</strong>','',$subtext);
            
                sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            
            }else if($a == 40){
                $rss = simplexml_load_string($feeds);
                $x=$rss;
                for($i = 0;$i<5;$i++) {
                    $entry = $x->channel->item[$i];
                    $title = $entry->title;
                    $guid = $entry->guid;
            
                    $link = $entry->link;
                    $date = $entry->pubDate;
                    
                    $html = file_get_html($link);
                    $img = $html->find('div.single-post-thumb')[0]->find('img')[0]->src;
                    $text = $html->find('div.entry')[0];
            
                    $texto = $text->find('div.agric-after-content')[0]; 
            
                    $text = str_replace($texto,$texto->remove,$text);  
                    $subtext = ' ';
                    //remove o dia da week (Mon,Tues) e o gmt do final
                    $date = str_replace($days, '', $date);
                    $date = str_replace('/', '-', $date);
                    //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
                    $date = date('Y-m-d H:i:s', strtotime($date));
                    //remove '' das news
                    $title = str_replace('\'', '', $title);
                    $text = str_replace('\'', '', $text);
                    $text = str_replace("<p>"," ",$text);
                    $text = str_replace("</p>"," ",$text);
                    $img = "<img style=width:100% src=$img>";
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
            
                }
            }else if($a == 41){
                $rss = simplexml_load_string($feeds);
                $x=$rss;
                for($i = 0;$i<5;$i++) {
                    $entry = $x->channel->item[$i];
                    $k=0;
                    $title = $entry->title;
                    $guid = $entry->guid;
                    $link = $entry->link;
                    $date = $entry->pubDate;
                    $html = file_get_html($link);
                    $img = $html->find('img.attachment-post-thumbnail.size-post-thumbnail.wp-post-image.jetpack-lazy-image')[0]->src;
                    if(!empty($img)){
                        $img = "<img style=width:100% src=$img >";
                    }else{
                        $img = '';
                    }
                    
                    $count = count($html->find('div.entry-content')[0]->find('p'));
                    for($n = 1;$n<$count;$n++) {
                        $element = $html->find('div.entry-content')[0]->find('p')[$n];
                        $nada[$n-1] = $element;                
                    }
                    $subtext =$html->find('div.entry-content')[0]->find('p')[0];
                    $nada[0]= " ";
                    $text = implode(" ",$nada);
                    //ordena numa forma que o sql perceba o H em vez de h para ser formato 24 em vez de 12
                    $date = date('Y-m-d H:i:s', strtotime($date));
                    sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
                }
            }
}
