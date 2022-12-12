-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour wakfutournament
CREATE DATABASE IF NOT EXISTS `wakfutournament` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wakfutournament`;

-- Listage de la structure de la table wakfutournament. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.category : ~0 rows (environ)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. character
CREATE TABLE IF NOT EXISTS `character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guild` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_character_id` int(11) NOT NULL,
  `nation_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_937AB034DEB44523` (`class_character_id`),
  KEY `IDX_937AB034AE3899` (`nation_id`),
  KEY `IDX_937AB0341844E6B7` (`server_id`),
  KEY `IDX_937AB034A76ED395` (`user_id`),
  KEY `IDX_937AB034708A0E0` (`gender_id`),
  CONSTRAINT `FK_937AB0341844E6B7` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`),
  CONSTRAINT `FK_937AB034708A0E0` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`),
  CONSTRAINT `FK_937AB034A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_937AB034AE3899` FOREIGN KEY (`nation_id`) REFERENCES `nation` (`id`),
  CONSTRAINT `FK_937AB034DEB44523` FOREIGN KEY (`class_character_id`) REFERENCES `class_character` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.character : ~6 rows (environ)
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
INSERT INTO `character` (`id`, `character_name`, `guild`, `class_character_id`, `nation_id`, `server_id`, `user_id`, `gender_id`) VALUES
	(1, 'Mélusine', 'Edda Saemundar', 1, 3, 1, 1, 2),
	(2, 'Scarlet', 'Edda Saemundar', 2, 3, 1, 1, 2),
	(3, 'Bloody Fury', 'Edda Saemundar', 3, 3, 1, 1, 2),
	(4, 'Maské', NULL, 14, 3, 1, 1, 1),
	(6, 'Bidule', NULL, 7, 1, 2, 2, 2),
	(7, 'Zimas', 'Goats', 4, 2, 1, 5, 1);
/*!40000 ALTER TABLE `character` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. class_character
CREATE TABLE IF NOT EXISTS `class_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_female` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_male` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.class_character : ~18 rows (environ)
/*!40000 ALTER TABLE `class_character` DISABLE KEYS */;
INSERT INTO `class_character` (`id`, `class_name`, `logo`, `img_female`, `img_male`) VALUES
	(1, 'Osamodas', 'osamodas-logo.png', 'osamodas_f.png', 'osamodas.png'),
	(2, 'Eniripsa', 'eniripsa-logo.png', 'eniripsa_f.png', 'eniripsa.png'),
	(3, 'Sacrieur', 'sacrieur-logo.png', 'sacrieur_f.png', 'sacrieur.png'),
	(4, 'Xélor', 'xelor-logo.png', 'xelor_f.png', 'xelor.png'),
	(5, 'Sadida', 'sadida-logo.png', 'sadida_f.png', 'sadida.png'),
	(6, 'Iop', 'iop-logo.png', 'iop_f.png', 'iop.png'),
	(7, 'Cra', 'cra-logo.png', 'cra_f.png', 'cra.png'),
	(8, 'Féca', 'feca-logo.png', 'feca_f.png', 'feca.png'),
	(9, 'Pandawa', 'pandawa-logo.png', 'pandawa_f.png', 'pandawa.png'),
	(10, 'Sram', 'sram-logo.png', 'sram_f.png', 'sram.png'),
	(11, 'Ecaflip', 'ecaflip-logo.png', 'ecaflip_f.png', 'ecaflip.png'),
	(12, 'Enutrof', 'enutrof-logo.png', 'enutrof_f.png', 'enutrof.png'),
	(13, 'Roublard', 'roublard-logo.png', 'roublard_f.png', 'roublard.png'),
	(14, 'Zobal', 'zobal-logo.png', 'zobal_f.png', 'zobal.png'),
	(15, 'Steamer', 'steamer-logo.png', 'steamer_f.png', 'steamer.png'),
	(16, 'Eliotrope', 'eliotrope-logo.png', 'eliotrope_f.png', 'eliotrope.png'),
	(17, 'Huppermage', 'huppermage-logo.png', 'huppermage_f.png', 'huppermage.png'),
	(18, 'Ouginak', 'ouginak-logo.png', 'ouginak_f.png', 'ouginak.png');
