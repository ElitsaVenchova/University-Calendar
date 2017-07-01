-- TODO: �� �� ������� ��� �� �� �������� ���� �� �������� ����� ���� (���-�������� �� ������� ���� �� ��������� � �� � ���_��_����������)
-- TODO: �� �� �������� �������� �� ����� �� ���������� (��� ���� �������, �� ���� �� ��� ������ � �� ����� �����)

-- � ������ ���� ������� check constraints, ������ � mySQL ����� �� �� ��������, �� ������ �� �� ��������. 
DROP DATABASE IF EXISTS UniversityCalender;
CREATE DATABASE IF NOT EXISTS UniversityCalender;
ALTER SCHEMA UniversityCalender DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE UniversityCalender;

CREATE TABLE IF NOT EXISTS NOM_DEGREES(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	description VARCHAR (1024) COMMENT '��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
    PRIMARY KEY NOM_DEGREE_id_pk (id),
	CONSTRAINT NOM_DEGREE_name_uk UNIQUE (name)
) COMMENT = '������������ �� ��������� �� ����������� (���������, �������� �.�';

CREATE TABLE IF NOT EXISTS NOM_STUDY_PROGRAMS(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	degree_id MEDIUMINT not null COMMENT '������',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	description VARCHAR (1024) COMMENT '��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
    PRIMARY KEY NOM_STUDY_PROGRAM_id_pk (id),
	CONSTRAINT NOM_STUDY_PROGRAM_name_uk UNIQUE (name),
	FOREIGN KEY NOM_STUDY_PROGRAM_degree_fk (degree_id) REFERENCES NOM_DEGREES(ID)
) COMMENT = '����������� �� ��������������';

CREATE TABLE IF NOT EXISTS nom_Cathedrals(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	description VARCHAR (500) COMMENT '��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
    PRIMARY KEY nom_Cathedral_pk (id),
	CONSTRAINT nom_cathedral_name_uk UNIQUE(name)
) COMMENT = '������������ �� ���������';

CREATE TABLE IF NOT EXISTS sys_users(
	username VARCHAR (80) NOT NULL COMMENT '������������� ���',
	password VARCHAR (80) NOT NULL COMMENT '������',
    first_name VARCHAR (50) NOT NULL COMMENT '���',
	surname VARCHAR (50) COMMENT '�������',
	last_name VARCHAR (50) NOT NULL COMMENT '������',
	title VARCHAR (50) COMMENT '����� (���., ����. � �.�.)',
	adress VARCHAR (350) COMMENT '�����',
	telefon_number VARCHAR (50) COMMENT '��������� �����',
	email VARCHAR (150) not null COMMENT '�����',
	visiting_time VARCHAR (450) COMMENT '�������� ���� �� ��������� �� ������� ����� �� �������������',
	cabinet VARCHAR (80) COMMENT '�������, ���� ���� �� ���� ������� �������������',
	rownumber VARCHAR (30) COMMENT '���������� �����',
	cathedral_id MEDIUMINT COMMENT '�������',
	study_program_id MEDIUMINT COMMENT '����������� �� �������',
	adm_group INTEGER COMMENT '��������������� ����� �� �������',
	year_at_university INTEGER COMMENT '����',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
	notes VARCHAR (500) COMMENT '������������ �������',
    PRIMARY KEY sys_users_pk (username),
	CONSTRAINT sys_user_username_uk UNIQUE(username),
	FOREIGN KEY sys_user_study_program_fk (study_program_id) REFERENCES NOM_STUDY_PROGRAMS(ID),
	FOREIGN KEY sys_users_cathedral_fk (cathedral_id) REFERENCES nom_Cathedrals(ID)
) COMMENT = '�����������';

CREATE TABLE IF NOT EXISTS Publications(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	title VARCHAR (255) NOT NULL COMMENT '��������',
	year INTEGER COMMENT '������ �� �����������',
	publication BLOB COMMENT '������ � ������������',
	PRIMARY KEY Publication_pk (id)
) COMMENT = '����������';

CREATE TABLE IF NOT EXISTS Sys_users_publications(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	author VARCHAR (80) NOT NULL COMMENT '�����',
	publication_id MEDIUMINT NOT NULL COMMENT '����������',
	PRIMARY KEY sys_user_publication_pk (id),
	FOREIGN KEY sys_user_public_author_fk (author) REFERENCES sys_users(username),
	FOREIGN KEY sys_user_public_public_fk(publication_id) REFERENCES Publications(ID),
	CONSTRAINT sys_usr_publs_uk UNIQUE(author, publication_id)
) COMMENT = '������ �� ����������';

