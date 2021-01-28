UPDATE users__tickets 
SET status_users__tickets = "@status_users__tickets"
where id_tickets = @id_tickets 
AND id_users = @id_users