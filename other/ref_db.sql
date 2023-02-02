# This file contains the schemas to refer for queries

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
    registration_number VARCHAR(255) PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    stream VARCHAR(255) NOT NULL,
    branch VARCHAR(255) NOT NULL,
    semester INT NOT NULL DEFAULT 1
);

CREATE TABLE course (
    course_code VARCHAR(255) NOT NULL,
    course_name VARCHAR(255) NOT NULL,
    semester INT NOT NULL,
    credits INT NOT NULL,
    branch VARCHAR(255) NOT NULL,
    stream VARCHAR(255) NOT NULL,
    course_type VARCHAR(255) NOT NULL,
    PRIMARY KEY (course_code, semester)
);

CREATE TABLE marks_distribution (
    course_code VARCHAR(255) NOT NULL,
    mid_semester_exam INT NOT NULL,
    end_semester_exam INT NOT NULL,
    teacher_assessment INT NOT NULL,
    semester INT NOT NULL,
    dist_year INT NOT NULL,
    PRIMARY KEY (course_code,semester,dist_year),
    FOREIGN KEY (course_code) REFERENCES course(course_code)
);

CREATE TABLE marks (
    course_code VARCHAR(255) NOT NULL,
    student_registration_number VARCHAR(255) NOT NULL,
    mid_semester_exam INT NOT NULL DEFAULT 0,
    end_semester_exam INT NOT NULL DEFAULT 0,
    teacher_assessment INT NOT NULL DEFAULT 0,
    points INT NOT NULL DEFAULT 0,
    semester INT NOT NULL DEFAULT 0,
    d_year INT NOT NULL DEFAULT 0,
    PRIMARY KEY (course_code,student_registration_number,semester,d_year),
    FOREIGN KEY (course_code) REFERENCES course(course_code),
    FOREIGN KEY (student_registration_number) REFERENCES student(registration_number)
);

CREATE TABLE semester_marks(
    student_registration_number VARCHAR(255) NOT NULL,
    semester INT NOT NULL,
    d_year INT NOT NULL,
    spi FLOAT NOT NULL DEFAULT 0,
    cpi FLOAT NOT NULL DEFAULT 0,
    PRIMARY KEY (student_registration_number,semester,d_year),
    FOREIGN KEY (student_registration_number) REFERENCES student(registration_number)
);

CREATE TABLE professor_allotment (
    employee_id INT NOT NULL,
    course_code VARCHAR(255) NOT NULL,
    branch VARCHAR(255) NOT NULL,
    semester INT NOT NULL,
    d_year INT NOT NULL,
    PRIMARY KEY (employee_id,course_code,semester,d_year),
    FOREIGN KEY (employee_id) REFERENCES professor(employee_id),
    FOREIGN KEY (course_code) REFERENCES course(course_code)
);

CREATE TABLE admin (
    employee_id INT NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    course_entry boolean NOT NULL DEFAULT FALSE,
    course_entered boolean NOT NULL DEFAULT FALSE,
    grade_entry boolean NOT NULL DEFAULT FALSE,
    grade_entered boolean NOT NULL DEFAULT FALSE,
    semester INT NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES professor(employee_id)
);

# Queries

# password -> '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu' -> '1234567'

# Change entry status
UPDATE admin SET course_entry = true, grade_entry = true;

# 3rd semester
INSERT INTO course (course_code, course_name, semester, credits, branch, stream, course_type)
VALUES ('CS13101', 'Data Structures', 3, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS13201', 'Object Oriented Programming', 3, 2, 'Computer Science', 'B.Tech', 'practical');

# 5th semester
INSERT INTO course (course_code, course_name, semester, credits, branch, stream, course_type)
VALUES ('CS15101', 'Microprocessor and its Application', 5, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS15102', 'Operating Systems', 5, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS15103', 'Database Management System', 5, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS15104', 'Object Oriented Modeling', 5, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS15105', 'Operation Research', 5, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS15106', 'Computer Architecture', 5, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS15201', 'Systems Calls Lab', 5, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS15202', 'Microprocessor', 5, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS15203', 'Operating Systems', 5, 2, 'Computer Science', 'B.Tech', 'practical'),
('CS15204', 'Database System', 5, 2, 'Computer Science', 'B.Tech', 'practical');

# 6th semester
INSERT INTO course (course_code, course_name, semester, credits, branch, stream, course_type)
VALUES ('CS16101', 'Embedded Systems', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16102', 'Compiler Construction', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16103', 'Data Mining', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16104', 'Cryptography & Network Security', 6, 3, 'Computer Science', 'B.Tech', 'theory'),
('CS16105', 'Computer Networks', 6, 4, 'Computer Science', 'B.Tech', 'theory'),
('CS16106', 'Software Engineering', 6, 3, 'Computer Science', 'B.Tech', 'theory');

# M.Tech
INSERT INTO course (course_code, course_name, semester, credits, branch, stream, course_type)
VALUES ('CS21101', 'Data Science: Concepts and Methodologies', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'theory'),
('CS21201', 'Programming Lab - 1', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'practical'),
('CS21202', 'Programming Lab - 2', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'practical'),
('CS22201', 'Machine Learning', 5, 4, 'Computer Science and Engineering', 'M.Tech', 'theory');

INSERT INTO student (registration_number, first_name, last_name, email, password_hash, stream, branch, semester)
VALUES ('20204022', 'Amit', 'Kumar', 'amit.20204022@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204085', 'Hitesh', 'Mitruka', 'hitesh.20204085@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204120', 'Naman', 'Aggrawal', 'naman.20204120@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204156', 'Priyav', 'Kaneria', 'priyav.20204156@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204176', 'Sanskar', 'Omar', 'sanskar.20204176@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('20204184', 'Shashank', 'Verma', 'shashank.20204184@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'B.Tech', 'Computer Science', 5),
('2018PR01', 'Saurabh', 'last_name', 'saurabh@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'M.Tech', 'Computer Science and Engineering', 5),
('2018MT11', 'Ankur', 'last_name', 'saurabh@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 'M.Tech', 'Computer Science and Engineering', 5);

INSERT INTO professor (employee_id, first_name, last_name, phone_number, email, password_hash, date_of_join)
VALUES (1116, 'Dr. Dushyant', 'Kumar Singh', '1234567890', 'dushyant@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1111, 'Dr. Ranvijay', 'Singh', '1234567890', 'ranvijay@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1112, 'Lt. (Dr.) Divya', 'Kumar', '1234567890', 'divya@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1113, 'Dr. Mayank', 'Pandey', '1234567890', 'mayank@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1114, 'Prof. Neeraj', 'Tyagi', '1234567890', 'neeraj@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1115, 'Dr. Dinesh', 'Singh', '1234567890', 'dinesh@mnnii.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1117, 'Dr. Shashwati', 'Banerjea', '1234567890', 'shashwati@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01'),
(1118, 'Dr. Srasij', 'Tripathi', '1234567890', 'sarsij@mnnit.ac.in', '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', '2010-01-01');

INSERT INTO admin (employee_id, password_hash, course_entry, course_entered, grade_entry, grade_entered, semester)
VALUES (1116, '$2y$12$NQjkpTMrmkCcOynIgiHiG.VRmzIMCEMxKsFLuvEkRYYequD2V4GNu', 0, 0, 5);
