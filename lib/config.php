<?php
/*******************************************************************************
* Filename : config.php
* Description : configuration
*******************************************************************************/

## DeBUG ##
$app['debug'] = 0;

## MAGIC QUOTeS ON/OFF ##
$app['magic_quote'] = 1;

## ReCIPIeNT ##
$app['recipient_email']['contact'] = "widhadi.awp@gmail.com";


$app['lead']="";
$app['title']="";
$app['detail']="";

## LANGUAGe ##
#$app['language']['ina'] = "Indonesia";
#$app['language']['eng'] = "english";


## SIZe FILe ##
$app['file']['size'] = 1500;


$app['current_page'] = "";
$app['bahasa'] = "";
$app['nopage'] = "";
$app['pageid'] = "";
$app['act'] = "";
$app['p_id'] = "";
$app['step'] = "";
$app['sub'] = "";
$app['cat'] = "";
## PAGe TeXT STATIS for menu Group  ##

## PAGe TeXT STATIS for admin  ##
// $app['pages']['e_01'] = "home";
// $app['pages']['e_02'] = "about us";
// $app['pages']['e_021'] = "milestone";
// $app['pages']['e_022'] = "how we work";
// $app['pages']['e_023'] = "why us";
// $app['pages']['e_03'] = "product";
// $app['pages']['e_031'] = "product category";
// $app['pages']['e_032'] = "product detail";
// $app['pages']['e_04'] = "services";
// $app['pages']['e_041'] = "service category";
// $app['pages']['e_042'] = "service details";
// $app['pages']['e_05'] = "special offers";
// $app['pages']['e_051'] = "special details";
// $app['pages']['e_06'] = "affiliate";
// $app['pages']['e_021'] = "sejarah";
// $app['pages']['e_022'] = "cara kerja kami";
// $app['pages']['e_023'] = "kenapa kami";
// $app['pages']['e_08'] = "hubungi kami";
## PAGe for HeADeR ##
$app['header']['home'] = "home";
$app['header']['e_02'] = "login";
$app['header']['e_03'] = "form registrasi member";
$app['header']['e_04'] = "profil mahasiswa";
$app['header']['e_05'] = "profil dosen";
$app['header']['e_06'] = "daftar dosen";
$app['header']['e_061'] = "detil dosen";
$app['header']['e_062'] = "materi dosen";
$app['header']['e_0621'] = "detil materi dosen";
$app['header']['e_063'] = "tugas dosen";
$app['header']['e_0631'] = "detil tugas dosen";
$app['header']['e_0632'] = "jawab tugas dosen";
$app['header']['e_07'] = "daftar mahasiswa";
$app['header']['e_08'] = "manajemen materi";
$app['header']['e_09'] = "manajemen tugas";
$app['header']['e_091'] = "manajemen pertanyaan tugas";
$app['header']['e_092'] = "manajemen jawaban tugas";


## TOTAL RANDOM PAGe ##
$app['random_page'] = 4;

## LIST ACTION GLOBAL##
$app['action']['home'] = 1;
$app['action']['destination'] = 2;
$app['action']['destination_detail'] = 21;
$app['action']['destination_kategori'] = 22;
$app['action']['community'] = 3;
$app['action']['community_detail'] = 31;
$app['action']['thread'] = 4;
$app['action']['news'] = 5;
$app['action']['news_detail'] = 51;
## LIST ACTION PERSONAL##
$app['action']['newsfeed'] = 6;
$app['action']['mytrip'] = 7;
$app['action']['mytrip_detail'] = 71;
$app['action']['friend'] = 8;
$app['action']['photos'] = 9;