CREATE TABLE IF NOT EXISTS sys_Roles(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	code VARCHAR (50) NOT NULL COMMENT '���',
	name VARCHAR (100) NOT NULL COMMENT '���',
	description VARCHAR (255) COMMENT '����������� ��������',
	PRIMARY KEY sys_Role_pk (id),
	INDEX sys_Roles_code_ind (code),
	CONSTRAINT sys_Roles_code_uk UNIQUE(code)
) COMMENT = '���� � ���������';

CREATE TABLE IF NOT EXISTS sys_users_roles(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	username VARCHAR (80) NOT NULL COMMENT '����������',
	role VARCHAR (50) NOT NULL COMMENT '����',
	PRIMARY KEY sys_user_role_pk (id),
	CONSTRAINT sys_users_roles_uk UNIQUE(role, username),
	FOREIGN KEY sys_users_roles_username_fk (username) REFERENCES sys_users(username),
	FOREIGN KEY sys_users_roles_role_fk (role) REFERENCES sys_Roles(code)
) COMMENT = '������������� ����';

CREATE TABLE IF NOT EXISTS nom_Course_categories(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	description VARCHAR (1024) COMMENT '��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
    PRIMARY KEY nom_Course_category_type_pk (id),
	CONSTRAINT nom_Course_category_types_name_uk UNIQUE(name)
) COMMENT = '����������� �� ������ �� ��������� (�, ��, ���, ��� � �.�.)';

CREATE TABLE IF NOT EXISTS nom_Semester_types(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	description VARCHAR (500) COMMENT '������������ ��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
    PRIMARY KEY nom_Semester_type_pk (id),
	CONSTRAINT nom_Semester_types_name_uk UNIQUE(name)
) COMMENT = '������������ �� �������� �������� (�����, �����, ����� �������� � �.�.)';

CREATE TABLE IF NOT EXISTS nom_Session_types(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	description VARCHAR (500) COMMENT '������������ ��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
    PRIMARY KEY nom_Session_type_pk (id),
	CONSTRAINT nom_Session_typesHide_name_uk UNIQUE(name)
) COMMENT = '����������� �� �������� ����� (�����, �����, ������ � �.�.)';

CREATE TABLE IF NOT EXISTS Courses(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	type VARCHAR (1) NOT NULL DEFAULT 'E' COMMENT '��� �� �����(E - elective, R - require)',
	category_id  MEDIUMINT not null COMMENT '��� �� ����',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	credits INTEGER NOT NULL COMMENT '���� �������',
	sign_key VARCHAR (255) COMMENT '���� �� �����',
	semester_type_id MEDIUMINT NOT NULL COMMENT '��� �� ���������, ���� ����� �� ���� �����',
	max_students INTEGER COMMENT '���������� ���� ��������, ����� ����� �� ������� �����',
	description VARCHAR (500) COMMENT '��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
	PRIMARY KEY Course_pk (id),
	FOREIGN KEY Courses_type_fk (category_id) REFERENCES nom_Course_categories(ID),
	FOREIGN KEY Courses_sem_type_fk (semester_type_id) REFERENCES nom_Semester_types(ID)
) COMMENT = '�������';

CREATE TABLE IF NOT EXISTS Course_restrictions(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	study_program_id MEDIUMINT NOT NULL COMMENT '�����������',
	course_id MEDIUMINT NOT NULL COMMENT '����, �� ����� �� ������� �������������',
	year_at_university INTEGER NOT NULL COMMENT 'K��� � ������������',
	PRIMARY KEY Course_restriction_id_pk (id),
	CONSTRAINT Course_restriction_course_program_uk UNIQUE(course_id, study_program_id, year_at_university),
	FOREIGN KEY Course_restriction_course_fk (course_id) REFERENCES Courses(id),
	FOREIGN KEY Course_restriction_study_program_fk (study_program_id) REFERENCES NOM_STUDY_PROGRAMS(ID)
) COMMENT = '����������� �� ���� (��� ������������ � ������� ����� �� �� �������)';

