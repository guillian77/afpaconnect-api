select status_users__tickets 
from users__tickets 
where id_tickets = @id_tickets 
AND 
id_users = @id_users 