select * from tickets 
INNER JOIN topics ON tickets.id_topics = topics.id_topics
INNER JOIN priorities ON tickets.id_priorities = priorities.id_priorities
WHERE id_tickets = @id_tickets