UPDATE users 
    SET active_users = @active_users
    WHERE users.id_users = @id_user;