/*!40000 ALTER TABLE `class_character` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. conversation
CREATE TABLE IF NOT EXISTS `conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_initiator_id` int(11) NOT NULL,
  `conversation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8A8E26E92D58D955` (`conversation_initiator_id`),
  CONSTRAINT `FK_8A8E26E92D58D955` FOREIGN KEY (`conversation_initiator_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.conversation : ~2 rows (environ)
/*!40000 ALTER TABLE `conversation` DISABLE KEYS */;
INSERT INTO `conversation` (`id`, `conversation_initiator_id`, `conversation_name`) VALUES
	(1, 1, 'Conversation Test'),
	(2, 2, 'Conversation reception Test');
/*!40000 ALTER TABLE `conversation` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table wakfutournament.doctrine_migration_versions : ~0 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20221003135216', '2022-10-11 06:45:32', 299),
	('DoctrineMigrations\\Version20221015083241', '2022-10-15 08:32:51', 1177);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. gender
CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.gender : ~2 rows (environ)
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` (`id`, `gender_type`) VALUES
	(1, 'male'),
	(2, 'female');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `sending_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FA76ED395` (`user_id`),
  KEY `IDX_B6BD307F9AC0396` (`conversation_id`),
  CONSTRAINT `FK_B6BD307F9AC0396` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`),
  CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.message : ~2 rows (environ)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` (`id`, `user_id`, `conversation_id`, `message`, `is_read`, `sending_date`) VALUES
	(1, 1, 1, 'Message test', 1, '2022-10-17 14:47:24'),
	(2, 2, 1, 'Reponse test 1', 1, '2022-10-17 14:47:46');
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.messenger_messages : ~2 rows (environ)
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
	(1, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:171:\\"http://localhost:8000/verify/email?expires=1666274954&signature=UDH7%2FlWZ7XSUXl2hmmLD8BbLKrqa20jZCY67o%2FoIiRk%3D&token=FdoGmCYqE%2FXhgDHpAg73oN9%2FXBhxJhD4QAxln0Dzpus%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:26:\\"admin@wakfu-tournament.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:16:\\"Wakfu Tournament\\";}}s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:12:\\"jean@jean.fr\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2022-10-20 13:09:15', '2022-10-20 13:09:15', NULL),
	(2, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:163:\\"http://localhost:8000/verify/email?expires=1666279612&signature=hqY0jsGy25zbzBnWqttmZSnSuFzlabQH6wFY4RG2F0Y%3D&token=PSWUEz2N6kGYfjYEMPQoyLDowKZv4Db18JS58Bw15tE%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:26:\\"admin@wakfu-tournament.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:16:\\"Wakfu Tournament\\";}}s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:6:\\"d@d.fr\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2022-10-20 14:26:52', '2022-10-20 14:26:52', NULL),
	(3, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:169:\\"http://localhost:8000/verify/email?expires=1666338452&signature=ZQbJ1MCpEPMGwW6LNmflrGTWS43NaUtC%2BRPrW0j0Z%2FQ%3D&token=dZup8k69uFWNsUBzdTy2VlpOt7h9hbOG%2BUy3mpfC3LQ%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:26:\\"admin@wakfu-tournament.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:16:\\"Wakfu Tournament\\";}}s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:6:\\"d@d.fr\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2022-10-21 06:47:32', '2022-10-21 06:47:32', NULL);
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. nation
CREATE TABLE IF NOT EXISTS `nation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.nation : ~5 rows (environ)
/*!40000 ALTER TABLE `nation` DISABLE KEYS */;
INSERT INTO `nation` (`id`, `name`) VALUES
	(1, 'Amakna'),
	(2, 'Bonta'),
	(3, 'Brâkmar'),
	(4, 'Sufokia'),
	(5, 'Aucune');
