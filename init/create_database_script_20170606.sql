-- TODO: да се измисли как ще се определя кога се провежда даден курс (най-вероятно да отпадне типа на семестъра и да е тип_на_провеждане)
-- TODO: да се създават кампании за избор на дисциплини (още една таблица, но дали да има връзки и тя насам натам)

-- В базата няма никакви check constraints, защото в mySQL могат да се създават, но базата не ги използва. 
DROP DATABASE IF EXISTS UniversityCalender;
CREATE DATABASE IF NOT EXISTS UniversityCalender;
ALTER SCHEMA UniversityCalender DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE UniversityCalender;

CREATE TABLE IF NOT EXISTS NOM_DEGREES(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	description VARCHAR (1024) COMMENT 'Описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
    PRIMARY KEY NOM_DEGREE_id_pk (id),
	CONSTRAINT NOM_DEGREE_name_uk UNIQUE (name)
) COMMENT = 'Номенклатура на степените на образование (бакалавър, магистър т.н';

CREATE TABLE IF NOT EXISTS NOM_STUDY_PROGRAMS(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	degree_id MEDIUMINT not null COMMENT 'Степен',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	description VARCHAR (1024) COMMENT 'Описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
    PRIMARY KEY NOM_STUDY_PROGRAM_id_pk (id),
	CONSTRAINT NOM_STUDY_PROGRAM_name_uk UNIQUE (name),
	FOREIGN KEY NOM_STUDY_PROGRAM_degree_fk (degree_id) REFERENCES NOM_DEGREES(ID)
) COMMENT = 'Номаклатура на специалностите';

CREATE TABLE IF NOT EXISTS nom_Cathedrals(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	description VARCHAR (500) COMMENT 'Описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
    PRIMARY KEY nom_Cathedral_pk (id),
	CONSTRAINT nom_cathedral_name_uk UNIQUE(name)
) COMMENT = 'Номенклатура на Катедрите';

CREATE TABLE IF NOT EXISTS sys_users(
	username VARCHAR (80) NOT NULL COMMENT 'Потребителско име',
	password VARCHAR (80) NOT NULL COMMENT 'Парола',
    first_name VARCHAR (50) NOT NULL COMMENT 'Име',
	surname VARCHAR (50) COMMENT 'Презиме',
	last_name VARCHAR (50) NOT NULL COMMENT 'Парола',
	title VARCHAR (50) COMMENT 'Титла (доц., проф. и т.н.)',
	adress VARCHAR (350) COMMENT 'Адрес',
	telefon_number VARCHAR (50) COMMENT 'Телефонен номер',
	email VARCHAR (150) not null COMMENT 'Имейл',
	visiting_time VARCHAR (450) COMMENT 'Текстово поле за въвеждане на приемно време на преподаватели',
	cabinet VARCHAR (80) COMMENT 'Кабитен, къде може да бъде намерен преподавателя',
	rownumber VARCHAR (30) COMMENT 'Факултетен номер',
	cathedral_id MEDIUMINT COMMENT 'Катедра',
	study_program_id MEDIUMINT COMMENT 'Специалност на студент',
	adm_group INTEGER COMMENT 'Административна група на студент',
	year_at_university INTEGER COMMENT 'Курс',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
	notes VARCHAR (500) COMMENT 'Допълнителни бележки',
    PRIMARY KEY sys_users_pk (username),
	CONSTRAINT sys_user_username_uk UNIQUE(username),
	FOREIGN KEY sys_user_study_program_fk (study_program_id) REFERENCES NOM_STUDY_PROGRAMS(ID),
	FOREIGN KEY sys_users_cathedral_fk (cathedral_id) REFERENCES nom_Cathedrals(ID)
) COMMENT = 'Потребители';

CREATE TABLE IF NOT EXISTS Publications(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	title VARCHAR (255) NOT NULL COMMENT 'Заглавие',
	year INTEGER COMMENT 'Година на публикуване',
	publication BLOB COMMENT 'Файлът с публикацията',
	PRIMARY KEY Publication_pk (id)
) COMMENT = 'Публикации';

CREATE TABLE IF NOT EXISTS Sys_users_publications(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	author VARCHAR (80) NOT NULL COMMENT 'Автор',
	publication_id MEDIUMINT NOT NULL COMMENT 'Публикация',
	PRIMARY KEY sys_user_publication_pk (id),
	FOREIGN KEY sys_user_public_author_fk (author) REFERENCES sys_users(username),
	FOREIGN KEY sys_user_public_public_fk(publication_id) REFERENCES Publications(ID),
	CONSTRAINT sys_usr_publs_uk UNIQUE(author, publication_id)
) COMMENT = 'Автори на публикации';

