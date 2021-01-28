select distinct firstname_users, status_users__tickets, tickets.id_tickets,
 users.id_users, users.discord_id_users
  from users__tickets
INNER JOIN users ON users__tickets.id_users = users.id_users
INNER JOIN tickets ON tickets.id_tickets = users__tickets.id_tickets
WHERE tickets.id_tickets = @id_tickets
AND tickets.active_tickets = 1
