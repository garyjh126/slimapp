<?php
use \Psr\Http\Message\ServerRequestInterface as Request; 
use \Psr\Http\Message\ResponseInterface as Response; 

$app = new \Slim\App;  

//Get all customers
$app->get('/api/readinglistitems', function(Request $request, Response $response){
	$sql = "SELECT * FROM readinglistitem";

	try{
		//Get DB Object 
		$db = new db();
		//Connect 
		$db = $db->connect();

		$stmt = $db->query($sql);
		$readinglistitems =$stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($readinglistitems);
	}catch (PDOException $e){
		echo '{"error":{"text": '.$e->getMessage().'}';
	}


});

//Get single readinglistitem  	**************Must provide get for one other param***************
//Handles get request to whatever URI is in parameters 
$app->get('/api/readinglistitem/{id}', function(Request $request, Response $response, $args){
	$id = $request->getAttribute('id');
	$sql = "SELECT * FROM readinglistitem WHERE ID = $id";
	// echo "Hello, " . $args['id'];
	
	try{
		//Get DB Object 
		$db = new db();
		//Connect 
		$db = $db->connect();

		$stmt = $db->query($sql);
		$readinglistitems =$stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($readinglistitems);
	}catch (PDOException $e){
		echo '{"error":{"text": '.$e->getMessage().'}';
	}


});

//Add a readinglistitem
$app->post('/api/readinglistitem/add', function(Request $request, Response $response){
	$name = $request->getParam('name');
	$URL = $request->getParam('URL');
	$theDesc = $request->getParam('theDesc');
	

	$sql = "INSERT INTO readinglistitem(theDate, name,URL,theDesc) VALUES (NOW(), :name,:URL,:theDesc)";

	try{
		//Get DB Object 
		$db = new db();
		//Connect 
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':URL',$URL);
		$stmt->bindParam(':theDesc',$theDesc);
		

		$stmt->execute();
		echo '{"notice": {"text": "reading list item Added"}';

	}catch (PDOException $e){
		echo '{"error":{"text": '.$e->getMessage().'}';
	}


});

//Update readinglistitem
$app->post('/api/readinglistitem/update/{id}', function(Request $request, Response $response,  $args){
	//$jso = json_decode($request, true);

	$id = $request->getAttribute('id');
	$name = $request->getParam('name');
	$URL = $request->getParam('URL');
	$theDesc = $request->getParam('theDesc');
   

	$sql = "UPDATE readinglistitem SET 
				name = :name,
				URL = :URL,
				theDesc = :theDesc
			WHERE ID = $id";				

	try{
		//Get DB Object 
		$db = new db();
		//Connect 
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':URL',$URL);
		$stmt->bindParam(':theDesc',$theDesc);

		$stmt->execute();
		echo '{"notice": {"text": "reading list item Updated"}';
		
	}catch (PDOException $e){
		echo '{"error":{"text": '.$e->getMessage().'}';
	}


});


//Delete readinglistitem
$app->delete('/api/readinglistitem/delete/{id}', function(Request $request, Response $response, $args){
	$id = $args['id'];
	

	$sql = "DELETE FROM readinglistitem WHERE ID = $id";		//change		

	try{
		//Get DB Object 
		$db = new db();
		//Connect 
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db = null;
		echo '{"notice": {"text": "reading list item Deleted"}';
		
	}catch (PDOException $e){
		echo '{"error":{"text": '.$e->getMessage().'}';
	}


});