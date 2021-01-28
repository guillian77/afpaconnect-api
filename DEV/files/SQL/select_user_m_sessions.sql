-- Get all sessions by formation
SELECT
    formations.designation_formations,
    sessions.id_sessions,
    DATE_FORMAT(sessions.start_at_sessions, "%d-%m-%Y") AS date_sessions
FROM formations

JOIN sessions

ON formations.id_formations = sessions.id_formations

WHERE sessions.active_sessions = 1

ORDER BY formations.designation_formations;