CREATE DATABASE IF NOT EXISTS student_directory;
USE student_directory;

DROP PROCEDURE IF EXISTS search_students;
DROP TABLE IF EXISTS students;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100)
);

INSERT INTO students (first_name, last_name, email) VALUES
('James', 'Anderson', 'james.anderson@example.com'),
('Sarah', 'Williams', 'sarah.williams@example.com'),
('Michael', 'Johnson', 'michael.johnson@example.com'),
('Emily', 'Brown', 'emily.brown@example.com'),
('David', 'Davis', 'david.davis@example.com');

DELIMITER //

CREATE PROCEDURE search_students(IN lName VARCHAR(50))
BEGIN
    SELECT * FROM students
    WHERE last_name LIKE CONCAT(lName, '%');
END //

DELIMITER ;
