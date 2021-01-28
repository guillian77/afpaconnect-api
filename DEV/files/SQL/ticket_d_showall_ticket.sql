SELECT 
DISTINCT tickets.id_tickets AS ID, tickets.subject_tickets, tickets.created_at_tickets,
 topics.designation_topics, priorities.designation_prioritys, users.firstname_users, screens.name_screens

 FROM users

INNER JOIN users__tickets ON users.id_users = users__tickets.id_users

INNER JOIN tickets ON tickets.id_tickets = users__tickets.id_tickets

INNER JOIN topics ON tickets.id_topics = topics.id_topics

INNER JOIN tickets AS tickets2 ON tickets2.id_topics = topics.id_topics
INNER JOIN priorities ON tickets.id_prioritys = priorities.id_prioritys

INNER JOIN tickets AS tickets3 ON tickets3.id_prioritys = priorities.id_prioritys 

LEFT JOIN screens ON tickets.id_tickets = screens.id_tickets

GROUP BY tickets.id_tickets