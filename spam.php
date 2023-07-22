<?php
include 'functionDB.php';
require('./noticias/simple_html_dom.php');
$mysongs=array();
$days = ["Mon,", "Tue,", "Wed,","Thu","Fri","Sat","Sun","GMT"];
$months = ["jan","fev","mar","abr","mai","jun","jul","ago","set","out","nov","dez"];
$months_num = ["01","02","03","04","05","06","07","08","09","10","11","12"];
$k =0;
$array = array();

$mysongs[0] = ('https://www.jm-madeira.pt/');

$context = stream_context_create(array(
    'http' => array(
        'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
    ),
));


$array_length = sizeof($mysongs);

for($a = 0; $a < $array_length; $a++){
    $id=3;
    $tudo=$mysongs[$a]; 
    $feeds = file_get_contents($mysongs[$a],false, $context);
    $html = file_get_html($tudo,false, $context);
    if($a == 0){for($i=1;$i<5;$i++){
            
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
        sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
        
    }
    }
}
$requiredPage = "../index.php";
//header('Refresh:1;url='.$requiredPage);
/*fazer em casa
for($i=0;$i<4;$i++){
        $link = $html->find('div.col-lg-4.col-md-6.col-sm-6.col-xs-12.article-thumb-block.ultima-hora')[$i]->find('a')[0]->href;
        $inside = file_get_html($link,false, $context);
        $title = $inside->find('h1.news-headline')[0]->plaintext;
        $subtext = $inside->find('h2.news-subheadline')[0]->plaintext;
        $img = $inside->find('div.news-main-image')[0]->find('img')[0]->src;
        
        $text = $inside->find('div.news-main-text')[0];
        $text = preg_replace('/\<div class=\"row hidden-sm hidden-md hidden-lg\"\>(.*?)\<\/div\>/', '', $text);
        $text = preg_replace('/\<div class=\"article-thumb-description\"\>(.*?)\<\/div\>/', '', $text);
        $text = preg_replace('/\<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"\>(.*?)\<\/div\>/', '', $text);
        $text = preg_replace('/\<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\" style=\"padding-left: 0px\"\>(.*?)\<\/div\>/', '', $text);
        $date = ' ';
        //sendinfocomplete($title, $text,$subtext,$date,$id,$link,$img);
    } 
    $link = $html->find('div.col-lg-4.col-md-6.col-sm-6.col-xs-12.article-thumb-block.ultima-hora')[5]->find('a')[0]->href;
    $inside = file_get_html('https://www.noticiasaominuto.com/pais/1216084/camiao-a-arder-na-ponte-vasco-da-gama-corta-transito-veja-as-imagens');
    $title = $inside->find('h1.news-headline')[0]->plaintext;
    $subtext = $inside->find('h2.news-subheadline')[0]->plaintext;
    $img = $inside->find('div.news-main-image')[0]->find('img')[0]->src;
    if(!empty($img)){
        $img = $inside->find('div.news-main-image')[0]->find('img')[0]->src;
    }else{
       $img = $inside;
       $top = $inside->find('div.rich-media-container')[0];
       $nav = $inside->find('nav.navbar.navbar-nm.navbar-fixed-top.pais')[0];
       $ad = $inside->find('div.side-bar')[0];
       $rela = $inside->find('div.news-related-container')[0];
       $news = $inside->find('div.newsletter-form-block.news.hidden-xs')[0];
       $foot = $inside->find('div.footer-block')[0];
       $float = $inside->find('div.sapofixedlayer')[0];
       $coment = $inside->find('div.row.news-social-comments')[0];

       
       $img = str_replace($top,$top->remove,$img);
       $img = str_replace($nav,$nav->remove,$img);
       $img = str_replace($ad,$ad->remove,$img);
       $img = str_replace($rela,$rela->remove,$img);
       $img = str_replace($news,$news->remove,$img);
       $img = str_replace($foot,$foot->remove,$img);
       $img = str_replace($float,$float->remove,$img);
       $img = str_replace($coment,$coment->remove,$img);
       

       echo $img;
    }
    $text = $inside->find('div.news-main-text')[0];
    $text = preg_replace('/\<div class=\"row hidden-sm hidden-md hidden-lg\"\>(.*?)\<\/div\>/', '', $text);
    $text = preg_replace('/\<div class=\"article-thumb-description\"\>(.*?)\<\/div\>/', '', $text);
    $text = preg_replace('/\<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"\>(.*?)\<\/div\>/', '', $text);
    $text = preg_replace('/\<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\" style=\"padding-left: 0px\"\>(.*?)\<\/div\>/', '', $text);
    $date = ' ';
*/


