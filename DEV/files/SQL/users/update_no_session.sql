UPDATE users
    SET
        users.firstname_users='@firstname_user',
        users.lastname_users='@lastname_user', 
        users.email_users='@email_user',
        users.discord_id_users='@id_discord_user'
        WHERE users.id_users=@id_user;
DELETE FROM users__sessions 
    WHERE users__sessions.id_users = @id_user;