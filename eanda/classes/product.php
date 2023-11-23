<?php

class product
{
    public $id_p;
    public $name_p;
    public $body;
    public $price;
    public $image;
    public $inventory;
    public $id_cat;

  	public function __construct()
  	{
     
	}
		
  	//Getter & Setter
  	public function getId_p()
	{
		return $this->id_p;
	}
	public function setId_p($id_p)
	{
		$this->id_p = $id_p;
  	}

  	public function getName_p()
	{
		return $this->name_p;
	}
	public function setName_p($name_p)
	{
		$this->name_p = $name_p;
  	}

  	public function getBody()
	{
		return $this->body;
	}
	public function setBody($body)
	{
		$this->body = $body;
  	}

  	public function getPrice()
	{
		return $this->price;
	}
	public function setPrice($price)
	{
		$this->price = $price;
  	}

  	public function getInventory()
	{
		return $this->inventory;
	}
	public function setInventory($inventory)
	{
		$this->inventory = $inventory;
  	}

  	public function getId_cat()
	{
		return $this->id_cat;
	}
	public function setId_cat($id_cat)
	{
		$this->id_cat = $id_cat;
  	}
}