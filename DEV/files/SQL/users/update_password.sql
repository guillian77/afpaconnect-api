-- Refresh password hash when user is connecting
UPDATE users SET password_users = "@password" WHERE id_users = @id;