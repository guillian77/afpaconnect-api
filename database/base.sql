#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

SET NAMES utf8;
DROP DATABASE IF EXISTS afpaconnect;
CREATE DATABASE IF NOT EXISTS afpaconnect CHARACTER SET utf8 COLLATE utf8_general_ci;
USE afpaconnect;

#------------------------------------------------------------
# Table: apps
#------------------------------------------------------------

DROP TABLE IF EXISTS apps;
CREATE TABLE apps(
        id_application Int  Auto_increment  NOT NULL ,
        app_name       Varchar (255) NOT NULL ,
        app_status     Bool NOT NULL ,
        app_hostname   Varchar (255) ,
        app_bddName    Varchar (255) NOT NULL
	,CONSTRAINT apps_PK PRIMARY KEY (id_application)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: trainings
#------------------------------------------------------------

DROP TABLE IF EXISTS trainings;
CREATE TABLE trainings(
        id_training     Int  Auto_increment  NOT NULL ,
        training_name   Varchar (255) NOT NULL ,
        training_degree Varchar (255) NOT NULL ,
        training_code   Varchar (15) NOT NULL ,
        training_status Bool NOT NULL
	,CONSTRAINT trainings_PK PRIMARY KEY (id_training)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: centers
#------------------------------------------------------------

DROP TABLE IF EXISTS centers;
CREATE TABLE centers(
        id_center                 Int  Auto_increment  NOT NULL ,
        center_name               Varchar (255) NOT NULL ,
        center_address            Varchar (255) NOT NULL ,
        center_complementAddress  Varchar (255) NOT NULL ,
        center_zipCode            Varchar (5) NOT NULL ,
        center_city               Varchar (255) NOT NULL ,
        center_schedule           Text NOT NULL ,
        center_contactMail        Varchar (255) NOT NULL ,
        center_withdrawalPlace    Varchar (255) NOT NULL ,
        center_withdrawalSchedule Varchar (255) NOT NULL ,
        center_urlGoogleMap       Text NOT NULL
	,CONSTRAINT centers_PK PRIMARY KEY (id_center)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

DROP TABLE IF EXISTS users;
CREATE TABLE users(
        id_user                Int  Auto_increment  NOT NULL ,
        id_center              Int NOT NULL ,
        user_identifier        Varchar (20) NOT NULL ,
        user_name              Varchar (255) NOT NULL ,
        user_firstName         Varchar (255) NOT NULL ,
        user_mailPro           Varchar (255) ,
        user_mailPerso         Varchar (255) ,
        user_psw               Varchar (255) ,
        user_phone             Varchar (15) ,
        user_address           Varchar (255) ,
        user_complementAddress Varchar (255) ,
        user_zipCode           Varchar (5) ,
        user_city              Varchar (255) ,
        user_country           Varchar (255) ,
        user_gender            Bool ,
        user_status            Bool ,
        user_created_at        Date  ,
        user_updated_at        Datetime
	,CONSTRAINT users_PK PRIMARY KEY (id_user)

	,CONSTRAINT users_centers_FK FOREIGN KEY (id_center) REFERENCES centers(id_center)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sessions
#------------------------------------------------------------

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
        id_session       Int  Auto_increment  NOT NULL ,
        id_training      Int NOT NULL ,
        session_code     Varchar (255) NOT NULL ,
        session_start_at Datetime NOT NULL ,
        session_end_at   Datetime NOT NULL ,
        session_entitled Varchar (255) NOT NULL ,
        session_status   Bool NOT NULL
	,CONSTRAINT sessions_PK PRIMARY KEY (id_session)

	,CONSTRAINT sessions_trainings_FK FOREIGN KEY (id_training) REFERENCES trainings(id_training)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: roles
#------------------------------------------------------------

DROP TABLE IF EXISTS roles;
CREATE TABLE roles(
        id_role   Int  Auto_increment  NOT NULL ,
        role_name Varchar (255) NOT NULL
	,CONSTRAINT roles_PK PRIMARY KEY (id_role)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: functions
#------------------------------------------------------------

DROP TABLE IF EXISTS functions;
CREATE TABLE functions(
        id_function   Int  Auto_increment  NOT NULL ,
        function_name Varchar (255) NOT NULL
	,CONSTRAINT functions_PK PRIMARY KEY (id_function)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: migrations
#------------------------------------------------------------

DROP TABLE IF EXISTS migrations;
CREATE TABLE migrations(
        id_migration        Int  Auto_increment  NOT NULL ,
        migration_datetime Varchar (255) NOT NULL
	,CONSTRAINT migrations_PK PRIMARY KEY (id_migration)
)ENGINE=InnoDB;

INSERT INTO `afpaconnect`.`migrations` (`migration_datetime`) VALUES ('1');

#------------------------------------------------------------
# Table: apps__users__roles
#------------------------------------------------------------

DROP TABLE IF EXISTS apps__users__roles;
CREATE TABLE apps__users__roles(
        id_application Int NOT NULL ,
        id_user        Int NOT NULL ,
        id_role        Int NOT NULL
	,CONSTRAINT apps__users__roles_PK PRIMARY KEY (id_application,id_user,id_role)

	,CONSTRAINT apps__users__roles_apps_FK FOREIGN KEY (id_application) REFERENCES apps(id_application)
	,CONSTRAINT apps__users__roles_users0_FK FOREIGN KEY (id_user) REFERENCES users(id_user)
	,CONSTRAINT apps__users__roles_roles1_FK FOREIGN KEY (id_role) REFERENCES roles(id_role)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__sessions
#------------------------------------------------------------

DROP TABLE IF EXISTS users__sessions;
CREATE TABLE users__sessions(
        id_user    Int NOT NULL ,
        id_session Int NOT NULL
	,CONSTRAINT users__sessions_PK PRIMARY KEY (id_user,id_session)

	,CONSTRAINT users__sessions_users_FK FOREIGN KEY (id_user) REFERENCES users(id_user)
	,CONSTRAINT users__sessions_sessions0_FK FOREIGN KEY (id_session) REFERENCES sessions(id_session)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: centers__trainings
#------------------------------------------------------------

DROP TABLE IF EXISTS centers__trainings;
CREATE TABLE centers__trainings(
        id_training Int NOT NULL ,
        id_center   Int NOT NULL
	,CONSTRAINT centers__trainings_PK PRIMARY KEY (id_training,id_center)

	,CONSTRAINT centers__trainings_trainings_FK FOREIGN KEY (id_training) REFERENCES trainings(id_training)
	,CONSTRAINT centers__trainings_centers0_FK FOREIGN KEY (id_center) REFERENCES centers(id_center)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__functions
#------------------------------------------------------------

DROP TABLE IF EXISTS users__functions;
CREATE TABLE users__functions(
        id_function Int NOT NULL ,
        id_user     Int NOT NULL ,
        start_date  Datetime NOT NULL ,
        end_date    Datetime NOT NULL
	,CONSTRAINT users__functions_PK PRIMARY KEY (id_function,id_user)

	,CONSTRAINT users__functions_functions_FK FOREIGN KEY (id_function) REFERENCES functions(id_function)
	,CONSTRAINT users__functions_users0_FK FOREIGN KEY (id_user) REFERENCES users(id_user)
)ENGINE=InnoDB;