CREATE TABLE IF NOT EXISTS sys_Roles(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	code VARCHAR (50) NOT NULL COMMENT 'Код',
	name VARCHAR (100) NOT NULL COMMENT 'Име',
	description VARCHAR (255) COMMENT 'Допълнитено описание',
	PRIMARY KEY sys_Role_pk (id),
	INDEX sys_Roles_code_ind (code),
	CONSTRAINT sys_Roles_code_uk UNIQUE(code)
) COMMENT = 'Роли в системата';

CREATE TABLE IF NOT EXISTS sys_users_roles(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	username VARCHAR (80) NOT NULL COMMENT 'Потребител',
	role VARCHAR (50) NOT NULL COMMENT 'Роля',
	PRIMARY KEY sys_user_role_pk (id),
	CONSTRAINT sys_users_roles_uk UNIQUE(role, username),
	FOREIGN KEY sys_users_roles_username_fk (username) REFERENCES sys_users(username),
	FOREIGN KEY sys_users_roles_role_fk (role) REFERENCES sys_Roles(code)
) COMMENT = 'Потребителски роли';

CREATE TABLE IF NOT EXISTS nom_Course_categories(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	description VARCHAR (1024) COMMENT 'Описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
    PRIMARY KEY nom_Course_category_type_pk (id),
	CONSTRAINT nom_Course_category_types_name_uk UNIQUE(name)
) COMMENT = 'Номаклатура на типове на курсовете (М, ПМ, ОКН, ЯКН и т.н.)';

CREATE TABLE IF NOT EXISTS nom_Semester_types(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	description VARCHAR (500) COMMENT 'Допълнително описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
    PRIMARY KEY nom_Semester_type_pk (id),
	CONSTRAINT nom_Semester_types_name_uk UNIQUE(name)
) COMMENT = 'Номенклатура на типовете семестри (летен, зимен, всеки семестер и т.н.)';

CREATE TABLE IF NOT EXISTS nom_Session_types(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	description VARCHAR (500) COMMENT 'Допълнително описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
    PRIMARY KEY nom_Session_type_pk (id),
	CONSTRAINT nom_Session_typesHide_name_uk UNIQUE(name)
) COMMENT = 'Номаклатура на типовете сесий (лятна, зимна, есенна и т.н.)';

CREATE TABLE IF NOT EXISTS Courses(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	type VARCHAR (1) NOT NULL DEFAULT 'E' COMMENT 'Тип на курса(E - elective, R - require)',
	category_id  MEDIUMINT not null COMMENT 'Тип на курс',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	credits INTEGER NOT NULL COMMENT 'Брой кредити',
	sign_key VARCHAR (255) COMMENT 'Ключ за курса',
	semester_type_id MEDIUMINT NOT NULL COMMENT 'Тип на семестъра, през който се води курса',
	max_students INTEGER COMMENT 'Максимален брой студенти, които могат да записаш курса',
	description VARCHAR (500) COMMENT 'Описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
	PRIMARY KEY Course_pk (id),
	FOREIGN KEY Courses_type_fk (category_id) REFERENCES nom_Course_categories(ID),
	FOREIGN KEY Courses_sem_type_fk (semester_type_id) REFERENCES nom_Semester_types(ID)
) COMMENT = 'Курсове';

CREATE TABLE IF NOT EXISTS Course_restrictions(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	study_program_id MEDIUMINT NOT NULL COMMENT 'Специалност',
	course_id MEDIUMINT NOT NULL COMMENT 'Курс, за който се отнасят ограниченията',
	year_at_university INTEGER NOT NULL COMMENT 'Kурс в университета',
	PRIMARY KEY Course_restriction_id_pk (id),
	CONSTRAINT Course_restriction_course_program_uk UNIQUE(course_id, study_program_id, year_at_university),
	FOREIGN KEY Course_restriction_course_fk (course_id) REFERENCES Courses(id),
	FOREIGN KEY Course_restriction_study_program_fk (study_program_id) REFERENCES NOM_STUDY_PROGRAMS(ID)
) COMMENT = 'Ограничения на курс (кои специалности и курсове могат да го избират)';

