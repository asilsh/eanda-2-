<?php

class admin
{
    public $id_a;
    public $name_a;
	public $email_a;
	public $password_a;


  	public function __construct()
  	{
     
	}
		
  	//Getter & Setter
  	public function getId_a()
	{
		return $this->id_a;
	}
	public function setId_a($id_a)
	{
		$this->id_a = $id_a;
  	}

    public function getName_a()
    {
        return $this->name_a;
    }
    public function setName_a($name_a)
    {
        $this->name_a=$name_a;
    }
	
	public function getEmail_a()
	{
		return $this->email_a;
	}
	public function setEmail_a($email_a)
	{
		$this->email_a = $email_a;

    }
    public function getPassword_a()
	{
		return $this->Password_a;
	}
	public function setPassword_a($password_a)
	{
		$this->password_a = $password_a;

    }
}