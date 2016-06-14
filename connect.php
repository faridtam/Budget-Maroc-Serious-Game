
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Inscription</title>      
  <link href="<?php echo RACINE.'web/css/bootstrap.min.css';?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo RACINE.'web/css/freelancer.css';?>" rel="stylesheet">
    <link href="<?php echo RACINE.'web/css/style.css';?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo RACINE.'web/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="<?php echo RACINE.'web/js/test.js';?>"></script>
  </head>

  <body style="   background-color: #18bc9c;"  >

    <div class="wrapper">
	<div class="container">
		<h2 align="center">Merci de compléter votre inscription </h2><br><br><br>
		<form  class= form name="FormAcces" action="CONNECTION.php" method="post" >
  
  
    <table align="center" >
      <tr  align="center"> 
       
        <td  > 
		
         <select class="selectpicker" style="width: 310px;height: 30px;margin-bottom:5px" >
  <option>Groupe d’âge</option>
  <option>18-24</option>
  <option>25-34</option>
    <option>25-34</option>
    <option>35-44</option>
    <option>45-54</option>
    <option> 55-64</option>
     <option> +65      </option>
</select>

        </td>
      </tr>
	  
      <tr> 
        <td > 
         <select class="selectpicker" style="width: 310px;height: 30px;margin-bottom:5px" >
  <option>Genre</option>
  <option>Féminin</option>
  <option>Masculin</option>
    
</select>
        </td>
      </tr>
      <tr> 
     
 
      <tr> 
        <td > 
         <select class="selectpicker" style="width: 310px;height: 30px;margin-bottom:5px" >
  <option>Niveau d’instruction</option>
  <option>pas de bac</option>
  <option> bac</option>
   <option>  bac+2</option>
    <option> bac+4</option>
     <option> ing</option>
      <option> master</option>
       <option>doctorat</option>
    
</select>
        </td>
      </tr>
       <tr> 
        <td > 
         <select class="selectpicker" style="width: 310px;height: 30px;margin-bottom:5px" >
  <option>Statut professionnel</option>
  <option> Employé</option>
  <option> Etudiant</option>
   <option>  Profession</option>
   
</select>
        </td>
      </tr>
       <tr> 
        <td > 
     <input style="width: 310px;height: 30px;margin-bottom:5px" type="text" value="adresse">
        </td>
      </tr>
      <tr> 
        <td > 
         <select class="selectpicker" style="width: 310px;height: 30px;margin-bottom:5px" >
  <option>Appartenance politique </option>
  <option> Oui</option>
  <option> Non</option>
                                
</select>
        </td>
      </tr>
      
      
      <tr> 
        <td colspan="2"> 
          <div align="center">
		  
			<input type="submit"  id="login-button" name="Envoyer">
  
          </div>
        </td>
      </tr>
    </table>
  </form>
		
			
</div>
	
	
</div>
    

    
    
  </body>
 
</html>