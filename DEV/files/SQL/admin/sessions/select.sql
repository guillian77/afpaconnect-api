-- get sessions with formations
SELECT
    sessions.id_sessions,
    sessions.start_at_sessions,
    sessions.end_at_sessions,
    formations.designation_formations,
    sessions.id_formations,
    sessions.active_sessions
        FROM `sessions`
        JOIN formations ON formations.id_formations = sessions.id_formations;