<?php

// ---
// Nom : user.php
// Par : Nicolas Montfort
// Le : 13 decembre 2012
// Description : Classe utilisateur
// ---

class User
{
	// User database fields
	private $id;
	private $name;
	private $firstname;
	private $email;
	private $isAdmin;
	private $password;
	private $dtc;
	
	// Computed fields
	private $isLogged;
	private $fullname;

	// Prepared sql requests
	private $selectAllUser;
	private $selectUserById;
	private $selectUserByEmail;
	private $updateUser;
	private $insertUser;
	
	public function User($db)
	{		
		$this->selectAllUser = $db->prepare(
		"SELECT * FROM user ORDER BY name, firstname ASC");
		
		$this->selectUserById = $db->prepare(
		'SELECT * FROM User WHERE id_user = :id_user');
		
		$this->selectUserByEmail = $db->prepare(
		'SELECT * FROM User WHERE mail = :mail');
				
		$this->updateUser = $db->prepare(
		'UPDATE User SET nom=:name, prenom=:firstName, password=:password, mail=:email WHERE id_user=:id_user');
		
		$this->updateUserWithoutPassword = $db->prepare(
		'UPDATE User SET nom=:name, prenom=:firstName, mail=:email WHERE id_user=:id_user');
		
		$this->insertUser = $db->prepare(
		'INSERT INTO User (nom, prenom, mail, password, isAdmin) VALUES (:name, :firstName, :email, :password, :isAdmin)');
		
		$this->load();
	}
	
	private function load()
	{
		$this->isLogged = isset($_SESSION['id_user']) && ! is_null($_SESSION['id_user']);
		
		if($this->isLogged)
		{
			$result = $this->getUserById($_SESSION['id_user']);
			
			// id_user | nom  | prenom | mail | salt | password | isAdmin | dtc |
			$this->id = $result->id_user;
			$this->name = $result->nom;
			$this->firstname = $result->prenom;
			$this->email = $result->mail;
			$this->isAdmin = $result->isAdmin;
			$this->password = $result->password;
			$this->dtc = $result->dtc;
			$this->fullname = $this->firstname . " " . $this->name;			
		}
		else
		{
			$this->id = NULL;
			$this->name = "";
			$this->firstname = "";
			$this->email = "";
			$this->isAdmin = false;
			$this->password = "";
			$this->dtc = "";
			$this->fullname = "";
		}
	}
	
	public function update($lastName, $firstName, $password, $email)
	{
		// Update this object
		empty($lastName) 	? : $this->name = $lastName;
		empty($firstName) 	? : $this->firstname = $firstName;
		empty($password)	? : $this->password = Pbkdf2::create_hash($password);
		empty($email)		? : $this->email = $email;
		
		$this->updateUser->execute(array( 	'name' => $this->name, 
											'firstName' => $this->firstname, 
											'password' => $this->password, 
											'email' => $this->email, 
											'id_user' => $this->id ));
											
		return true;
	}
	
	public function updateWithoutPassword($lastName, $firstName, $email)
	{
		// Update this object
		empty($lastName) 	? : $this->name = $lastName;
		empty($firstName) 	? : $this->firstname = $firstName;
		empty($email)		? : $this->email = $email;
		
		$this->updateUserWithoutPassword->execute(array( 	'name' => $this->name, 
											'firstName' => $this->firstname, 
											'email' => $this->email, 
											'id_user' => $this->id ));
											
		return true;
	}
	
	public function insert($lastName, $firstname, $password, $email)
	{
		$this->insertUser->execute(array( 	'name' => $lastName, 
											'firstName' => $firstname, 
											'password' => Pbkdf2::create_hash($password), 
											'email' => $email,
											'isAdmin' => 'User'));
									
		return $this->logIn($email,$password);
	}

	public function __get($attribute)
	{
		return property_exists($this,$attribute) ? $this->$attribute : die();
	}
	
	public function logOut()
	{
		if(isset($_SESSION['id_user']))
		{
			$_SESSION['id_user'] = NULL;
			unset($_SESSION['id_user']);
		}
		//session_unset(); // We use other Session key also (the timer for example)
		//session_destroy();
		$this->load();
	}
	
	public function logIn($email, $password)
	{
		try 
		{
			$this->selectUserByEmail->execute(array('mail' => $email));
			$user = $this->selectUserByEmail->fetch(PDO::FETCH_OBJ);
		}
		catch (PDOException $e) 
		{
			return false;
		}

		if($user && !empty($user->id_user) && Pbkdf2::validate_password($password, $user->password))
		{
			$_SESSION['id_user'] = $user->id_user;
			$this->load();
		}
		else
		{
			return false;
		}
		
		return true;
	}
	
	public function isEmailUsed($email)
	{
		//$email = trim(strtolower($email));

		// Query DB		
		$this->selectUserByEmail->execute(array('mail' => $email));
		//	$result = $this->selectUserByEmail->rowCount();
		
		$result = $this->selectUserByEmail->fetchAll();

		// And count
		return count($result) > 0;
	}
	
	// TODO: Add try catch 
	public function getAllUser()
	{
		$this->selectAllUser->execute();
		return $this->selectAllUser->fetchAll();
	}
	
	// TODO: Add try catch 
	public function getUserById($id)
	{
		$this->selectUserById->execute(array('id_user' => $id));
		return $this->selectUserById->fetch(PDO::FETCH_OBJ);
	}
}

