<?php

class order
{
    public $id_o;
    public $id_p;
    public $quantity;
    public $status;
    public $date;
    public $start;
    public $end;

  	public function __construct()
  	{
     
	}
		
  	//Getter & Setter
  	public function getId_o()
	{
		return $this->id_o;
	}
	public function setId_o($id_o)
	{
		$this->id_o = $id_o;
  	}

  	public function getId_p()
	{
		return $this->id_p;
	}
	public function setId_p($id_p)
	{
		$this->id_p = $id_p;
  	}

  	public function getQuantity()
	{
		return $this->quantity;
	}
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
  	}
      public $date;

  	public function getStatus()
	{
		return $this->status;
	}
	public function setStatus($status)
	{
		$this->status = $status;
  	}

  	public function getDate()
	{
		return $this->date;
	}
	public function setDate($date)
	{
		$this->date = $date;
  	}

	public function getStart()
	{
		return $this->start;
	}
	public function setStart($start)
	{
		$this->start = $start;
    }

    public function getEnd()
	{
		return $this->end;
	}
	public function setEnd($end)
	{
		$this->end = $end;
    }
}