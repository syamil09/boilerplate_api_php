<?php

class DbOperation
{
    //Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

	/*
	* The create operation
	* When this method is called a new record is created in the database
	*/
	function createHero($nama, $email, $nohp, $komentar){
		$stmt = $this->con->prepare("INSERT INTO tabel_syamil (nama, email, nohp, komentar) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $nama, $email, $nohp, $komentar);
		if($stmt->execute())
			return true;
		return false;
	}

	/*
	* The read operation
	* When this method is called it is returning all the existing record of the database
	*/
	function getHeroes(){
		$stmt = $this->con->prepare("SELECT id, nama, email, nohp, komentar FROM tabel_syamil");
		$stmt->execute();
		$stmt->bind_result($id, $nama, $email, $nohp, $komentar);

		$heroes = array();

		while($stmt->fetch()){
			$hero  = array();
			$hero['id'] = $id;
			$hero['nama'] = $nama;
			$hero['email'] = $email;
			$hero['nohp'] = $nohp;
			$hero['komentar'] = $komentar;

			array_push($heroes, $hero);
		}

		return $heroes;
	}

	/*
	* The update operation
	* When this method is called the record with the given id is updated with the new given values
	*/
	function updateHero($id, $nama, $email, $nohp, $komentar){
		$stmt = $this->con->prepare("UPDATE tabel_syamil SET nama = ?, email = ?, nohp = ?, komentar = ? WHERE id = ?");
		$stmt->bind_param("ssssi", $nama, $email, $nohp, $komentar, $id);
		if($stmt->execute())
			return true;
		return false;
	}


	/*
	* The delete operation
	* When this method is called record is deleted for the given id
	*/
	function deleteHero($id){
		$stmt = $this->con->prepare("DELETE FROM tabel_syamil WHERE id = ? ");
		$stmt->bind_param("i", $id);
		if($stmt->execute())
			return true;

		return false;
	}
}