CREATE TABLE IF NOT EXISTS Grades(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	year INTEGER not null COMMENT '������ �� ����������',
	course_id MEDIUMINT NOT NULL COMMENT '����, � ����� � ��������',
	session_type_id MEDIUMINT NOT NULL COMMENT '��� �� �������, ���� ����� � ��������',
	grade DECIMAL(6,5) COMMENT '������',
	credits INTEGER NOT NULL COMMENT '�������� �������',
	student VARCHAR (80) NOT NULL COMMENT '����������, �� ������ � ��������',
	PRIMARY KEY Grades_pk (id),
	CONSTRAINT  Grades_student_uk UNIQUE(course_id, student),
	FOREIGN KEY Grades_student_fk (student) REFERENCES sys_users(username),
	FOREIGN KEY Grades_course_fk (course_id) REFERENCES Courses(ID),
	FOREIGN KEY Grades_Session_type_fk (session_type_id) REFERENCES nom_Session_typesHide(ID)
) COMMENT = '������';

CREATE TABLE IF NOT EXISTS Courses_students(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	student VARCHAR (80) NOT NULL COMMENT '����������, ����� � ������� �����',
	course_id MEDIUMINT NOT NULL COMMENT '����, ����� � ������� �����������',
	year INTEGER NOT NULL COMMENT '������, ���� ����� � ������� �����',
	semester_type_id MEDIUMINT NOT NULL COMMENT '��� �� ���������, �� ����� � ������� �����',
	status VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '������ �� ����� (R - recored, E - elective, W - waiting, M - marked)',
	request_time DATETIME COMMENT '���� � ���, � ����� � ������ �����. �������� �� �������� ���� �� �������� �� ������� ����.',
	PRIMARY KEY Course_student_pk (id),
	CONSTRAINT Courses_students_cour_stud_uk UNIQUE(student, course_id),
	FOREIGN KEY Courses_students_student_fk (student) REFERENCES sys_users(username),
	FOREIGN KEY Courses_students_course_fk (course_id) REFERENCES Courses(ID),
	FOREIGN KEY Courses_students_sem_type_fk (semester_type_id) REFERENCES nom_Semester_types(ID)
) COMMENT = '�������� ��� �������';

CREATE TABLE IF NOT EXISTS Courses_teachers(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	teacher VARCHAR (80) NOT NULL COMMENT '����������, ����� ���� �����',
	course_id MEDIUMINT NOT NULL COMMENT '����, ����� �� ���� �� �����������',
	year INTEGER NOT NULL COMMENT '������, ���� ����� � ����� �����',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
	PRIMARY KEY Course_techer_pk (id),
	CONSTRAINT Courses_teachers_cour_teach_uk UNIQUE(teacher, course_id),
	FOREIGN KEY Courses_teachers_teacher_fk (teacher) REFERENCES sys_users(username),
	FOREIGN KEY Courses_teachers_course_fk (course_id) REFERENCES Courses(ID)
) COMMENT = '����������� ��� �������';

CREATE TABLE IF NOT EXISTS News(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	publisher VARCHAR (80) NOT NULL COMMENT '����������, ����� � �������� ��������',
	publish_date date not null COMMENT '���� �� �����������',
	title VARCHAR (255) NOT NULL COMMENT '�������� �� ��������',
	content BLOB COMMENT '����������',
	PRIMARY KEY News_pk (id),
	FOREIGN KEY News_publisher_fk (publisher) REFERENCES sys_users(username)
) COMMENT = '������';

CREATE TABLE IF NOT EXISTS nom_Room_types(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT '������ ������������',
	name VARCHAR (255) NOT NULL COMMENT '����� ������������',
	description VARCHAR (500) COMMENT '��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
    PRIMARY KEY nom_Room_type_pk (id),
	CONSTRAINT nom_Room_typesHide_name_uk UNIQUE(name)
) COMMENT = '������������ �� �������� ���� (���������� ���� � �.�.)';

CREATE TABLE IF NOT EXISTS Rooms(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	num VARCHAR (20) NOT NULL COMMENT '����� �� ������',
	place VARCHAR (20) NOT NULL COMMENT '���� �� ������ ������ (��������, ��� � � ���� ��������)',
	type_id MEDIUMINT NOT NULL COMMENT '��� �� ������',
	work_stations INTEGER COMMENT '���� ������� �����',
	description VARCHAR (1024) COMMENT '������������ ��������',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� �� ���������',
	PRIMARY KEY Room_pk (id),
	FOREIGN KEY Rooms_type_fk (type_id) REFERENCES nom_Room_typesHide(ID)
) COMMENT = '����, � ����� ����� �� �� ��������� �������';

