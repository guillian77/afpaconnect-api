UPDATE sessions SET
    start_at_sessions = "@start_at_sessions",
    end_at_sessions = "@end_at_sessions",
    active_sessions = @active_sessions
WHERE id_formations = @id_formations;