/*!40000 ALTER TABLE `nation` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. participation
CREATE TABLE IF NOT EXISTS `participation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `participator_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB55E24F8E46E9DE` (`participator_id`),
  KEY `IDX_AB55E24F9AC0396` (`conversation_id`),
  CONSTRAINT `FK_AB55E24F8E46E9DE` FOREIGN KEY (`participator_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_AB55E24F9AC0396` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.participation : ~2 rows (environ)
/*!40000 ALTER TABLE `participation` DISABLE KEYS */;
INSERT INTO `participation` (`id`, `participator_id`, `conversation_id`) VALUES
	(1, 2, 1),
	(2, 1, 2);
/*!40000 ALTER TABLE `participation` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. server
CREATE TABLE IF NOT EXISTS `server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.server : ~2 rows (environ)
/*!40000 ALTER TABLE `server` DISABLE KEYS */;
INSERT INTO `server` (`id`, `server_name`) VALUES
	(1, 'Pandora'),
	(2, 'Rubilax'),
	(3, 'Serveur Bêta');
/*!40000 ALTER TABLE `server` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. sub_category
CREATE TABLE IF NOT EXISTS `sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BCE3F79812469DE2` (`category_id`),
  CONSTRAINT `FK_BCE3F79812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.sub_category : ~0 rows (environ)
/*!40000 ALTER TABLE `sub_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_category` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. team
CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leader_id` int(11) NOT NULL,
  `team_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `server_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C4E0A61F73154ED4` (`leader_id`),
  KEY `IDX_C4E0A61F1844E6B7` (`server_id`),
  CONSTRAINT `FK_C4E0A61F1844E6B7` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`),
  CONSTRAINT `FK_C4E0A61F73154ED4` FOREIGN KEY (`leader_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.team : ~5 rows (environ)
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` (`id`, `team_name`, `leader_id`, `team_logo`, `description`, `server_id`, `creation_date`) VALUES
	(1, 'Brâk\' assez', 1, '261d90d2dc322e530862fc33ef619b1b.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nulla metus, lacinia a scelerisque id, accumsan id velit. Fusce eget velit euismod sem mattis gravida. Donec porta quam ut mi pretium congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce varius arcu ut metus fringilla gravida. Curabitur quis suscipit erat, ut semper turpis. In ligula eros, eleifend in vestibulum in, mollis quis purus.', 1, '2022-11-03 14:19:04'),
	(2, 'Testouille team', 2, 'team-default.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nulla metus, lacinia a scelerisque id, accumsan id velit. Fusce eget velit euismod sem mattis gravida. Donec porta quam ut mi pretium congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce varius arcu ut metus fringilla gravida. Curabitur quis suscipit erat, ut semper turpis. In ligula eros, eleifend in vestibulum in, mollis quis purus.', 1, '2022-10-27 07:52:06'),
	(3, 'Seconde team', 1, 'team-default.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nulla metus, lacinia a scelerisque id, accumsan id velit. Fusce eget velit euismod sem mattis gravida. Donec porta quam ut mi pretium congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce varius arcu ut metus fringilla gravida. Curabitur quis suscipit erat, ut semper turpis. In ligula eros, eleifend in vestibulum in, mollis quis purus.', 2, '2022-11-03 13:17:53'),
	(4, 'Vampire', 5, 'team-default.jpg', 'Team chillax', 1, '2022-11-10 08:14:21'),
	(10, 'hack team', 1, 'team-default.jpg', 'pouetipouet', 2, '2022-11-10 15:00:19');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_id` int(11) NOT NULL,
  `topic_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `statut` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BF7BFE87C` (`sub_category_id`),
  CONSTRAINT `FK_9D40DE1BF7BFE87C` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.topic : ~0 rows (environ)
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. tournament
CREATE TABLE IF NOT EXISTS `tournament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tournament_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisator_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `mode_id` int(11) NOT NULL,
  `img_tournament` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_tournament` longtext COLLATE utf8mb4_unicode_ci,
  `reward_choice` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reward` longtext COLLATE utf8mb4_unicode_ci,
  `limited_inscription` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_team_limit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BD5FB8D9FFDD4EC8` (`organisator_id`),
  KEY `IDX_BD5FB8D91844E6B7` (`server_id`),
  KEY `IDX_BD5FB8D977E5854A` (`mode_id`),
  CONSTRAINT `FK_BD5FB8D91844E6B7` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`),
  CONSTRAINT `FK_BD5FB8D977E5854A` FOREIGN KEY (`mode_id`) REFERENCES `tournament_mode` (`id`),
  CONSTRAINT `FK_BD5FB8D9FFDD4EC8` FOREIGN KEY (`organisator_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.tournament : ~6 rows (environ)
/*!40000 ALTER TABLE `tournament` DISABLE KEYS */;
INSERT INTO `tournament` (`id`, `tournament_name`, `organisator_id`, `server_id`, `mode_id`, `img_tournament`, `start_date`, `end_date`, `place`, `description_tournament`, `reward_choice`, `reward`, `limited_inscription`, `nb_team_limit`) VALUES
	(1, 'Tournois fini', 1, 2, 1, 'tournament-default.jpg', '2022-10-19 16:28:00', '2022-10-26 16:27:00', 'ecaflipus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nulla metus, lacinia a scelerisque id, accumsan id velit. Fusce eget velit euismod sem mattis gravida. Donec porta quam ut mi pretium congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce varius arcu ut metus fringilla gravida. Curabitur quis suscipit erat, ut semper turpis. In ligula eros, eleifend in vestibulum in, mollis quis purus.', 'false', '', 'true', 2),
	(2, 'Premier tournois en cours', 1, 1, 4, 'tournament-default.jpg', '2023-01-06 18:00:00', '2023-01-16 18:00:00', 'ecaflipus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nulla metus, lacinia a scelerisque id, accumsan id velit. Fusce eget velit euismod sem mattis gravida. Donec porta quam ut mi pretium congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce varius arcu ut metus fringilla gravida. Curabitur quis suscipit erat, ut semper turpis. In ligula eros, eleifend in vestibulum in, mollis quis purus.', 'true', '- des kamas', 'false', NULL),
	(3, 'Tournois en cours', 2, 1, 7, 'tournament-default.jpg', '2022-10-28 08:00:00', '2022-12-27 08:00:00', 'ecaflipus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nulla metus, lacinia a scelerisque id, accumsan id velit. Fusce eget velit euismod sem mattis gravida. Donec porta quam ut mi pretium congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce varius arcu ut metus fringilla gravida. Curabitur quis suscipit erat, ut semper turpis. In ligula eros, eleifend in vestibulum in, mollis quis purus.', 'true', '- un costume', 'false', NULL),
	(4, 'Tournois pour s\'inscrire', 2, 1, 1, 'tournament-default.jpg', '2023-01-06 18:00:00', '2023-01-16 18:00:00', 'ecaflipus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nulla metus, lacinia a scelerisque id, accumsan id velit. Fusce eget velit euismod sem mattis gravida. Donec porta quam ut mi pretium congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce varius arcu ut metus fringilla gravida. Curabitur quis suscipit erat, ut semper turpis. In ligula eros, eleifend in vestibulum in, mollis quis purus.', 'false', NULL, 'false', NULL),
	(5, 'Tournois des goats', 5, 1, 1, 'tournament-default.jpg', '2023-01-09 18:00:00', '2023-01-15 18:00:00', 'Sufokia', 'Tournois pour les goats seulement !', 'true', '- costume peeveepee', 'true', 20),
	(6, 'voezvbnoZ', 3, 1, 4, 'tournament-default.jpg', '2023-11-10 09:54:07', '2023-12-10 09:54:12', 'quelque part', 'bdbhbcbijzbvpibpazig', 'true', '- une photo de pakito', 'true', 2);
