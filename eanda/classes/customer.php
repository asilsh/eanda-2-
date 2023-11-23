<?php
include 'db/login_register.php';

class customer
{
    public $id_cus;
    public $name;
    public $email;
    public $password;
    public $city;
    public $phone;
    public $id_o;

    private $db;

    public function __construct($data)
    {
        $this->db = new db();
    }

    public function getCustomerByEmail($email) {
        $query = "SELECT * FROM customer WHERE email = :email";
        $params = array(':email' => $email);
        $result = $this->db->fetch($query, $params);
        
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
    

    //Getter & Setter
    public function getId_cus()
    {
        return $this->id_cus;
    }

    public function setId_cus($id_cus)
    {
        $this->id_cus = $id_cus;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name_cus)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
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
?>