SELECT users.id_users,
users.firstname_users,
users.lastname_users,
users.email_users,
users.discord_id_users,
formations.designation_formations,
users.active_users
FROM users
INNER JOIN (users__sessions,sessions,formations) 
ON users__sessions.id_users = users.id_users
AND users__sessions.id_sessions = sessions.id_sessions 
AND sessions.id_formations = formations.id_formations
WHERE active_users = 2