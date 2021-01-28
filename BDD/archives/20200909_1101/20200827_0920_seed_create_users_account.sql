-- ----------------------
-- USERS
-- ----------------------
INSERT INTO `users`
    (`id_users`, `firstname_users`, `lastname_users`, `email_users`, `password_users`, `key_reset_users`, `birthdate_users`, `discord_id_users`, `created_at_users`, `updated_at_users`, `active_users`)
    VALUES
    (NULL, 'p_admin', 'n_admin', 'admin@admin.fr', '$argon2i$v=19$m=1024,t=2,p=2$c0dGTmwuNDYzQkRkclFrZA$BeT6jvtx/ZmXuRm4gas5R6eBKeSVlvrBtt6UzFxAwgk', NULL, '1995-09-01', 'Dekadmin#5545', '2020-08-27', NULL, '1');

INSERT INTO `users`
    (`id_users`, `firstname_users`, `lastname_users`, `email_users`, `password_users`, `key_reset_users`, `birthdate_users`, `discord_id_users`, `created_at_users`, `updated_at_users`, `active_users`)
    VALUES
    (NULL, 'p_user', 'n_user', 'user@user.fr', '$argon2i$v=19$m=1024,t=2,p=2$NlBWZENrQmovWkI0aXJhSQ$GTlTUfa8JbGVXdH5OgT5oQbsZB8+muDmJuWhDPzjm2Q', NULL, '1995-09-01', 'Dekadmin#5545', '2020-08-27', NULL, '1');
