DELIMITER |
CREATE TRIGGER `before_update_report_ticket` BEFORE UPDATE ON `tickets`
    FOR EACH ROW BEGIN
    IF (new.count_report_tickets > (SELECT report_limit_configs FROM configs)) THEN 
    SET new.active_tickets = 2;
    END 
    IF;
END |
DELIMITER ;