/*!40000 ALTER TABLE `tournament` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. tournament_mode
CREATE TABLE IF NOT EXISTS `tournament_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_players_by_team` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.tournament_mode : ~6 rows (environ)
/*!40000 ALTER TABLE `tournament_mode` DISABLE KEYS */;
INSERT INTO `tournament_mode` (`id`, `mode_name`, `nb_players_by_team`) VALUES
	(1, '6 vs 6', 6),
	(2, '5 vs 5', 5),
	(3, '4 vs 4', 4),
	(4, '3 vs 3', 3),
	(5, '2 vs 2', 2),
	(6, '1 vs 1', 1),
	(7, 'Autre', NULL);
/*!40000 ALTER TABLE `tournament_mode` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. tournament_team
CREATE TABLE IF NOT EXISTS `tournament_team` (
  `tournament_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`tournament_id`,`team_id`),
  KEY `IDX_F36D142133D1A3E7` (`tournament_id`),
  KEY `IDX_F36D1421296CD8AE` (`team_id`),
  CONSTRAINT `FK_F36D1421296CD8AE` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_F36D142133D1A3E7` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.tournament_team : ~1 rows (environ)
/*!40000 ALTER TABLE `tournament_team` DISABLE KEYS */;
INSERT INTO `tournament_team` (`tournament_id`, `team_id`) VALUES
	(6, 2),
	(6, 4);
