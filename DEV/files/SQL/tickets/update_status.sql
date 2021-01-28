UPDATE tickets 
    SET active_tickets = @active_tickets
    WHERE tickets.id_tickets = @id_ticket;