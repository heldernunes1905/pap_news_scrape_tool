
<?php 
include_once '../functionDB1.php';
require('simple_html_dom.php');
$days = ["Mon,", "Tue,", "Wed,","Thu","Fri","Sat","Sun","GMT"];
$months = ["jan","fev","mar","abr","mai","jun","jul","ago","set","out","nov","dez"];
$months_num = ["01","02","03","04","05","06","07","08","09","10","11","12"];
$b = 0;
$lista = url();

$context = stream_context_create(array(
    'http' => array(
        'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
    ),
));


$html = 'https://www.ojogo.pt';
for($a = 0; $a < 1; $a++){
    $id=1;
    $tudo=$html; 
    $feeds = file_get_contents($tudo,false, $context);
    $html = file_get_html($tudo,false, $context);
     if($a == 0){
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
    }
}