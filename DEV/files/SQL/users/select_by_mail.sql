-- Get a user by his email
SELECT 
    users.id_users,
    users.firstname_users,
    users.lastname_users,
    users.email_users,
    users.password_users,
    users.rank_users,
    users.birthdate_users,
    users.discord_id_users,
    users.created_at_users,
    users.updated_at_users,
    users.active_users
FROM users
WHERE email_users = "@user_mail"
AND active_users = 1;