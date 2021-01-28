-- create a new formation
INSERT INTO 
    formations
    (id_formations, designation_formations, active_formations)
    VALUES
    (NULL, "@designation_formations", @active_formations);