<?php
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/php_errors.log');

// // Trigger a deliberate error to test
// echo $undefined_variable;

class Model
{
    private $db;

    public function __construct($db)
    {
        if ($db instanceof PDO) {
            $this->db = $db;
        } else {
            die('Invalid database connection.');
        }
        
    }
  /** ---------------- Login and User management Functions-------------------- **/

    // login function
    
    public function getStaff($email){
        $sql = "SELECT * FROM staff_login WHERE email = :email";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email); 
        
        $query->execute($parameters);
        return $query->fetch();
    }

    public function reset_password($email, $password){
        $sql = "UPDATE staff_login SET password = :password WHERE email = :email";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email,':password' => $password); 
        
        if ($query->execute($parameters)) {
            // Check if any rows were affected
            if ($query->rowCount() > 0) {
            // Password reset successful
            return true;
            } else {
            // No rows were affected (email not found)
            return false;
            }
        } else {
            // Error executing the query
            return false;
        }
    }
    // user management function
    public function get_users()
    {
        $stmt = $this->db->prepare("SELECT * FROM staff_login");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);  
    }

    public function insert_user($email, $department, $position, $role, $password = 'mle2025'){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO staff_login (email, department, position, role, password) 
                VALUES (:email, :department, :position, :role, :password)";
        $query = $this->db->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':department', $department ?: null, $department ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $query->bindValue(':position', $position ?: null, $position ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $query->bindValue(':role', $role, PDO::PARAM_STR);
        $query->bindValue(':password', $hashed_password, PDO::PARAM_STR);
    
        return $query->execute();
    }
    

    public function edit_user($id, $email,$department, $position, $role){
        
        $sql = "UPDATE staff_login SET email=:email, department=:department, position=:position,  role=:role where id=:id";
        $query = $this->db->prepare($sql);
        $parameters = array(':department' => $department,':position' => $position,':email' => $email,':role' => $role, ':id'=>$id); 
        //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); 
       
        return  $query->execute($parameters);
    }
     
    public function delete_user($id){
        
        $sql = "DELETE FROM staff_login where id=:id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id'=>$id); 
        //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); 
       
        return  $query->execute($parameters);
    }


       //location model
    // Fetch all locations
    public function getLocations() {
        $sql = "SELECT * FROM locations ORDER BY created_at DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    // Add new location
    public function addLocation($location_name) {
        $sql = "INSERT INTO locations (location_name) VALUES (:location_name)";
        $query = $this->db->prepare($sql);
        $parameters = array(':location_name' => $location_name);
        return $query->execute($parameters);
    }

    // Get a single location by ID
    public function getLocationById($id) {
        $sql = "SELECT * FROM locations WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Update location
    public function updateLocation($id, $location_name) {
        $sql = "UPDATE locations SET location_name = :location_name WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':location_name' => $location_name, ':id' => $id);
        return $query->execute($parameters);
    }

    // Delete location
    public function deleteLocation($id) {
        $sql = "DELETE FROM locations WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        return $query->execute($parameters);
    }

    
    //office model
    // Fetch all offices with their locations
    public function getOffices() {
        $sql = "SELECT offices.*, locations.location_name 
                FROM offices 
                JOIN locations ON offices.location_id = locations.id 
                ORDER BY office_name ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add new office
    public function addOffice($office_name, $location_id) {
        $sql = "INSERT INTO offices (office_name, location_id) 
            VALUES (:office_name, :location_id)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':office_name' => $office_name,
            ':location_id' => $location_id
        );
        return $query->execute($parameters);
    }

    // Get a single office by ID
    public function getOfficeById($id) {
        $sql = "SELECT offices.*, locations.location_name 
                FROM offices 
                JOIN locations ON offices.location_id = locations.id 
                WHERE offices.id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Update office
    public function updateOffice($id, $office_name, $location_id) {
        $sql = "UPDATE offices SET office_name = :office_name, location_id = :location_id WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':office_name' => $office_name,
            ':location_id' => $location_id,
            ':id' => $id
        );
        return $query->execute($parameters);
    }

    // Delete office
    public function deleteOffice($id) {
        $sql = "DELETE FROM offices WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        return $query->execute($parameters);
    }


        //CATEGORY MODEL:
    // Fetch all categories
    public function getCategories() {
        $sql = "SELECT * FROM categories ORDER BY created_at DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add new category
    public function addCategory($category_name, $description) {
        $sql = "INSERT INTO categories (category, description) VALUES (:category, :description)";
        $query = $this->db->prepare($sql);
        $parameters = array(':category' => $category_name, ':description' => $description);
        return $query->execute($parameters);
    }

    // Get a single category by ID
    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Update category
    public function updateCategory($id, $category_name, $description) {
        $sql = "UPDATE categories SET category = :category, description = :description WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':category' => $category_name, ':description' => $description, ':id' => $id);
        return $query->execute($parameters);
    }

    // Delete category
    public function deleteCategory($id) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        return $query->execute($parameters);
    }

        // INVENTORY MODEL 
    // Fetch all inventory items
    public function getItems() {
        $sql = "SELECT i.id, c.category AS category, i.description, i.serial_number, 
                        i.tag_number, i.acquisition_date, i.acquisition_cost, i.warranty_date 
                FROM inventory i
                JOIN categories c ON i.category_id = c.id
                ORDER BY i.created_at DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add new inventory item
    public function addItem($category_id, $description, $serial_number, $tag_number, $acquisition_date, $acquisition_cost, $warranty_date) {
        $sql = "INSERT INTO inventory (category_id, description, serial_number, tag_number, acquisition_date, acquisition_cost, warranty_date) 
                VALUES (:category_id, :description, :serial_number, :tag_number, :acquisition_date, :acquisition_cost, :warranty_date)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':category_id' => $category_id,
            ':description' => $description,
            ':serial_number' => $serial_number,
            ':tag_number' => $tag_number,
            ':acquisition_date' => $acquisition_date,
            ':acquisition_cost' => $acquisition_cost,
            ':warranty_date' => $warranty_date
        );
        return $query->execute($parameters);
    }

    // Get a single inventory item by ID
    public function getItemById($id) {
        $sql = "SELECT * FROM inventory WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Update inventory item
    public function updateItem($id, $category_id, $description, $serial_number, $tag_number, $acquisition_date, $acquisition_cost, $warranty_date) {
        $sql = "UPDATE inventory 
                SET category_id = :category_id, description = :description, serial_number = :serial_number, 
                    tag_number = :tag_number, acquisition_date = :acquisition_date, 
                    acquisition_cost = :acquisition_cost, warranty_date = :warranty_date
                WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':id' => $id,
            ':category_id' => $category_id,
            ':description' => $description,
            ':serial_number' => $serial_number,
            ':tag_number' => $tag_number,
            ':acquisition_date' => $acquisition_date,
            ':acquisition_cost' => $acquisition_cost,
            ':warranty_date' => $warranty_date
        );
        return $query->execute($parameters);
    }

    // Delete inventory item
    public function deleteItem($id) {
        $sql = "DELETE FROM inventory WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        return $query->execute($parameters);
    }

    //search items
    public function searchItems($search_query)
    {
        $sql = "SELECT inventory.*, categories.category AS category
            FROM inventory
            LEFT JOIN categories ON inventory.category_id = categories.id
            WHERE inventory.description LIKE :search_query1
            OR inventory.serial_number LIKE :search_query2
            OR inventory.tag_number LIKE :search_query3";

        $stmt = $this->db->prepare($sql);
        $search_param = '%' . $search_query . '%';
        
        // Bind each placeholder separately
        $stmt->bindParam(':search_query1', $search_param, PDO::PARAM_STR);
        $stmt->bindParam(':search_query2', $search_param, PDO::PARAM_STR);
        $stmt->bindParam(':search_query3', $search_param, PDO::PARAM_STR);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

            //inventory assgnment model
    // Fetch all assignments
    public function getAllAssignments() {
        
        $sql = "SELECT 
                    ia.id,
                    ia.name AS user_name,
                    ia.email,
                    sl.department,
                    sl.position,
                    ia.location,
                    i.category_id,
                    i.description,
                    ia.serial_number,
                    ia.tag_number,
                    ia.date_assigned,
                    ia.managed_by,
                    ia.acknowledgment_status,
                    ia.created_at,
                    ia.updated_at
                FROM inventory_assignment ia
                LEFT JOIN inventory i ON ia.item = i.id
                LEFT JOIN staff_login sl ON ia.email = sl.email";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Fetch all unassigned items (not pending or approved)
    public function getUnassignedItems()
    {
        $sql = "SELECT i.id, i.description, i.serial_number, i.tag_number, i.category_id 
                FROM inventory i
                LEFT JOIN inventory_assignment ia ON i.id = ia.item
                WHERE ia.item IS NULL OR ia.acknowledgment_status NOT IN ('pending', 'approved')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all users
    public function getAllUsers()
    {
        $sql = "SELECT id, email FROM staff_login";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get user details by ID
    public function getUserById($user_id)
    {
        $sql = "SELECT email FROM staff_login WHERE id = :user_id";
        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $user_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Get manager's email from staff_login (for managed_by field)
    public function getManagerEmail($email)
    {
        $sql = "SELECT email FROM staff_login WHERE email = :email";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Assign items to users
    public function addAssignment($user_id, $item_ids, $date_assigned, $manager_email, $location)
    {
        $manager = $this->getManagerEmail($manager_email);
        if (!$manager) {
            return "Invalid manager email: " . htmlspecialchars($manager_email);
        }
        $managed_by = strtok($manager['email'], '@');

        $userSql = "SELECT 
                        email AS name,
                        email,
                        CONCAT(COALESCE(department, 'N/A'), ' ', COALESCE(position, 'N/A')) AS role
                    FROM staff_login
                    WHERE id = :user_id";

        $userQuery = $this->db->prepare($userSql);
        $userQuery->execute([':user_id' => $user_id]);
        $user = $userQuery->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "User not found.";
        }

        foreach ($item_ids as $item_id) {
            $itemSql = "SELECT serial_number, tag_number FROM inventory WHERE id = :item_id";
            $itemQuery = $this->db->prepare($itemSql);
            $itemQuery->execute([':item_id' => $item_id]);
            $item = $itemQuery->fetch(PDO::FETCH_ASSOC);

            if (!$item) {
                return "Item with ID $item_id not found in inventory.";
            }

            $checkSql = "SELECT COUNT(*) FROM inventory_assignment 
                        WHERE item = :item_id AND acknowledgment_status IN ('pending', 'approved')";
            $checkQuery = $this->db->prepare($checkSql);
            $checkQuery->execute([':item_id' => $item_id]);
            if ($checkQuery->fetchColumn() > 0) {
                return "Item with ID $item_id is already assigned.";
            }

            $sql = "INSERT INTO inventory_assignment 
                        (name, email, role, location, item, serial_number, tag_number, managed_by, acknowledgment_status, created_at, updated_at, date_assigned)
                    VALUES 
                        (:name, :email, :role, :location, :item_id, :serial_number, :tag_number, :managed_by, 'pending', NOW(), NOW(), :date_assigned)";

            $query = $this->db->prepare($sql);
            $parameters = [
                ':name' => $user['name'],
                ':email' => $user['email'],
                ':role' => $user['role'],
                ':location' => $location,
                ':item_id' => $item_id,
                ':serial_number' => $item['serial_number'],
                ':tag_number' => $item['tag_number'],
                ':managed_by' => $managed_by,
                ':date_assigned' => $date_assigned
            ];

            if (!$query->execute($parameters)) {
                $errorInfo = $query->errorInfo();
                return "Failed to assign item with ID $item_id. Error: " . $errorInfo[2];
            }
        }

        return "Items successfully assigned!";
    }
    //get assignment by id
    public function getAssignmentById($assignment_id)
    {
        $sql = "SELECT ia.*, au.id AS user_id, au.email AS user_email, i.id AS item_id, i.description, i.serial_number
                FROM inventory_assignment ia
                JOIN staff_login au ON ia.email = au.email
                LEFT JOIN inventory i ON ia.item = i.id
                WHERE ia.id = :assignment_id";

        $query = $this->db->prepare($sql);
        $query->execute([':assignment_id' => $assignment_id]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null; // Assignment not found
        }

        $assignment = $result[0]; // Base assignment details

        // Collect items into an array
        $assignment['items'] = [];
        foreach ($result as $row) {
            if ($row['item_id']) {
                $assignment['items'][] = [
                    'id' => $row['item_id'],
                    'description' => $row['description'],
                    'serial_number' => $row['serial_number']
                ];
            }
        }

        return $assignment;
    }

    //update user assigned items
    public function updateAssignment($assignment_id, $item_ids, $date_assigned, $location, $manager_email)
{
    // Debug to check if the correct manager email is being submitted
    error_log('Submitted manager_email: ' . $manager_email);

    // Validate manager email
    if (!filter_var($manager_email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format for manager: " . htmlspecialchars($manager_email);
    }

    // Extract name before '@' for managed_by field
    $managed_by = strtok($manager_email, '@');

    // Ensure assignment is pending
    $checkSql = "SELECT acknowledgment_status FROM inventory_assignment WHERE id = :assignment_id";
    $checkQuery = $this->db->prepare($checkSql);
    $checkQuery->execute([':assignment_id' => $assignment_id]);
    $assignment = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if (!$assignment) {
        return "Assignment not found.";
    }

    if ($assignment['acknowledgment_status'] !== 'pending') {
        return "Only pending assignments can be edited.";
    }

    // Get item details for each item
    $items = [];
    foreach ($item_ids as $item_id) {
        $itemSql = "SELECT serial_number, tag_number FROM inventory WHERE id = :item_id";
        $itemQuery = $this->db->prepare($itemSql);
        $itemQuery->execute([':item_id' => $item_id]);
        $item = $itemQuery->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            return "Item not found with ID: " . htmlspecialchars($item_id);
        }
        $items[$item_id] = $item;
    }

    // Update assignment (first item for simplicity — you might want to loop for all items)
    $sql = "UPDATE inventory_assignment
            SET item = :item_id,
                serial_number = :serial_number,
                tag_number = :tag_number,
                date_assigned = :date_assigned,
                location = :location,
                managed_by = :managed_by,
                updated_at = NOW()
            WHERE id = :assignment_id AND acknowledgment_status = 'pending'";

    $query = $this->db->prepare($sql);

    foreach ($items as $item_id => $item) {
        $query->execute([
            ':assignment_id' => $assignment_id,
            ':item_id' => $item_id,
            ':serial_number' => $item['serial_number'],
            ':tag_number' => $item['tag_number'],
            ':date_assigned' => $date_assigned,
            ':location' => $location,
            ':managed_by' => $managed_by
        ]);
    }

    return $query->rowCount() > 0 ? "Assignment updated successfully!" : "No changes made.";
}


    //delete an item(once not approved)
    public function deleteAssignment($assignment_id)
    {
        // Check if the assignment is acknowledged
        $sql = "SELECT acknowledgment_status FROM inventory_assignment WHERE id = :assignment_id";
        $query = $this->db->prepare($sql);
        $query->execute([':assignment_id' => $assignment_id]);
        $assignment = $query->fetch(PDO::FETCH_ASSOC);

        if (!$assignment) {
            return "Assignment not found.";
        }

        if ($assignment['acknowledgment_status'] !== 'acknowledged') {
            return "Only acknowledged assignments can be deleted.";
        }

        // Proceed to delete if acknowledged
        $deleteSql = "DELETE FROM inventory_assignment WHERE id = :assignment_id";
        $deleteQuery = $this->db->prepare($deleteSql);
        $deleteQuery->execute([':assignment_id' => $assignment_id]);

        if ($deleteQuery->rowCount() > 0) {
            return "Assignment deleted successfully!";
        } else {
            return "Failed to delete assignment.";
        }
    }
    //marking item as received(pending to acknowledge)
    // Get pending assignments for the logged-in user
    public function getPendingAssignmentsByLoggedInUser($user_name)
    {
        $sql = "SELECT 
                    ia.id,
                    ia.name AS user_name,
                    ia.email,
                    sl.department,
                    sl.position,
                    ia.location,
                    i.category_id,
                    i.description,
                    ia.serial_number,
                    ia.tag_number,
                    ia.date_assigned,
                    ia.managed_by,
                    ia.acknowledgment_status,
                    ia.created_at,
                    ia.updated_at
                FROM inventory_assignment ia
                LEFT JOIN inventory i ON ia.item = i.id
                LEFT JOIN staff_login sl ON ia.email = sl.email
                WHERE TRIM(ia.name) = :user_name
                AND TRIM(ia.acknowledgment_status) = 'pending'";
    
        $query = $this->db->prepare($sql);
        $query->execute([':user_name' => $user_name]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

        // Acknowledge pending items
        public function acknowledgeAssignment($assignment_id, $user_name)
        {
            $sql = "UPDATE inventory_assignment
                    SET acknowledgment_status = 'acknowledged', updated_at = NOW()
                    WHERE id = :assignment_id AND TRIM(name) = :user_name";

            $query = $this->db->prepare($sql);
            $query->execute([
                ':assignment_id' => $assignment_id,
                ':user_name' => $user_name
            ]);

            return $query->rowCount(); // Number of rows updated
        }

        ///get items assigned to a logged in user
        public function getApprovedAssignmentsByLoggedInUser($user_name)
        {
            $sql = "SELECT 
                        ia.id,
                        ia.name AS user_name,
                        ia.email,
                        sl.department,
                        sl.position,
                        ia.location,
                        i.category_id,
                        i.description,
                        ia.serial_number,
                        ia.tag_number,
                        ia.date_assigned,
                        ia.managed_by,
                        ia.acknowledgment_status,
                        ia.created_at,
                        ia.updated_at
                    FROM inventory_assignment ia
                    LEFT JOIN inventory i ON ia.item = i.id
                    LEFT JOIN staff_login sl ON ia.email = sl.email
                    WHERE TRIM(ia.name) = :user_name
                    AND TRIM(ia.acknowledgment_status) = 'acknowledged'";
            
            $query = $this->db->prepare($sql);
            $query->execute([':user_name' => $user_name]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
            //item returning process...
        //model to show returned item
        public function getReturnedItems()
        {
            $sql = "SELECT ir.id, i.description, i.serial_number, 
                        SUBSTRING_INDEX(sl.email, '@', 1) AS name, 
                        ir.return_date, ir.status
                    FROM inventory_returned ir
                    JOIN inventory i ON ir.item_id = i.id
                    JOIN staff_login sl ON ir.receiver_id = sl.id
                    ORDER BY ir.return_date DESC";

            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }


    // Get a single returned item by ID
    public function getReturnedItemById($id)
    {
        $sql = "SELECT * FROM inventory_returned WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getReceivers()
    {
        $sql = "SELECT id, SUBSTRING_INDEX(email, '@', 1) AS name FROM staff_login WHERE role = 'admin'"; 
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addItemReturn($assignment_id, $item_id, $return_date, $receiver_id, $status)
    {
        $sql = "INSERT INTO inventory_returned (assignment_id, item_id, return_date, receiver_id, status, created_at) 
                VALUES (:assignment_id, :item_id, :return_date, :receiver_id, :status, NOW())";
        $query = $this->db->prepare($sql);

        $parameters = array(
            ':assignment_id' => $assignment_id,
            ':item_id' => $item_id,
            ':return_date' => $return_date,
            ':receiver_id' => $receiver_id,
            ':status' => $status
        );

        return $query->execute($parameters);
    }
    
}


