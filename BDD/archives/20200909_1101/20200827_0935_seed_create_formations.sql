-- ----------------------
-- FORMATIONS
-- ----------------------

-- DWWM
INSERT INTO `formations` (`id_formations`, `designation_formations`, `active_formations`) VALUES (NULL, 'Développeur web et web mobile', '1');
INSERT INTO `sessions` (`id_sessions`, `date_sessions`, `active_sessions`, `id_formations`) VALUES (NULL, '2020-04-06', '1', '1');

-- CDA
INSERT INTO `formations` (`id_formations`, `designation_formations`, `active_formations`) VALUES (NULL, "Concepteur développeur d'application", '1');
INSERT INTO `sessions` (`id_sessions`, `date_sessions`, `active_sessions`, `id_formations`) VALUES (NULL, '2020-04-06', '1', '2');