$app['action']['e_02'] = "login";
$app['action']['e_03'] = "daftar-member";
$app['action']['e_04'] = "profil-mhs";
$app['action']['e_05'] = "profil-dosen";
$app['action']['e_06'] = "daftar-dosen";
$app['action']['e_061'] = "detil-dosen";
$app['action']['e_062'] = "materi-dosen";
$app['action']['e_0621'] = "detil-materi-dosen";
$app['action']['e_063'] = "tugas-dosen";
$app['action']['e_0631'] = "detil-tugas-dosen";
$app['action']['e_0632'] = "jawab-tugas-dosen";
$app['action']['e_07'] = "daftar-mhs";
$app['action']['e_08'] = "manajemen-materi";
$app['action']['e_09'] = "manajemen-tugas";
$app['action']['e_091'] = "manajemen-pertanyaan-tugas";
$app['action']['e_092'] = "manajemen-jawaban-tugas";


##--for editor--##
$app['editor']['title']="text";
$app['editor']['leads']="wysiwyg";
## STATUS FOR MONTH ##
$app['month'][0]=date('F',strtotime("2002-1-1"));
$app['month'][1]=date('F',strtotime("2002-2-1"));
$app['month'][2]=date('F',strtotime("2002-3-1"));
$app['month'][3]=date('F',strtotime("2002-4-1"));
$app['month'][4]=date('F',strtotime("2002-5-1"));
$app['month'][5]=date('F',strtotime("2002-6-1"));
$app['month'][6]=date('F',strtotime("2002-7-1"));
$app['month'][7]=date('F',strtotime("2002-8-1"));
$app['month'][8]=date('F',strtotime("2002-9-1"));
$app['month'][9]=date('F',strtotime("2002-10-1"));
$app['month'][10]=date('F',strtotime("2002-11-1"));
$app['month'][11]=date('F',strtotime("2002-12-1"));

## STATUS FOR BROWSeR ##
$app['browser'][0]="MSIe 6";
$app['browser'][1]="MSIe 7";
$app['browser'][2]="MSIe 8";
$app['browser'][3]="MSIe 9";
$app['browser'][4]="Lynx";
$app['browser'][5]="Opera";
$app['browser'][6]="Konqueror";
$app['browser'][7]="Netscape";
$app['browser'][8]="Firefox 3x";
$app['browser'][9]="Firefox 4x";
$app['browser'][10]="Chrome";
$app['browser'][11]="Bot";
$app['browser'][12]="Opera Mini";
$app['browser'][13]="Iphone";
$app['browser'][14]="Android";
$app['browser'][15]="BlackBerry";
//$app['browser'][12]="Palm Os";
$app['browser'][16]="Other";

## STATUS FOR HOUR ##
$app['hour'][0]="1 am";
$app['hour'][1]="2 am";
$app['hour'][2]="3 am";
$app['hour'][3]="4 am";
$app['hour'][4]="5 am";
$app['hour'][5]="6 am";
$app['hour'][6]="7 am";
$app['hour'][7]="8 am";
$app['hour'][8]="9 am";
$app['hour'][9]="10 am";
$app['hour'][10]="11 am";
$app['hour'][11]="12 am";
$app['hour'][12]="1 pm";
$app['hour'][13]="2 pm";
$app['hour'][14]="3 pm";
$app['hour'][15]="4 pm";
$app['hour'][16]="5 pm";
$app['hour'][17]="6 pm";
$app['hour'][18]="7 pm";
$app['hour'][19]="8 pm";
$app['hour'][20]="9 pm";
$app['hour'][21]="10 pm";
$app['hour'][22]="11 pm";
$app['hour'][23]="12 pm";

## STATUS FOR OS ##
$app['os'][0]="Windows";
$app['os'][1]="Linux";
$app['os'][2]="Mac";
$app['os'][3]="FreeBSD";
$app['os'][4]="SunOS";
$app['os'][5]="IRIX";
$app['os'][6]="BeOS";
$app['os'][7]="OS2";
$app['os'][8]="AIX";
$app['os'][9]="Other";

## STATUS FOR Week ##
$app['week'][0]="Minggu";
$app['week'][1]="Senin";
$app['week'][2]="Selasa";
$app['week'][3]="Rabu";
$app['week'][4]="Kamis";
$app['week'][5]="Jum'at";
$app['week'][6]="Sabtu";

