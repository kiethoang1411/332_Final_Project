CREATE TABLE Professor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ssn VARCHAR(9) UNIQUE,
    name VARCHAR(64) NOT NULL,
    address VARCHAR(128) NOT NULL,
    telephone VARCHAR(16) NOT NULL,
    sex CHAR(1) NOT NULL,				# M, F
    title VARCHAR(64) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    degrees VARCHAR(128) NOT NULL
);

-- Create table for departments
CREATE TABLE Department (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    telephone VARCHAR(16) NOT NULL,
    office VARCHAR(128) NOT NULL,
    chairperson INT NOT NULL,
    FOREIGN KEY (chairperson) REFERENCES Professor(id)
);

-- Create table for courses
CREATE TABLE Course (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(64) NOT NULL,
    textbook VARCHAR(128) NOT NULL,
    units INT NOT NULL,
    dept_id INT NOT NULL,
    FOREIGN KEY (dept_id) REFERENCES Department(id)
);

-- Create table for course sections
CREATE TABLE Section (
    id INT NOT NULL,
    course_id INT NOT NULL,
    classroom VARCHAR(64) NOT NULL,
    seats INT NOT NULL,
    meeting_days VARCHAR(3) NOT NULL,				# U (Sunday), M, T, W, R, F, S (saturday)
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    professor_id INT NOT NULL,
    PRIMARY KEY (course_id, id),
    FOREIGN KEY (course_id) REFERENCES Course(id),
    FOREIGN KEY (professor_id) REFERENCES Professor(id)
);

-- Create table for students
CREATE TABLE Student (
    id VARCHAR(16) PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    address VARCHAR(128) NOT NULL,
    telephone VARCHAR(16) NOT NULL,
    major_id INT NOT NULL,
    FOREIGN KEY (major_id) REFERENCES Department(id)
);

CREATE TABLE Minor (
	dept_id INT NOT NULL,
    student_id VARCHAR(64) NOT NULL,
    FOREIGN KEY (dept_id) REFERENCES Department(id),
    FOREIGN KEY (student_id) REFERENCES Student(id)
);

-- Create table for enrollments
CREATE TABLE Enrollment (
    campus_id VARCHAR(16) NOT NULL,
    course_id INT NOT NULL,
    section_id INT NOT NULL,
    grade CHAR(2) NOT NULL,
    PRIMARY KEY (campus_id, course_id, section_id),
    FOREIGN KEY (campus_id) REFERENCES Student(id),
    FOREIGN KEY (course_id, section_id) REFERENCES Section(course_id, id)
);

-- Create table for course prerequisites
CREATE TABLE Prerequisite (
    course_id INT NOT NULL,
    prereq_course_id INT NOT NULL,
    PRIMARY KEY (course_id, prereq_course_id),
    FOREIGN KEY (course_id) REFERENCES Course(id),
    FOREIGN KEY (prereq_course_id) REFERENCES Course(id)
);



-- sample Profs
INSERT INTO `Professor` 
VALUES 
	(1,'111111111', 'Yann LeCunn', '101 5th Avenue', '(650) 678-8463', 'M', 'Professor', 90000.00, 'PhD Computer Science'),
	(2,'222222222', 'Sarah Cauchy','40 6th Avenue', '(567) 756-7363', 'F', 'Assistant Professor', 70000.00, 'PhD Mathematics'),
	(3,'333333333', 'Albert Einstein', '250 8th Avenue', '(747) 737-3717', 'M','Associate Professor', 80000.00, 'PhD Physics');

-- sample Departments
INSERT INTO `Department` 
VALUES 
	(1, 'Computer Science', '(888) 101-7466', '10, Science Building', 1),
	(2, 'Mathematics', '(880) 976-8017', '32, Math Building', 2);

-- Sample courses
INSERT INTO Course (title, textbook, units, dept_id)
VALUES
	('Intro to Computer Science', 'Computer Science Fundamentals', 3, 1),
	('Algorithms', 'Algorithm Design', 3, 1),
	('Calculus A', 'Calculus: Early Transcendentals', 4, 2),
	('Linear Algebra', 'Linear Algebra for Dummies', 3, 2);

-- sample students
INSERT INTO Student (id, name, address, telephone, major_id)
VALUES
	('00000001', 'Natasha Romanoff', '123 Main St', '(658) 847-3738', 1),
	('00000002', 'Eliz Olsen', '54 10th Ave', '(373) 847-2819', 2),
	('00000003', 'Dane Webber', '784 5th Ave', '(716) 727-2872', 1),
	('00000004', 'Miles Morales', '89 6th Ave', '(326) 646-2716', 1),
	('00000005', 'Peter Parker', '10 10th Ave', '(362) 726-3723', 2),
	('00000006', 'Tony Stark', '69 8th Ave', '(262) 696-2928', 1),
	('00000007', 'Bruce Banner', '30 3th Ave', '(363) 837-2727', 1),
	('00000008', 'Steve Rogers', '9 Walnut Ave', '(262) 262-3282', 2);

-- sample sections
INSERT INTO Section (id, course_id, classroom, seats, meeting_days, start_time, end_time, professor_id)
VALUES
  (1, 1, 'Room A', 30, 'MW', '09:00:00', '10:30:00', 1),
  (2, 1, 'Room B', 25, 'TR', '11:00:00', '12:30:00', 2),
  (1, 2, 'Room C', 20, 'WF', '13:00:00', '14:30:00', 3),
  (2, 2, 'Room D', 15, 'MWF', '10:00:00', '11:30:00', 3),
  (1, 3, 'Room E', 30, 'TR', '14:00:00', '15:30:00', 2),
  (1, 4, 'Room F', 25, 'MW', '13:00:00', '14:30:00', 1);

-- sample enrollment
INSERT INTO Enrollment (campus_id, course_id, section_id, grade)
VALUES
	('00000001', 1, 1, 'A'),
	('00000003', 1, 1, 'B+'),
	('00000002', 1, 1, 'C'),
	('00000006', 1, 1, 'A-'),
	('00000004', 1, 1, 'B'),
	('00000003', 3, 1, 'B+'),
	('00000004', 3, 1, 'A-'),
	('00000007', 3, 1, 'B+'),
	('00000001', 4, 1, 'A'),
	('00000005', 4, 1, 'B+'),
	('00000007', 2, 1, 'C+'),
	('00000002', 2, 2, 'B-'),
	('00000003', 2, 1, 'C'),
	('00000008', 2, 2, 'C-'),
	('00000001', 3, 1, 'B'),
	('00000004', 4, 1, 'A'),
	('00000006', 2, 2, 'A-'),
	('00000008', 1, 1, 'B+'),
	('00000006', 2, 1, 'A'),
	('00000005', 3, 1, 'B+');