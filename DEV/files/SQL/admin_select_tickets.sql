SELECT tickets.id_tickets,
priorities.designation_priorities,
`subject_tickets`,
topics.designation_topics,
DATE_FORMAT(tickets.created_at_tickets,"%d-%m-%Y à %H:%i"),
users.firstname_users
FROM tickets
INNER JOIN (topics,priorities,users__tickets,users)
ON topics.id_topics = tickets.id_topics
AND priorities.id_priorities = tickets.id_priorities
AND users__tickets.id_tickets = tickets.id_tickets
AND users.id_users = users__tickets.id_users
WHERE active_tickets = 1
AND reported_tickets = 0
AND status_users__tickets = 1

