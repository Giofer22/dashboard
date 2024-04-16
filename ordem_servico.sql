-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Abr-2024 às 00:18
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ordem_servico`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `PK_CLIENTE` int(11) NOT NULL,
  `NOME` varchar(100) DEFAULT NULL,
  `CPF` varchar(14) DEFAULT NULL,
  `WHATSAPP` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`PK_CLIENTE`, `NOME`, `CPF`, `WHATSAPP`, `EMAIL`) VALUES
(2, 'Glauco Santos', '987.654.321-00', '(12)98888-7418', 'glauco.psantos@sp.senac.br'),
(5, 'Davilla Arielle', '789.123.456-00', '(12) 99876-5432', 'davilla.arielle@sp.senac.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordens_servicos`
--

CREATE TABLE `ordens_servicos` (
  `PK_ORDEM_SERVICO` int(11) NOT NULL,
  `DATA_ORDEM_SERVICO` date DEFAULT NULL,
  `DATA_INICIO` date DEFAULT NULL,
  `DATA_FIM` date DEFAULT NULL,
  `VALOR_TOTAL` decimal(10,2) DEFAULT NULL,
  `FK_CLIENTE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ordens_servicos`
--

INSERT INTO `ordens_servicos` (`PK_ORDEM_SERVICO`, `DATA_ORDEM_SERVICO`, `DATA_INICIO`, `DATA_FIM`, `VALOR_TOTAL`, `FK_CLIENTE`) VALUES
(1, '2024-03-04', '2024-03-06', NULL, '1150.50', 5),
(2, '2024-03-08', NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_servicos_os`
--

CREATE TABLE `rl_servicos_os` (
  `FK_SERVICO` int(11) DEFAULT NULL,
  `FK_ORDEM_SERVICO` int(11) DEFAULT NULL,
  `VALOR` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `rl_servicos_os`
--

INSERT INTO `rl_servicos_os` (`FK_SERVICO`, `FK_ORDEM_SERVICO`, `VALOR`) VALUES
(1, 1, '500.00'),
(2, 1, '100.00'),
(4, 1, '550.50'),
(2, 2, '180.00'),
(4, 2, '120.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `pk_SERVICO` int(11) NOT NULL,
  `SERVICO` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`pk_SERVICO`, `SERVICO`) VALUES
(1, 'Manutencao de micro'),
(2, 'formatacao e instalacao de softwares'),
(3, 'montagem de computadores'),
(4, 'configuracao de roteador'),
(5, 'remocao de virus');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teste`
--

CREATE TABLE `teste` (
  `pk_teste` int(11) NOT NULL COMMENT 'kkk muito bom\n',
  `nome` varchar(50) NOT NULL,
  `data_hora` datetime DEFAULT current_timestamp(),
  `ativo` tinyint(1) DEFAULT 1,
  `cpf` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `teste`
--

INSERT INTO `teste` (`pk_teste`, `nome`, `data_hora`, `ativo`, `cpf`) VALUES
(1, 'Glauco', '2024-03-11 21:05:24', 1, '123.456.789-00'),
(2, 'Fernando', '2024-03-11 21:05:24', 1, '147.852.369-00'),
(3, 'Rodrigo', '2024-03-11 21:23:57', 1, '159.357.824-66');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `pk_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`pk_usuario`, `nome`, `email`, `senha`) VALUES
(1, 'giovanni', 'email@email.com', '1234');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`PK_CLIENTE`),
  ADD UNIQUE KEY `CPF` (`CPF`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `WHATSAPP` (`WHATSAPP`);

--
-- Índices para tabela `ordens_servicos`
--
ALTER TABLE `ordens_servicos`
  ADD PRIMARY KEY (`PK_ORDEM_SERVICO`),
  ADD KEY `FK_ORDENS_SERVICOS_2` (`FK_CLIENTE`);

--
-- Índices para tabela `rl_servicos_os`
--
ALTER TABLE `rl_servicos_os`
  ADD KEY `FK_RL_SERVICOS_OS_1` (`FK_SERVICO`),
  ADD KEY `FK_RL_SERVICOS_OS_2` (`FK_ORDEM_SERVICO`);

--
-- Índices para tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`pk_SERVICO`);

--
-- Índices para tabela `teste`
--
ALTER TABLE `teste`
  ADD PRIMARY KEY (`pk_teste`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`pk_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `PK_CLIENTE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `ordens_servicos`
--
ALTER TABLE `ordens_servicos`
  MODIFY `PK_ORDEM_SERVICO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `pk_SERVICO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `teste`
--
ALTER TABLE `teste`
  MODIFY `pk_teste` int(11) NOT NULL AUTO_INCREMENT COMMENT 'kkk muito bom\n', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `pk_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `ordens_servicos`
--
ALTER TABLE `ordens_servicos`
  ADD CONSTRAINT `FK_ORDENS_SERVICOS_2` FOREIGN KEY (`FK_CLIENTE`) REFERENCES `clientes` (`PK_CLIENTE`);

--
-- Limitadores para a tabela `rl_servicos_os`
--
ALTER TABLE `rl_servicos_os`
  ADD CONSTRAINT `FK_RL_SERVICOS_OS_1` FOREIGN KEY (`FK_SERVICO`) REFERENCES `servicos` (`PK_SERVICO`),
  ADD CONSTRAINT `FK_RL_SERVICOS_OS_2` FOREIGN KEY (`FK_ORDEM_SERVICO`) REFERENCES `ordens_servicos` (`PK_ORDEM_SERVICO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
