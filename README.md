# lou-geh-library-system

Here the steps to run the Lou Geh library System

step 1: download the file and put it to file location C:\xampp\htdocs

step 2: Start your SQL and Apache and open this URL http://localhost/phpmyadmin/

Step 3: run this SQL script to create the database and tables

-- Create Database
CREATE DATABASE IF NOT EXISTS library_db;

-- Use the newly created database
USE library_db;

-- Create Books Table
CREATE TABLE IF NOT EXISTS books (
isbn VARCHAR(20) PRIMARY KEY,
title VARCHAR(255) NOT NULL,
author VARCHAR(255) NOT NULL,
publication_year YEAR,
number_of_pages INT,
publisher_id INT,
categories TEXT,
book_image VARCHAR(255)
);

-- Create Book Copies Table
CREATE TABLE IF NOT EXISTS book_copies (
copy_id INT AUTO_INCREMENT PRIMARY KEY,
isbn VARCHAR(20),
shelf_location VARCHAR(255),
availability ENUM('available', 'borrowed', 'reserved') DEFAULT 'available',
FOREIGN KEY (isbn) REFERENCES books(isbn) ON DELETE CASCADE
);

-- Create Borrow Records Table
CREATE TABLE IF NOT EXISTS borrow_records (
borrow_id INT AUTO_INCREMENT PRIMARY KEY,
reader_id INT,
copy_id INT,
borrow_date DATE NOT NULL,
due_date DATE NOT NULL,
return_date DATE,
status ENUM('borrowed', 'returned') DEFAULT 'borrowed',
FOREIGN KEY (reader_id) REFERENCES readers(reader_id),
FOREIGN KEY (copy_id) REFERENCES book_copies(copy_id)
);

-- Create Categories Table
CREATE TABLE IF NOT EXISTS categories (
category_id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
parent_category_id INT DEFAULT NULL,
FOREIGN KEY (parent_category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);

-- Create Publishers Table
CREATE TABLE IF NOT EXISTS publishers (
publisher_id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
location VARCHAR(255)
);

-- Create Readers Table
CREATE TABLE IF NOT EXISTS readers (
reader_id INT AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
city VARCHAR(255),
date_of_birth DATE
);

Step 4: Open this URL http://localhost/my-app/

Step 5. Enjoy!
