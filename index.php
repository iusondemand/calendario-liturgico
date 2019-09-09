<?php
# 9.9.2019 by valentino spataro per www.pregaognigiorno.it; plugin (utilizzabile anche altrove) per i siti di www.sitieassistenza.it
# licenza MIT

$base="https://www.favrin.net/misc/calendario_liturgico/?output=JSON&anno=".date("Y");

if (date("Ymd") != date("Ymd", filemtime("./calendario.txt") ) ) {
	$cal =	file_get_contents($base);
	file_put_contents("./calendario.txt",$cal);
} else {
	$cal =	file_get_contents("./calendario.txt");
}

$meseit = array('Gennaio', 'Febbraio', 'Marzo','Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');


$pluginoutput= <<<CIAO

<style>
.liturgiadata{display:inline-block;width:80px;height:20px;margin-right:20px;text-align:right;}
#liturgia tr td {vertical-align:top;padding: 5px 5px;}
.right {text-align:right;}
.bigger {font-size:100%;}
.light {color:#888;}
.anno {font-size:110%;}
</style>

<p>Grazie a Gabriele Favrin</p>

<table id=liturgia>
CIAO;

$calarray = json_decode($cal, true);

$mese=date("m");

foreach ( $calarray["eventi"] as  $item ) {
	$url=$item["cathopedia"];
	if ($url=="") {
		$url=$item["wikipedia"];
	}
	if ($url!="") {
		$item["evento"] = "<a href=\"$url\">".$item["evento"]."</a>";
	}
	if ($item["giorno"]<10) {$item["giorno"]="0".$item["giorno"];}
	if ($item["mese"] >= $mese)  {
		$item["mese"] = substr( $meseit[$item["mese"]-1], 0,3);
		$pluginoutput.="\r\n<tr><td class=right><span class=bigger>".$item["giorno"].".".$item["mese"]."</span></td><td><b>".$item["evento"]."</b> <i>".$item["tipo_evento"]." <span class=light>".$item["colore"]."</Span></i></td></tr>"; 
	}
}


$pluginoutput.="</table>";

echo $pluginoutput;
