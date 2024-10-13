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
INSERT INTO admins (id, username, password)
VALUES (UUID(), 'admin', '$2y$10$ybOP3hulir7vLGAC4A8xUe9nAEAVnGZHsPWcdo7.EWUANkcKwFVLi'); -- Password: password123


-- Create table for simple user 

CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(50) PRIMARY KEY NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL DEFAULT 'user'
);
