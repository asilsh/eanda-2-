<?php

class cart
{
    public $id_car;
    public $id_cus;
    public $id_p;

  	public function __construct()
  	{
     
	}
		
  	//Getter & Setter
  	public function getId_cat()
	{
		return $this->id_cat;
	}
	public function setId_cat($id_cat)
	{
		$this->id_cat = $id_cat;
  	}

  	public function getId_cus()
	{
		return $this->id_cus;
	}
	public function setId_cus($id_cus)
	{
		$this->id_cat = $id_cus;
  	}
    
  	public function getId_p()
	{
		return $this->id_p;
	}
	public function setId_p($id_p)
	{
		$this->id_p = $id_p;
  	}
}