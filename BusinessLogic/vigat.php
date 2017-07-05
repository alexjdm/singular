<?php

class VigaT
{

    public function checkVigaT(){

        //session_destroy();
        //require('ingreso.php');
        //session_start();

        $b	= $_GET['b'];
        $bw	= $_GET['bw'];
        $h	= $_GET['h'];
        $hf	= $_GET['hf'];
        $r	= $_GET['r'];
        $d	= $h - $r;
        $fc	= $_GET['fc'];
        $fy	= $_GET['fy'];
        $Es	= $_GET['Es'];
        $Mu	= $_GET['Mu'];
        //$Pu	= $_GET['Pu'];
        $Vu	= $_GET['Vu'];
        $n	= $_GET['n'];

        //Aca las variables son llamadas ala sesion
        $_SESSION['b']		= 100;
        $_SESSION['bw']		= 30;
        $_SESSION['d']		= 55;
        $_SESSION['h']		= 60;
        $_SESSION['hf']		= 12;
        $_SESSION['r']		= 5;
        $_SESSION['fc']		= 25;
        $_SESSION['fy']		= 420;
        $_SESSION['Es']		= 210000;
        $_SESSION['Mu']		= 50;
        $_SESSION['Pu']		= 20.1;
        $_SESSION['Vu']		= 10;
        $_SESSION['n']		= 3;

        $_SESSION['dd[1]']	= 5;
        $_SESSION['dd[2]']	= 30;
        $_SESSION['dd[3]']	= 55;


        $_SESSION['As[1]']	= 5;
        $_SESSION['As[2]']	= 5;
        $_SESSION['As[3]']	= 5;


        //Declaracion de variables:
        $b	= $_SESSION['b'];
        $bw	= $_SESSION['bw'];
        $d	= $_SESSION['d'];
        $h	= $_SESSION['h'];
        $hf	= $_SESSION['hf'];
        $r	= $_SESSION['r'];
        $fc	= $_SESSION['fc'];
        $fy	= $_SESSION['fy'];
        $Es	= $_SESSION['Es'];
        $Mu	= $_SESSION['Mu'];
        $Pu	= $_SESSION['Pu'];
        $Vu	= $_SESSION['Vu'];
        $n	= $_SESSION['n'];

        $dd	= array();
        $cc	= array();	$cc[0] = 0;
        $rr = array();
        $ss = array();  $ss[0] = 0;
        $NN = array();  $NN[0] = 0;
        $kk = array();
        $roo = array();
        $fs = array();
        $As = array();
        $PP = array(); $PP[0] = 0;
        $Mnn = array(); $Mnn[0] = 0;
        $MM = array(); $MM[0] = 0;
        $MMp = array(); $MMp[0] = 0;
        $PPp = array(); $PPp[0] = 0;
        $PPs = array(); $PPs[0] = 0;
        $MMs = array(); $MMs[0] = 0;
        $MMss = array(); $MMss[0] = 0;
        $Pn = array(); $Pn[0] = 0;
        $Mn = array(); $Mn[0]  =0;

        $Aslinea= array();

        $Mu=$Mu*100000;

        for($i=1; $i<=$n; $i++)
        {
            $dd[$i] = $_SESSION['dd['.$i.']'];
            //	echo "<p>dd[$i]=".$dd[$i];
        }

        for($i=1; $i<=$n; $i++)
        {
            $As[$i] = $_SESSION['As['.$i.']'];
            //	echo "<p>dd[$i]=".$dd[$i];
        }


        // Calculo r
        $d		= $h-$r;
        $rr[1] 	= $d;
        //echo "<p>rr[1]=".$d;
        //echo "<p>rr[1]=".$rr[1];

        for($i=2; $i<=$n; $i++)
        {
            $rr[$i]	= $h-$dd[$i];
        }

        $ey = $fy/$Es;
        $_SESSION['ey'] = $ey;

        //Calculo beta
        if($fc <= 30){
            $_SESSION['B1'] = 0.85;
        } elseif($fc>55){
            $_SESSION['B1'] = 0.65;
        } else {
            $_SESSION['B1'] = 0.85-0.008*($fc-30);
        }

        $B1 = $_SESSION['B1'];
        //echo $B1;


        //CALCULO ARMADURA MINIMA

        $Asm=0.8*(pow($fc*10,0.5))*$bw*$d/(4*$fy*10);
        //echo "<p>Asmin=".$Asm;
        if($Asm<=14*$bw*$d/($fy*10)){
            $Asm=14*$bw*$d/($fy*10);
            //echo "<p>Asmin refe=".$Asm;
        }else{
            //$Asm=$Asm;
        }

        //echo "<p>Asmin=".$Asm;





        //CALCULO MOMENTO MAXIMO (LIMITE)
        $clim 	= (3/7)*$d;

        //Se hace et= et limite = 0.004 (sección controlada tracción)
        $et 	= 0.004;
        $etlim	= $et;

        //Calculo de fii
        if($et<=$ey){
            $fii = 0.65;
        }
        elseif($et >= 0.005){
            $fii = 0.9;
        }
        else{
            $fii = 0.65+($et-$ey)*(0.25/(0.005-$ey));
        }

        $filim = $fii;  // se define fi limite
        //echo $fii. '<br>';

        $c = $clim;
        $alim = $B1*$c;

        $fs[1] = 0.003*$Es*10*($d-$c)/$c;
        //echo "<p>fs[1]=".$fs[1];


        for ($i=2; $i<=$n; $i++)
        {
            $fs[$i] = 0.003*$Es*10*($c-$rr[$i])/$c;
        }

        for ($i=1; $i<=$n; $i++)
        {
            //echo $i;
            if($fs[$i]>$fy*10)
            {
                $fs[$i]	= $fy*10;
            }
            else if($fs[$i]<-($fy*10))
            {
                $fs[$i]	= -$fy*10;
            }
            else {
                //$fs[$i] = $fs[$i];
            }
            //	echo "<p>fs[$i]=".$fs[$i];
        }


        for ($i=1; $i<=$n; $i++)
        {
            for ($i=1; $i<=$n; $i++)
            {
                if($rr[$i]<=$c)
                {
                    $MM[$i]=($fs[$i]-0.85*$fc*10)*$As[$i]*($d-$rr[$i]);
                }
                else
                {
                    $MM[$i]=$fs[$i]*$As[$i]*($d-$rr[$i]);
                }

                //echo "<p>MM[$i]=".$MM[$i];
            }

            for ($i=1; $i<=$n; $i++)
            {
                $MMs[$i]=$MM[$i]+ $MM[$i-1];  //suma los momentos pareciales aportado por el acero
                //echo "<p>MMs[$i]=".$MMs[$i];
            }
        }

        if($alim<=$hf){
            $Mnlim= 0.85*$fc*$alim*$b*($d-0.5*$alim)*10+$MMs[$n];
        }
        else{
            $Mnlim=0.85*$fc*10*($hf*($b-$bw)*($d-($hf*0.5))+$bw*$alim*($d-($alim*0.5)))+$MMs[$n];
        }

        $Mmax= $Mnlim*$fii;


        //CALCULO C

        if($Mu > $Mmax)
        {

            //echo "<p>clim=".$clim;
            //echo "<p>et=".$etlim;
            //echo "<p>Mnlim=".$Mnlim;
            //echo "<p>fii=".$filim;
            //echo "<p>Mu=".$Mu;
            //echo "<p>Mmax= Mnlim * fii=".$Mmax;

            $seccion = 'Armadura Insuficiente.... Mu >Mmax';
            //echo "<p>".$seccion;

            $variables = array
            (
                array("clim",$clim),
                array("et",$etlim),
                array("Mnlim",$Mnlim),
                array("fii",$filim),
                array("Mu", $Mu),
                array("Mmax", $Mmax),
                array("seccion", $seccion)
            );

            $data = array(
                'status'  => "success",
                'message' => $variables
            );
        }
        else {
            $cmin 	= 1;
            $cmax	= $clim;
            $ciclos = 0;
            $Msol   = 0;

            do
            {
                $ciclos= $ciclos + 1;

                for ($i=1; $i<=11; $i++)
                {
                    $paso=($cmax-$cmin)/10;
                    if($i==1)
                    {
                        $cc[$i]=$cmin;
                    }
                    else{
                        $cc[$i]=$cc[$i-1]+ $paso;
                    }
                    //echo "<p><h1>cc[$i]=</h1>".$cc[$i];

                    $a = $B1*$cc[$i];
                    $et=0.003*($d-$cc[$i])/$cc[$i];

                    //Calculo de fii
                    if($et<=$ey){
                        $fii = 0.65;
                    }
                    elseif($et >= 0.005){
                        $fii = 0.9;
                    }
                    else{
                        $fii = 0.65+($et-$ey)*(0.25/(0.005-$ey));
                    }

                    $filim = $fii;  // se define fi limite
                    //echo $fii. '<br>';

                    //echo "<p>roo[$j]".$roo[$j];
                    //	echo "<p>As".$As;

                    for ($u=1; $u<=$n; $u++)
                    {
                        $fs[$u] = 0.003*$Es*10*($cc[$i]-$rr[$u])/$cc[$i];
                        //echo "<p>fsssss[$i]=".$fs[$i];
                    }

                    for ($u=1; $u<=$n; $u++)
                    {
                        //echo "<p>fscc[$i]=".$fs[$i];
                        //echo $i;
                        if($fs[$u]>$fy*10)
                        {
                            $fs[$u]	= $fy*10;
                        }
                        else if($fs[$u]<-($fy*10))
                        {
                            $fs[$u]	= -$fy*10;
                        }
                        else {
                            //$fs[$u] = $fs[$u];
                        }
                        //echo "<p>fsssss[$u]=".$fs[$u];
                    }

                    for ($u=1; $u<=$n; $u++)
                    {
                        if($rr[$u]<=$cc[$i])
                        {
                            $MM[$u]=($fs[$u]-0.85*$fc*10)*$As[$u]*($d-$rr[$u]);
                        }
                        else{
                            $MM[$u]=$fs[$u]*$As[$u]*($d-$rr[$u]);
                        }
                        //echo "<p>MM[$u]=".$MM[$u];
                    }

                    for ($u=1; $u<=$n; $u++)
                    {
                        //echo "<p>fs[$u]=".$fs[$u];
                        //echo "<p>As]=".$As;
                        //echo "<p>MM[$u]=".$MM[$u];

                        $MMs[$u]=$MM[$u]+ $MMs[$u-1];
                        //echo "<p>MMs[$u]=".$MMs[$u];
                    }

                    $Mnn[$i]	= 0.85*$fc*10*$a*$b*($d-$a*0.5)+$MMs[$n];

                    if($a<=$hf){
                        $Mnn[$i]= 0.85*$fc*$a*$b*($d-0.5*$a)*10+$MMs[$n];
                    }
                    else{
                        $Mnn[$i]=0.85*$fc*10*($hf*($b-$bw)*($d-($hf*0.5))+$bw*$a*($d-($a*0.5)))+$MMs[$n];
                    }

                    $Msol=$Mu/$fii;

                    if($Msol>=$Mnn[$i-1] &&	$Msol<=$Mnn[$i])
                    {
                        $cmin=$cc[$i-1];
                        $cmax=$cc[$i];
                        $dif= $cmax-$cmin;
                        break;
                    }
                    else{}


                }//for de c

            }
            while(abs($Msol-$Mnn[$i])>0.01);

            $c = $cmax;
            $Mn= $Mnn[$i];


            if($Msol==$Mn)
            {
                $condicion='Msol = Mn .... sección suficiente..ok';
            }
            else {
                $condicion='Msol < Mn .... sección suficiente..ok';
            }

            if($As[1]< $Asm) {
                $condicion_armmin= 'ALERTA!!! ...ARMADURA A TRACCION MENOR QUE LA MINIMA....CAP. 10.5.1 ACI 318/2005';
            }
            else{
                $condicion_armmin='As a tracción ≤ Asmin...ok';
            }

            //echo "<p>Asmin=".$Asm;

            //echo "<p>As[1]=".$As[1];


            //echo "<p>c=".$c;
            //echo "<p>Mn=".$Mn;

            //echo "<p>Mmax= Momento nominal máximo nominal reducido =  ".$Mmax;
            //echo "<p>Mu=".$Mu;
            //echo "<p>fii=".$fii;
            //echo "<p>Msol= Mu/fii=".$Msol;
            //echo "<p>et=".$et;

            //echo "<p>".$condicion ;
            //echo "<p>".$condicion_armmin ;
            //echo "<p> deformacion armadura extrema a tracción mayor a 0.004, de acuerdo Cap.10.3.4 ACI 318/2005...ok";

            /*$variables = array
            (
                array("Asmin",$Asm),
                array("As[1]",$As[1]),
                array("c",$c),
                array("Mmax= Momento nominal máximo nominal reducido",$Mmax),
                array("Mu", $Mu),
                array("fii", $fii),
                array("Msol", $Msol),
                array("condicion", $condicion),
                array("condicion_armmin", $condicion_armmin),
                array("resultado", "deformacion armadura extrema a tracción mayor a 0.004, de acuerdo Cap.10.3.4 ACI 318/2005...ok"),
            );

            $data = array(
                'status'  => "success",
                'message' => $variables
            );*/

            $data = array(
                'status'  => "success",
                'Asmin' => $Asm,
                'As[1]' => $As[1],
                'c' => $c,
                'Mmax' => $Mmax,
                'Mu' => $Mu,
                'fii' => $fii,
                'Msol' => $Msol,
                'condicion' => $condicion,
                'condicion_armmin' => $condicion_armmin,
                'resultado' => "deformacion armadura extrema a tracción mayor a 0.004, de acuerdo Cap.10.3.4 ACI 318/2005...ok"
            );

        } // else


        echo json_encode($data);

    }

