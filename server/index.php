<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
include_once './koneksi.php';

$table = '';
$fungsi = '';

$date = date('Y-m-d H:i:s');
$tgl  = date('Y-m-d');
$jam  = date('H:i:s');

//var_dump(selectdb($conn, 'register')); SELECT
//var_dump(insertNormal($conn, $table, $data)); INSERT
//var_dump(updateNormal($conn, $table, $dataU, ' NIM=1234567')); UPDATE
//var_dump(deleteWhere($conn, $table, ' NIM=1234567'));

if (!empty($_POST['fungsi'])) {$fungsi = $_POST['fungsi'];}
if (!empty($_POST['table'])) {$table = $_POST['table'];}

if ($fungsi == 'select') {
	$data = selectdb($conn, $table);
	if ($data) {
		$response = $data;
	}
	else{
		$response = false;
	}
}
if ($fungsi == 'insert') {
	if ($table == 'register') {
		$data = array(
			'NIM' 			=> $_POST['nim'],
			'nama' 			=> $_POST['nama'],
			'mata_kuliah' 	=> 'mobile',
			'email' 		=> $_POST['email'],
			'waktu' 		=> $date);
	}
	if ($table == 'lapor') {
		$data = array(
			'NIM' 		=> $_POST['nim'],
			'nama' 		=> $_POST['nama'],
			'progdi' 	=> $_POST['progdi'],
			'kelas' 	=> $_POST['kelas'],
			'tgl'		=> $tgl,
			'jam'		=> $jam,
			'URL'		=> $_POST['url'],
			'kumpul'	=> $date);
	}

	$data = insertNormal($conn, $table, $data);
	if ($data) {
		$response = true;
	}
	else{
		$response = false;
	}
}

echo json_encode($response);











/////////////////////////////////
/////// CRUD DB
/////////////////////////////////
function selectdb($conn, $table){
	$query = 'select * from '.$table;
	$execute = $conn->query($query);
	$data = $execute->fetch_all(MYSQLI_ASSOC);
	if ($execute) {
		return $data;
	}
}
function insertNormal($conn, $table, $data = array()){
	$generate = generateValue($data, 'insert');
	$query = "insert into ".$table."(".$generate['field'].") values(".$generate['value'].")";
	$execute = mysqli_query($conn, $query);
	if ($execute) {
		return true;
	}
	else{
		return false;
	}
}
function updateNormal($conn, $table, $data = array(), $kondisi){
	$generate = generateValue($data, 'update');
	$query = 'UPDATE '.$table.' SET '.$generate['update'].' where '.$kondisi;
	$execute = mysqli_query($conn, $query);
	if ($execute) {
		return true;
	}
	else{
		return false;
	}
}
function  deleteWhere($conn, $table, $kondisi){
	$query = 'delete from '.$table.' where '.$kondisi;
	$execute = mysqli_query($conn, $query);
	if ($execute) {
		return true;
	}
	else{
		return false;
	}
}



/////////////////////////////////
/////// ALAT DB
/////////////////////////////////
function generateValue($data = array(), $key){
	$keys = array_keys($data);
	$vals = array_values($data);
	$generate['field']  = '';
	$generate['value']  = '';
	$generate['update'] = '';

	for ($i=0; $i < count($data); $i++) { 
		if ($key == 'update') {
			if (empty($generate['update'])) {
				$generate['update'] = $keys[$i].'='."'".$vals[$i]."'";
			}
			else{
				$generate['update'] = $generate['update'].', '.$keys[$i].'='."'".$vals[$i]."'";
			}
		}
		if ($key == 'insert') {
			if (empty($generate['field']) && empty($generate['value'])) {
				$generate['field'] = $keys[$i];
				$generate['value'] = "'".$vals[$i]."'";
			}
			else{
				$generate['field'] = $generate['field'].",".$keys[$i];
				$generate['value'] = $generate['value'].", '".$vals[$i]."'";
			}
		}
	}
	return $generate;
}

?>