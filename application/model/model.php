<?php

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
    public function get_users(){
        $sql = "SELECT email, department, position, role FROM staff_login ";

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function insert_user($email, $department, $position, $role, $password = 'mle2025'){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO staff_login (email, department, position, role, password) 
                VALUES (:email, :department, :position, :role, :password)";
        $query = $this->db->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':department', $department, PDO::PARAM_NULL);
        $query->bindValue(':position', $position, PDO::PARAM_NULL);
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
}