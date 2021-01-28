SELECT
    tickets.subject_tickets,
    tickets.id_tickets,
    tickets.description_tickets,
    tickets.resolved_tickets,
    tickets.count_report_tickets,
    tickets.reported_tickets,
    tickets.active_tickets,
    tickets.id_topics,
    tickets.id_priorities,
    tickets.created_at_tickets,
    MOD( DATE_FORMAT( TIMEDIFF( NOW(), tickets.created_at_tickets ), "%i" ),  MINUTE(priorities.interval_priorities) ) AS modulo,
    ROUND(UNIX_TIMESTAMP()/60) as maintenant,
    round(UNIX_TIMESTAMP(tickets.created_at_tickets)/60) + MINUTE(priorities.interval_priorities) as created_plus_int
FROM tickets

JOIN priorities ON priorities.id_priorities = tickets.id_priorities
JOIN users__tickets ON users__tickets.id_tickets = tickets.id_tickets

WHERE MOD( DATE_FORMAT( TIMEDIFF( NOW(), tickets.created_at_tickets ), "%i" ),  MINUTE(priorities.interval_priorities)) = 0
AND users__tickets.status_users__tickets != "helper"
AND tickets.resolved_tickets = 0
AND tickets.reported_tickets = 0
AND tickets.active_tickets = 1
AND ROUND(UNIX_TIMESTAMP()/60) >= round(UNIX_TIMESTAMP(tickets.created_at_tickets)/60) + MINUTE(priorities.interval_priorities);