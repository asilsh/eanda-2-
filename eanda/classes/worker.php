<?php

class worker
{
    public $id_w;
    public $name_w;
	public $email_w;
	public $password_w;
    public $id_o;


  	public function __construct()
  	{
     
	}
		
  	//Getter & Setter
  	public function getId_w()
	{
		return $this->id_w;
	}
	public function setId_w($id_w)
	{
		$this->id_w = $id_w;
  	}

    public function getName_w()
    {
        return $this->name_w;
    }
    public function setName_w($name_w)
    {
        $this->name_w=$name_w;
    }
	
	public function getEmail_w()
	{
		return $this->email_w;
	}
	public function setEmail_w($email_w)
	{
		$this->email_w = $email_w;
    }

    public function getPassword_w()
	{
		return $this->password_w;
	}
	public function setPassword_w($password_w)
	{
		$this->password_w = $password_w;
    }

    public function getId_o()
	{
		return $this->id_o;
	}
	public function setId_o($id_o)
	{
		$this->id_o = $id_o;
    }
}