UPDATE tickets 

    SET active_tickets = 0

WHERE tickets.id_tickets =@id_tickets;
