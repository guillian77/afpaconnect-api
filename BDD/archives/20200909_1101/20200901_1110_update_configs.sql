-- Remove useless auto increment ID from configs table.
ALTER TABLE configs DROP COLUMN id_configs;

-- Remove useless auto increment ID from configs table.
ALTER TABLE configs DROP COLUMN active_configs;

-- Edit any fields to unique
ALTER TABLE `configs` ADD UNIQUE(`discord_token_configs`);
ALTER TABLE `configs` ADD UNIQUE(`discord_id_guild_configs`);
ALTER TABLE `configs` ADD UNIQUE(`discord_notif_channel_configs`);
ALTER TABLE `configs` ADD UNIQUE(`ticket_limit_configs`);
ALTER TABLE `configs` ADD UNIQUE(`img_limit_configs`);
ALTER TABLE `configs` ADD UNIQUE(`report_limit_configs`);
ALTER TABLE `configs` ADD UNIQUE(`size_screen_configs`);

-- Move discord_id_guild_configs length from 11 to 18 + BIG INT
ALTER TABLE `configs` CHANGE `discord_id_guild_configs` `discord_id_guild_configs` BIGINT(18) NOT NULL;

-- Move discord_id_guild_configs length from 255 to 18 + BIG INT
ALTER TABLE `configs` CHANGE `discord_notif_channel_configs` `discord_notif_channel_configs` BIGINT(18) NOT NULL;
