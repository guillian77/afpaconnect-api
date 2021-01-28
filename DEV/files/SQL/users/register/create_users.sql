-- Insert a new user (! rank_users = 0)
INSERT INTO users (firstname_users, lastname_users, email_users,password_users, rank_users, birthdate_users, discord_id_users, created_at_users, active_users) 
VALUES ("@firstname_users", "@lastname_users", "@email_users", "@password_users", 0, "@birthdate_users", "@discord_id_users", NOW(), 1);