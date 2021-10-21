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
        id Int  Auto_increment  NOT NULL ,
        name       Varchar (255) NOT NULL ,
        status     Bool NOT NULL
    ,CONSTRAINT apps_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: formations
#------------------------------------------------------------

DROP TABLE IF EXISTS formations;
CREATE TABLE formations(
        id     Int  Auto_increment  NOT NULL ,
        tag   Varchar (15) NOT NULL ,
        name   Varchar (255) NOT NULL ,
        degree Varchar (255) NOT NULL ,
        status Bool NOT NULL
	,CONSTRAINT formations_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: centers
#------------------------------------------------------------

DROP TABLE IF EXISTS centers;
CREATE TABLE centers(
        id                 Int  Auto_increment  NOT NULL ,
        name               Varchar (255) NOT NULL ,
        address            Varchar (255) NOT NULL ,
        complementAddress  Varchar (255) NOT NULL ,
        zip            Varchar (5) NOT NULL ,
        city               Varchar (255) NOT NULL ,
        schedule           Text NOT NULL ,
        mail        Varchar (255) NOT NULL ,
        withdrawalPlace    Varchar (255) NOT NULL ,
        withdrawalSchedule Varchar (255) NOT NULL ,
        urlGoogleMap       Text NOT NULL
	,CONSTRAINT centers_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: financials
#------------------------------------------------------------

DROP TABLE IF EXISTS financials;
CREATE TABLE financials(
                        id                 Int  Auto_increment  NOT NULL ,
                        tag     Varchar (255) NOT NULL ,
                        name               Varchar (255) NOT NULL ,
                        public_name               Varchar (255) NOT NULL
    ,CONSTRAINT financials_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

DROP TABLE IF EXISTS users;
CREATE TABLE users(
        id                Int  Auto_increment  NOT NULL ,
        center_id              Int NOT NULL ,
        financial_id              Int NOT NULL ,
        identifier        Varchar (20) NOT NULL UNIQUE ,
        lastname              Varchar (255) NOT NULL ,
        firstname         Varchar (255) NOT NULL ,
        mailPro           Varchar (255) ,
        mailPerso         Varchar (255) ,
        password               Varchar (255) ,
        phone             Varchar (15) ,
        address           Varchar (255) ,
        complementAddress Varchar (255) ,
        zip           Varchar (5) ,
        city              Varchar (255) ,
        country           Varchar (255) ,
        gender            Bool ,
        status            Bool NOT NULL DEFAULT '1',
        created_at        Date  ,
        updated_at        Datetime
	,CONSTRAINT users_PK PRIMARY KEY (id)

    ,CONSTRAINT users_centers_FK FOREIGN KEY (center_id) REFERENCES centers(id)

    ,CONSTRAINT users_financials_FK FOREIGN KEY (financial_id) REFERENCES financials(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sessions
#------------------------------------------------------------

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
        id       Int  Auto_increment  NOT NULL ,
        formation_id      Int NOT NULL ,
        tag     Varchar (255) NOT NULL ,
        name Varchar (255) NOT NULL ,
        start_at DATE NOT NULL ,
        end_at   DATE NOT NULL ,
        status   Bool NOT NULL
	,CONSTRAINT sessions_PK PRIMARY KEY (id)

	,CONSTRAINT sessions_formations_FK FOREIGN KEY (formation_id) REFERENCES formations(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: roles
#------------------------------------------------------------

DROP TABLE IF EXISTS roles;
CREATE TABLE roles(
        id   Int  Auto_increment  NOT NULL ,
        tag     Varchar (255) NOT NULL ,
        name Varchar (255) NOT NULL
	,CONSTRAINT roles_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: functions
#------------------------------------------------------------

DROP TABLE IF EXISTS functions;
CREATE TABLE functions(
        id   Int  Auto_increment  NOT NULL ,
        tag     Varchar (255) NOT NULL ,
        name Varchar (255) NOT NULL
	,CONSTRAINT functions_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: migrations
#------------------------------------------------------------

DROP TABLE IF EXISTS migrations;
CREATE TABLE migrations(
        id        Int  Auto_increment  NOT NULL ,
        datetime Varchar (255) NOT NULL
	,CONSTRAINT migrations_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

INSERT INTO `afpaconnect`.`migrations` (`datetime`) VALUES ('1');

#------------------------------------------------------------
# Table: apps__users__roles
#------------------------------------------------------------

DROP TABLE IF EXISTS apps__users__roles;
CREATE TABLE apps__users__roles(
        app_id         Int NOT NULL ,
        user_id        Int NOT NULL ,
        role_id        Int NOT NULL
	,CONSTRAINT apps__users__roles_PK PRIMARY KEY (app_id,user_id,role_id)

	,CONSTRAINT apps__users__roles_apps_FK FOREIGN KEY (app_id) REFERENCES apps(id)
	,CONSTRAINT apps__users__roles_users0_FK FOREIGN KEY (user_id) REFERENCES users(id)
	,CONSTRAINT apps__users__roles_roles1_FK FOREIGN KEY (role_id) REFERENCES roles(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__sessions
#------------------------------------------------------------

DROP TABLE IF EXISTS users__sessions;
CREATE TABLE users__sessions(
        user_id    Int NOT NULL ,
        session_id Int NOT NULL
	,CONSTRAINT users__sessions_PK PRIMARY KEY (user_id,session_id)

	,CONSTRAINT users__sessions_users_FK FOREIGN KEY (user_id) REFERENCES users(id)
	,CONSTRAINT users__sessions_sessions0_FK FOREIGN KEY (session_id) REFERENCES sessions(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: centers__trainings
#------------------------------------------------------------

DROP TABLE IF EXISTS centers__trainings;
CREATE TABLE centers__trainings(
        center_id   Int NOT NULL ,
        training_id Int NOT NULL
	,CONSTRAINT centers__trainings_PK PRIMARY KEY (training_id,center_id)

	,CONSTRAINT centers__trainings_trainings_FK FOREIGN KEY (training_id) REFERENCES formations(id)
	,CONSTRAINT centers__trainings_centers0_FK FOREIGN KEY (center_id) REFERENCES centers(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__functions
#------------------------------------------------------------

DROP TABLE IF EXISTS users__functions;
CREATE TABLE users__functions(
        user_id     Int NOT NULL ,
        function_id Int NOT NULL ,
        start_date  Datetime NOT NULL ,
        end_date    Datetime NOT NULL
	,CONSTRAINT users__functions_PK PRIMARY KEY (function_id,user_id)

	,CONSTRAINT users__functions_functions_FK FOREIGN KEY (function_id) REFERENCES functions(id)
	,CONSTRAINT users__functions_users0_FK FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS apps__roles;
CREATE TABLE apps__roles(
    `app_id` INT NOT NULL ,
     `role_id` INT NOT NULL ,
     CONSTRAINT apps__roles_PK PRIMARY KEY (app_id,role_id),
     CONSTRAINT apps__roles_apps_FK FOREIGN KEY (app_id) REFERENCES apps(id),
     CONSTRAINT apps__roles_roles_FK FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE = InnoDB;
