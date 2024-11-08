-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08/11/2024 às 13:31
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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `forum_perguntas`
--

INSERT INTO `forum_perguntas` (`fk_id_usuario`, `id_pergunta`, `area`, `duvida_area`, `pergunta`) VALUES
(1, 3, 'TI', 'RH', 'Qual é o processo para solicitar o vale-transporte?'),
(1, 2, 'TI', 'RH', 'Como faço para utilizar o plano de saúde ou odontológico?'),
(1, 1, 'TI', 'RH', 'Quais benefícios a empresa oferece?'),
(1, 4, 'TI', 'RH', 'Como funciona o vale-refeição ou alimentação?'),
(2, 5, 'Vendas', 'RH', 'A empresa oferece algum auxílio para educação ou cursos?'),
(2, 6, 'Vendas', 'RH', 'Quando é o pagamento do salário');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `forum_respostas`
--

INSERT INTO `forum_respostas` (`fk_id_usuario`, `fk_id_pergunta`, `id_resposta`, `resposta`, `curtidas`) VALUES
(2, 1, 1, 'A empresa oferece uma variedade de benefícios para apoiar o bem-estar e o desenvolvimento dos colaboradores. Nossos principais benefícios incluem:\r\n\r\nPlano de Saúde e Odontológico: Cobrimos consultas, exames, e alguns procedimentos básicos e de emergência, com extensões para dependentes.\r\nVale-Refeição ou Vale-Alimentação: Com valor mensal que pode ser utilizado em mercados, padarias e restaurantes credenciados.\r\nVale-Transporte: Subsidiado para quem precisa de auxílio com deslocamento.\r\nSeguro ', NULL),
(2, 2, 2, 'Para utilizar o plano de saúde, basta entrar em contato com uma das clínicas ou laboratórios credenciados e apresentar sua carteirinha do plano de saúde, que foi emitida no momento da contratação. Caso ainda não tenha a carteirinha, você pode solicitar uma segunda via diretamente conosco no RH ou acessá-la pelo aplicativo do plano, onde também é possível visualizar todas as opções de atendimento e especialidades.\r\n\r\nPara o plano odontológico, o processo é semelhante: basta procurar um profission', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `imagem_usuario`, `statusAdministrador_usuario`) VALUES
(1, 'Amanda', 'amandaveigafurtado@gmail.com', '$2y$10$QZEMW75b3179MRkwDPWsJ.FvMeSFvyB2b7KmbBir2y/G/PL9iWbEC', 'css/img/usuario/image.png', 'a'),
(2, 'Usuario', '1234@gmail.com', '$2y$10$xy6UtoQLNbxeBA.1zS/zquv3ck3VoXHS6YTF2XVcUMW6sKYxR9fiS', 'css/img/usuario/no_image.png', 'c');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
