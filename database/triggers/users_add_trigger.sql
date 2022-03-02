CREATE OR REPLACE TRIGGER auto_assign_user_function_on_insert
    AFTER INSERT ON users__sessions
    FOR EACH ROW
BEGIN
    -- Get function correspond to interns.
    SET  @internFunction = (SELECT functions.id FROM functions WHERE functions.tag = "FUNCTION_INTERN");

    -- Get session end date.
    SET @userSessionEndAt = (SELECT sessions.end_at FROM users
        LEFT JOIN users__sessions ON users.id = users__sessions.user_id
        LEFT JOIN sessions ON users__sessions.session_id = sessions.id
        WHERE users.id = NEW.user_id
    );

    -- Auto assign a new user to a function.
    INSERT INTO users__functions (user_id, function_id, start_date, end_date)
        VALUES (NEW.user_id, @internFunction, NOW(), @userSessionEndAt);
END;
