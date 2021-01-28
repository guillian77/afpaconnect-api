-- --------------------------
-- SELECT tickets grouped
-- by topics
-- --------------------------
SELECT topics.id_topics, topics.designation_topics, COUNT(topics.id_topics) AS count
    FROM tickets

    JOIN topics ON topics.id_topics = tickets.id_topics

    GROUP BY topics.id_topics

    ORDER BY count DESC

    LIMIT 5;