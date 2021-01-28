select sessions.active_sessions from users
INNER JOIN users__sessions ON users.id_users = users__sessions.id_users

INNER JOIN sessions
    ON users__sessions.id_sessions = sessions.id_sessions

where users__sessions.id_users = @id_users
