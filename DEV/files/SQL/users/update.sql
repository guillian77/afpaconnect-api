INSERT INTO users__sessions (id_sessions , id_users)
    VALUES (@id_sessions , @id_user)
    ON DUPLICATE KEY
UPDATE 
    id_sessions = VALUES(id_sessions),
    id_users = VALUES(id_users);

UPDATE users
    SET
        users.firstname_users='@firstname_user',
        users.lastname_users='@lastname_user', 
        users.email_users='@email_user',
        users.discord_id_users='@id_discord_user'
        WHERE users.id_users=@id_user;