CREATE TABLE IF NOT EXISTS Grades(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	year INTEGER not null COMMENT 'Година на получаване',
	course_id MEDIUMINT NOT NULL COMMENT 'Курс, в който е получена',
	session_type_id MEDIUMINT NOT NULL COMMENT 'Тип на сесията, през който е изкарана',
	grade DECIMAL(6,5) COMMENT 'Оценка',
	credits INTEGER NOT NULL COMMENT 'Получени кредити',
	student VARCHAR (80) NOT NULL COMMENT 'Потребител, на когото е оценката',
	PRIMARY KEY Grades_pk (id),
	CONSTRAINT  Grades_student_uk UNIQUE(course_id, student),
	FOREIGN KEY Grades_student_fk (student) REFERENCES sys_users(username),
	FOREIGN KEY Grades_course_fk (course_id) REFERENCES Courses(ID),
	FOREIGN KEY Grades_Session_type_fk (session_type_id) REFERENCES nom_Session_typesHide(ID)
) COMMENT = 'Оценки';

CREATE TABLE IF NOT EXISTS Courses_students(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	student VARCHAR (80) NOT NULL COMMENT 'Потребител, който е записал курса',
	course_id MEDIUMINT NOT NULL COMMENT 'Курс, който е записал потребителя',
	year INTEGER NOT NULL COMMENT 'Година, през която е записан курса',
	semester_type_id MEDIUMINT NOT NULL COMMENT 'Вид на семестъра, за който е записан курса',
	status VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Статус на курса (R - recored, E - elective, W - waiting, M - marked)',
	request_time DATETIME COMMENT 'Дата и час, в които е избран курса. Използва се определя реда на чакащите да запишат курс.',
	PRIMARY KEY Course_student_pk (id),
	CONSTRAINT Courses_students_cour_stud_uk UNIQUE(student, course_id),
	FOREIGN KEY Courses_students_student_fk (student) REFERENCES sys_users(username),
	FOREIGN KEY Courses_students_course_fk (course_id) REFERENCES Courses(ID),
	FOREIGN KEY Courses_students_sem_type_fk (semester_type_id) REFERENCES nom_Semester_types(ID)
) COMMENT = 'Курсисти към курсове';

CREATE TABLE IF NOT EXISTS Courses_teachers(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	teacher VARCHAR (80) NOT NULL COMMENT 'Потребител, който води курса',
	course_id MEDIUMINT NOT NULL COMMENT 'Курс, който се води от потребителя',
	year INTEGER NOT NULL COMMENT 'Година, през която е воден курса',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
	PRIMARY KEY Course_techer_pk (id),
	CONSTRAINT Courses_teachers_cour_teach_uk UNIQUE(teacher, course_id),
	FOREIGN KEY Courses_teachers_teacher_fk (teacher) REFERENCES sys_users(username),
	FOREIGN KEY Courses_teachers_course_fk (course_id) REFERENCES Courses(ID)
) COMMENT = 'Преподавате към курсове';

CREATE TABLE IF NOT EXISTS News(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	publisher VARCHAR (80) NOT NULL COMMENT 'Потребител, който е направил новината',
	publish_date date not null COMMENT 'Дата на публикуване',
	title VARCHAR (255) NOT NULL COMMENT 'Заглавие на новината',
	content BLOB COMMENT 'Съдържание',
	PRIMARY KEY News_pk (id),
	FOREIGN KEY News_publisher_fk (publisher) REFERENCES sys_users(username)
) COMMENT = 'Новини';

CREATE TABLE IF NOT EXISTS nom_Room_types(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	short_name VARCHAR (80) NOT NULL COMMENT 'Кратко наименование',
	name VARCHAR (255) NOT NULL COMMENT 'Пълно наименование',
	description VARCHAR (500) COMMENT 'Описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
    PRIMARY KEY nom_Room_type_pk (id),
	CONSTRAINT nom_Room_typesHide_name_uk UNIQUE(name)
) COMMENT = 'Номенклатура на типовете стай (компютърна зала и т.н.)';

CREATE TABLE IF NOT EXISTS Rooms(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	num VARCHAR (20) NOT NULL COMMENT 'Номер на стаята',
	place VARCHAR (20) NOT NULL COMMENT 'Къде се намира стаята (например, ако е в друг факултет)',
	type_id MEDIUMINT NOT NULL COMMENT 'Тип на залата',
	work_stations INTEGER COMMENT 'Брой работни места',
	description VARCHAR (1024) COMMENT 'Допълнително описание',
	is_active VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг за активност',
	PRIMARY KEY Room_pk (id),
	FOREIGN KEY Rooms_type_fk (type_id) REFERENCES nom_Room_typesHide(ID)
) COMMENT = 'Стай, в които могат да се провеждат занятия';

