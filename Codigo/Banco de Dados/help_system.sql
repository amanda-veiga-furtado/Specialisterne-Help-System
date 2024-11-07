-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 07/11/2024 às 14:08
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `help_system`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `forum_perguntas`
--

DROP TABLE IF EXISTS `forum_perguntas`;
CREATE TABLE IF NOT EXISTS `forum_perguntas` (
  `fk_id_usuario` int NOT NULL,
  `id_pergunta` int NOT NULL AUTO_INCREMENT,
  `area` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `duvida_area` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `pergunta` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_pergunta`),
  KEY `fk_id_usuario` (`fk_id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `forum_perguntas`
--

INSERT INTO `forum_perguntas` (`fk_id_usuario`, `id_pergunta`, `area`, `duvida_area`, `pergunta`) VALUES
(0, 1, '1', '1', 'nnnnnnnn'),
(0, 2, '1', '2', 'aaaaaaaaaa'),
(0, 3, '2', '2', '222'),
(0, 4, '2', '1', 'teste'),
(1, 5, '1', '1', 'aaaaaaaa'),
(1, 6, '1', '1', 'gghg'),
(1, 7, '1', '2', 'jjjjjjjjjjj'),
(168, 8, '1', '5', '2'),
(168, 9, '3', '4', 'hhhhhhhhhhh');

-- --------------------------------------------------------

--
-- Estrutura para tabela `forum_respostas`
--

DROP TABLE IF EXISTS `forum_respostas`;
CREATE TABLE IF NOT EXISTS `forum_respostas` (
  `fk_id_usuario` int NOT NULL,
  `fk_id_pergunta` int DEFAULT NULL,
  `id_resposta` int NOT NULL AUTO_INCREMENT,
  `resposta` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `curtidas` int DEFAULT NULL,
  PRIMARY KEY (`id_resposta`),
  KEY `id_usuario` (`fk_id_usuario`,`fk_id_pergunta`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `forum_respostas`
--

INSERT INTO `forum_respostas` (`fk_id_usuario`, `fk_id_pergunta`, `id_resposta`, `resposta`, `curtidas`) VALUES
(0, 2, 1, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', NULL),
(0, 1, 2, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', NULL),
(0, 1, 3, 'aaaaaaaaaa', NULL),
(170, 1, 4, 'hgg', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `senha_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `imagem_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'css/img/usuario/no_image.png',
  `statusAdministrador_usuario` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'c',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `unique_nome_usuario` (`nome_usuario`),
  UNIQUE KEY `unique_email_usuario` (`email_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `imagem_usuario`, `statusAdministrador_usuario`) VALUES
(1, 'Amanda', 'amandaveigafurtado@gmail.com', '$2y$10$QZEMW75b3179MRkwDPWsJ.FvMeSFvyB2b7KmbBir2y/G/PL9iWbEC', 'css/img/usuario/image.png', 'a'),
(168, '1234@gmail.com', '1234@gmail.com', '$2y$10$xy6UtoQLNbxeBA.1zS/zquv3ck3VoXHS6YTF2XVcUMW6sKYxR9fiS', 'css/img/usuario/no_image.png', 'c'),
(169, '12345@gmail.com', '12345@gmail.com', '$2y$10$oe/lPJOt/W2.EV4zToQlq.CKku9uUZ5XbkEY86ldsU3EQ1rbHg1ji', 'css/img/usuario/no_image.png', 'c'),
(170, '1uuu@gmail.com', '1uuu@gmail.com', '$2y$10$dLngHDCuaZgkrf.AqxKWQOHdLxMuJwf58CAnkhAj6Ds8knRhimgcW', 'css/img/usuario/no_image.png', 'c');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
