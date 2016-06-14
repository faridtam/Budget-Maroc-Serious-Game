<?php
class modele extends model{
    public function __construct()
    {
        parent::__construct();
    }

    public function getscore()
    {
        $score=array();
        $sql="SELECT MAX(score) as 'MAX' FROM `score`s, reponse r, joueur j WHERE j.id_joueur=r.id_joueur AND r.id_score=s.id_score";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		$max=$sth->fetch();
        return $max;
    }

    public function getquestion()
    {
        $i=0;
        $id_question = array();
        $libelle = array();
        $sql="select * from question";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		$question=$sth->fetchAll();
        return $question;
    }
    function IMPOT ()
    {
        $df="SELECT montant FROM `scenario` ";
		$sth = $this->db->prepare($df);
		$sth->execute();
		$montant=$sth->fetchAll();
		$montant=array_column($montant, 'montant');
        $rand_keys1=array_rand($montant,1);
        $montant1=$montant[$rand_keys1] ;
		
        $df1="SELECT impot FROM `scenario` where montant=$montant1";
		$sth = $this->db->prepare($df1);
		$sth->execute();
		$impot=$sth->fetch();
		
		$impot=array_column($impot, 'impot');
		foreach ($impot as $lib){
			$impot= $lib;
		}
        
        if($impot==null){
            /* De 30.001 à 50.000 Dhs  */
            if($montant1 > 2500 and $montant1<=4167)
                $impot= ($montant1*10/100) - (3000 / 12);

            /* De 50.001 à 60.000 Dhs */
            if($montant1 > 4167 and $montant1<=5000)
                $impot= ($montant1*20/100) - (8000 / 12);

            /* De 60.001 à 80.000 Dhs */
            if($montant1 > 5000 and $montant1<=6667)
                $impot= ($montant1*30/100) - (14000 / 12);

            /* De 80.001 à 180.000 Dhs */
            if($montant1 > 6667 and $montant1<=15000)
                $impot= ($montant1*34/100) - (17200 / 12);

            /* Surplus de 180.000 Dhs */
            if($montant1 > 15000)
                $impot= ($montant1*8/100) - (24400 / 12);

			$sql = "UPDATE scenario SET impot =$impot where montant=$montant1";
			$req = $this->db->prepare($sql);     
			$req->execute();
        }
		$impot=round($impot,2);
		$_SESSION['impot']=$impot;		
        return  array('impot'=>$impot, 'montant'=>$montant1);
    }

    function Score ($Sante ,$Education , $Environnement ,$Defense ,$Finance ,$Autre,
                    $estimation_sante ,$estimation_education , $estimation_environnement ,$estimation_defense ,$estimation_finance ,$estimation_autre) {
		$impot=$_SESSION['impot'];
        $sante= $Sante*100/$impot;
        $education= $Education*100/$impot;
        $environnement= $Environnement*100/$impot;
        $finance= $Finance*100/$impot;
        $defense= $Defense*100/$impot;
        $autre= $Autre*100/$impot;

        $score=0;

		$df1="SELECT `bud_sante`, `bud_education`, `bud_environnement`, `bud_finance`, `bud_defense`, `bud_autre` FROM `budget` where annee=2016";
		$sth = $this->db->prepare($df1);
		$sth->execute();
		$res=$sth->fetchAll();
		$bud_sante=array_column($res, 'bud_sante');
		$bud_education=array_column($res, 'bud_education');
		$bud_environnement=array_column($res, 'bud_environnement');
		$bud_finance=array_column($res, 'bud_finance');
		$bud_defense=array_column($res, 'bud_defense');
		$bud_autre=array_column($res, 'bud_autre');
		$i=0;
		$bud=array();
		foreach ($bud_sante as $sa){
			$bud['sante']= $sa;
		}
		foreach ($bud_education as $ed){
			$bud['education']= $ed;
		}
		foreach ($bud_environnement as $en){
			$bud['environnement']= $en;
		}
		foreach ($bud_finance as $fi){
			$bud['finance']= $fi;
		}
		foreach ($bud_defense as $de){
			$bud['defense']= $de;
		}
		foreach ($bud_autre as $au){
			$bud['autre']= $au;
		}
        $var= $bud['sante']-$sante;
        $var1= $bud['education']-$education;
        $var2= $bud['environnement']-$environnement;
        $var3= $bud['finance']-$finance;
        $var4= $bud['defense']-$defense;
        $var5= $bud['autre']-$autre;
		
		$var0= ($sante-$bud['sante'])*100/$bud['sante'];
		
        $var10= ($education-$bud['education'])*100/$bud['education'];
		
        $var20= ($environnement-$bud['environnement'])*100/$bud['environnement'];
		
        $var30= ($finance-$bud['finance'])*100/$bud['finance'];
		
        $var40= ($defense-$bud['defense'])*100/$bud['defense'];
		
        $var50= ($autre-$bud['autre'])*100/$bud['autre'];

        $_SESSION['sante']=$var0;
        $_SESSION['education']=$var10;
        $_SESSION['environement']=$var20;
        $_SESSION['finance']=$var30;
        $_SESSION['defense']=$var40;
        $_SESSION['autre']=$var50;

        // $resultat= $var0 + $var10 + $var20 + $var30 + $var40 + $var50;
		
        $score= $var + $var1 + $var2 + $var3 + $var4 + $var5;
		$score= 100-$score;
        $score=$score/10;
		
		$req='insert into score(date_score, score) values("'.date("Y-m-d").'",'.$score.')';
		$sth = $this->db->prepare($req);
		$sth->execute();
		
		$sql="SELECT MAX(id_score) as 'max' FROM `score`";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		$max=$sth->fetchAll();
		$max=array_column($max, 'max');
		foreach ($max as $m) {
			$max= $m;
		}
		
		// id_joueur a rendre dynamique
		
		$req="insert into reponse(id_joueur,rep_sante,rep_education,rep_environnement,rep_finance,rep_defense,rep_autre,id_question,annee,id_score) values
		(1,'$sante','$education','$environnement','$finance','$defense','$autre',1,2016,'$max')";
		$sth = $this->db->prepare($req);
		$sth->execute() or die(print_r($sth->errorInfo(), true));

        $sante1= $estimation_sante*100/$impot;
        $education1= $estimation_education*100/$impot;
        $environnement1= $estimation_environnement*100/$impot;
        $finance1= $estimation_finance*100/$impot;
        $defense1= $estimation_defense*100/$impot;
        $autre1= $estimation_autre*100/$impot;

        $req='insert into reponse(id_joueur,rep_sante,rep_education,rep_environnement,rep_finance,rep_defense,rep_autre,id_question,annee,id_score) values
		(1,'.$sante1.','.$education1.','.$environnement1.','.$finance1.','.$defense1.','.$autre1.',2,2016,'.$max.')';
		$sth = $this->db->prepare($req);
		$sth->execute() or die(print_r($sth->errorInfo(), true));
	}

	function connexion () {
		session_destroy(); 
    }
	
    function deconnection () {
		session_destroy(); 
    }
}