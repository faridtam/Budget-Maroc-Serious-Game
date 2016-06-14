<?php

class index extends controller{

    public function jouer(){
		$ques=array();
		$i=0;
		$j=0;
        $this->loadModel('modele');
        $max=$this->modele->getscore();
        $this->charger($max);
        $question=$this->modele->getquestion();
		$id_question=array_column($question, 'id_question');
		$libelle=array_column($question, 'libelle');
		foreach ($libelle as $lib){
			$ques['libelle'.$i]= $lib;
            $i++;
		}foreach ($id_question as $id) {
			$ques['id'.$j]= $id;
			$j++;
		}
		$this->charger($ques);
        $impot=$this->modele->IMPOT();
        $this->charger($impot);
        $this->render('jouer');
    }

    public function enregistrer(){
		$ques=array();
		$i=0;
		$j=0;
        $this->loadModel('modele');
        $max=$this->modele->Score($_POST['sante'],$_POST['education'],$_POST['environnement'],$_POST['finance'],$_POST['defense'],$_POST['autre'], $_POST['estimation_sante'],
            $_POST['estimation_education'],$_POST['estimation_environnement'],$_POST['estimation_finance'],$_POST['estimation_defense'],$_POST['estimation_autre']);

        $max=$this->modele->getscore();
        $this->charger($max);
        $question=$this->modele->getquestion();
		$id_question=array_column($question, 'id_question');
		$libelle=array_column($question, 'libelle');
		foreach ($libelle as $lib){
			$ques['libelle'.$i]= $lib;
            $i++;
		}foreach ($id_question as $id) {
			$ques['id'.$j]= $id;
			$j++;
		}
		$this->charger($ques);
        $impot=$this->modele->IMPOT();
        $this->charger($impot);
        $this->render('jouer');
    }
	
	public function deconnection(){
        $this->loadModel('modele');
        $this->modele->deconnection();
        $this->render('connexion');
    }
}