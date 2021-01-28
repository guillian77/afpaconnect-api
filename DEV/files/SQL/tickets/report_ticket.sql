UPDATE tickets

    INNER JOIN users__tickets 
    ON tickets.id_tickets = users__tickets.id_tickets

        SET tickets.active_tickets = 2 ,

            tickets.reported_tickets = 1,

            users__tickets.reason_report = '@reason_report',

            users__tickets.date_report = NOW()

        WHERE tickets.id_tickets =@id_ticket;