## WeeKDAY ##
$app['eng']['weekday'][0] = 'Sunday';
$app['eng']['weekday'][1] = 'Monday';
$app['eng']['weekday'][2] = 'Tuesday';
$app['eng']['weekday'][3] = 'Wednesday';
$app['eng']['weekday'][4] = 'Thursday';
$app['eng']['weekday'][5] = 'Friday';
$app['eng']['weekday'][6] = 'Saturday';

$app['ina']['weekday'][1] = 'Senin';
$app['ina']['weekday'][2] = 'Selasa';
$app['ina']['weekday'][3] = 'Rabu';
$app['ina']['weekday'][4] = 'Kamis';
$app['ina']['weekday'][5] = 'Jumat';
$app['ina']['weekday'][6] = 'Sabtu';
$app['ina']['weekday'][7] = 'Minggu';

## MONTH ##
$app['ina']['month'][0]="Jan";
$app['ina']['month'][1]="Feb";
$app['ina']['month'][2]="Mar";
$app['ina']['month'][3]="Apr";
$app['ina']['month'][4]="May";
$app['ina']['month'][5]="Jun";
$app['ina']['month'][6]="Jul";
$app['ina']['month'][7]="Aug";
$app['ina']['month'][8]="Sep";
$app['ina']['month'][9]="Oct";
$app['ina']['month'][10]="Nov";
$app['ina']['month'][11]="Dec";

$app['eng']['month'][0]="January";
$app['eng']['month'][1]="February";
$app['eng']['month'][2]="March";
$app['eng']['month'][3]="April";
$app['eng']['month'][4]="May";
$app['eng']['month'][5]="June";
$app['eng']['month'][6]="July";
$app['eng']['month'][7]="August";
$app['eng']['month'][8]="September";
$app['eng']['month'][9]="October";
$app['eng']['month'][10]="November";
$app['eng']['month'][11]="December";
/* Tambahan buat Calendar*/
$app['year'] = date("Y");
$app['month'] = date("n"); 
$app['limit_day'] = date("w", mktime (0,0,0,$app['month']+1,0,$app['year']));
$app['last_day'] = date("d", mktime (0,0,0,$app['month']+1,0,$app['year']));
$app['last_day_this'] = date("w", mktime (0,0,0,$app['month']+1,0,$app['year']));
$app['last_day_prev'] = date("d", mktime (0,0,0,$app['month'],0,$app['year']));
$app['first_day'] = date("w", mktime (0,0,0,$app['month'],1,$app['year']));
//alias
$app['als']['weekday'][1] = 'M';
$app['als']['weekday'][2] = 'T';
$app['als']['weekday'][3] = 'W';
$app['als']['weekday'][4] = 'T';
$app['als']['weekday'][5] = 'F';
$app['als']['weekday'][6] = 'S';
$app['als']['weekday'][7] = 'S';
//abjad browse
$app['abjad'][1]="a";
$app['abjad'][2]="b";
$app['abjad'][3]="c";
$app['abjad'][4]="d";
$app['abjad'][5]="e";
$app['abjad'][6]="f";
$app['abjad'][7]="g";
$app['abjad'][8]="h";
$app['abjad'][9]="i";
$app['abjad'][10]="j";
$app['abjad'][11]="k";
$app['abjad'][12]="l";
$app['abjad'][13]="m";
$app['abjad'][14]="n";
$app['abjad'][15]="o";
$app['abjad'][16]="p";
$app['abjad'][17]="q";
$app['abjad'][18]="r";
$app['abjad'][19]="s";
$app['abjad'][20]="t";
$app['abjad'][21]="u";
$app['abjad'][22]="v";
$app['abjad'][23]="w";
$app['abjad'][24]="x";
$app['abjad'][25]="y";
$app['abjad'][26]="z";
$app['abjad'][27]="#";

$app["aktip"]="";
?>