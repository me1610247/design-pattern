<?php
// Repository Pattern To Use The Methods of Crud 
class ItemRepository 
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = rtrim(str_repeat("?, ", count($data)), ", ");
        $stmt = $this->db->getConnection()->prepare("INSERT INTO $table ($columns) VALUES ($values)");
    
        // Get values from $data array for binding
        $values = array_values($data);
    
        // Prepare the types string for binding parameters
        $types = str_repeat("s", count($data)); // Assuming all values are strings, modify accordingly
    
        // Bind parameters dynamically
        $stmt->bind_param($types, ...$values);
    
        if ($stmt->execute()) {
            return true; // Item inserted successfully
        } else {
            return "Error inserting item: " . $stmt->error;
        }
    }
    
    
    public function delete($tableName,$itemId)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM $tableName WHERE id = ?");
        $stmt->bind_param("i", $itemId);

        if ($stmt->execute()) {
            return true; // Item deleted successfully
        } else {
            return "Error deleting item: " . $stmt->error;
        }
    }
    public function getOrdersByUserID($tableName, $userId)
{
    $stmt = $this->db->getConnection()->prepare("SELECT * FROM $tableName WHERE user_id = ?");
    $stmt->bind_param("i", $userId);

    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

    public function deleteCart($tableName, $columnName, $columnValue)
{
    $stmt = $this->db->getConnection()->prepare("DELETE FROM $tableName WHERE $columnName = ?");
    $stmt->bind_param("s", $columnValue);

    if ($stmt->execute()) {
        return true; // Items deleted successfully
    } else {
        return "Error deleting items: " . $stmt->error;
    }
}
    
    public function get($tableName)
    {
    $stmt = $this->db->getConnection()->prepare("SELECT * FROM $tableName");
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    return $items;
    }
    public function getLastInsertedId()
    {
        return $this->db->getConnection()->insert_id;
    }
    public function clearCart($userId)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            return true; // Cart cleared successfully
        } else {
            return "Error clearing cart: " . $stmt->error;
        }
    }
    public function getUserByEmail($email)
    {
        // this function used to save the info
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // User not found
        }
    }
    
    public function read($tableName, $conditions = [])
{
    $query = "SELECT * FROM $tableName";
    
    if (!empty($conditions)) {
        $query .= " WHERE ";
        $keys = array_keys($conditions);
        $lastKey = end($keys);

        foreach ($conditions as $key => $value) {
            $query .= "$key = ?";
            if ($key !== $lastKey) {
                $query .= " AND ";
            }
        }
    }

    $stmt = $this->db->getConnection()->prepare($query);

    if (!empty($conditions)) {
        $stmt->bind_param(str_repeat('s', count($conditions)), ...array_values($conditions));
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    return $items;
}

    public function getById($tableName,$itemId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM $tableName WHERE id = ?");
        $stmt->bind_param("i", $itemId);

        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Item not found
        }
    }
    public function getItemsByCategoryId($category_id)
    {
        $stmt = $this->db->getConnection()->prepare( "SELECT * FROM items WHERE category = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();

        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Item not found
        }
    }
    public function getCartItemsByUser($user_id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = []; // Initialize an array to hold cart items
    
        if ($result->num_rows > 0) {
            // Fetch all rows into an array
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            return $items;
        } else {
            return $items; // Return an empty array if no items found
        }
    }
    
    public function update($tableName, $itemId, $data)
{
    $set = "";
    foreach ($data as $column => $value) {
        $set .= "$column = ?, ";
    }
    $set = rtrim($set, ", ");
    $stmt = $this->db->getConnection()->prepare("UPDATE $tableName SET $set WHERE id = ?");
    
    // Append the itemId at the end of the $data array for binding
    $data['id'] = $itemId;
    
    // Prepare the types string for binding parameters
    $types = str_repeat("s", count($data) - 1) . "i";

    // Get values from $data array for binding
    $values = array_values($data);

    // Bind parameters dynamically
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        return true; // Item updated successfully
    } else {
        return "Error updating item: " . $stmt->error;
    }
}

}

?>
