INSERT INTO
    `sessions`
    (id_sessions, start_at_sessions, end_at_sessions, active_sessions, id_formations)
    VALUES
    (NULL, "@start_at_sessions", "@end_at_sessions",  @active_sessions, @id_formations);