/*!40000 ALTER TABLE `tournament_team` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudonyme` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discord_pseudo` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitch_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D6491FE3BDAF` (`pseudonyme`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.user : ~5 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `pseudonyme`, `email`, `password`, `roles`, `is_verified`, `creation_date`, `avatar`, `discord_pseudo`, `twitch_link`) VALUES
	(1, 'Achanga', 'julie@julie.fr', '$2y$13$JYZ2.JZBHe8yDs6PPJDWeOPYeAGYx9O0IXKWQ1aJZ1sL6T4NqU6HK', '[]', 1, '2022-10-05 10:30:16', 'profil-julie.jpg', 'Non renseigné', 'Non renseigné'),
	(2, 'Testouille', 'test@test.fr', '$2y$13$MTmBV6f/TUb/CdqscMIPRefItTMsY9dM.g76bIqSPkB21Io.0xDyK', '[]', 1, '2022-10-10 07:10:02', '46185fc7690f631eb861752c4c85b9ab.jpg', 'Testouille', 'testwitch'),
	(3, 'Kevin', 'kevin@kevin.fr', '$2y$13$JHzC74pXnWJRhToFV1jvW.AMIXlQCctBFolOfrFQjBDKcyNZQ0Mqe', '[]', 1, '2022-10-04 14:22:45', 'e991d330310d948d85ef0bb1d4a3d9c4.jpg', 'Non renseigné', 'Non renseigné'),
	(4, 'Aman', 'aman@aman.fr', '$2y$13$JHzC74pXnWJRhToFV1jvW.AMIXlQCctBFolOfrFQjBDKcyNZQ0Mqe', '[]', 1, '2022-11-10 09:01:10', '137fa53c0e042aba90f167daecae6d62.jpg', 'Non renseigné', 'Non renseigné'),
	(5, 'Zimas', 'zimas@zimas.fr', '$2y$13$5UNx97iEAILOTon0kbhcKu6MH4q6AOMPj8AIFuNjhz8aJSFUv/F0y', '[]', 0, '2022-11-10 08:48:09', 'fd77d41aac43a41745f3f9c3d0a88f9e.png', 'Non renseigné', 'Non renseigné'),
	(6, 'Juju', 'juju@spaghetti.fr', '12345678', '[]', 1, '2022-11-10 09:02:45', 'profil-default.png', 'Non renseigné', 'Non renseigné');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Listage de la structure de la table wakfutournament. user_team
CREATE TABLE IF NOT EXISTS `user_team` (
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`team_id`),
  KEY `IDX_BE61EAD6A76ED395` (`user_id`),
  KEY `IDX_BE61EAD6296CD8AE` (`team_id`),
  CONSTRAINT `FK_BE61EAD6296CD8AE` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_BE61EAD6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table wakfutournament.user_team : ~9 rows (environ)
/*!40000 ALTER TABLE `user_team` DISABLE KEYS */;
INSERT INTO `user_team` (`user_id`, `team_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 10),
	(2, 2),
	(3, 1),
	(4, 1),
	(5, 4);
/*!40000 ALTER TABLE `user_team` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
