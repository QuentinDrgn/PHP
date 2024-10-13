<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    // The table associated with the model
    protected $table = 'users';
    
    // The primary key of the table
    protected $primaryKey = 'id';
    
    // Allowed fields for insert/update
    protected $allowedFields = ['name', 'email', 'password'];
    
    // Whether the model should return results as arrays or objects
    protected $returnType = 'array';
    
    // Enable timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Example: Defining custom methods
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
