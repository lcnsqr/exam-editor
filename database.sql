-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2019 at 07:45 PM
-- Server version: 5.7.25
-- PHP Version: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `cat` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat`) VALUES
(1, '101'),
(2, '102'),
(3, '103'),
(4, '104'),
(5, '105'),
(6, '106'),
(7, '107'),
(8, '108'),
(9, '109'),
(10, '110');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `template_id` int(10) UNSIGNED NOT NULL,
  `contents` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'text/json',
  `cat_id` int(10) UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `template_id`, `contents`, `cat_id`, `enabled`) VALUES
(2, 1, '{\"answer\":[[0,\"<code>insmod</code>\"],[0,\"<code>cat /etc/modprobe.conf</code>\"],[1,\"<code>lsmod</code>\"],[0,\"<code>depmod -m</code>\"],[0,\"<code>modprobe -l</code>\"]],\"context\":{\"var0\":\"lista os módulos do kernel atualmente carregados pelo sistema\"}}', 1, 1),
(41, 2, '{\"context\":{\"var0\":\"Um novo repositório de software foi incluído num sistema que utiliza o gerenciador de pacotes do Debian. \",\"var1\":\"deve ser realizada para que os pacotes desse repositório estejam disponíveis para instalação no sistema local\"},\"answer\":[[0,\"Executar o comando <code>apt-get refresh</code>\"],[1,\"Executar o comando <code>apt-get update</code>\"],[0,\"Executar o comando <code>apt-get upgrade</code>\"],[0,\"Executar o comando <code>apt-get dist-upgrade</code>\"],[0,\"Executar o comando <code>apt-get repo-update</code>\"]]}', 2, 1),
(50, 3, '{\"context\":{\"var0\":\"o comando que redireciona o conteúdo recebido na entrada padrão para a saída padrão e ao mesmo tempo salva o conteúdo num arquivo indicado\",\"var1\":\"Escreva somente o comando, sem opções ou parâmetros\"},\"answer\":[\"tee\"]}', 3, 1),
(60, 4, '{\"context\":{\"var0\":\"será a permissão padrão\",\"var1\":\"será utilizada para novos arquivos caso o valor da máscara <em>umask</em> esteja definido em <code>0002</code>\"},\"answer\":[[0,\"u=rwx,g=rwx,o=rx\"],[1,\"u=rw,g=rw,o=r\"],[0,\"u=rw,g=r,o=r\"],[0,\"u=rwx,g=rwx,o=r\"],[0,\"u=r,g=r,o=r\"]]}', 4, 1),
(71, 5, '{\"context\":{\"var0\":\"a finalidade do comando <code>seq</code>\"},\"answer\":[[0,\"Segmentar um arquivo.\"],[0,\"Unir vários arquivo em um só.\"],[1,\"Exibir uma sequência ordenada de números.\"],[0,\"Ordenar um arquivo de texto em ordem alfabética.\"],[0,\"Executar comandos em sequência.\"]]}', 5, 1),
(77, 6, '{\"context\":{\"var0\":\"caminhos padrão para os arquivos de configuração do servidor Xorg\",\"var1\":\"duas\"},\"answer\":[[1,\"<code>/etc/X11/xorg.conf</code>\"],[1,\"<code>/etc/X11/xorg.conf.d/*.conf</code>\"],[0,\"<code>/etc/default/xorg.conf</code>\"],[0,\"<code>/etc/xorg.conf</code>\"],[0,\"<code>/etc/X11.conf</code>\"]]}', 6, 1),
(91, 3, '{\"context\":{\"var0\":\"o comando que bloqueia alterações no arquivo <code>/etc/group</code> para que possa ser modificado com o editor padrão do sistema\",\"var1\":\"Escreva somente o comando, sem opções ou parâmetros\"},\"answer\":[\"vigr vipw\"]}', 7, 1),
(102, 5, '{\"context\":{\"var0\":\"a finalidade do comando <code>newaliases</code>\"},\"answer\":[[1,\"Atualizar os novos <em>aliases</em> de email no sistema.\"],[0,\"Abrir o assistente de criação de <em>aliases</em> de email.\"],[0,\"Apagar a tabela antiga de <em>aliases</em>.\"],[0,\"Localizar os <em>aliases</em> de email criados recentemente.\"],[0,\"Incluir um novo arquivo que contém <em>aliases</em> de email.\"]]}', 8, 1),
(109, 6, '{\"context\":{\"var0\":\"comandos que podem ser utilizados para exibir as interfaces de rede ativas na máquina local\",\"var1\":\"três\"},\"answer\":[[1,\"<code>ifconfig</code>\"],[1,\"<code>netstat</code>\"],[1,\"<code>ip</code>\"],[0,\"<code>ipconfig</code>\"],[0,\"<code>netconf</code>\"]]}', 9, 1),
(120, 1, '{\"context\":{\"var0\":\"tem a finalidade de gerar chaves pessoais no formato RSA para o SSH\"},\"answer\":[[0,\"<code>ssh -t rsa</code>\"],[1,\"<code>ssh-keygen -t rsa</code>\"],[0,\"<code>keygen -t rsa</code>\"],[0,\"<code>ssh --keygen -t rsa</code>\"],[0,\"<code>ssh-keygen -f rsa</code>\"]]}', 10, 1),
(124, 7, '{\"context\":{\"var0\":\"lists the kernel modules currently loaded by the system\"},\"answer\":[[0,\"<code>insmod</code>\"],[0,\"<code>cat /etc/modprobe.conf</code>\"],[1,\"<code>lsmod</code>\"],[0,\"<code>depmod -m</code>\"],[0,\"<code>modprobe -l</code>\"]]}', 1, 1),
(130, 8, '{\"context\":{\"var0\":\"A new software repository was added to a system based on Debian packages.\",\"var1\":\"must be performed to make the packages from that repository available for installation on the local system\"},\"answer\":[[0,\"To run the command <code>apt-get refresh</code>\"],[1,\"To run the command <code>apt-get update</code>\"],[0,\"To run the command <code>apt-get upgrade</code>\"],[0,\"To run the command <code>apt-get dist-upgrade</code>\"],[0,\"To run the command <code>apt-get repo-update</code>\"]]}', 2, 1),
(131, 9, '{\"context\":{\"var0\":\"command that redirects data received in the standard input to the standard output and at the same time writes the data to a file\",\"var1\":\"Write only the command, without options or parameters\"},\"answer\":[\"tee\"]}', 3, 1),
(132, 10, '{\"context\":{\"var0\":\"is the default permission\",\"var1\":\"will be used for new files if the creation mask <em>umask</em> is <code>0002</code>\"},\"answer\":[[0,\"u=rwx,g=rwx,o=rx\"],[1,\"u=rw,g=rw,o=r\"],[0,\"u=rw,g=r,o=r\"],[0,\"u=rwx,g=rwx,o=r\"],[0,\"u=r,g=r,o=r\"]]}', 4, 1),
(133, 11, '{\"context\":{\"var0\":\"the purpose of the command <code>seq</code>\"},\"answer\":[[0,\"To split a file.\"],[0,\"To archive multiple files.\"],[1,\"To output an ordered sequence of numbers.\"],[0,\"To sort a text file in alphabetic order.\"],[0,\"To run commands on sequence.\"]]}', 5, 1),
(134, 12, '{\"context\":{\"var0\":\"default paths to the configuration files of the Xorg server\",\"var1\":\"two\"},\"answer\":[[1,\"<code>/etc/X11/xorg.conf</code>\"],[1,\"<code>/etc/X11/xorg.conf.d/*.conf</code>\"],[0,\"<code>/etc/default/xorg.conf</code>\"],[0,\"<code>/etc/xorg.conf</code>\"],[0,\"<code>/etc/X11.conf</code>\"]]}', 6, 1),
(135, 9, '{\"context\":{\"var0\":\"command that locks changes to the file <code>/etc/group</code> in order to be modified by the system\'s default editor\",\"var1\":\"Write only the command, without options or parameters\"},\"answer\":[\"vigr\",\"vipw\"]}', 7, 1),
(136, 11, '{\"context\":{\"var0\":\"the purpose of the command <code>newaliases</code>\"},\"answer\":[[1,\"To update new email aliases in the system.\"],[0,\"To open the email aliases assistent.\"],[0,\"To erase the old email aliases table.\"],[0,\"To locate the recently created email aliases.\"],[0,\"To include a new file containing email aliases.\"]]}', 8, 1),
(137, 12, '{\"context\":{\"var0\":\"commands that can be used to show active network interfaces on the local system\",\"var1\":\"three\"},\"answer\":[[1,\"<code>ifconfig</code>\"],[1,\"<code>netstat</code>\"],[1,\"<code>ip</code>\"],[0,\"<code>ipconfig</code>\"],[0,\"<code>netconf</code>\"]]}', 9, 1),
(138, 7, '{\"context\":{\"var0\":\"generates RSA personal keys to be used with SSH\"},\"answer\":[[0,\"<code>ssh -t rsa</code>\"],[1,\"<code>ssh-keygen -t rsa</code>\"],[0,\"<code>keygen -t rsa</code>\"],[0,\"<code>ssh --keygen -t rsa</code>\"],[0,\"<code>ssh-keygen -f rsa</code>\"]]}', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `lang` enum('pt_BR','en') COLLATE utf8_unicode_ci NOT NULL,
  `descr` longtext COLLATE utf8_unicode_ci NOT NULL,
  `fixed` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'HTML markup',
  `list` tinyint(3) UNSIGNED NOT NULL DEFAULT '5' COMMENT 'How many items to choose from',
  `many` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Allowed to choose many answers'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `lang`, `descr`, `fixed`, `list`, `many`) VALUES
(1, 'pt_BR', 'Dada a definição ou resultado esperado, escolher o comando de uma lista.', '<p>Qual dos comandos a seguir <span class=\"var\" data-id=\"var0\"></span>?</p>', 5, 0),
(2, 'pt_BR', 'Descrição de caso e alternativa apropriada.', '<div class=\"var\" data-id=\"var0\"></div><p>Qual das alternativas a seguir <span class=\"var\" data-id=\"var1\"></span>?</p>', 5, 0),
(3, 'pt_BR', 'Dada a definição, informar textualmente o comando, arquivo ou variável.', '<p>Qual é <span class=\"var\" data-id=\"var0\"></span>? <em>(<span class=\"var\" data-id=\"var1\"></span>.)</em></p>', 0, 0),
(4, 'pt_BR', 'Dada uma definição de configuração ou de uma opção de comando, escolher a opção correspondente de uma lista.', '<p>Qual <span class=\"var\" data-id=\"var0\"></span> que <span class=\"var\" data-id=\"var1\"></span>?</p>', 5, 0),
(5, 'pt_BR', 'Solicitar a definição da finalidade de um comando ou de uma opção de comando, da finalidade de um arquivo ou recurso oferecido por tecnologia.', '<p>Qual das alternativas a seguir descreve <span class=\"var\" data-id=\"var0\"></span>?</p>', 5, 0),
(6, 'pt_BR', 'Mais de uma alternativa correta: comandos que podem ... | informações corretas a respeito do ...', '<p>Quais das alternativas a seguir são <span class=\"var\" data-id=\"var0\"></span>? <em>(Escolha <strong><span class=\"var\" data-id=\"var1\"></span></strong> respostas corretas.)</em></p>', 5, 1),
(7, 'en', 'Given a definition or expected result, choose a command from a list.', '<p>Which of the following commands <span class=\"var\" data-id=\"var0\"></span>?</p>', 5, 0),
(8, 'en', 'Case description and correct option.', '<div class=\"var\" data-id=\"var0\"></div><p>Which of the following alternatives <span class=\"var\" data-id=\"var1\"></span>?</p>', 5, 0),
(9, 'en', 'Given a definition, write the related command, file or variable.', '<p>What is the <span class=\"var\" data-id=\"var0\"></span>? <em>(<span class=\"var\" data-id=\"var1\"></span>.)</em></p>', 0, 0),
(10, 'en', 'Given the definition of a configuration setting or of a command option, choose the related option from a list.', '<p>What <span class=\"var\" data-id=\"var0\"></span> that <span class=\"var\" data-id=\"var1\"></span>?</p>', 5, 0),
(11, 'en', 'Request the purpose of a command (or command option), the purpose of a file or technology feature.', '<p>Which of the following items describes <span class=\"var\" data-id=\"var0\"></span>?</p>', 5, 0),
(12, 'en', 'More than one correct alternative: command that can ... | correct information about ...', '<p>Which of the following alternatives are <span class=\"var\" data-id=\"var0\"></span>? <em>(Choose <strong><span class=\"var\" data-id=\"var1\"></span></strong> correct answers.)</em></p>', 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