CREATE TABLE IF NOT EXISTS Master_Events(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	creator VARCHAR (80) NOT NULL COMMENT '����������, ����� � ������ ���������',
	event_Type VARCHAR (1) not null COMMENT '��� �� ������(O - one-time, P - periodic)',
	is_accept VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT '���� ���� � �������� ��������',
	course_id MEDIUMINT NOT NULL COMMENT '����, �� ����� �� ������ ���������',
	PRIMARY KEY Master_event_pk (id),
	FOREIGN KEY Master_event_creator_fk (creator) REFERENCES sys_users(username),
	FOREIGN KEY Master_event_course_fk (course_id) REFERENCES Courses(ID)
) COMMENT = '������� �������� ������ �� ���������(����������, ����������), ����� �� ����� ��� ��������';

CREATE TABLE IF NOT EXISTS Child_Events(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	master_id MEDIUMINT NOT NULL COMMENT '���������� �����',
	room_id MEDIUMINT NOT NULL COMMENT '����� �� ���������� �� ���������',
	class_date DATE NOT NULL COMMENT '���� �� ���������� �� ���������',
	from_hour TIME  NOT NULL COMMENT '�� ���',
	to_hour TIME  NOT NULL COMMENT '�� ���',
	title VARCHAR (80) NOT NULL COMMENT '�������� �� ���������',
	description VARCHAR (1024) COMMENT '������������ ��������',
	PRIMARY KEY Child_event_pk (id),
	FOREIGN KEY Child_event_master_fk (master_id) REFERENCES Master_Events(ID),
	FOREIGN KEY Child_event_room_fk (room_id) REFERENCES Rooms(ID)
) COMMENT = '������������ ������ �� ��������';

CREATE TABLE IF NOT EXISTS Event_view_groups(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	master_event_id MEDIUMINT NOT NULL COMMENT '������ �������',
	type VARCHAR (3) NOT NULL COMMENT '��� �� ������� (A-all, S-students, T-teachers, ST-student-teachers)',
	course_id MEDIUMINT NOT NULL COMMENT '����, ����� �� �������� ���� ����',
	year_at_university INTEGER COMMENT '������ � ������������',
	degree_id MEDIUMINT not null COMMENT '������ �� �����������',
	cathedral_id MEDIUMINT NOT NULL COMMENT '�������',
	study_program_id MEDIUMINT COMMENT '����, �������� � �����������',
	PRIMARY KEY Event_view_group_pk (id),
	FOREIGN KEY Event_view_group_course_fk (course_id) REFERENCES Courses(ID),
	FOREIGN KEY Event_view_group_degree_fk (degree_id) REFERENCES NOM_DEGREES(ID),
	FOREIGN KEY Event_view_group_program_fk (study_program_id) REFERENCES NOM_STUDY_PROGRAMS(ID),
	FOREIGN KEY Event_view_group_cathedral_fk (cathedral_id) REFERENCES nom_Cathedrals(ID)
) COMMENT = '������� ����������� �� ����, ����� ����� �� ������ ���������';

CREATE TABLE IF NOT EXISTS Event_view_users(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	type VARCHAR (1) NOT NULL COMMENT '��� �� ������������ (��� � ���� ���������)(C-creator, S-self)',
	master_event_id MEDIUMINT NOT NULL COMMENT '������ �������',
	username VARCHAR (80) NOT NULL COMMENT '����������, ����� � ��� ������� ��� ��������� �� ���������',
	direction VARCHAR (1) NOT NULL COMMENT '������ �� ������������ �� �����������(I-in, O-out).',
	PRIMARY KEY Event_view_user_pk (id),
	CONSTRAINT Event_view_user_master_event_uk UNIQUE(master_event_id, username, direction),
	FOREIGN KEY Event_view_user_master_event_fk (master_event_id) REFERENCES Master_Events(ID),
	FOREIGN KEY Event_view_user_person_fk (username) REFERENCES sys_users(username)
) COMMENT = '���� �� ������������ �� ���� (��������), ����� �� �������� � ���������� �� �������';

-- ����� �� ������
INSERT INTO NOM_DEGREES (short_name, name, description, is_active)
	values('Bachelor', '���������', '���������', 'Y');
INSERT INTO NOM_DEGREES (short_name, name, description, is_active)
	values('Master', '��������', '��������', 'Y');
INSERT INTO NOM_DEGREES (short_name, name, description, is_active)
	values('Phd', '������������', '������������', 'Y');

INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'SI', '��������� �����������', '��������� �����������', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'IS', '������������� �������', '������������� �������', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'KN', '���������� �����', '���������� �����', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'I', '�����������', '�����������', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(2, 'IT', '��������� ��������', '��������� ��������', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(2, 'DM', 'Data mining', 'Data mining', 'Y');

INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('SS', '���������� � ����������', '���������� � ����������', 'Y');
INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('I', '�����������', '�����������', 'Y');
INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('PM', '�������� ����������', '�������� ����������', 'Y');
INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('SI', '��������� �����������', '��������� �����������', 'Y');

insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('evenchova', '1','�����','�������', '�������', '','�����','08*********','mail@mail.mail', '', null, 61807, null,1,5,3,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('nsignatova', '','�������','������', '���������', '','�����','08*********','mail@mail.mail', '', null, 61767, null,1,5,3,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('mpetrov', '','�����','', '������', '���.','�����','08*********','mail@mail.mail', '����� 10:00-12:00 ��� ���.200', 200, null, 4,null,null,null,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('ldilov', '','�����','', '�����', '','�����','08*********','mail@mail.mail', '', null, null, 4,5,1,1,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('ssekretar', '','��������','', '��������', '�-��','�����','08*********','mail@mail.mail', '���, ���� 120, 8:30-16:30, ������ ������� 12:00-13:00', 120, null, null,null,null,null,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('aadmin', '','�����','', '�����', '�-�', '�����', '08*********', 'mail@mail.mail', '', null, null, null,null,null,null,'Y',null);

INSERT INTO nom_Semester_types (short_name, name, description, is_active)
	values('W', '����� ��������', '����� ��������', 'Y');
INSERT INTO nom_Semester_types (short_name, name, description, is_active)
	values('S', '����� ��������', '����� ��������', 'Y');

INSERT INTO nom_Session_typesHide (short_name, name, description, is_active)
	values('W', '������ �����', '������ �����', 'Y');
INSERT INTO nom_Session_typesHide (short_name, name, description, is_active)
	values('S', '����� �����', '����� �����', 'Y');
INSERT INTO nom_Session_typesHide (short_name, name, description, is_active)
	values('A', '������ �����', '������ �����', 'Y');

INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('QKN', '���', '���� �� ������������ �����', 'Y');
INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('OKN', '���', '������ �� ������������ �����', 'Y');
INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('PM', '��', '�������� ����������', 'Y');
INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('M', '�', '����������', 'Y');

INSERT INTO nom_Room_typesHide (short_name, name, description, is_active)
	values('COMPUTER', '���������� ����', '���������� ����', 'Y');
INSERT INTO nom_Room_typesHide (short_name, name, description, is_active)
	values('AUDITOR', '���������', '���������', 'Y');
INSERT INTO nom_Room_typesHide (short_name, name, description, is_active)
	values('EXERCISE', '���� �� ����������', '���� �� ����������', 'Y');

INSERT INTO sys_Roles (code,name, description)
values ('ADMIN', '�����', '����� �� ������������');
INSERT INTO sys_Roles (code,name, description)
values ('SECRETARY', '��������', '��������');
INSERT INTO sys_Roles (code,name, description)
values ('STUDENT', '�������', '�������');
INSERT INTO sys_Roles (code,name, description)
values ('ASSISTENT', '��������', '��������');
INSERT INTO sys_Roles (code,name, description)
values ('LECTURER', '������������', '������������');

INSERT INTO sys_users_roles(username, role)
	values ('evenchova','STUDENT');
INSERT INTO sys_users_roles(username, role)
	values ('nsignatova','STUDENT');
INSERT INTO sys_users_roles(username, role)
	values ('mpetrov','LECTURER');
INSERT INTO sys_users_roles(username, role)
	values ('ldilov','ASSISTENT');
INSERT INTO sys_users_roles(username, role)
	values ('ldilov','STUDENT');
INSERT INTO sys_users_roles(username, role)
	values ('aadmin','ADMIN');
INSERT INTO sys_users_roles(username, role)
	values ('ssekretar','SECRETARY');

insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '314', '���', 30, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '200', '���', 200, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '325', '���', 150, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '02', '���', 50, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '01', '���', 70, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '09', '���', 15, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '321', '���', 35, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '320', '���', 35, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '107', '���', 35, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '307', '���', 20, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '405', '���', 20, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '500', '���', 40, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '210', '���', 250, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '130', '���', 200, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '207', '��� A', 90, '', 'Y');
