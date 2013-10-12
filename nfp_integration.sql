-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2013 at 05:11 PM
-- Server version: 5.5.31
-- PHP Version: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nfp_integration`
--

-- --------------------------------------------------------

--
-- Table structure for table `lr_empresa`
--

CREATE TABLE IF NOT EXISTS `lr_empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `razao_social` varchar(255) NOT NULL,
  `nome_fantasia` varchar(255) NOT NULL,
  `cnpj` int(11) NOT NULL,
  `endereco` varchar(255) NULL,
  `bairro` varchar(255) NULL,
  `cidade` varchar(255) NULL,
  `estado` varchar(255) NULL,
  `cep` int(11) NULL,
  `telefone` int(11) NULL,
  `email` varchar(255) NULL,
  `nome_responsavel` varchar(255) NULL,
  `telefone_responsavel` varchar(255) NULL,
  `email_responsavel` varchar(255) NULL,
  `id_nucleo` int(11) NOT NULL,
  `id_voluntario_captador` int(11) NOT NULL,
  `observacao` text NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lr_entidade`
--

CREATE TABLE IF NOT EXISTS `lr_entidade` (
  `id_entidade` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_entidade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lr_nucleo`
--

CREATE TABLE IF NOT EXISTS `lr_nucleo` (
  `id_nucleo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_nucleo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lr_rel_acesso_usuario_tela`
--

CREATE TABLE IF NOT EXISTS `lr_rel_acesso_usuario_tela` (
  `username` varchar(255) NOT NULL,
  `id_tela` int(11) NOT NULL,
  `cod_nivel_acesso` char(1) CHARACTER SET latin1 NOT NULL COMMENT ' ''T'' - total, ''C'' - consulta',
  PRIMARY KEY (`username`,`id_tela`),
  KEY `id_tela` (`id_tela`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lr_config_acesso_tipo_volunt`
--

CREATE TABLE IF NOT EXISTS `lr_config_acesso_tipo_volunt` (
  `id_tipo_voluntario` bigint(11) NOT NULL,
  `id_tela` int(11) NOT NULL,
  `cod_nivel_acesso` char(1) CHARACTER SET latin1 NOT NULL COMMENT ' ''T'' - total, ''C'' - consulta',
  PRIMARY KEY (`id_tipo_voluntario`, `id_tela`, `cod_nivel_acesso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lr_status`
--

CREATE TABLE IF NOT EXISTS `lr_status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lr_status`
--

INSERT INTO `lr_status` (`id_status`, `descricao`) VALUES
(1, 'ATIVO'),
(2, 'INATIVO');

-- --------------------------------------------------------

--
-- Table structure for table `lr_tela`
--

CREATE TABLE IF NOT EXISTS `lr_tela` (
  `id_tela` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_tela`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lr_tipo_voluntario`
--

CREATE TABLE IF NOT EXISTS `lr_tipo_voluntario` (
  `id_tipo_voluntario` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id_tipo_voluntario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lr_usuario`
--

CREATE TABLE IF NOT EXISTS `lr_usuario` (
  `username` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lr_voluntario`
--

CREATE TABLE IF NOT EXISTS `lr_voluntario` (
  `id_voluntario` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_voluntario` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` int(11) NOT NULL,
  `rg` varchar(255) NULL,
  `dt_nascimento` date NULL,
  `endereco` varchar(255) NULL,
  `bairro` varchar(255)  NULL,
  `cidade` varchar(255)  NULL,
  `estado` varchar(255)  NULL,
  `cep` int(11) NULL,
  `telefone` int(11) NULL,
  `profissao` varchar(255) NULL,
  `email` varchar(255) NULL,
  `id_entidade` int(11) NOT NULL,
  `id_nucleo` int(11) NOT NULL,
  `username` varchar(255) NULL,
  PRIMARY KEY (`id_voluntario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lr_rel_acesso_usuario_tela`
--
ALTER TABLE `lr_rel_acesso_usuario_tela`
  ADD CONSTRAINT `lr_rel_acesso_usuario_tela_ibfk_1` FOREIGN KEY (`id_tela`) REFERENCES `lr_tela` (`id_tela`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lr_rel_acesso_usuario_tela_ibfk_2` FOREIGN KEY (`username`) REFERENCES `lr_usuario` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lr_voluntario`
--

ALTER TABLE `lr_voluntario`
  ADD CONSTRAINT `fk_vol_user_1` FOREIGN KEY (`username`) REFERENCES `lr_usuario` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vol_nucleo_2` FOREIGN KEY (`id_nucleo`) REFERENCES `lr_nucleo` (`id_nucleo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vol_ent_3` FOREIGN KEY (`id_entidade`) REFERENCES `lr_entidade` (`id_entidade`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vol_tp_vol_4` FOREIGN KEY (`id_tipo_voluntario`) REFERENCES `lr_tipo_voluntario` (`id_tipo_voluntario`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Table structure for table `lr_importa_arquivo_nota`
--

CREATE TABLE IF NOT EXISTS `lr_importa_arquivo_nota` (
  `id_importa_arquivo_nota` int(11) NOT NULL AUTO_INCREMENT,
  `data_importacao` date null,
  `id_voluntario` int(11) NULL,
  `csv_numero_nota` int(11) NULL,
  `csv_valor_nota` int(11) NULL,
  `csv_data_nota` date NULL,
  `csv_cnpj_entidade_social` int(11) NULL,
  `csv_cpf_cadastrador` int(11) NULL,
  `csv_data_pedido` date NULL,
  `csv_status_pedido` varchar(255) NULL,
  `csv_tipo_pedido` varchar(255) NULL,
  `csv_cnpj_estabelecimento` int(11) NULL,
  `csv_razao_social_estab` varchar(255) NULL,
  PRIMARY KEY (`id_importa_arquivo_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
