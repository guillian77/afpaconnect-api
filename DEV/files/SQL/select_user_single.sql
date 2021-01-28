-- select user by id
SELECT
    users.id_users,
    users.firstname_users,
    users.lastname_users,
    users.email_users,
    users.birthdate_users,
    users.discord_id_users
FROM
    users
WHERE users.id_users= @id_user;