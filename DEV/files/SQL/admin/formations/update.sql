-- update a formation
UPDATE formations
    SET
        designation_formations = "@designation_formations",
        active_formations = @active_formations
    WHERE
        id_formations = @id_formations;