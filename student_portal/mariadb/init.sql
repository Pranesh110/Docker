CREATE DATABASE IF NOT EXISTS student_db;

USE student_db;

CREATE TABLE IF NOT EXISTS students (
    reg_no VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    student_id VARCHAR(50) NOT NULL
);

INSERT INTO students (reg_no, name, age, student_id)
VALUES
('REG001', 'Arun Kumar', 21, 'STU001'),
('REG002', 'Priya Sharma', 22, 'STU002'),
('REG003', 'Rahul Kumar', 20, 'STU003');