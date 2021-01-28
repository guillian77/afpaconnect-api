-- TODO: Check if TIME should be string
INSERT INTO priorities
    (id_priorities, designation_priorities, interval_priorities, active_priorities)
    VALUE
    (NULL, "@designation_priorities", "@interval_priorities", @active_priorities);