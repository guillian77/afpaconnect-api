#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

CREATE TABLE users(
        id_users         Int  Auto_increment  NOT NULL ,
        firstname_users  Varchar (50) NOT NULL ,
        lastname_users   Varchar (50) NOT NULL ,
        email_users      Varchar (100) NOT NULL ,
        password_users   Varchar (60) NOT NULL ,
        key_reset_users  Varchar (10) ,
        birthdate_users  Date NOT NULL ,
        discord_id_users Varchar (40) NOT NULL ,
        created_at_users Date NOT NULL ,
        updated_at_users Date ,
        active_users     Bool NOT NULL default 1
	,CONSTRAINT users_PK PRIMARY KEY (id_users)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: formations
#------------------------------------------------------------

CREATE TABLE formations(
        id_formations          Int  Auto_increment  NOT NULL ,
        designation_formations Varchar (50) NOT NULL ,
        active_formations      Bool NOT NULL default 1
	,CONSTRAINT formations_PK PRIMARY KEY (id_formations)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sessions
#------------------------------------------------------------

CREATE TABLE sessions(
        id_sessions     Int  Auto_increment  NOT NULL ,
        date_sessions   Date ,
        active_sessions Bool NOT NULL default 1,
        id_formations   Int NOT NULL
	,CONSTRAINT sessions_PK PRIMARY KEY (id_sessions)

	,CONSTRAINT sessions_formations_FK FOREIGN KEY (id_formations) REFERENCES formations(id_formations)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: topics
#------------------------------------------------------------

CREATE TABLE topics(
        id_topics          Int  Auto_increment  NOT NULL ,
        designation_topics Varchar (30) NOT NULL ,
        active_topics      Bool NOT NULL default 1
	,CONSTRAINT topics_PK PRIMARY KEY (id_topics)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: prioritys
#------------------------------------------------------------

CREATE TABLE prioritys(
        id_prioritys          Int  Auto_increment  NOT NULL ,
        designation_prioritys Varchar (7) NOT NULL ,
        interval_prioritys    Time NOT NULL ,
        active_prioritys      Bool NOT NULL default 1
	,CONSTRAINT prioritys_PK PRIMARY KEY (id_prioritys)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: tickets
#------------------------------------------------------------

CREATE TABLE tickets(
        id_tickets           Int  Auto_increment  NOT NULL ,
        date_tickets         Bool NOT NULL ,
        subject_tickets      Varchar (50) NOT NULL ,
        description_tickets  Varchar (600) NOT NULL ,
        resolved_tickets     Bool NOT NULL ,
        count_report_tickets TinyINT NOT NULL ,
        reported_tickets     Bool NOT NULL ,
        active_tickets       Bool NOT NULL default 1,
        id_topics            Int NOT NULL ,
        id_prioritys         Int NOT NULL
	,CONSTRAINT tickets_PK PRIMARY KEY (id_tickets)

	,CONSTRAINT tickets_topics_FK FOREIGN KEY (id_topics) REFERENCES topics(id_topics)
	,CONSTRAINT tickets_prioritys0_FK FOREIGN KEY (id_prioritys) REFERENCES prioritys(id_prioritys)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: configs
#------------------------------------------------------------

CREATE TABLE configs(
        id_configs                    Int  Auto_increment  NOT NULL ,
        discord_token_configs         Varchar (255) NOT NULL ,
        discord_id_guild_configs      Int NOT NULL ,
        discord_notif_channel_configs Varchar (255) NOT NULL ,
        ticket_limit_configs          Int NOT NULL ,
        img_limit_configs             Int NOT NULL ,
        report_limit_configs          Int NOT NULL ,
        size_screen_configs           Int NOT NULL ,
        active_configs                Bool NOT NULL default 1
	,CONSTRAINT configs_PK PRIMARY KEY (id_configs)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: screens
#------------------------------------------------------------

CREATE TABLE screens(
        id_screens   Int  Auto_increment  NOT NULL ,
        name_screens Varchar (10) NOT NULL ,
        id_tickets   Int NOT NULL
	,CONSTRAINT screens_PK PRIMARY KEY (id_screens)

	,CONSTRAINT screens_tickets_FK FOREIGN KEY (id_tickets) REFERENCES tickets(id_tickets)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__sessions
#------------------------------------------------------------

CREATE TABLE users__sessions(
        id_sessions Int NOT NULL ,
        id_users    Int NOT NULL
	,CONSTRAINT users__sessions_PK PRIMARY KEY (id_sessions,id_users)

	,CONSTRAINT users__sessions_sessions_FK FOREIGN KEY (id_sessions) REFERENCES sessions(id_sessions)
	,CONSTRAINT users__sessions_users0_FK FOREIGN KEY (id_users) REFERENCES users(id_users)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__tickets
#------------------------------------------------------------

CREATE TABLE users__tickets(
        id_tickets            Int NOT NULL ,
        id_users              Int NOT NULL ,
        status_users__tickets Varchar (10) NOT NULL ,
        date_report           Date ,
        reason_report         Varchar (255)
	,CONSTRAINT users__tickets_PK PRIMARY KEY (id_tickets,id_users)

	,CONSTRAINT users__tickets_tickets_FK FOREIGN KEY (id_tickets) REFERENCES tickets(id_tickets)
	,CONSTRAINT users__tickets_users0_FK FOREIGN KEY (id_users) REFERENCES users(id_users)
)ENGINE=InnoDB;

