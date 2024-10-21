-- Use the database
USE my_dbase;

-- Create table for personal information
CREATE TABLE IF NOT EXISTS personal_info (
    id VARCHAR(50) PRIMARY KEY NOT NULL,
    id_user VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) UNIQUE NOT NULL,
    title VARCHAR(150) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    profile_description TEXT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (email) REFERENCES users(email),
    FOREIGN KEY (phone) REFERENCES users(phone)
);

-- Insert default data

-- Create a table for admin login credentials
CREATE TABLE IF NOT EXISTS admins (
    id VARCHAR(50) PRIMARY KEY NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'admin'
);

-- Insert an admin user (the password should be hashed using PHP's password_hash('password123', PASSWORD_DEFAULT) function)
-- Password: password123

-- Create table for simple user 

CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(50) PRIMARY KEY NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS style_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(50),
    background1 VARCHAR(100),
    background2 VARCHAR(100),
    background3 VARCHAR(100),
    border VARCHAR(100),
    title_color_right VARCHAR(100),
    title_color_left VARCHAR(100),
    name_color VARCHAR(100),
    p_color_L VARCHAR(100),
    p_color_R VARCHAR(100),
    subtitle_color VARCHAR(100),
    admin_id VARCHAR(50),
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_user) REFERENCES admin(id)
);

ALTER TABLE style_settings
MODIFY COLUMN user_id VARCHAR(50) NULL,  -- Allow user_id to be NULL
MODIFY COLUMN admin_id VARCHAR(50) NULL;


-- Create table for projects

CREATE TABLE IF NOT EXISTS projects (
    id VARCHAR(50) PRIMARY KEY NOT NULL,
    user_id VARCHAR(50),
    admin_id VARCHAR(50),
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,  
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (admin_id) REFERENCES admins(id)
);

