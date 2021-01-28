select count(*) as COUNT_TICKET from tickets 
INNER JOIN users__tickets
    ON tickets.id_tickets = users__tickets.id_tickets 

INNER JOIN users 
    ON users__tickets.id_users = users.id_users

where users__tickets.id_users = @id_users
AND tickets.active_tickets = 1
AND users__tickets.status_users__tickets = "owner"