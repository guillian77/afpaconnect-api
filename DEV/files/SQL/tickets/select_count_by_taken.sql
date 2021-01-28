SELECT
      COUNT(tickets.id_tickets) AS count
    FROM tickets

    JOIN users__tickets ON users__tickets.id_tickets = tickets.id_tickets

    WHERE active_tickets = 1
    AND status_users__tickets = "helper";