UPDATE tickets set subject_tickets="@subject_tickets",
 description_tickets="@description_tickets",
id_topics=@id_topics,id_priorities=@id_priorities,
updated_at_tickets= NOW()
where id_tickets=@id_tickets
