SELECT 
    users.id_users,
    users.firstname_users,
    users.lastname_users,
    users.email_users,
    users.rank_users,
    users.birthdate_users,
    users.discord_id_users,
    users.created_at_users,
    users.updated_at_users,
    users.active_users
FROM users
WHERE key_reset_users = "@key_reset_users";