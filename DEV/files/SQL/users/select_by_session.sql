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
    FROM users__sessions
    JOIN users ON users.id_users = users__sessions.id_users
    WHERE users__sessions.id_sessions = @id_sessions;