    public function checkCorteVigaT() {

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
        {
            trigger_error("Raiz fc' excede 8,3 MPa", E_USER_ERROR);
        }

        //$_SESSION['ey']=$ey;

        //$diseno="sismico";
        //CALULO DE FI


        if($diseño_sismo==1)
        {
            $fii=0.6;
        }
        else {
            $fii=0.75;
        }


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
        else{
            $Avmin=$Avmin;
        }


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



        //echo "<p><h1>RESULTADOS</h1>";

        //echo "<p>b=". $b;
        //echo "<p>bw=". $bw;
        //echo "<p>h=". $h;
        //echo "<p>d=". $d;
        //echo "<p>s=". $s;
        //echo "<p>s_calculado=". $s_cal;
        //echo "<p>fi=". $fii;
        //echo "<p>Vu=". $Vu;
        //echo "<p>Vn=". $Vn;
        //echo "<p>Vc=". $Vc;
        //echo "<p>Vs=". $Vs;
        //echo "<p>Vsmax=". $Vsmax;



        //echo "<p>Avmin=". $Avmin;
        //echo "<p>Avmin_menor=". $Avmin_menor;
        //echo "<p>Av=". $Av;

        //echo "<p>". $seccion;
        //echo "<p>".$condicion_Av;
        //echo "<p>".$condicion_s;
        //echo "<p>".$condicion_Vn;


        $data = array(
            'status'  => "success",
            'b' => $b,
            'bw' => $bw,
            'h' => $h,
            'd' => $d,
            's' => $s,
            's_calculado' => $s_cal,
            'fi' => $fii,
            'Vu' => $Vu,
            'Vn' => $Vn,
            'Vc' => $Vc,
            'Vs' => $Vs,
            'Vsmax' => $Vsmax,
            'Avmin' => $Avmin,
            'Avmin_menor' => $Avmin_menor,
            'Av' => $Av,
            'seccion' => $seccion,
            'condicion_Av' => $condicion_Av,
            'condicion_s' => $condicion_s,
            'condicion_Vn' => $condicion_Vn,
        );


        echo json_encode($data);
    }

}