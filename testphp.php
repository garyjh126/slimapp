<?php  
 //Four functions
//f1: $id and $email paramater are empty, follow route to get all customers
//f2: $id parameter is requested and $email paramater is empty, follow route to get single customer by ID
//f3: $email parameter is requested and $id paramater is empty, follow route to get single customer by email
//f4: both $id and $email are requested, push responsibility towards f2 and f3;


$iden = "";
$em = "";

if(isset($_GET['id'])){
 	$iden = urldecode($_GET['id']);
}
if(isset($_GET['name'])){
 	$em = urldecode($_GET['name']);
}

if(($iden=="")&&($em=="")){
	f1($iden, $em);
}

if(($iden!="")&&($em=="")){
	f2($iden, $em);    
}

if(($iden=="")&&($em!="")){

	f3($iden, $em);

	
}
  
if(($iden!="")&&($em!="")){
	f4($iden, $em);

}	


function f1($id, $email){
	$url = "http://slimapp/api/readinglistitems";
	$json = file_get_contents($url); 
	$json_dec = json_decode($json, true);
	echo $json;
	echo "<br/>";
}

function f2($id, $email){
	$url = "http://slimapp/api/readinglistitem/".$id;

		try{
			$json = file_get_contents($url); 
			$json_dec = json_decode($json, true);
			$ks="";
			
			if($json!="[]"){
				$ks = $json_dec[0]['ID'];
			}

			$leng = strlen($ks);
			if(($ks==$id)&&($leng>0)){
				echo $json;
				echo "<br/>";
			}
			else{
				echo "<p style = 'color:red'>No Match for that ID.<br></p>";
				
			}
		}
		catch(Exception $e) {
	  		$e->getMessage();
		}
}

function f3($id, $email){

	$max = 25;
	for($i=0;$i<$max;$i++){ //re-arrange max
		$url = "http://slimapp/api/readinglistitem/".$i;

		
			$json = file_get_contents($url); 
			$json_dec = json_decode($json, true);
			$ks="";
			
			if($json!="[]"){
				$ks = $json_dec[0]['name']; //email from json response
				
				
				
			}
			else{
				if($i==($max-1)){
					echo "<p style = 'color:red'>No Match for that Name.<br></p>";
				}
				continue;
			}
			

			$leng = strlen($ks);
			if(($ks==$email)&&($leng>0)){
				echo $json;
				echo "<br/>";
				break;
			}
			
		
		
	}
}

function f4($id, $email){
	$idn = $id;
	$e = $email;
	f2($idn, $e);
}


?>  