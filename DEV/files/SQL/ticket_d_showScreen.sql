SELECT
    DISTINCT 
     screens.name_screens, screens.id_tickets

FROM users

    INNER JOIN users__tickets ON users.id_users = users__tickets.id_users

    INNER JOIN tickets ON tickets.id_tickets = users__tickets.id_tickets

    INNER JOIN topics ON tickets.id_topics = topics.id_topics

    INNER JOIN tickets AS tickets2 ON tickets2.id_topics = topics.id_topics
    INNER JOIN priorities ON tickets.id_prioritys = priorities.id_prioritys

    INNER JOIN tickets AS tickets3 ON tickets3.id_prioritys = priorities.id_prioritys

    LEFT JOIN screens ON tickets.id_tickets = screens.id_tickets

