<?php
class db
{
    private $host;
    private $db;
    private $charset;
    private $user;
    private $pass;
    private $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    private $pdo;

    public function __construct(string $host = "localhost", string $db = "eanda", string $charset = "utf8", string $user = "root", string $pass = "")
    {
        $this->host = $host;
        $this->db = $db;
        $this->charset = $charset;
        $this->user = $user;
        $this->pass = $pass;

        $this->connect(); // Connect to the database
    }

    public function fetch($query, $params)
    {
        $stmt = $this->pdo->prepare($query);
        if ($stmt->execute($params)) {
            // Fetch the data as an associative array
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if any rows were returned
            if ($result) {
                return $result;
            }
        }

        // Return null if there's an error or no rows were returned
        return null;
    }

    private function connect()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $this->opt);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function disconnect()
    {
        $this->pdo = null;
    }

    // Check if user exists in:
    //1. table (customer/worker/admin)
    //2. column (email)
    //3. item (user's mail)
    function check_if_exist($table, $column, $item){
        $query = "SELECT * FROM $table WHERE $column = :item";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['item' => $item]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty($result))
            return 1;
        return 0;
    }

    // Return user ID by email:
    //1. table (customer/worker/admin)
    //2. column (email)
    //3. item (user's mail)
    function customer_id($table, $column, $item) {
        $query = "SELECT id_cus FROM $table WHERE $column = :item";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['item' => $item]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!empty($result)) {
            return $result['id_cus'];
        }
        return null;
    }

    // Check if user exists to login:
    //1. table (customer/worker/admin)
    //2. column (email, password)
    //3. item (user's mail, password)
    function check_login($table, $email, $password) {
        $query = "SELECT name FROM $table WHERE email = ? AND password = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email, $password]);
        $result = $stmt->fetch();
    
        if ($result) {
            return $result['name'];
        } else {
            return null;
        }
    }

    function check_login_reset($table, $email, $phone) {
        $query = "SELECT name FROM $table WHERE email = ? AND phone = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email, $phone]);
        $result = $stmt->fetch();
    
        if ($result) {
            return $result['name'];
        } else {
            return null;
        }
    }
    
    // Check if user exits in any teable
    //1. table (customer/worker/admin)
    // If exists return 1 else 0
    function userType($table, $email) {
        $query = "SELECT COUNT(*) FROM $table WHERE email = :email";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();

        return $count > 0 ? 1 : 0;
    }  

    // Get the max id from the table and increment by 1
    //1. table (customer/worker/admin)
    //2. column (id)
    function get_max_id($table, $column)
{
    $query = "SELECT MAX($column) AS max_id FROM `$table`"; // Add backticks around the table name

    $stmt = $this->pdo->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $max_id = $row['max_id'];

    if ($max_id === null)
        return 1; // Return 1 if no records exist

    $next_id = $max_id + 1;
    return $next_id;
}


    // Insert user in:
    //1. table (customer/worker/admin)
    //2. column (array of params ex. ["name", "email", "phone"])
    //3. values (array of values ex. ["John Doe", "johndoe@example.com", "123456789"])
    public function insert_data($table, $columns, $values)
    {
        $columnNames = implode(', ', $columns);
        $placeholders = rtrim(str_repeat('?, ', count($values)), ', ');
        $values[0] = $this->get_max_id($table, $values[0]);

        $query = "INSERT INTO $table ($columnNames) VALUES ($placeholders)";

        return $this->insert($query, $values);
    }

    // Insert data into the database
    private function insert($query, $values)
    {
        $statement = $this->pdo->prepare($query);

        if ($statement->execute($values)) {
            return true;
        } else {
            return false;
        }
    }

    // Check if user exists in:
    //1. table (customer/worker/admin)
    //2. column (email)
    //3. item (user's mail)
    public function return_user_data($table, $column, $item){
        $query = "SELECT * FROM $table WHERE $column = :item";

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['item' => $item]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
        } catch (PDOException $e) {
            // Handle the exception (e.g., log, display an error message)
            // For now, let's just echo the error message
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    //Get product info by ID
    public function getProductByID($table, $column, $id_p) {
        $query = "SELECT * FROM $table WHERE $column = :id_p";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id_p' => $id_p]);
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
        } catch (PDOException $e) {
            // Handle the exception (e.g., log, display an error message)
            // For now, let's just echo the error message
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    //Get product info by ID
    public function getOrderByID($table, $column, $id_o) {
        $query = "SELECT * FROM $table WHERE $column = :id_o";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id_o' => $id_o]);
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
        } catch (PDOException $e) {
            // Handle the exception (e.g., log, display an error message)
            // For now, let's just echo the error message
            echo "Error: " . $e->getMessage();
        }
        return null;
    }    

    // Get customer info by customer's email
    //1. table (customer)
    //2. column (email)
    //3. item (user's mail)
    function getCustomerByEmail($table, $column, $item){
        $query = "SELECT * FROM $table WHERE $column = :item";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['item' => $item]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result; // Return the result directly
    }  

    // Get Products from the table
    // 1. table (Product)
    public function getProduct($table)
    {
        $query = "SELECT * FROM $table";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result; // Return all products as an array
    }

    // Get Products from the table where status = sold out
    // 1. table (Product)
    public function getProduct_soldout($table)
    {
        try {
            $query = "SELECT * FROM $table WHERE status = 'Out of Stock'";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }

    // Check if status of product is sold out or not in status_$size
    public function status_sold_out($table, $id_p, $size)
    {
        try {
            $query = "SELECT status_$size AS status FROM $table WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $result['status'] === 'Out of Stock') {
                return true; // Product status is sold out
            } else {
                return false; // Product status is not sold out
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Return false in case of an error
        }
    }

    // Update customer info by customer's email
    //1. table (customer)
    //2. column (email)
    //3. item (user's email)
    public function updateCustomer($table, $columns, $values, $email)
    {
        $updateColumns = array();
        $params = array();
    
        // Build the SET clause dynamically
        for ($i = 0; $i < count($columns); $i++) {
            $columnName = $columns[$i];
            $paramName = 'param' . $i;
            $updateColumns[] = "$columnName = :$paramName";
            $params[$paramName] = $values[$i];
        }
    
        $setClause = implode(', ', $updateColumns);
        $identifierColumn = 'email'; // Replace with the actual column name for identification
        $identifierValue = $email; // Use the provided email value
        $params['identifierValue'] = $identifierValue;

        $query = "UPDATE $table SET $setClause WHERE $identifierColumn = :identifierValue";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    
        if ($stmt->rowCount() > 0) {
            return 1; // Update successful
        } else {
            return 0; // No rows affected, update failed
        }
    }    

    // Update product info by product's id
    //1. table (product)
    //2. column (id)
    //3. item (product's id)
    public function update_product($table, $columns, $values, $id_p)
    {
        $updateColumns = array();
        $params = array();

        // Build the SET clause dynamically
        for ($i = 0; $i < count($columns); $i++) {
            $columnName = $columns[$i];
            $paramName = 'param' . $i;
            $updateColumns[] = "$columnName = :$paramName";
            $params[$paramName] = $values[$i];
        }

        $setClause = implode(', ', $updateColumns);

        $query = "UPDATE $table SET $setClause WHERE id_p = :id_p";
        $params['id_p'] = $id_p;

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            return true; // Update successful
        } else {
            return false; // No rows affected, update failed
        }
    }

    //Remove id_p from table
    public function delete_product($table, $id_p) {
        try {
            $query = "DELETE FROM $table WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }  

    // Update product
    // if it's 0 means it's out of stock
    public function update_inventory($table, $id_p)
    {
        $query = "UPDATE $table SET inventory = 0 WHERE id_p = :id_p";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_p', $id_p);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    // Get all product info by product's Type and gender
    //1. table (product)
    //2. column ()
    //3. item (product's id)
    public function getProductByTypeAndName($table, $typeColumn, $typeValue, $nameColumn, $nameValue)
    {
        $query = "SELECT * FROM $table WHERE $typeColumn = :typeValue AND $nameColumn = :nameValue";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':typeValue', $typeValue);
        $stmt->bindParam(':nameValue', $nameValue);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Check phone number
    // 1. Should be 10 numbers
    // 2. should start with 05 and third number should be (0/2/4/5)
    public function check_phone($phone, $table)
    {
        // Remove any non-digit characters from the phone number
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Check if the phone number has exactly 10 digits
        if (strlen($phone) !== 10) {
            return 0; // Phone number does not have exactly 10 digits
        }

        // Check if the phone number starts with '05'
        if (substr($phone, 0, 2) !== '05') {
            return 0; // Phone number does not start with '05'
        }

        // Check if the third digit is one of (0, 2, 4, 5)
        $thirdDigit = substr($phone, 2, 1);
        if (!in_array($thirdDigit, ['0', '2', '4', '5'])) {
            return 0; // Third digit is not one of (0, 2, 4, 5)
        }
        if(!$this->check_if_phone_exists($phone, $table)){
            return 1; // Phone number is valid
        }
        else {
                return 0;
        }
    }

    // Check phone number if exists in databse
    public function check_if_phone_exists($phone, $table)
    {
        $query = "SELECT COUNT(*) FROM $table WHERE phone = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$phone]);
    
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            return 1; // Phone number exists in the table
        } else {
            return 0; // Phone number does not exist in the table
        }
    }    
    
    // update password in reset page  in forget password
    public function update_password($table, $email, $password)
    {
        $query = "UPDATE $table SET password = ? WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$password, $email]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            return true; // Password update successful
        } else {
            return false; // Password update failed
        }
    }

    // get id of product by his name and body
    public function product_id($table, $name, $body)
    {
        $query = "SELECT id_p FROM $table WHERE name = ? AND body = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name, $body]);

        $result = $stmt->fetch();

        if ($result && isset($result['id_p'])) {
            return $result['id_p']; // Return the product ID
        } else {
            return false; // Product not found
        }
    }
    
    // get price of product by his name and body
    public function product_price($table, $id_p)
    {
        $query = "SELECT price FROM $table WHERE id_p = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_p]);
    
        $result = $stmt->fetch();
    
        if ($result && isset($result['price'])) {
            return $result['price']; // Return the product price
        } else {
            return false; // Product not found or price is not set
        }
    }  

    // Get id from customer email
    public function customer_id_by_email($table, $email)
    {
        $query = "SELECT id_cus FROM $table WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);

        $result = $stmt->fetch();

        if ($result && isset($result['id_cus'])) {
            return $result['id_cus']; // Return the customer ID
        } else {
            return false; // Customer not found
        }
    }

    // save product in cart for customer
    public function save_product($id_cus, $id_p, $quantity, $price, $size) {
        $id_cart = $this->get_max_id_cart('cart', 'id_cart');
        if ($this->insert_product('cart', $id_cart, $id_cus, $id_p, $quantity, $price, $size)) {
            return 1; // The product has been added
        } else {
            return 0;
        }
    }

    // Save product in wishlist for customer
    public function wishlist_product($email, $id_p)
    {
        // Retrieve the current wishlist for the customer
        $query = "SELECT wishlist FROM customer WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentWishlist = $row['wishlist'];

        // Check if the item already exists in the wishlist
        if (!empty($currentWishlist)) {
            $wishlistItems = explode(',', $currentWishlist);
            if (in_array($id_p, $wishlistItems)) {
                return false; // Item already exists in the wishlist, return false
            }
        }

        // Append the new product ID to the existing wishlist
        if (!empty($currentWishlist)) {
            $newWishlist = $currentWishlist . ',' . $id_p;
        } else {
            $newWishlist = $id_p;
        }

        // Update the wishlist for the customer
        $query = "UPDATE customer SET wishlist = :wishlist WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':wishlist', $newWishlist);
        $stmt->bindValue(':email', $email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Insert product to cart
    public function insert_product($table, $id_cart, $id_cus, $id_p, $amount, $price, $size)
    {
        $query = "INSERT INTO $table (id_cart, id_cus, id_p, amount, price, size) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_cart, $id_cus, $id_p, $amount, $price, $size]);
    
        if ($stmt->rowCount() > 0) {
            return true; // Insertion successful
        } else {
            return false; // Insertion failed
        }
    }   

    // check if customer choose this product, return the amount
    public function check_customer_add_product($table, $id_cus, $id_p)
    {
        $query = "SELECT amount FROM $table WHERE id_cus = ? AND id_p = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_cus, $id_p]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['amount'])) {
            return $result['amount']; // Return the amount
        } else {
            return 0; // Customer has not added this product
        }
    }


    // Increment amount product in cart
    function increment_product_amount($table, $column, $id_cus, $id_p)
    {
        $query = "SELECT $column AS current_amount FROM $table WHERE $id_cus = ? AND $id_p = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_cus, $id_p]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_amount = $row['current_amount'];

        if ($current_amount === null) {
            return 1; // Return 1 if no records exist
        }

        $next_amount = $current_amount + 1;

        $updateQuery = "UPDATE $table SET $column = ? WHERE $id_cus = ? AND $id_p = ?";
        $updateStmt = $this->pdo->prepare($updateQuery);
        $updateStmt->execute([$next_amount, $id_cus, $id_p]);

        return $next_amount;
    }


    // Get max id from cart
    public function get_max_id_cart($table, $column)
    {
        $query = "SELECT MAX($column) AS max_id FROM $table";

        $stmt = $this->pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_id = $row['max_id'];

        if ($max_id === null)
            return 1; // Return 1 if no records exist

        $next_id = $max_id + 1;
        return $next_id;
    }

    // Get all information from cart table by email
    public function customer_cart($table, $email)
    {
        $id_cus = $this->customer_id_by_email('customer', $email);
        $query = "SELECT * FROM $table WHERE id_cus = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_cus]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // Update order id in customer after buying, return the id_o
    public function update_order($table, $email, $id_o)
    {
        // Retrieve the current id_o for the customer
        $query = "SELECT id_o FROM $table WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentID_o = $row['id_o'];

        // Check if the order ID already exists in the list
        if (!empty($currentID_o)) {
            $id_o_Items = explode(',', $currentID_o);
            if (in_array($id_o, $id_o_Items)) {
                return; // Order ID already exists in the list, no need to update
            }
            $newID_o = $currentID_o . ',' . $id_o;
        } else {
            $newID_o = $id_o;
        }

        // Update the order IDs for the customer
        $query = "UPDATE $table SET id_o = :id_o WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_o', $newID_o);
        $stmt->bindValue(':email', $email);

        $stmt->execute();
    }


    //Get data from table where id=id
    public function get_data($table, $id, $data){
        $query = "SELECT $data FROM $table WHERE id_cus = :id_cus";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_cus', $id);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($results) {
            return $results;
        } else {
            return array(); // Return an empty array if no results found
        }
    }

    //save order in database
    public function insert_order($table, $columns, $values)
    {
        $columnNames = implode(', ', $columns);
        $placeholders = rtrim(str_repeat('?, ', count($values)), ', ');
    
        $query = "INSERT INTO `$table` ($columnNames) VALUES ($placeholders)";
    
        $statement = $this->pdo->prepare($query);
    
        foreach ($values as $i => $value) {
            // If the value is a serialized array, bind it as a string
            if (is_array($value)) {
                $serializedValue = serialize($value);
                $statement->bindValue($i + 1, $serializedValue, PDO::PARAM_STR);
            } else {
                $statement->bindValue($i + 1, $value);
            }
        }
    
        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }       

    public function get_order_by_id($table, $id_o)
    {
        $query = "SELECT * FROM `$table` WHERE id_o = :id_o";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_o', $id_o, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //delete value from cart table
    public function delete_cart($table)
    {
        $query = "DELETE FROM $table";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    // Get all orders from order table where id_w matches the given value or id_w is 0
    public function all_orders($table, $id_w)
    {
        try {
            $query = "SELECT * FROM `$table` WHERE id_w = :id_w OR id_w = 0";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_w', $id_w, PDO::PARAM_INT);
            $stmt->execute();

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $orders;
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    //update time where column = time where is id_o
    public function update_time($table, $column, $datetime, $id)
    {
        $query = "UPDATE `$table` SET `$column` = :datetime WHERE `id_o` = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':datetime', $datetime);
        $stmt->bindValue(':id', $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get id by email
    function getWorkerIDByEmail($table, $column, $item)
    {
        $query = "SELECT id_w FROM $table WHERE $column = :item";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['item' => $item]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a result exists and return the id_w value
        if ($result && isset($result['id_w'])) {
            return $result['id_w'];
        }

        return null; // Return null if no result or id_w is found
    }

    //Update id_o for worker 
    public function update_worker_id_o($table, $id_o, $email)
    {
        // Retrieve the current order numbers for the worker
        $query = "SELECT `id_o` FROM `$table` WHERE `email` = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentOrderNumbers = $row['id_o'];
        
        // Append the new order number to the existing order numbers
        if (!empty($currentOrderNumbers)) {
            $newOrderNumbers = $currentOrderNumbers . ',' . $id_o;
        } else {
            $newOrderNumbers = $id_o;
        }
    
        // Update the order numbers for the worker
        $query = "UPDATE `$table` SET `id_o` = :id_o WHERE `email` = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_o', $newOrderNumbers);
        $stmt->bindValue(':email', $email);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }    

    //Get all orders from order table only with status shipped and where id_w = id_W and id_w = 0 
    public function all_orders_shipped($table)
    {
        $query = "SELECT * FROM `$table` WHERE status = 'Shipped'"; // Modify the query to filter by status
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }
    

    //Get all orders from order table
    public function all_workers($table)
    {
        $query = "SELECT * FROM `$table`"; // Escaping the table name
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }

    //return all wishlist array from customer table
    public function customer_wishlist($table, $email)
    {
        $query = "SELECT wishlist FROM $table WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $wishlist = $row['wishlist'];
        
        // Convert the comma-separated string to an associative array
        $wishlistArray = [];
        $wishlistItems = explode(',', $wishlist);
        foreach ($wishlistItems as $item) {
            $wishlistArray[] = ['id_p' => $item];
        }
        
        return $wishlistArray;
    }      

    //Delete product from wishlist
    public function wishlist_product_delete($id_cus, $id_p)
    {
        // Retrieve the current wishlist for the customer
        $query = "SELECT wishlist FROM customer WHERE id_cus = :id_cus";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_cus', $id_cus);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentWishlist = $row['wishlist'];

        // Remove the product ID from the wishlist
        $wishlistArray = explode(',', $currentWishlist);
        $updatedWishlistArray = array_diff($wishlistArray, [$id_p]);
        $updatedWishlist = implode(',', $updatedWishlistArray);

        // Update the wishlist for the customer
        $query = "UPDATE customer SET wishlist = :wishlist WHERE id_cus = :id_cus";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':wishlist', $updatedWishlist);
        $stmt->bindValue(':id_cus', $id_cus);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Delete product from cart
    public function cart_product_delete($id_cus, $id_p)
    {
        $query = "DELETE FROM cart WHERE id_cus = :id_cus AND id_p = :id_p";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_cus', $id_cus);
        $stmt->bindValue(':id_p', $id_p);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }  
    
    // Change status of product to sold out
    public function sold_out($id_p)
    {
        $query = "UPDATE product SET status = 'sold out' WHERE id_p = :id_p";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_p', $id_p);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Change status of order to "Has been reviewed"
    public function review_done($id_o)
    {
        try {
            $query = "UPDATE `order` SET `status` = 'Has been reviewed' WHERE `id_o` = :id_o";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_o', $id_o);

            if ($stmt->execute()) {
                return true; // Update successful
            } else {
                return false; // Update failed
            }
        } catch (PDOException $e) {
            // Handle the exception (e.g., log, display an error message)
            // For now, let's just echo the error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Change status of product to sold out
    public function suspended($id_p)
    {
        $query = "UPDATE product SET status = 'suspended' WHERE id_p = :id_p";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_p', $id_p);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //count column amount of products in cart
    //$column = amount
    public function amount_product($table, $column)
    {
        $query = "SELECT SUM($column) AS total_amount FROM $table";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_amount'];
    }

    //Sum column price of products in cart
    //$column = price
    public function sum_price($table, $price, $amount)
    {
        $query = "SELECT SUM($price * $amount) AS total_price FROM $table";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_price'];
    }    
    
    //Get all id_o orders from order table where id_cus=$id_cus
    public function customer_orders($table, $id_cus)
    {
        try {
            $query = "SELECT id_o
                      FROM `$table`
                      WHERE id_cus = :id_cus";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_cus', $id_cus, PDO::PARAM_INT);
            $stmt->execute();
    
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $orders;
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }    

    public function recived_order($id_o){
        $query = "UPDATE order SET status = 'Complete' WHERE id_o = :id_o";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_o', $id_o);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //change status in table where id_o
    public function complete($table, $id_o, $status){
        $query = "UPDATE `$table` SET status = :status WHERE id_o = :id_o";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_o', $id_o);
        $stmt->bindValue(':status', $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }   
    }

    // Get all id_p values from `order` table where id_o = $id_o
    public function order_product($table, $id_o)
    {
        $query = "SELECT id_p FROM `$table` WHERE id_o = :id_o";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_o', $id_o);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Save review without name for privacy
    public function save_review($table, $itemIDValue, $reviewText)
    {
        $query = "INSERT INTO $table (id_p, review) VALUES (:id_p, :review)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_p', $itemIDValue);
        $stmt->bindValue(':review', $reviewText);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log, display an error message)
            // For now, let's just echo the error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get the reviews from the "review" table
    public function review_orders($table, $id_p)
    {
        $query = "SELECT * FROM $table WHERE id_p = :id_p";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log, display an error message)
            // For now, let's just echo the error message
            echo "Error: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }       

    // Search for products based on name or body
    public function getResult($search)
    {
        // The SQL query to search for products with a matching name or body
        $query = "SELECT * FROM product WHERE name LIKE '%$search%' OR body LIKE '%$search%'";

        try {
            // Prepare and execute the query
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    // Get the best worker based on the least time taken for a specific order
    public function best_worker($table) {
        try {
            $query = "SELECT id_w, SUM(TIME_TO_SEC(TIMEDIFF(`end`, `start`))) AS total_time
                      FROM `$table`
                      WHERE TIMEDIFF(`end`, `start`) != '00:00:00'
                      GROUP BY id_w
                      ORDER BY total_time ASC
                      LIMIT 1";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $id_w = $result['id_w'];
                $worker_name = $this->getWorkerName('worker', $id_w);
                $total_time = gmdate('H:i:s', $result['total_time']);
                return "Best Worker ID: $worker_name, Total Time Taken: " . date('H:i', strtotime($total_time)) . " (For each product)";
            } else {
                return "No valid results found.";
            }
        } catch (PDOException $e) {
            return "Error executing query: " . $e->getMessage();
        }
    }

    // Get worker info by id_w
    public function worker_info($table, $id_w) {
        try {
            $query = "SELECT * FROM $table WHERE id_w = :id_w";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_w', $id_w, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result; // Return the worker information as an associative array
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    // Get the best time of orders
    public function getBestOrderTime($table)
    {
        $query = "SELECT MIN(`end`) AS best_time
                FROM $table
                WHERE `end` > NOW()";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['best_time'];
    }

    // Get worker name from worker table based on id_w
    public function getWorkerName($table, $id_w) {
        try {
            $query = "SELECT name FROM $table WHERE id_w = :id_w";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_w', $id_w, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result['name'];
            } else {
                return null; // Return null if no results found
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    // Decrement products and change status
    public function decrement_products($id_o)
    {
        $id_p_array = $this->id_p_order($id_o);
        $amount_array = $this->amount_order($id_o);

        foreach ($id_p_array as $key => $id_p) {
            $amount = $amount_array[$key];

            // Update the product's quantity (Assuming you have a products table)
            $this->decrement_product_inventory($id_p, $amount);
        }
    }

    // Get max quantity from product table where id_p = $id_p
    public function get_quantity($table, $id_p) {
        try {
            $query = "SELECT inventory FROM $table WHERE id_p = :id_p";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && isset($result['inventory'])) {
                return $result['inventory'];
            } else {
                return 0; // Return 0 if no results found or inventory is not set
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }    

    // Check if $id_p are exisrs in cart table if yes return false else return true 
    public function check_duplicates($table, $id_p) {
        try {
            $query = "SELECT COUNT(*) as count FROM $table WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'] === '0'; // Return true if count is 0, indicating no duplicates
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }    

    // function to decrement product inventory
    private function decrement_product_inventory($id_p, $amount)
    {
        try {
            $query = "UPDATE product SET inventory = inventory - :amount WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();

            // Check if the inventory has become zero
            $newInventory = $this->get_product_inventory($id_p);
            if ($newInventory <= 0) {
                $this->update_product_status($id_p, 'Out of Stock'); // Change status to "Out of Stock"
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    // Get product inventory
    private function get_product_inventory($id_p)
    {
        try {
            $query = "SELECT inventory FROM product WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['inventory'];
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    // Update product status
    public function update_product_status($id_p, $status)
    {
        try {
            $query = "UPDATE product SET status = :status WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':status', $status);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    } 


    // Get array id_p from order table
    public function id_p_order($id_o)
    {
        try {
            $query = "SELECT id_p FROM `order` WHERE id_o = :id_o";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_o', $id_o, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $id_p_array = explode(',', $result['id_p']);
                return $id_p_array;
            } else {
                return array(); // Return an empty array if no results found
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    // Get array amount from order table
    public function amount_order($id_o)
    {
        try {
            $query = "SELECT amount FROM `order` WHERE id_o = :id_o";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id_o', $id_o, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $amount_array = explode(',', $result['amount']);
                return $amount_array;
            } else {
                return array(); // Return an empty array if no results found
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }

    // Get price of each month in order table
    public function get_price($table, $month) {
        try {
            $query = "SELECT SUM(amount_price) AS total_price
                      FROM $table
                      WHERE MONTH(date) = :month";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':month', $month, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && $result['total_price'] !== null) {
                return $result['total_price'];
            } else {
                return 0; // Return 0 if no results found
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }
    
    // Get amount of orders in  each month in order table
    public function get_amount_of_orders($table, $month) {
        try {
            $query = "SELECT COUNT(*) AS total_orders
                      FROM $table
                      WHERE MONTH(date) = :month";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':month', $month, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && $result['total_orders'] !== null) {
                return $result['total_orders'];
            } else {
                return 0; // Return 0 if no results found
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }    

    //Update size s = $size_s and m = $size_m and l = $size_l where id_p=id_p
    public function update_product_size($table, $id_p, $size_s, $size_m, $size_l) {
        try {
            $query = "UPDATE $table SET s = :size_s, m = :size_m, l = :size_l WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':size_s', $size_s, PDO::PARAM_STR);
            $stmt->bindValue(':size_m', $size_m, PDO::PARAM_STR);
            $stmt->bindValue(':size_l', $size_l, PDO::PARAM_STR);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }    

    //Update status where $size = $status
    public function update_product_status_size($id_p, $status, $column) {
        try {            
            $query = "UPDATE product SET $column = :status WHERE id_p = :id_p";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }   
    
    // Decrement size from product table
    public function decrement_products_size($amount_string, $size_string, $id_p_string) {
        try {
            $id_p_array = explode(',', $id_p_string); // Convert the comma-separated string to an array
            $sizes = explode(',', $size_string);
            $amounts = explode(',', $amount_string);
    
            for ($i = 0; $i < count($id_p_array); $i++) {
                $id_p = $id_p_array[$i];
                $size = $sizes[$i];
                $amount = $amounts[$i];
    
                $query = "UPDATE product SET {$size} = {$size} - :amount WHERE id_p = :id_p";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
                $stmt->bindValue(':id_p', $id_p, PDO::PARAM_INT);
                $stmt->execute();
    
                // Check if the updated inventory for the size is now 0
                $new_inventory = $this->get_quantity('product', $id_p, $size);
                if ($new_inventory === 0) {
                    $status_column = "status_" . $size;
                    $this->update_product_status_size($id_p, 'Out of Stock', $status_column);
                }
            }
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }
    
    //Get all from $column from $table where date between $from and $to and total of $column 
    public function get_order_amout_price_dates($table, $column, $from, $to) {
        try {
            $query = "SELECT SUM($column) AS total_amount FROM `$table` WHERE `date` BETWEEN :from_date AND :to_date";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':from_date', $from);
            $stmt->bindValue(':to_date', $to);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_amount'];
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }    
    
    // Get count of all orders between this dates
    public function get_order_amout_orders_dates($table, $column, $from, $to) {
        try {
            $query = "SELECT count($column) AS total_order FROM `$table` WHERE `date` BETWEEN :from_date AND :to_date";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':from_date', $from);
            $stmt->bindValue(':to_date', $to);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_order'];
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }  
    }  
}
?>