CREATE TABLE IF NOT EXISTS Master_Events(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	creator VARCHAR (80) NOT NULL COMMENT 'Потребител, който е създал събитието',
	event_Type VARCHAR (1) not null COMMENT 'Тип на записа(O - one-time, P - periodic)',
	is_accept VARCHAR (1) NOT NULL DEFAULT 'Y' COMMENT 'Флаг дали е удобрена заявката',
	course_id MEDIUMINT NOT NULL COMMENT 'Курс, за който се отнася събитието',
	PRIMARY KEY Master_event_pk (id),
	FOREIGN KEY Master_event_creator_fk (creator) REFERENCES sys_users(username),
	FOREIGN KEY Master_event_course_fk (course_id) REFERENCES Courses(ID)
) COMMENT = 'Съдържа главните записи за събитията(периодични, еднократни), които за заяки или одобрени';

CREATE TABLE IF NOT EXISTS Child_Events(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	master_id MEDIUMINT NOT NULL COMMENT 'Родителски запис',
	room_id MEDIUMINT NOT NULL COMMENT 'Място на провеждане на занятието',
	class_date DATE NOT NULL COMMENT 'Дата на провеждане на занятието',
	from_hour TIME  NOT NULL COMMENT 'От час',
	to_hour TIME  NOT NULL COMMENT 'До час',
	title VARCHAR (80) NOT NULL COMMENT 'Заглавие на събитиети',
	description VARCHAR (1024) COMMENT 'Допълнително описание',
	PRIMARY KEY Child_event_pk (id),
	FOREIGN KEY Child_event_master_fk (master_id) REFERENCES Master_Events(ID),
	FOREIGN KEY Child_event_room_fk (room_id) REFERENCES Rooms(ID)
) COMMENT = 'Размножените записи от родителя';

CREATE TABLE IF NOT EXISTS Event_view_groups(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	master_event_id MEDIUMINT NOT NULL COMMENT 'Главно събитие',
	type VARCHAR (3) NOT NULL COMMENT 'Тип на групата (A-all, S-students, T-teachers, ST-student-teachers)',
	course_id MEDIUMINT NOT NULL COMMENT 'Хора, който са записали този курс',
	year_at_university INTEGER COMMENT 'Година в уноверситета',
	degree_id MEDIUMINT not null COMMENT 'Степен на образование',
	cathedral_id MEDIUMINT NOT NULL COMMENT 'Катедра',
	study_program_id MEDIUMINT COMMENT 'Хора, записани в Специалност',
	PRIMARY KEY Event_view_group_pk (id),
	FOREIGN KEY Event_view_group_course_fk (course_id) REFERENCES Courses(ID),
	FOREIGN KEY Event_view_group_degree_fk (degree_id) REFERENCES NOM_DEGREES(ID),
	FOREIGN KEY Event_view_group_program_fk (study_program_id) REFERENCES NOM_STUDY_PROGRAMS(ID),
	FOREIGN KEY Event_view_group_cathedral_fk (cathedral_id) REFERENCES nom_Cathedrals(ID)
) COMMENT = 'Съдържа множествата от хора, които могат да виждат събитиети';

CREATE TABLE IF NOT EXISTS Event_view_users(
	id MEDIUMINT NOT NULL AUTO_INCREMENT COMMENT 'UNIQUE ID',
	type VARCHAR (1) NOT NULL COMMENT 'Тип на изключението (как е било създадено)(C-creator, S-self)',
	master_event_id MEDIUMINT NOT NULL COMMENT 'Главно събитие',
	username VARCHAR (80) NOT NULL COMMENT 'Потребител, който е бил добаван или премахнат от събитиети',
	direction VARCHAR (1) NOT NULL COMMENT 'Посока на изключението на потребителя(I-in, O-out).',
	PRIMARY KEY Event_view_user_pk (id),
	CONSTRAINT Event_view_user_master_event_uk UNIQUE(master_event_id, username, direction),
	FOREIGN KEY Event_view_user_master_event_fk (master_event_id) REFERENCES Master_Events(ID),
	FOREIGN KEY Event_view_user_person_fk (username) REFERENCES sys_users(username)
) COMMENT = 'Това са изключениети на хора (поименно), който са добавени и премахната от списъка';

-- Данни за базата
INSERT INTO NOM_DEGREES (short_name, name, description, is_active)
	values('Bachelor', 'Бакалавър', 'Бакалавър', 'Y');
INSERT INTO NOM_DEGREES (short_name, name, description, is_active)
	values('Master', 'Магистър', 'Магистър', 'Y');
INSERT INTO NOM_DEGREES (short_name, name, description, is_active)
	values('Phd', 'Докторантура', 'Докторантура', 'Y');

INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'SI', 'Софтуерно инженерство', 'Софтуерно инженерство', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'IS', 'Информационни системи', 'Информационни системи', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'KN', 'Компютърни науки', 'Компютърни науки', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(1, 'I', 'Информатика', 'Информатика', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(2, 'IT', 'Изкуствен интелект', 'Изкуствен интелект', 'Y');
INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active)
	values(2, 'DM', 'Data mining', 'Data mining', 'Y');

INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('SS', 'Статистика и стохастика', 'Статистика и стохастика', 'Y');
INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('I', 'Информатика', 'Информатика', 'Y');
INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('PM', 'Приложна математика', 'Приложна математика', 'Y');
INSERT INTO nom_Cathedrals (short_name, name, description, is_active) 
	values ('SI', 'Софтуерно инженерство', 'Софтуерно инженерство', 'Y');

insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('evenchova', '1','Елица','Емилова', 'Венчова', '','София','08*********','mail@mail.mail', '', null, 61807, null,1,5,3,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('nsignatova', '','Наталия','Сашова', 'Ингнатова', '','София','08*********','mail@mail.mail', '', null, 61767, null,1,5,3,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('mpetrov', '','Милен','', 'Петров', 'доц.','София','08*********','mail@mail.mail', 'Сряда 10:00-12:00 ФМИ каб.200', 200, null, 4,null,null,null,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('ldilov', '','Лазар','', 'Дилов', '','София','08*********','mail@mail.mail', '', null, null, 4,5,1,1,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('ssekretar', '','Секретар','', 'Секретар', 'г-жа','София','08*********','mail@mail.mail', 'ФМИ, стая 120, 8:30-16:30, обедна почивка 12:00-13:00', 120, null, null,null,null,null,'Y',null);
insert into sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes)
values('aadmin', '','Админ','', 'Админ', 'г-н', 'София', '08*********', 'mail@mail.mail', '', null, null, null,null,null,null,'Y',null);

INSERT INTO nom_Semester_types (short_name, name, description, is_active)
	values('W', 'Зимен семестър', 'Зимен семестър', 'Y');
INSERT INTO nom_Semester_types (short_name, name, description, is_active)
	values('S', 'Летен семестър', 'Летен семестър', 'Y');

INSERT INTO nom_Session_typesHide (short_name, name, description, is_active)
	values('W', 'Зимена сесия', 'Зимена сесия', 'Y');
INSERT INTO nom_Session_typesHide (short_name, name, description, is_active)
	values('S', 'Лятна сесия', 'Лятна сесия', 'Y');
INSERT INTO nom_Session_typesHide (short_name, name, description, is_active)
	values('A', 'Есенна сесия', 'Есенна сесия', 'Y');

INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('QKN', 'ЯКН', 'Ядро на компютърните науки', 'Y');
INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('OKN', 'ОКН', 'Основи на компютърните науки', 'Y');
INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('PM', 'ПМ', 'Приложна математика', 'Y');
INSERT INTO nom_Course_categories (short_name, name, description, is_active)
	values('M', 'М', 'Математика', 'Y');

INSERT INTO nom_Room_typesHide (short_name, name, description, is_active)
	values('COMPUTER', 'Компютърна зала', 'Компютърна зала', 'Y');
INSERT INTO nom_Room_typesHide (short_name, name, description, is_active)
	values('AUDITOR', 'Аудитория', 'Аудитория', 'Y');
INSERT INTO nom_Room_typesHide (short_name, name, description, is_active)
	values('EXERCISE', 'Зала за упражнение', 'Зала за упражнение', 'Y');

INSERT INTO sys_Roles (code,name, description)
values ('ADMIN', 'Админ', 'Админ на приложението');
INSERT INTO sys_Roles (code,name, description)
values ('SECRETARY', 'Секретар', 'Секретар');
INSERT INTO sys_Roles (code,name, description)
values ('STUDENT', 'Студент', 'Студент');
INSERT INTO sys_Roles (code,name, description)
values ('ASSISTENT', 'Асистент', 'Асистент');
INSERT INTO sys_Roles (code,name, description)
values ('LECTURER', 'Преподавател', 'Преподавател');

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
VALUES (1, '314', 'ФМИ', 30, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '200', 'ФМИ', 200, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '325', 'ФМИ', 150, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '02', 'ФМИ', 50, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '01', 'ФМИ', 70, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '09', 'ФМИ', 15, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '321', 'ФМИ', 35, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '320', 'ФМИ', 35, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (1, '107', 'ФМИ', 35, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '307', 'ФМИ', 20, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '405', 'ФМИ', 20, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (3, '500', 'ФМИ', 40, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '210', 'ФХФ', 250, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '130', 'ФХФ', 200, '', 'Y');
insert into Rooms (type_id, num, place, work_stations, description, is_active)
VALUES (2, '207', 'ФзФ A', 90, '', 'Y');
