<?php session_start();
?>
<html>
<head>

	<title>Verifica corte vigas T.</title>
</head>

<body>


	<?php

//session_destroy();
	//require('ingreso.php');
	//Aca las variables son llamadas ala sesion
	$_SESSION['$diseño_sismo']		= 0;
	$_SESSION['b']=$_POST["b"]=70;
	$_SESSION['bw']=$_POST["bw"]=30;
	$_SESSION['h']=$_POST["h"]=52;
	$_SESSION['d']=$_POST["d"]=45;
	$_SESSION['dr']=$_POST["dr"]=7;
	$_SESSION['s']=$_POST["s"]=11.25;
	$_SESSION['Av']=$_POST["Av"]=3.1714813908026;
	$_SESSION['fc']=$_POST["fc"]=35;
	$_SESSION['fy']=$_POST["fy"]=420;
	$_SESSION['fyt']=$_POST["fyt"]=420;
	$_SESSION['Es']=$_POST["Es"]=210000;
	$_SESSION['Mu']=$_POST["Mu"]=20.1;
	$_SESSION['Vu']=$_POST["Vu"]=50;
	$_SESSION['diseno']=$_POST["diseno"]="sismico";

	//Declaracion de variables:
	$diseño_sismo = $_SESSION['$diseño_sismo'];	
	$b=$_SESSION['b'];
	$bw=$_SESSION['bw'];
	$h=$_SESSION['h'];
	$d=$_SESSION['d'];
	$dr=$_SESSION['dr'];
	$s = $_SESSION['s'];
	$Av= $_SESSION['Av'];
	$fc=$_SESSION['fc'];
	$fy=$_SESSION['fy'];
	$fyt=$_SESSION['fyt'];
	$Es=$_SESSION['Es'];
	$Mu=$_SESSION['Mu'];
	$Vu=$_SESSION['Vu'];
	$diseno=$_SESSION['diseno'];
		//print_r($_SESSION);
	
	$eyt=$fyt/$Es;
	
	$Vu= $Vu * 1000;
	
	$raiz_fc=pow($fc,0.5);
	
	if($raiz_fc>8.3)
	{trigger_error("Raiz fc' excede 8,3 MPa", E_USER_ERROR);}
	
	//$_SESSION['ey']=$ey;

//$diseno="sismico";
//CALULO DE FI


if($diseño_sismo==1)
{$fii=0.6;
}
else {$fii=0.75;}





$Vc=0.53*(pow($fc*10,0.5))*$bw*$d;

$Vs= $Av*($fy*10)*$d/$s;


$Vsespacio=1.1*(pow($fc*10,0.5))*$bw*$d;

$Vn= $Vc + $Vs;


 if($Vs>$Vsespacio)	
		{
		$s_cal=min($d/4,30);
		}	
 		else{
		$s_cal=min($d/2,60);
		}
 $Avmin=(0.2)*pow($fc*10,0.5)*$bw*$s/($fyt*10);
 //echo "<p>Avmin=". $Avmin; 
 
 $Avmin_menor=3.5*$bw*$s/($fyt*10);
 
 if($Avmin < $Avmin_menor)
 {
 $Avmin=$Avmin_menor;
 }
 else{$Avmin=$Avmin;}

 		
  
 	
 
if($Av< $Avmin)
{
$condicion_Av='ALERTA!!!...Av < Avmin';
}
else{
$condicion_Av=' Av >= Avmin...ok';

}

if($s <= $s_cal)
{
$condicion_s=' s <= s calculado...ok';
}
else{
$condicion_s=' s > s calculado...no cumple';

}




$Vsmax= 2.2 * pow($fc*10,0.5) * $bw * $d;

if($Vs > $Vsmax)
{
$seccion = 'Vs > Vsmax....seccion insuficiente, de acuerdo 11.5.7.9  ACI318-2005';
}
else{
$seccion= ' Vs <= Vsmax...ok...de acuerdo 11.5.7.9  ACI318-2005';

}

if($Vu > $fii*$Vn)
{
$condicion_Vn=' Vu > fiVn.... no cumple';
}
else{
$condicion_Vn=' Vu <= fiVn.... ok';

}
	


	echo "<p><h1>RESULTADOS</h1>";

	 echo "<p>b=". $b; 
	  echo "<p>bw=". $bw;
	 echo "<p>h=". $h;  
	 echo "<p>d=". $d;  
	 echo "<p>s=". $s; 
	 echo "<p>s_calculado=". $s_cal;
	 echo "<p>fi=". $fii;
	 echo "<p>Vu=". $Vu;
	 echo "<p>Vn=". $Vn; 
	 echo "<p>Vc=". $Vc;  
	 echo "<p>Vs=". $Vs;  
	 echo "<p>Vsmax=". $Vsmax;  
	    
	
	
	 echo "<p>Avmin=". $Avmin; 
	 echo "<p>Avmin_menor=". $Avmin_menor; 
	 echo "<p>Av=". $Av; 
	 
	 echo "<p>". $seccion;
	 echo "<p>".$condicion_Av;
	 echo "<p>".$condicion_s;
	 echo "<p>".$condicion_Vn;
	 
	 
	?>
	
</body>

</html>
