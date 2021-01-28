-- --------------------------
-- USERS: update > TRIGGER
-- --------------------------
DELIMITER |
    CREATE TRIGGER `before_update_delete_ticket` BEFORE UPDATE ON `tickets`
    FOR EACH ROW BEGIN
        IF ( new.active_tickets = 0 ) THEN 
        DELETE FROM users__tickets WHERE id_tickets = new.id_tickets ;
        END 
        IF;
    END
    |

    CREATE TRIGGER `before_update_users` BEFORE UPDATE ON `users`
    FOR EACH ROW BEGIN
        IF (new.active_users = 0) THEN 
            SET @SELECT_WHERE_id_AND_owner = (SELECT id_tickets FROM users__tickets WHERE id_users = new.id_users    AND status_users__tickets ="owner");
        UPDATE tickets
        set active_tickets = 0
        WHERE id_tickets IN (@SELECT_WHERE_id_AND_owner);

        END IF ;
    END
    |
DELIMITER ;