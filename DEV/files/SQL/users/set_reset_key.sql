UPDATE users
    SET key_reset_users = "@key_reset_users"
    WHERE email_users = "@email_users";