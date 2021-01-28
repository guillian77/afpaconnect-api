DELETE FROM users__sessions
    WHERE id_users = @id_users;
DELETE FROM users
    WHERE id_users = @id_users;