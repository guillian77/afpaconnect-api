-- --------------------------
-- SESSIONS: update
-- --------------------------
-- Edit current `date_session` to `start_at_sessions`
-- Add end column for sessions

ALTER TABLE `sessions` CHANGE `date_sessions` `start_at_sessions` DATE NULL DEFAULT NULL;
ALTER TABLE `sessions` ADD `end_at_sessions` DATE NULL AFTER `start_at_sessions`;
