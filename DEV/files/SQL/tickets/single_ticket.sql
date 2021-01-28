SELECT tickets.id_tickets,
    tickets.subject_tickets,
    tickets.description_tickets, 
    DATE_FORMAT(tickets.created_at_tickets,"%d-%c-%Y à %H:%i") AS date_tickets, 
    priorities.designation_priorities, topics.designation_topics, 
    users__tickets.reason_report 

    FROM tickets 

    INNER JOIN priorities 
    ON tickets.id_priorities = priorities.id_priorities 

    INNER JOIN topics 
    ON tickets.id_topics = topics.id_topics 

    INNER JOIN users__tickets 
    ON users__tickets.id_tickets = tickets.id_tickets 

    WHERE tickets.id_tickets = @id_ticket
    AND users__tickets.status_users__tickets = "owner";