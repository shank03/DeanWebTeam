# This file contains only the schemas to refer for queries

CREATE TABLE professor (
    employee_id INT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(10) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    date_of_join DATE NOT NULL
);

CREATE TABLE student (
    registration_number INT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    stream VARCHAR(255) NOT NULL,
    branch VARCHAR(255) NOT NULL,
    semester INT NOT NULL DEFAULT 1
);

CREATE TABLE course (
    course_code VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    semester INT NOT NULL,
    credits INT NOT NULL,
    branch VARCHAR(255) NOT NULL,
    stream VARCHAR(255) NOT NULL,
    course_type VARCHAR(255) NOT NULL
);

CREATE TABLE marks_dist_theory (
    course_code VARCHAR(255) PRIMARY KEY REFERENCES course(course_code),
    mid_semester_exam INT NOT NULL,
    end_semester_exam INT NOT NULL,
    teacher_assessment INT NOT NULL,
    semester INT NOT NULL,
    dist_year INT NOT NULL
);

CREATE TABLE marks_dist_practical (
    course_code VARCHAR(255) PRIMARY KEY REFERENCES course(course_code),
    practical INT NOT NULL,
    viva INT NOT NULL,
    lab_file INT NOT NULL,
    teacher_assessment INT NOT NULL,
    semester INT NOT NULL,
    dist_year INT NOT NULL
);

CREATE TABLE marks (
    course_code VARCHAR(255) NOT NULL,
    student_registration_number INT NOT NULL,
    mid_semester_exam INT NOT NULL DEFAULT 0,
    end_semester_exam INT NOT NULL DEFAULT 0,
    teacher_assessment INT NOT NULL DEFAULT 0,
    practical INT NOT NULL DEFAULT 0,
    viva INT NOT NULL DEFAULT 0,
    lab_file INT NOT NULL DEFAULT 0,
    semester INT NOT NULL DEFAULT 0,
    d_year INT NOT NULL DEFAULT 0,
    PRIMARY KEY (course_code,student_registration_number,semester),
    FOREIGN KEY (course_code) REFERENCES course(course_code),
    FOREIGN KEY (student_registration_number) REFERENCES student(registration_number)
);

CREATE TABLE professor_allotment (
    employee_id INT REFERENCES professor(employee_id),
    course_code VARCHAR(255) REFERENCES course(course_code),
    semester INT NOT NULL,
    d_year INT NOT NULL,
    PRIMARY KEY (employee_id,course_code,semester)
);

CREATE TABLE admin (
    password_hash VARCHAR(255) NOT NULL,
    course_entry boolean NOT NULL DEFAULT FALSE,
    grade_entry boolean NOT NULL DEFAULT FALSE
);

# Queries

# Change entry status
UPDATE admin SET course_entry = true, grade_entry = true;

INSERT INTO professor (employee_id, first_name, last_name, phone_number, email, password_hash, date_of_join)
VALUES (1116, 'Dr. Dushyant', 'Kumar Singh', '1234567890', 'dushyant@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01');

INSERT INTO course (course_code, name, semester, credits, branch, stream, course_type)
VALUES ('CS13101', 'Data Structures', 3, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS15101', 'Microprocessor and its Application', 5, 3, 'Computer Science', 'B.Tech'),
('CS15102', 'Operating Systems', 5, 4, 'Computer Science', 'B.Tech'),
('CS15103', 'Database Management System', 5, 4, 'Computer Science', 'B.Tech'),
('CS15104', 'Object Oriented Modeling', 5, 4, 'Computer Science', 'B.Tech'),
('CS15105', 'Operation Research', 5, 3, 'Computer Science', 'B.Tech'),
('CS15106', 'Computer Architecture', 5, 3, 'Computer Science', 'B.Tech'),
('CS15201', 'Systems Calls Lab', 5, 2, 'Computer Science', 'B.Tech'),
('CS15202', 'Microprocessor', 5, 2, 'Computer Science', 'B.Tech'),
('CS15203', 'Operating Systems', 5, 2, 'Computer Science', 'B.Tech'),
('CS15204', 'Database System', 5, 2, 'Computer Science', 'B.Tech');
