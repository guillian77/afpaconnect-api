SELECT tickets.id_tickets,
    priorities.designation_priorities, 
    tickets.subject_tickets,
    topics.designation_topics, 
    DATE_FORMAT(tickets.created_at_tickets,"%d-%c-%Y à %H:%i"), 
    users.lastname_users,
    tickets.description_tickets

    FROM tickets
        INNER JOIN priorities
        ON tickets.id_priorities = priorities.id_priorities

        INNER JOIN topics
        ON  tickets.id_topics = topics.id_topics

        INNER JOIN users__tickets
        ON tickets.id_tickets = users__tickets.id_tickets

        INNER JOIN users
        ON users.id_users = users__tickets.id_users

        WHERE users.id_users = @id_users
    
        AND tickets.active_tickets = 1
        AND users__tickets.status_users__tickets = "owner";
