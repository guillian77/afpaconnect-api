-- update user in DB
SET @session_user = (SELECT sessions.id_sessions From sessions
NATURAL JOIN formations 
WHERE formations.designation_formations = '@formation'
AND sessions.start_at_sessions = '@date_sessions');

UPDATE users INNER JOIN (users__sessions,sessions,formations)
ON users__sessions.id_users = users.id_users
AND users__sessions.id_sessions = sessions.id_sessions
AND sessions.id_formations = formations.id_formations
SET
users.firstname_users = '@prenom',
users.birthdate_users= "@date_naissance",
users.lastname_users = "@nom",
users.email_users = "@email",
users.password_users= "@mdp",
users.discord_id_users = "@discord",
users__sessions.id_sessions= "@id_session"
WHERE users.id_users=@id_user_update;

