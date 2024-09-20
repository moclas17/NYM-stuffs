<?php 
include('nym_conexion.php');
/*
934 - Erik Valle
1398 - Erik (India)
*/ 
$ids = array( 934, 1398);//arreglo de ids de nodos a consultar
foreach($ids as $id){
	$active = is_active($id); //funcion que verifica si el nodo esta activo en el set
	$rewards = get_rewards($id); //obtiene las recompensas (viene de nodes guru)
	$epoch = epoch(); //obtiene el epoch  (viene de nodes guru)
	$interval = interval(); //obtiene el interval  (viene de nodes guru)
	$rewards['total_node_reward']=number_format($rewards['total_node_reward']/1000000,2);
	$rewards['operator']=number_format($rewards['operator']/1000000,2);
	$rewards['delegates']=number_format($rewards['delegates']/1000000,2);
	$rewards['operating_cost']=number_format($rewards['operating_cost']/1000000,2);
	$Conexion->query("INSERT INTO nym_active (mixnode, active, epoch_id, epoch_start, epoch_end, epoch_total, interval_start, interval_end, total_node_reward, operator, delegates, operating_cost) VALUES (".$id.", '".$active."', '".$epoch['id']."', '".$epoch['start']."', '".$epoch['end']."', '".$epoch['total']."', '".$interval['start']."', '".$interval['end']."', '".$rewards['total_node_reward']."', '".$rewards['operator']."', '".$rewards['delegates']."', '".$rewards['operating_cost']."');");
}




function is_active($id){
	$ip="https://explorer.nymtech.net/api/v1/mix-node/".$id;
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $ip,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$data = json_decode($response,true);
	return ($data['status']=='active'?1:0);
}
function get_rewards($id){
	$ip="https://mixnet.api.explorers.guru/api/mixnodes/".$id."/estimated_reward";
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $ip,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response,true);
}
function epoch(){
	
	$ip="https://mixnet.api.explorers.guru/api/contract/epoch";
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $ip,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response,true);
}
function interval(){
	
	$ip="https://mixnet.api.explorers.guru/api/contract/interval";
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $ip,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response,true);
}