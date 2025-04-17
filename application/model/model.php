<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    
    public function getStaff($email) {
        $sql = "SELECT email, password, role, department, position FROM staff_login WHERE email = :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
    
        return $query->fetch(PDO::FETCH_OBJ);  
    }
    
    public function reset_password($email, $hashed_password,){
        $sql = "UPDATE staff_login SET password = :password WHERE email = :email";
        $query = $this->db->prepare($sql);
    $query->bindValue(':password', $hashed_password, PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    return $query->execute();
    }
    // user management function
    public function get_users()
    {
        $sql = "SELECT sl.*, d.department_name, p.position_name, CONCAT(loc.location_name, ' - ', o.office_name) as dutystation
                FROM staff_login sl
                LEFT JOIN departments d ON sl.department = d.id
                LEFT JOIN positions p ON sl.position = p.id
                LEFT JOIN offices o ON sl.dutystation = o.id
                LEFT JOIN locations loc ON o.location_id = loc.id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function insert_user($email, $department, $position, $role, $dutystation = null, $password = 'mle2025')
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO staff_login (email, department, position, role, dutystation, password) 
                VALUES (:email, :department, :position, :role, :dutystation, :password)";
        $query = $this->db->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':department', $department ?: null, PDO::PARAM_INT);
        $query->bindValue(':position', $position ?: null, PDO::PARAM_INT);
        $query->bindValue(':role', $role, PDO::PARAM_STR);
        $query->bindValue(':dutystation', $dutystation ?: null, PDO::PARAM_INT);
        $query->bindValue(':password', $hashed_password, PDO::PARAM_STR);

        return $query->execute();
    }
       
    public function edit_user($id, $email, $department, $position, $role, $dutystation)
    {
        $sql = "UPDATE staff_login 
                SET email=:email, department=:department, position=:position, role=:role, dutystation=:dutystation 
                WHERE id=:id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':email' => $email,
            ':department' => $department,
            ':position' => $position,
            ':role' => $role,
            ':dutystation' => $dutystation,
            ':id' => $id
        );
        return $query->execute($parameters);
    }
         
    public function delete_user($id)
    {
        $sql = "DELETE FROM staff_login WHERE id=:id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);

        return $query->execute($parameters);
    }
    // Fetch departments
    public function get_departments()
    {
        $stmt = $this->db->prepare("SELECT id, department_name FROM departments");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Fetch positions
    public function get_positions()
    {
        $stmt = $this->db->prepare("SELECT id, position_name FROM positions");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Fetch roles
    public function get_roles()
    {
        return ['super_admin', 'admin', 'staff']; // Static ENUM values
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
                    CONCAT(UCASE(LEFT(SUBSTRING_INDEX(ia.email, '@', 1), 1)), 
                           LCASE(SUBSTRING(SUBSTRING_INDEX(ia.email, '@', 1), 2))) AS user_name, 
                    ia.email,
                    d.department_name AS department,  
                    p.position_name AS position,    
                    CONCAT(loc.location_name, ' - ', o.office_name) AS location, -- formatted location
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
                LEFT JOIN departments d ON sl.department = d.id  
                LEFT JOIN positions p ON sl.position = p.id
                LEFT JOIN offices o ON sl.dutystation = o.id 
                LEFT JOIN locations loc ON o.location_id = loc.id 
                LEFT JOIN inventory_returned ir ON ia.id = ir.assignment_id  
                WHERE ir.assignment_id IS NULL";  
    
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
        
    
    //searchbutton
    public function searchAssignments($query) {
        $sql = "SELECT 
                    ia.id,
                    CONCAT(UCASE(LEFT(SUBSTRING_INDEX(ia.email, '@', 1), 1)), 
                           LCASE(SUBSTRING(SUBSTRING_INDEX(ia.email, '@', 1), 2))) AS user_name, 
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
                WHERE 
                    LOWER(SUBSTRING_INDEX(ia.email, '@', 1)) LIKE LOWER(:query)
                    OR ia.serial_number LIKE :query
                    OR ia.tag_number LIKE :query
                    OR ia.acknowledgment_status LIKE :query";
    
        $query = "%" . $query . "%";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':query', $query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
      
    // Fetch all unassigned items (not pending or approved)
    public function getUnassignedInventory()
    {
        $sql = "SELECT 
                    i.id, 
                    c.category AS category,  
                    i.description, 
                    i.serial_number, 
                    i.tag_number 
                FROM inventory i
                LEFT JOIN categories c ON i.category_id = c.id
                WHERE 
                    -- Ensure item is not currently assigned
                    i.id NOT IN (
                        SELECT ia.item FROM inventory_assignment ia
                        WHERE ia.acknowledgment_status IN ('pending', 'approved', 'acknowledged')
                    )
                    -- Ensure item is either never assigned OR returned and marked as functional OR is repairable
                    AND (
                        -- Exclude lost items
                        i.id NOT IN (
                            SELECT ia.item FROM inventory_assignment ia
                            JOIN inventory_returned ir ON ia.id = ir.assignment_id
                            WHERE ir.item_state = 'lost' 
                        )
                        -- Include approved functional items
                        OR i.id IN (
                            SELECT ia.item FROM inventory_assignment ia
                            JOIN inventory_returned ir ON ia.id = ir.assignment_id
                            WHERE ir.item_state = 'functional'
                            AND ir.status = 'approved' 
                        )
                        -- Include repairable damaged items
                        OR i.id IN (
                            SELECT ia.item FROM inventory_assignment ia
                            JOIN inventory_returned ir ON ia.id = ir.assignment_id
                            WHERE ir.item_state = 'damaged'
                            AND ir.repair_status = 'Repairable' 
                        )
                    )";
        
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
    public function addAssignment($user_id, $item_ids, $date_assigned, $manager_email)
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
                        (name, email, role, item, serial_number, tag_number, managed_by, acknowledgment_status, created_at, updated_at, date_assigned)
                    VALUES 
                        (:name, :email, :role, :item_id, :serial_number, :tag_number, :managed_by, 'pending', NOW(), NOW(), :date_assigned)";

            $query = $this->db->prepare($sql);
            $parameters = [
                ':name' => $user['name'],
                ':email' => $user['email'],
                ':role' => $user['role'],
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

    // Update assignment only if acknowledgment_status is pending
    public function updateAssignment($id, $updatedData, $inventory_ids)
    {
        // Fetch current assignment details
        $existingAssignmentSql = "SELECT email FROM inventory_assignment WHERE id = :id";
        $existingStmt = $this->db->prepare($existingAssignmentSql);
        $existingStmt->execute([':id' => $id]);
        $existingAssignment = $existingStmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$existingAssignment) {
            return "Assignment not found.";
        }
    
        // Get user details
        $userSql = "SELECT 
                        email AS name,
                        email,
                        CONCAT(COALESCE(department, 'N/A'), ' ', COALESCE(position, 'N/A')) AS role
                    FROM staff_login
                    WHERE id = :user_id";
    
        $userQuery = $this->db->prepare($userSql);
        $userQuery->execute([':user_id' => $updatedData['user_id']]);
        $user = $userQuery->fetch(PDO::FETCH_ASSOC);
    
        if (!$user) {
            return "User not found.";
        }
    
        // Get manager details
        $manager = $this->getManagerEmail($updatedData['managed_by']);
        if (!$manager) {
            return "Invalid manager email: " . htmlspecialchars($updatedData['managed_by']);
        }
        $managed_by = strtok($manager['email'], '@');
    
        // Update assignment details
        $updateSql = "UPDATE inventory_assignment 
                      SET name = :name, email = :email, role = :role, 
                          location = :location, managed_by = :managed_by, 
                          date_assigned = :date_assigned, updated_at = NOW() 
                      WHERE id = :id";
    
        $updateStmt = $this->db->prepare($updateSql);
        $updateParams = [
            ':id' => $id,
            ':name' => $user['name'],
            ':email' => $user['email'],
            ':role' => $user['role'],
            ':managed_by' => $managed_by,
            ':date_assigned' => $updatedData['date_assigned']
        ];
    
        if (!$updateStmt->execute($updateParams)) {
            return "Failed to update assignment.";
        }
    
        // Delete old inventory assignments
        $deleteSql = "DELETE FROM inventory_assignment WHERE id = :id";
        $deleteStmt = $this->db->prepare($deleteSql);
        $deleteStmt->execute([':id' => $id]);
    
        // Insert new inventory assignments
        foreach ($inventory_ids as $inventory_id) {
            $itemSql = "SELECT serial_number, tag_number FROM inventory WHERE id = :item_id";
            $itemQuery = $this->db->prepare($itemSql);
            $itemQuery->execute([':item_id' => $inventory_id]);
            $item = $itemQuery->fetch(PDO::FETCH_ASSOC);
    
            if (!$item) {
                return "Item with ID $inventory_id not found in inventory.";
            }
    
            $insertSql = "INSERT INTO inventory_assignment 
                              (name, email, role, item, serial_number, tag_number, managed_by, 
                              acknowledgment_status, created_at, updated_at, date_assigned) 
                          VALUES 
                              (:name, :email, :role, :item_id, :serial_number, :tag_number, 
                              :managed_by, 'pending', NOW(), NOW(), :date_assigned)";
    
            $insertStmt = $this->db->prepare($insertSql);
            $insertParams = [
                ':name' => $user['name'],
                ':email' => $user['email'],
                ':role' => $user['role'],
                ':item_id' => $inventory_id,
                ':serial_number' => $item['serial_number'],
                ':tag_number' => $item['tag_number'],
                ':managed_by' => $managed_by,
                ':date_assigned' => $updatedData['date_assigned']
            ];
    
            if (!$insertStmt->execute($insertParams)) {
                return "Failed to update item with ID $inventory_id.";
            }
        }
    
        return "Assignment successfully updated!";
    }
    
 
    // Delete assignment only if acknowledgment_status is pending
    public function deleteAssignment($id) {
        // Ensure only pending assignments can be deleted
        $assignment = $this->getAssignmentById($id);
        if (!$assignment || $assignment['acknowledgment_status'] !== 'pending') {
            return false;
        }

        $sql = "DELETE FROM inventory_assignment WHERE id = ?";
        $query = $this->db->prepare($sql);
        return $query->execute([$id]);
    }
    //marking item as received(pending to acknowledge)
    // Get pending assignments for the logged-in user
    public function getPendingAssignmentsByLoggedInUser($user_email)
    {
        $sql = "SELECT 
                    ia.id,
                    ia.name AS user_name,
                    ia.email,
                    d.department_name AS department,  
                    p.position_name AS position,    
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
                LEFT JOIN departments d ON sl.department = d.id  
                LEFT JOIN positions p ON sl.position = p.id 
                WHERE ia.email = :user_email
                AND ia.acknowledgment_status = 'pending'";
    
        $query = $this->db->prepare($sql);
        $query->execute([':user_email' => $user_email]);
    
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
        public function getApprovedAssignmentsByLoggedInUser($user_email)
        {
            $sql = "SELECT 
                        ia.id,
                        ia.name AS user_name,
                        ia.email,
                        d.department_name AS department,  
                        p.position_name AS position,
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
                    LEFT JOIN departments d ON sl.department = d.id  
                    LEFT JOIN positions p ON sl.position = p.id 
                    WHERE ia.email = :user_email
                    AND ia.acknowledgment_status = 'acknowledged'
                    -- Exclude items that have been returned and approved
                    AND ia.id NOT IN (
                        SELECT ir.assignment_id
                        FROM inventory_returned ir
                        WHERE ir.status = 'approved' 
                          AND ir.return_date IS NOT NULL
                    )";
        
            $query = $this->db->prepare($sql);
            $query->execute([':user_email' => $user_email]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
            //item returning process...
        //model to show returned item
        public function getReturnedItems($returned_by)
        {
            try {
                $sql = "SELECT ir.id, i.description, i.serial_number, 
                               SUBSTRING_INDEX(sl.email, '@', 1) AS returned_by_name,  
                               ir.return_date, ir.status, 
                               SUBSTRING_INDEX(sl_receiver.email, '@', 1) AS receiver_name
                        FROM inventory_returned ir
                        INNER JOIN inventory_assignment ia ON ir.assignment_id = ia.id  
                        INNER JOIN inventory i ON ia.item = i.id 
                        INNER JOIN staff_login sl ON ir.returned_by = sl.email
                        INNER JOIN staff_login sl_receiver ON ir.receiver_id = sl_receiver.id  
                        WHERE ir.returned_by = :returned_by";
        
                $query = $this->db->prepare($sql);
                $query->execute([ ':returned_by' => $returned_by ]);
        
                $returnedItems = $query->fetchAll(PDO::FETCH_ASSOC);
        
                return $returnedItems;
            } catch (PDOException $e) {
                die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
            }
        }
           //delete returned items that are not approve
        public function deleteReturn($id)
           {
               try {
                   // Check item status first
                   $sql = "SELECT status FROM inventory_returned WHERE id = :id";
                   $query = $this->db->prepare($sql);
                   $query->execute([":id" => $id]);
                   $item = $query->fetch(PDO::FETCH_ASSOC);
           
                   if (!$item) {
                       return false; // Item not found
                   }
           
                   if (strtolower($item['status']) !== 'pending') {
                       return false; // Only pending items can be deleted
                   }
           
                   // Delete the item
                   $sql = "DELETE FROM inventory_returned WHERE id = :id";
                   $query = $this->db->prepare($sql);
                   return $query->execute([":id" => $id]); // Return true if deleted
           
               } catch (PDOException $e) {
                   die("SQL Error: " . $e->getMessage());
               }
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
        $sql = "SELECT id, SUBSTRING_INDEX(email, '@', 1) AS name 
                FROM staff_login 
                WHERE role = 'admin'"; 
        
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //returning items
    public function recordReturn($assignment_id, $returned_by, $receiver_id, $return_date)
    {
        try {
            // Debugging output
            echo "Recording return for Assignment ID: $assignment_id, Return Date: $return_date, Receiver ID: $receiver_id, Returned By: $returned_by<br>";

            // SQL Insert for item return
            $sql = "INSERT INTO inventory_returned (assignment_id, returned_by, receiver_id, return_date, status)
                    VALUES (:assignment_id, :returned_by, :receiver_id, :return_date, 'pending')";

            $query = $this->db->prepare($sql);
            $result = $query->execute([
                ':assignment_id' => $assignment_id,
                ':returned_by' => $returned_by,
                ':receiver_id' => $receiver_id,
                ':return_date' => $return_date
            ]);

            if (!$result) {
                echo "<br><strong>Database Error:</strong> " . implode(" | ", $query->errorInfo()) . "<br>";
                exit();
            } else {
                echo "<br><strong>Success:</strong> Item(s) returned under Assignment ID: $assignment_id!";
            }

            return $result;
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }
 
    public function getItemReturnStatus($assignment_id, $item_id)
    {
        $sql = "SELECT status FROM inventory_returned WHERE assignment_id = :assignment_id AND item_id = :item_id LIMIT 1";
        $query = $this->db->prepare($sql);

        $query->execute([
            ':assignment_id' => $assignment_id,
            ':item_id' => $item_id
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    // Get pending items for approval by the logged-in user
    public function getPendingApprovalsByUser($receiver_id)
    {
        $sql = "SELECT ir.*, inv.description, inv.serial_number, 
                   sl.email AS receiver_email,
                   SUBSTRING_INDEX(sl.email, '@', 1) AS name
             FROM inventory_returned ir
             JOIN inventory_assignment ia ON ir.assignment_id = ia.id
             JOIN inventory inv ON ia.item = inv.id
             JOIN staff_login sl ON ir.receiver_id = sl.id
             WHERE ir.receiver_id = :receiver_id
             AND ir.status = 'pending'
             ORDER BY ir.return_date DESC";
    
        $query = $this->db->prepare($sql);
        $query->bindParam(':receiver_id', $receiver_id, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($results)) {
            
        }
    
        return $results;
    }
     
    // Approve the returned item
    public function approveReturn($return_id, $item_state, $approved_by) {
        try {
            $sql = "UPDATE inventory_returned 
                    SET status = 'approved', 
                        item_state = :item_state, 
                        approved_by = :approved_by, 
                        approved_date = NOW(), 
                        updated_at = NOW()
                    WHERE id = :return_id";
    
            $query = $this->db->prepare($sql);
            $query->execute([
                ':item_state'  => $item_state,
                ':approved_by' => $approved_by,
                ':return_id'   => $return_id
            ]);
    
            return true;
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }
     
    public function getUserIdByEmail($email)
    {
        $sql = "SELECT id FROM staff_login WHERE email = :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);
        return $query->fetchColumn(); // Returns the user ID
    }
    //lost items
    public function getLostItems()
    {
        $sql = "SELECT 
                    ia.item AS item_id, 
                    i.description, 
                    i.serial_number, 
                    i.tag_number, 
                    c.category, 
                    ir.return_date AS reported_date, 
                    ir.approved_date  -- Include approved_date here
                FROM inventory_returned ir
                JOIN inventory_assignment ia ON ir.assignment_id = ia.id
                JOIN inventory i ON ia.item = i.id
                JOIN categories c ON i.category_id = c.id
                WHERE ir.item_state = 'lost'
                ORDER BY ir.approved_date DESC";  
    
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    //search lost item
    public function getLostItemsSearch($search)
    {
        try {
            $sql = "SELECT 
                        ia.item AS item_id, 
                        i.description, 
                        i.serial_number, 
                        i.tag_number, 
                        c.category, 
                        ir.return_date AS reported_date, 
                        ir.approved_date 
                    FROM inventory_returned ir
                    JOIN inventory_assignment ia ON ir.assignment_id = ia.id
                    JOIN inventory i ON ia.item = i.id
                    JOIN categories c ON i.category_id = c.id
                    WHERE ir.item_state = 'lost'
                    AND (
                        LOWER(i.description) LIKE :search 
                        OR LOWER(i.serial_number) LIKE :search 
                        OR LOWER(i.tag_number) LIKE :search
                    )
                    ORDER BY ir.approved_date DESC";  

            $query = $this->db->prepare($sql);
            $query->execute(['search' => "%$search%"]); 
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }

    //damaged items
    public function getDamagedItems()
    {
        $sql = "SELECT 
                    ia.item AS item_id, 
                    i.description, 
                    i.serial_number, 
                    i.tag_number,  -- Added
                    c.category,  -- Added
                    ir.repair_status, 
                    ir.return_date AS reported_date
                FROM inventory_returned ir
                JOIN inventory_assignment ia ON ir.assignment_id = ia.id
                JOIN inventory i ON ia.item = i.id
                JOIN categories c ON i.category_id = c.id  -- Joined categories table
                WHERE ir.item_state = 'damaged'
                ORDER BY ir.return_date DESC";
    
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    //search damaged items
    public function getDamagedItemsSearch($search)
    {
        try {
            $sql = "SELECT 
                        ia.item AS item_id, 
                        i.description, 
                        i.serial_number, 
                        i.tag_number,  
                        c.category,  
                        ir.repair_status, 
                        ir.return_date AS reported_date
                    FROM inventory_returned ir
                    JOIN inventory_assignment ia ON ir.assignment_id = ia.id
                    JOIN inventory i ON ia.item = i.id
                    JOIN categories c ON i.category_id = c.id  
                    WHERE ir.item_state = 'damaged'
                    AND (
                        LOWER(i.description) LIKE :search 
                        OR LOWER(i.serial_number) LIKE :search 
                        OR LOWER(i.tag_number) LIKE :search
                    )
                    ORDER BY ir.return_date DESC";

            $query = $this->db->prepare($sql);
            $query->execute(['search' => "%$search%"]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }

    //approving ststus of damaged items
    public function updateRepairStatus($item_id, $repair_status)
    {
        $query = "SELECT id FROM inventory_assignment WHERE item = :item_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':item_id' => $item_id]);
        $assignment = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$assignment) {
            die("DEBUG: No assignment found for item_id = $item_id");
        }
    
        $assignment_id = $assignment['id'];

        $sql = "UPDATE inventory_returned SET repair_status = :repair_status WHERE assignment_id = :assignment_id";
        $stmt = $this->db->prepare($sql);
        
        $success = $stmt->execute([
            ':repair_status' => $repair_status,
            ':assignment_id' => $assignment_id
        ]);
    
        if (!$success) {
            die("DEBUG: Update query failed.");
        }
    
        echo "DEBUG: Repair status updated successfully for assignment_id = $assignment_id!";
        return true;
    }
    
    public function getAssignedItems()
    {
        $sql = "SELECT 
                    ia.id,
                    CONCAT(
                        UPPER(LEFT(SUBSTRING_INDEX(ia.email, '@', 1), 1)), 
                        LOWER(SUBSTRING(SUBSTRING_INDEX(ia.email, '@', 1), 2))
                    ) AS user_name,
                    ia.email AS assigned_user_email,
                    d.department_name AS department,
                    p.position_name AS position,
                    c.category AS category,
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
                LEFT JOIN categories c ON i.category_id = c.id  
                LEFT JOIN staff_login sl ON ia.email = sl.email
                LEFT JOIN departments d ON sl.department = d.id
                LEFT JOIN positions p ON sl.position = p.id
                WHERE ia.acknowledgment_status = 'acknowledged'
                AND NOT EXISTS (
                    -- Exclude items that are returned as approved (functional, lost, damaged)
                    SELECT 1 FROM inventory_returned ir 
                    WHERE ir.assignment_id = ia.id 
                    AND (
                        ir.item_state = 'functional' AND ir.status = 'approved'  -- Exclude approved functional items
                        OR ir.item_state = 'lost'  -- Exclude lost items
                        OR ir.item_state = 'damaged'  -- Exclude all damaged items (repairable, unrepairable, or null)
                    )
                )";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
        return $result['in_use_count'];
    }
    
    //search in inuse page
    public function getAssignedItemsSearch($search)
    {
        try {
            $sql = "SELECT 
                        ia.id,
                        ia.name AS user_name,
                        ia.email AS assigned_user_email, 
                        sl.department,
                        sl.position,
                        ia.location,
                        c.category AS category,
                        i.description,
                        i.serial_number,  
                        i.tag_number, 
                        ia.date_assigned,
                        ia.managed_by,
                        ia.created_at,
                        ia.updated_at
                    FROM inventory_assignment ia
                    INNER JOIN inventory i ON ia.item = i.id 
                    LEFT JOIN categories c ON i.category_id = c.id  
                    LEFT JOIN staff_login sl ON ia.email = sl.email
                    WHERE 
                        ia.id IS NOT NULL  
                        AND NOT EXISTS (
                            SELECT 1 FROM inventory_returned ir 
                            WHERE ir.assignment_id = ia.id 
                            AND (
                                ir.item_state IN ('functional', 'lost', 'damaged') 
                                AND ir.status = 'approved'
                            )
                        )
                        AND (
                            LOWER(i.serial_number) LIKE :search 
                            OR LOWER(i.tag_number) LIKE :search
                        )";
    
            $query = $this->db->prepare($sql);
            $query->execute(['search' => "%$search%"]); 
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }
      
    //disposed items ie items that cant be repaired and lost
    public function getDisposedItems()
    {
        $sql = "SELECT 
                    ia.item AS item_id, 
                    i.description, 
                    i.serial_number, 
                    i.tag_number, 
                    c.category AS category_name, 
                    ir.returned_by, 
                    ir.item_state,  
                    ir.repair_status, 
                    ir.return_date AS reported_date, 
                    ir.approved_date, 
                    CASE 
                        WHEN ir.item_state = 'lost' THEN 'Lost' 
                        WHEN ir.repair_status = 'Unrepairable' THEN 'Unrepairable' 
                        ELSE 'Disposed' 
                    END AS reason
                FROM inventory_returned ir
                JOIN inventory_assignment ia ON ir.assignment_id = ia.id
                JOIN inventory i ON ia.item = i.id
                JOIN categories c ON i.category_id = c.id
                WHERE ir.item_state = 'lost' OR ir.repair_status = 'Unrepairable'
                ORDER BY ir.approved_date DESC";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    //search disposed items
    public function getDisposedItemsSearch($search)
    {
        try {
            $sql = "SELECT 
                        ia.item AS item_id, 
                        i.description, 
                        i.serial_number, 
                        i.tag_number, 
                        c.category AS category_name, 
                        ir.returned_by, 
                        ir.item_state,  
                        ir.repair_status, 
                        ir.return_date AS reported_date, 
                        ir.approved_date, 
                        CASE 
                            WHEN ir.item_state = 'lost' THEN 'Lost' 
                            WHEN ir.repair_status = 'Unrepairable' THEN 'Unrepairable' 
                            ELSE 'Disposed' 
                        END AS reason
                    FROM inventory_returned ir
                    JOIN inventory_assignment ia ON ir.assignment_id = ia.id
                    JOIN inventory i ON ia.item = i.id
                    JOIN categories c ON i.category_id = c.id
                    WHERE (ir.item_state = 'lost' OR ir.repair_status = 'Unrepairable')
                    AND (
                        LOWER(i.description) LIKE :search 
                        OR LOWER(i.serial_number) LIKE :search 
                        OR LOWER(i.tag_number) LIKE :search
                    )
                    ORDER BY ir.approved_date DESC";

            $query = $this->db->prepare($sql);
            $query->execute(['search' => "%$search%"]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }

    public function getUnassignedItems()
    {
        try {
            $sql = "SELECT 
                        i.id, 
                        c.category AS category,  
                        i.description, 
                        i.serial_number, 
                        i.tag_number 
                    FROM inventory i
                    LEFT JOIN categories c ON i.category_id = c.id
                    WHERE 
                        -- Ensure item is not currently assigned
                        i.id NOT IN (
                            SELECT ia.item FROM inventory_assignment ia
                            WHERE ia.acknowledgment_status IN ('pending', 'approved', 'acknowledged')
                        )
                        -- Ensure item is either never assigned OR returned and marked as functional OR is repairable
                        AND (
                            -- Exclude lost items
                            i.id NOT IN (
                                SELECT ia.item FROM inventory_assignment ia
                                JOIN inventory_returned ir ON ia.id = ir.assignment_id
                                WHERE ir.item_state = 'lost' 
                            )
                            -- Include approved functional items
                            OR i.id IN (
                                SELECT ia.item FROM inventory_assignment ia
                                JOIN inventory_returned ir ON ia.id = ir.assignment_id
                                WHERE ir.item_state = 'functional'
                                AND ir.status = 'approved' 
                            )
                            -- Include repairable damaged items
                            OR i.id IN (
                                SELECT ia.item FROM inventory_assignment ia
                                JOIN inventory_returned ir ON ia.id = ir.assignment_id
                                WHERE ir.item_state = 'damaged'
                                AND ir.repair_status = 'Repairable' 
                            )
                        )
                        -- Ensure the item is functional and approved or repairable
                        OR i.id IN (
                            SELECT ia.item FROM inventory_assignment ia
                            JOIN inventory_returned ir ON ia.id = ir.assignment_id
                            WHERE 
                                (
                                    -- Functional and approved items
                                    (ir.item_state = 'functional' AND ir.status = 'approved')
                                    -- Damaged items with repairable status
                                    OR (ir.item_state = 'damaged' AND ir.repair_status = 'Repairable')
                                )
                        )";
            
            // Prepare the query
            $query = $this->db->prepare($sql);
            // Execute the query
            $query->execute();
            
            // Fetch all results
            $unassignedItems = $query->fetchAll(PDO::FETCH_ASSOC);
            
            return $unassignedItems;
            return $result['in_stock_count'];
            
        } catch (PDOException $e) {
            // Handle any SQL exceptions
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }
    //search in the instock page
    public function getUnassignedItemsSearch($search)
    {
        try {
            $sql = "SELECT 
                        i.id, 
                        c.category AS category,  
                        i.description, 
                        i.serial_number, 
                        i.tag_number 
                    FROM inventory i
                    LEFT JOIN categories c ON i.category_id = c.id
                    WHERE 
                        (
                            i.id NOT IN (
                                SELECT ia.item FROM inventory_assignment ia
                                JOIN inventory_returned ir ON ia.id = ir.assignment_id
                                WHERE ir.item_state = 'lost' 
                            )
                            OR i.id IN (
                                SELECT ia.item FROM inventory_assignment ia
                                JOIN inventory_returned ir ON ia.id = ir.assignment_id
                                WHERE ir.item_state = 'functional'
                                AND ir.status = 'approved' 
                            )
                            OR i.id IN (
                                SELECT ia.item FROM inventory_assignment ia
                                JOIN inventory_returned ir ON ia.id = ir.assignment_id
                                WHERE ir.item_state = 'damaged'
                                AND ir.repair_status = 'Repairable' 
                            )
                        )
                        -- Search condition
                        AND (
                            i.serial_number LIKE :search 
                            OR i.tag_number LIKE :search
                        )";
    
            $query = $this->db->prepare($sql);
            $query->execute([':search' => "%$search%"]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }

    //positions model
    // Fetch all positions ordered by hierarchy level
    public function getPositions()
    {
        $sql = "SELECT * FROM positions ORDER BY hierarchy_level ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new position
    public function addPosition($position_name, $hierarchy_level)
    {
        $sql = "INSERT INTO positions (position_name, hierarchy_level) VALUES (:position_name, :hierarchy_level)";
        $query = $this->db->prepare($sql);
        $parameters = array(':position_name' => $position_name, ':hierarchy_level' => $hierarchy_level);
        return $query->execute($parameters);
    }

    // Get a single position by ID
    public function getPositionById($id)
    {
        $sql = "SELECT * FROM positions WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Update an existing position
    public function updatePosition($id, $position_name, $hierarchy_level)
    {
        $sql = "UPDATE positions SET position_name = :position_name, hierarchy_level = :hierarchy_level WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':position_name' => $position_name, ':hierarchy_level' => $hierarchy_level, ':id' => $id);
        return $query->execute($parameters);
    }

    // Delete a position
    public function deletePosition($id)
    {
        $sql = "DELETE FROM positions WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        return $query->execute($parameters);
    }
    
    //department model
    // Fetch all departments
    public function getAllDepartments() {
        return $this->db->query("SELECT * FROM departments ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Fetch departments with parent-child structure
    public function getDepartmentsHierarchy() {
        return $this->db->query("
            SELECT d1.id, d1.department_name, d1.parent_id, d2.department_name AS parent_name
            FROM departments d1
            LEFT JOIN departments d2 ON d1.parent_id = d2.id
            ORDER BY d1.parent_id ASC, d1.department_name ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Get department by ID
    public function getDepartmentById($id) {
        $stmt = $this->db->prepare("SELECT * FROM departments WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Add new department with parent ID
    public function addDepartment($department_name, $parent_id = NULL) {
        $stmt = $this->db->prepare("INSERT INTO departments (department_name, parent_id) VALUES (:department_name, :parent_id)");
        $stmt->bindParam(':department_name', $department_name);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_NULL | PDO::PARAM_INT);
        return $stmt->execute();
    }

      // Update department details including parent_id
    public function updateDepartment($id, $department_name, $parent_id = NULL) 
    {
        $stmt = $this->db->prepare("UPDATE departments SET department_name = :department_name, parent_id = :parent_id WHERE id = :id");
        $stmt->bindParam(':department_name', $department_name, PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_NULL | PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete a department
    public function deleteDepartment($id) {
        $stmt = $this->db->prepare("DELETE FROM departments WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
     //managers reports
    //hierachy access of assignments
    public function getAssignmentsByHierarchy($loggedInEmail)
    {
        $sql = "SELECT p.hierarchy_level AS position_level, d.id AS department_id
                FROM staff_login sl
                LEFT JOIN positions p ON sl.position = p.id
                LEFT JOIN departments d ON sl.department = d.id
                WHERE sl.email = :email";
    
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $loggedInEmail, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        if (!$user) {
            return [];
        }
    
        $userLevel = (int) $user->position_level;
        $userDepartment = (int) $user->department_id;
    
        $subDepartments = $this->getSubDepartments($userDepartment);
        $subDepartments[] = $userDepartment;  
    
        $allowedLevels = [];
        switch ($userLevel) {
            case 1:  
                $allowedLevels = [1, 2, 3, 4, 5, 6];
                break;
            case 2:  
                $allowedLevels = [3, 4, 5, 6];
                break;
            case 3:  
                $allowedLevels = [4, 5, 6];
                break;
            case 4:  
                $allowedLevels = [5, 6];
                break;
            default:
                return [];
        }
    
        // Fetch assignments for staff within the department hierarchy
        $sql = "SELECT 
                    ia.id,
                    CONCAT(UCASE(LEFT(SUBSTRING_INDEX(sl.email, '@', 1), 1)), 
                           LCASE(SUBSTRING(SUBSTRING_INDEX(sl.email, '@', 1), 2))) AS user_name, 
                    sl.email,
                    d.department_name AS department,  
                    p.position_name AS position,    
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
                LEFT JOIN departments d ON sl.department = d.id  
                LEFT JOIN positions p ON sl.position = p.id
                LEFT JOIN inventory_returned ir ON ia.id = ir.assignment_id  
                WHERE sl.department IN (" . implode(',', array_fill(0, count($subDepartments), '?')) . ")  
                AND p.hierarchy_level IN (" . implode(',', $allowedLevels) . ")  
                AND ir.assignment_id IS NULL";
    
        $query = $this->db->prepare($sql);
        foreach ($subDepartments as $index => $deptId) {
            $query->bindValue($index + 1, $deptId, PDO::PARAM_INT);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    private function getSubDepartments($departmentId)
    {
        $sql = "WITH RECURSIVE sub_departments AS (
                    SELECT id FROM departments WHERE parent_id = :departmentId
                    UNION ALL
                    SELECT d.id FROM departments d
                    INNER JOIN sub_departments sd ON d.parent_id = sd.id
                ) 
                SELECT id FROM sub_departments";

        $query = $this->db->prepare($sql);
        $query->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $query->execute();
        return array_column($query->fetchAll(PDO::FETCH_ASSOC), 'id');
    }
    
    //hierachy access of returned items
    public function getReturnedItemsByHierarchy($loggedInEmail, $search = '')
    {
        try {

            $sql = "SELECT p.hierarchy_level, sl.department 
                    FROM staff_login sl
                    LEFT JOIN positions p ON sl.position = p.id
                    WHERE sl.email = :email";
    
            $query = $this->db->prepare($sql);
            $query->bindParam(':email', $loggedInEmail, PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_OBJ);
    
            if (!$user) {
                return []; 
            }
    
            $userLevel = (int) $user->hierarchy_level;
            $userDepartment = (int) $user->department;
    
            $subDepartments = $this->getSubDepartments($userDepartment);
            $subDepartments[] = $userDepartment;

            $allowedLevels = [];
            switch ($userLevel) {
                case 1: $allowedLevels = [2, 3, 4, 5]; break;
                case 2: $allowedLevels = [3, 4, 5]; break;
                case 3: $allowedLevels = [4, 5]; break;
                default: return []; 
            }

            $placeholders = implode(',', array_fill(0, count($subDepartments), '?'));
            $sql = "SELECT ir.id, i.description, i.serial_number, 
                            SUBSTRING_INDEX(sl.email, '@', 1) AS returned_by_name,  
                            ir.return_date, ir.status, 
                            SUBSTRING_INDEX(sl_receiver.email, '@', 1) AS receiver_name
                    FROM inventory_returned ir
                    INNER JOIN inventory_assignment ia ON ir.assignment_id = ia.id  
                    INNER JOIN inventory i ON ia.item = i.id  
                    INNER JOIN staff_login sl ON ir.returned_by = sl.email
                    INNER JOIN staff_login sl_receiver ON ir.receiver_id = sl_receiver.id  
                    INNER JOIN positions p ON sl.position = p.id
                    WHERE p.hierarchy_level IN (" . implode(',', $allowedLevels) . ") 
                    AND sl.department IN ($placeholders)
                    AND ir.returned_by != ?"; 
    

            if (!empty($search)) {
                $sql .= " AND (
                            i.description LIKE ? 
                            OR i.serial_number LIKE ? 
                            OR ir.status LIKE ?
                            OR SUBSTRING_INDEX(sl.email, '@', 1) LIKE ?
                        )";
            }
    
            $query = $this->db->prepare($sql);
    
            $params = array_merge($subDepartments, [$loggedInEmail]);
    
            if (!empty($search)) {
                $searchTerm = "%$search%";
                $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            }
    
            $query->execute($params);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }
    
    // downloading managers reports
    public function getAssignmentsForDownload($loggedInEmail)
    {
        $sql = "SELECT p.hierarchy_level AS position_level, d.id AS department_id
                FROM staff_login sl
                LEFT JOIN positions p ON sl.position = p.id
                LEFT JOIN departments d ON sl.department = d.id
                WHERE sl.email = :email";
    
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $loggedInEmail, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        if (!$user) {
            return [];
        }
    
        $userLevel = (int) $user->position_level;
        $userDepartment = (int) $user->department_id;
    
        $subDepartments = $this->getSubDepartments($userDepartment);
        $subDepartments[] = $userDepartment;  
    
        $allowedLevels = [];
        switch ($userLevel) {
            case 1:  
                $allowedLevels = [1, 2, 3, 4, 5, 6];
                break;
            case 2:  
                $allowedLevels = [3, 4, 5, 6];
                break;
            case 3:  
                $allowedLevels = [4, 5, 6];
                break;
            case 4:  
                $allowedLevels = [5, 6];
                break;
            default:
                return [];
        }
    
        $sql = "SELECT 
                    ia.id,
                    sl.email AS user_email,
                    d.department_name AS department,  
                    p.position_name AS position,    
                    i.category_id,
                    i.description,
                    ia.serial_number,
                    ia.tag_number,
                    ia.date_assigned,
                    ia.managed_by,
                    ia.acknowledgment_status,
                    ia.created_at
                FROM inventory_assignment ia
                LEFT JOIN inventory i ON ia.item = i.id
                LEFT JOIN staff_login sl ON ia.email = sl.email
                LEFT JOIN departments d ON sl.department = d.id  
                LEFT JOIN positions p ON sl.position = p.id
                LEFT JOIN inventory_returned ir ON ia.id = ir.assignment_id  
                WHERE sl.department IN (" . implode(',', array_fill(0, count($subDepartments), '?')) . ")  
                AND p.hierarchy_level IN (" . implode(',', $allowedLevels) . ")  
                AND ir.assignment_id IS NULL";
    
        $query = $this->db->prepare($sql);
        foreach ($subDepartments as $index => $deptId) {
            $query->bindValue($index + 1, $deptId, PDO::PARAM_INT);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getReturnedItemsForDownload($loggedInEmail)
    {
        try {

            $sql = "SELECT p.hierarchy_level, sl.department AS department_id
                    FROM staff_login sl
                    LEFT JOIN positions p ON sl.position = p.id
                    WHERE sl.email = ?";
    
            $query = $this->db->prepare($sql);
            $query->execute([$loggedInEmail]);
            $user = $query->fetch(PDO::FETCH_OBJ);
    
            if (!$user) {
                return [];
            }
    
            $userLevel = (int) $user->hierarchy_level;
            $userDepartment = (int) $user->department_id;

            $subDepartments = $this->getSubDepartments($userDepartment);
            $subDepartments[] = $userDepartment;

            $allowedLevels = [];
            switch ($userLevel) {
                case 1: $allowedLevels = [1, 2, 3, 4, 5, 6]; break;
                case 2: $allowedLevels = [3, 4, 5, 6]; break;
                case 3: $allowedLevels = [4, 5, 6]; break;
                case 4: $allowedLevels = [5, 6]; break;
                default: return [];
            }
    

            $placeholders = implode(',', array_fill(0, count($subDepartments), '?'));
            $sql = "SELECT ir.id, i.description, i.serial_number, 
                            SUBSTRING_INDEX(sl.email, '@', 1) AS returned_by_name,  
                            ir.return_date, ir.status, 
                            SUBSTRING_INDEX(sl_receiver.email, '@', 1) AS receiver_name
                    FROM inventory_returned ir
                    INNER JOIN inventory_assignment ia ON ir.assignment_id = ia.id  
                    INNER JOIN inventory i ON ia.item = i.id  
                    INNER JOIN staff_login sl ON ir.returned_by = sl.email
                    INNER JOIN staff_login sl_receiver ON ir.receiver_id = sl_receiver.id  
                    INNER JOIN positions p ON sl.position = p.id
                    WHERE sl.department IN ($placeholders)  
                    AND p.hierarchy_level IN (" . implode(',', $allowedLevels) . ")  
                    AND ir.returned_by != ?";
    

            $query = $this->db->prepare($sql);
            $params = array_merge($subDepartments, [$loggedInEmail]);
            $query->execute($params);
    
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<br><strong>SQL Exception:</strong> " . $e->getMessage());
        }
    }
    
    // Fetch the counts for the dashboards
    public function getItemStates()
    {
        $query = "
            SELECT 
                SUM(CASE 
                    WHEN ir.item_state = 'functional' AND ir.assignment_id IS NULL THEN 1
                    WHEN ir.item_state = 'functional' THEN 1
                    ELSE 0 
                END) AS functional,
                SUM(CASE 
                    WHEN ir.item_state = 'lost' THEN 1 
                    ELSE 0 
                END) AS lost,
                SUM(CASE 
                    WHEN ir.item_state = 'damaged' THEN 1 
                    ELSE 0 
                END) AS damaged
            FROM inventory_assignment ia
            LEFT JOIN inventory_returned ir ON ia.id = ir.assignment_id 
        ";
        
        $result = $this->db->query($query);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        
        return $data;
    }
    
    public function getInUseCount() {
        $sql = "SELECT COUNT(*) AS in_use_count
                FROM inventory_assignment ia
                LEFT JOIN inventory i ON ia.item = i.id
                LEFT JOIN inventory_returned ir ON ia.id = ir.assignment_id
                WHERE ir.assignment_id IS NULL 
                AND ia.acknowledgment_status = 'acknowledged'";
    
        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['in_use_count'];
    }
    
    public function getInStockCount() {
        $sql = "SELECT COUNT(*) AS in_stock_count
                FROM inventory i
                LEFT JOIN inventory_assignment ia ON i.id = ia.item
                LEFT JOIN inventory_returned ir ON ia.id = ir.assignment_id
                WHERE (ia.id IS NULL 
                        OR (ir.assignment_id IS NOT NULL 
                            AND (ir.item_state = 'functional' AND ir.status = 'approved')
                            OR (ir.item_state = 'damaged' AND ir.repair_status = 'Repairable'))
                       )";
    
        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['in_stock_count'];
    }
    
    public function getItemCountsByCategory() {
        $sql = "SELECT 
                    c.category AS category_name,
                    COUNT(i.id) AS item_count
                FROM inventory i
                LEFT JOIN categories c ON i.category_id = c.id
                GROUP BY c.category";
    
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function get_user_by_email($email)
    {
        $sql = "SELECT 
                    sl.*, 
                    d.department_name, 
                    p.position_name, 
                    CONCAT(loc.location_name, ' - ', o.office_name) as dutystation
                FROM staff_login sl
                LEFT JOIN departments d ON sl.department = d.id
                LEFT JOIN positions p ON sl.position = p.id
                LEFT JOIN offices o ON sl.dutystation = o.id
                LEFT JOIN locations loc ON o.location_id = loc.id
                WHERE sl.email = :email
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
     
}


