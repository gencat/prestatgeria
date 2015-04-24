-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Temps de generació: 24-04-2015 a les 14:30:21
-- Versió del servidor: 5.5.43
-- Versió de PHP : 5.4.39-1+deb.sury.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de dades: `presta1`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `e3009369_2_access`
--

CREATE TABLE IF NOT EXISTS `e3009369_2_access` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL DEFAULT '0',
  `contentsid` int(10) NOT NULL DEFAULT '0',
  `myaccess` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `e3009369_2_config`
--

CREATE TABLE IF NOT EXISTS `e3009369_2_config` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(100) NOT NULL DEFAULT '',
  `site_home` varchar(255) NOT NULL DEFAULT '',
  `myname` varchar(12) NOT NULL DEFAULT '',
  `mypass` varchar(40) NOT NULL DEFAULT '',
  `loggedin` char(1) NOT NULL DEFAULT 'N',
  `opentext` text NOT NULL,
  `openimage` varchar(60) NOT NULL DEFAULT '',
  `logins` int(5) NOT NULL DEFAULT '0',
  `abouttext` text NOT NULL,
  `version` varchar(25) NOT NULL DEFAULT '',
  `adminemail` varchar(255) NOT NULL DEFAULT '',
  `pathtoproccess` varchar(255) NOT NULL DEFAULT '',
  `Processor` varchar(255) NOT NULL DEFAULT '',
  `showsearch` varchar(25) NOT NULL DEFAULT '',
  `lang` char(2) NOT NULL DEFAULT '',
  `image_folder` varchar(50) NOT NULL DEFAULT '',
  `theme` varchar(12) NOT NULL DEFAULT '',
  `html_editor` varchar(20) NOT NULL DEFAULT 'xinha',
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `e3009369_2_config`
--

INSERT INTO `e3009369_2_config` (`recno`, `site_title`, `site_home`, `myname`, `mypass`, `loggedin`, `opentext`, `openimage`, `logins`, `abouttext`, `version`, `adminemail`, `pathtoproccess`, `Processor`, `showsearch`, `lang`, `image_folder`, `theme`, `html_editor`) VALUES
(1, 'Llibre número 1', 'llibre.php?fisbn=e3009369_2', 'usu1', '6142bfd56a583d891f0b1dcdbb2a9ef8', 'Y', '<p>&nbsp;</p><p>Això és un llibre d''exemple\r\n\r\n</p>', '4373433bdf74.jpg', 1, '\r\n\r\n\r\n', '', 'usu1@xtec.cat', '', '', '', 'ca', 'e3009369_2', 'workbook', 'xinha');

-- --------------------------------------------------------

--
-- Estructura de la taula `e3009369_2_contents`
--

CREATE TABLE IF NOT EXISTS `e3009369_2_contents` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '',
  `openimage` varchar(80) NOT NULL DEFAULT '',
  `ordernum` int(10) NOT NULL DEFAULT '0',
  `opentext` text NOT NULL,
  `permissions` varchar(30) NOT NULL DEFAULT 'approval',
  `notifyemail` varchar(80) NOT NULL DEFAULT '',
  `entriespage` char(1) NOT NULL DEFAULT 'Y',
  `showname` char(1) NOT NULL DEFAULT 'Y',
  `showemail` char(1) NOT NULL DEFAULT '',
  `showurl` char(1) NOT NULL DEFAULT '',
  `showimage` char(1) NOT NULL DEFAULT 'Y',
  `formatpage` int(2) NOT NULL DEFAULT '2',
  `sortby` varchar(30) NOT NULL DEFAULT '',
  `insertto` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Bolcant dades de la taula `e3009369_2_contents`
--

INSERT INTO `e3009369_2_contents` (`recno`, `name`, `openimage`, `ordernum`, `opentext`, `permissions`, `notifyemail`, `entriespage`, `showname`, `showemail`, `showurl`, `showimage`, `formatpage`, `sortby`, `insertto`) VALUES
(1, 'Capítol 1', '', 1, '<p>\r\nBenvinguts al&nbsp;capítol 1</p><p>­<br />\r\n</p>\r\n<div align="center"><iframe width="420" height="315" frameborder="0" src="https://www.youtube.com/embed/kpO-E8B-b_4"></iframe>­</div>', 'approval', 'usu1@xtec.cat ', 'Y', 'Y', '', '', 'Y', 2, '', ''),
(2, 'Capítol 2', '', 2, 'Benvinguts al capítol 2\r\n\r\n', 'approval', 'usu1@xtec.cat', 'Y', 'Y', '', '', 'Y', 2, '', ''),
(3, 'Capítol 3', '', 3, 'Benvinguts al capítol 3\r\n\r\n\r\n\r\n', 'approval', 'usu1@xtec.cat', 'Y', 'Y', '', '', 'Y', 2, '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `e3009369_2_users`
--

CREATE TABLE IF NOT EXISTS `e3009369_2_users` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `myusername` varchar(60) NOT NULL DEFAULT '',
  `mypassword` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `loggedin` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `e3009369_2_words`
--

CREATE TABLE IF NOT EXISTS `e3009369_2_words` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `section` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `webaddress` varchar(150) DEFAULT NULL,
  `webname` varchar(150) DEFAULT NULL,
  `comment` text,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(70) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `contentsid` int(10) NOT NULL DEFAULT '0',
  `approved` char(1) NOT NULL DEFAULT 'N',
  `myimage` varchar(60) NOT NULL DEFAULT '',
  `ordernum` int(11) NOT NULL DEFAULT '0',
  `imagealign` varchar(60) NOT NULL DEFAULT 'top',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Bolcant dades de la taula `e3009369_2_words`
--

INSERT INTO `e3009369_2_words` (`id`, `section`, `email`, `webaddress`, `webname`, `comment`, `name`, `title`, `updated`, `contentsid`, `approved`, `myimage`, `ordernum`, `imagealign`) VALUES
(1, NULL, '', '', '', '\r\n<p><br />\r\nAixò és una pàgina de demostració</p><p><img width="300" height="187" alt="diary_srb_1118480_m.jpg" src="/prestatgeria/centres/e3009369_2/diary_srb_1118480_m.jpg" /></p><p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus \r\nsollicitudin feugiat orci. Vestibulum quis orci nisl. Integer tempus sed\r\n ante ac ultrices. Class aptent taciti sociosqu ad litora torquent per \r\nconubia nostra, per inceptos himenaeos. Suspendisse condimentum pulvinar\r\n orci at finibus. Nam eget porttitor erat. Vivamus a pharetra odio, at \r\naliquam enim.\r\n</p>\r\n<p>\r\nPhasellus bibendum, arcu non venenatis condimentum, dui massa luctus \r\ntortor, in molestie sapien metus eget massa. Maecenas congue orci velit,\r\n quis interdum lacus euismod in. Nullam convallis ligula vel dolor \r\nsemper sagittis vitae sed nisi. In fermentum, sem vitae laoreet \r\nporttitor, nunc metus pellentesque nunc, a molestie elit sem non ipsum. \r\nPraesent faucibus ornare molestie. Phasellus nec diam purus. Suspendisse\r\n sodales efficitur libero a finibus. Phasellus cursus, odio non commodo \r\ninterdum, ex mauris semper lacus, nec viverra sem libero non metus. \r\nCurabitur commodo at justo sit amet vestibulum. Quisque vehicula gravida\r\n est at imperdiet. Nunc neque dolor, vehicula a facilisis id, molestie a\r\n velit. Morbi pretium iaculis viverra. Phasellus efficitur mauris non \r\ntristique accumsan. Nunc et turpis in nunc accumsan ultricies eget a \r\nerat. Mauris eleifend arcu ex, ut hendrerit dui fringilla eget.\r\n</p>\r\n<p>\r\nFusce pellentesque eros quis mauris aliquet ornare. Aenean pulvinar in \r\nvelit vel auctor. Nam quis est sed nibh placerat cursus in et neque. \r\nCurabitur enim tortor, pharetra at odio ut, laoreet tincidunt ex. \r\nPellentesque neque purus, hendrerit fermentum diam sit amet, tempus \r\npellentesque justo. Vivamus quis lorem hendrerit, malesuada felis ac, \r\nlaoreet eros. Proin sem sem, pellentesque ut est eu, fermentum pulvinar \r\nodio. Mauris sapien velit, tempus in iaculis non, laoreet quis turpis. \r\nSed at dolor lobortis ipsum rhoncus hendrerit nec vitae leo. Cras \r\ninterdum at sem eu dapibus.\r\n</p>\r\n<p>\r\nFusce blandit leo et nunc feugiat, ut convallis neque tempor. Proin a \r\nscelerisque sapien. Vivamus varius dui sed nibh aliquam rutrum. Nunc at \r\nodio in mi rutrum luctus sed ut risus. Donec dapibus lacus et facilisis \r\nimperdiet. Suspendisse vel commodo justo. Vivamus dignissim at turpis \r\nsed tincidunt. Nunc leo lacus, luctus aliquet libero sit amet, tempor \r\naliquet lorem. Donec et iaculis velit. Suspendisse in pulvinar tortor.\r\n</p>\r\n', 'Usuari 1', 'Pàgina 1', '2015-04-24 12:23:33', 1, 'Y', '', 1, 'top'),
(2, NULL, '', '', '', '<p>Això és la pàgina 2 </p><p><img width="300" height="186" src="/prestatgeria/centres/e3009369_2/quiz_2_600705_m.jpg" alt="quiz_2_600705_m.jpg" /><br /></p>', 'Usuari 1', 'Pàgina 2', '2015-04-24 11:58:33', 1, 'Y', '', 2, 'top'),
(3, NULL, '', '', '', '<br />\r\n<p>Això és la pàgina 3</p><p><img width="300" height="144" src="/prestatgeria/centres/e3009369_2/rowers_on_the_river_cam_341053_m.jpg" alt="rowers_on_the_river_cam_341053_m.jpg" /><br /></p>', 'Usuari 1', 'Pàgina 3', '2015-04-24 11:58:33', 1, 'Y', '', 3, 'top'),
(4, NULL, '', '', '', '<br />\r\n<p>Això és la pàgina 4</p><p><img width="224" height="300" src="/prestatgeria/centres/e3009369_2/university_of_mexico_5_718009_m.jpg" alt="university_of_mexico_5_718009_m.jpg" /><br /></p>', 'Usuari 1', 'Pàgina 4', '2015-04-24 11:58:33', 1, 'Y', '', 4, 'top');

-- --------------------------------------------------------

--
-- Estructura de la taula `llibres_1_access`
--

CREATE TABLE IF NOT EXISTS `llibres_1_access` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL DEFAULT '0',
  `contentsid` int(10) NOT NULL DEFAULT '0',
  `myaccess` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Bolcant dades de la taula `llibres_1_access`
--

INSERT INTO `llibres_1_access` (`recno`, `userid`, `contentsid`, `myaccess`) VALUES
(3, 5, 7, 'F'),
(5, 5, 3, 'R');

-- --------------------------------------------------------

--
-- Estructura de la taula `llibres_1_config`
--

CREATE TABLE IF NOT EXISTS `llibres_1_config` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(60) NOT NULL DEFAULT '',
  `site_home` varchar(255) NOT NULL DEFAULT '',
  `myname` varchar(12) NOT NULL,
  `mypass` varchar(40) NOT NULL,
  `loggedin` char(1) NOT NULL DEFAULT 'N',
  `opentext` mediumtext NOT NULL,
  `openimage` varchar(60) NOT NULL DEFAULT '',
  `logins` int(5) NOT NULL DEFAULT '0',
  `abouttext` mediumtext NOT NULL,
  `version` varchar(25) NOT NULL DEFAULT '',
  `adminemail` varchar(255) NOT NULL DEFAULT '',
  `pathtoproccess` varchar(255) NOT NULL DEFAULT '',
  `Processor` varchar(255) NOT NULL DEFAULT '',
  `showsearch` varchar(25) NOT NULL DEFAULT '',
  `lang` char(2) NOT NULL DEFAULT '',
  `image_folder` varchar(12) NOT NULL DEFAULT '',
  `theme` varchar(12) NOT NULL DEFAULT '',
  `html_editor` varchar(10) NOT NULL,
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `llibres_1_config`
--

INSERT INTO `llibres_1_config` (`recno`, `site_title`, `site_home`, `myname`, `mypass`, `loggedin`, `opentext`, `openimage`, `logins`, `abouttext`, `version`, `adminemail`, `pathtoproccess`, `Processor`, `showsearch`, `lang`, `image_folder`, `theme`, `html_editor`) VALUES
(1, 'Com funcionen els llibres?', 'http://localhost/book/', 'llibres', '6142bfd56a583d891f0b1dcdbb2a9ef8', 'Y', '<h4>Benvinguts a la prestatgeria digital de la XTEC\r\n</h4> \r\n  <p>Aquest servei, destinat a centres docents, permet escriure llibres de manera col·laborativa a través d''Internet. Es proporciona un compte a cada centre, des d''on es poden crear llibres virtuals i assignar-ne l''administració a diferents usuaris.\r\n</p> \r\n  <p>Totes les persones amb un compte de correu XTEC poden entrar i afegir continguts als llibres. Els administradors de cada llibre poden decidir si accepten els canvis proposats, si els publiquen o els descarten.\r\n  <br /> </p> \r\n  <p>Els llibres s''han de crear des de l''usuari XTEC del centre. També en poden crear els usuaris als quals el centre hagi delegat aquesta tasca. En el moment de crear-se un llibre cal especificar a quin usuari/ària XTEC s''assigna aquell llibre. La persona a qui s''hagi assignat un llibre en serà l''administrador/a.<br /></p> \r\n  <p>Per saber més coses sobre els llibres compartits de la XTEC, podeu consultar els capítols d''aquest llibre.\r\n</p> \r\n  <p>Si teniu suggeriments de millora del sistema o detecteu errors de funcionament, podeu enviar un missatge de correu electrònic a l''adreça: <a href="mailto:llibres@xtec.cat">llibres@xtec.cat</a>.\r\n</p>', 'd2333f5a6f96.gif', 4, '\r\nAquest llibre pretén explicar com funcionen els llibres digitals.\r\n', '4.0', 'llibres@xtec.cat', '', '', '', 'ca', '', 'classic', 'xinha');

-- --------------------------------------------------------

--
-- Estructura de la taula `llibres_1_contents`
--

CREATE TABLE IF NOT EXISTS `llibres_1_contents` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '',
  `openimage` varchar(80) NOT NULL DEFAULT '',
  `ordernum` int(10) NOT NULL DEFAULT '0',
  `opentext` mediumtext NOT NULL,
  `permissions` varchar(30) NOT NULL DEFAULT '',
  `notifyemail` varchar(80) NOT NULL DEFAULT '',
  `entriespage` char(1) NOT NULL DEFAULT 'Y',
  `showname` char(1) NOT NULL DEFAULT 'Y',
  `showemail` char(1) NOT NULL DEFAULT 'Y',
  `showurl` char(1) NOT NULL DEFAULT 'Y',
  `showimage` char(1) NOT NULL DEFAULT 'Y',
  `formatpage` int(2) NOT NULL DEFAULT '2',
  `sortby` varchar(30) NOT NULL DEFAULT '',
  `insertto` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Bolcant dades de la taula `llibres_1_contents`
--

INSERT INTO `llibres_1_contents` (`recno`, `name`, `openimage`, `ordernum`, `opentext`, `permissions`, `notifyemail`, `entriespage`, `showname`, `showemail`, `showurl`, `showimage`, `formatpage`, `sortby`, `insertto`) VALUES
(4, 'Descripció de l''entorn', 'a36eb2260ee4.bmp', 2, '\r\n<p>Aquí trobareu tota la informació referent a la interfície d''usuari dels llibres virtuals.</p><p>Les quatre directrius que s''esmenten donen una indicació o deixen intuir les possibilitats dels llibres virtuals. Tot i així, la gràcia d''aquests llibres rau en el seu propi descobriment!</p><p>Com va dir Confuci:<em><br /></em></p><p>&quot;M''ho van explicar i ho vaig oblidar,</p><p>           ho vaig veure i ho vaig entendre,</p><p>              ho vaig fer i ho vaig aprendre.&quot;</p><p> </p>Ànims i molta sort!<br />', 'read', ' llibres@xtec.cat         ', 'Y', 'Y', 'Y', 'Y', 'Y', 2, '', ''),
(3, 'La prestatgeria digital de la XTEC', 'fc58f9e59989.jpg', 1, '\r\n<p>La prestatgeria digital de la XTEC és un servei que permet crear llibres virtuals amb aportacions de diferents persones.</p><p>En aquest capítol, descobrireu què és i com començar a treballar-hi.<br /></p><p> </p>', 'read', 'llibres@xtec.cat                                        ', 'Y', '', '', '', 'Y', 2, '', ''),
(6, 'Introducció de continguts nous', 'ce8c204bcef0.bmp', 3, '\r\n  <p><span>En aquest capítol, veureu com donar continguts als llibres.<br /></span></p>  <p><span>Mitjançant els enllaços de capítol nou i d''article nou, els centres poden donar estructura i continguts.<br /></span></p>  ', 'read', 'llibres@xtec.cat          ', 'Y', '', '', '', 'Y', 2, '', ''),
(7, 'Administració dels llibres', '34bbff8d5682.png', 5, '\r\n<p> </p><p> </p><p>\r\nEn aquest capítol, es mostra com administrar els usuaris que tenen accés a un llibre. </p><p>Cal distingir entre l''accés a la prestatgeria digital i l''accés a un llibre específic. El primer està disponible per a totes aquelles persones amb compte XTEC i serveix per crear llibres (si es tracta d''un compte de centre o d''un CRP) i per marcar-ne com a preferits.</p><p>L''accés a un llibre específic el defineix l''usuari/ària que l''ha creat i es fa a nivell de capítol. Tot seguit veureu com fer-ho.<br /></p>', 'read', 'llibres@xtec.cat           ', 'Y', 'Y', 'Y', 'Y', 'Y', 2, '', ''),
(8, 'Subscripció a continguts', '', 4, '\r\n<p>La sindicació o subscripció permet rebre informació immediata sobre les entrades noves que hi ha als llibres.<br /></p><p>La sindicació es pot fer a capítols concrets o a llibres sencers.</p>', 'read', 'llibres@xtec.cat       ', 'Y', '', '', '', 'Y', 2, '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `llibres_1_users`
--

CREATE TABLE IF NOT EXISTS `llibres_1_users` (
  `recno` int(10) NOT NULL AUTO_INCREMENT,
  `myusername` varchar(60) NOT NULL DEFAULT '',
  `mypassword` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `loggedin` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`recno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Bolcant dades de la taula `llibres_1_users`
--

INSERT INTO `llibres_1_users` (`recno`, `myusername`, `mypassword`, `email`, `name`, `loggedin`) VALUES
(5, 'usu1', 'agora', 'agora@xtec.invalid', 'Usuari 1', 'Y');

-- --------------------------------------------------------

--
-- Estructura de la taula `llibres_1_words`
--

CREATE TABLE IF NOT EXISTS `llibres_1_words` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `section` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `webaddress` varchar(150) DEFAULT NULL,
  `webname` varchar(150) DEFAULT NULL,
  `comment` mediumtext,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(70) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `contentsid` int(10) NOT NULL DEFAULT '0',
  `approved` char(1) NOT NULL DEFAULT 'N',
  `myimage` varchar(60) NOT NULL DEFAULT '',
  `ordernum` int(11) NOT NULL DEFAULT '0',
  `imagealign` varchar(60) NOT NULL DEFAULT 'top',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- Bolcant dades de la taula `llibres_1_words`
--

INSERT INTO `llibres_1_words` (`id`, `section`, `email`, `webaddress`, `webname`, `comment`, `name`, `title`, `updated`, `contentsid`, `approved`, `myimage`, `ordernum`, `imagealign`) VALUES
(15, NULL, '', '', '', '\r\n          <p>La prestatgeria digital de la XTEC és un recurs ofert als centres docents que els permet crear llibres virtuals amb continguts diversos i per a diferents finalitats. </p><p>Cada centre pot tenir tants llibres com cregui oportú i, a dins de cadascun d''ells, pot crear tants capítols com calgui. Els capítols estan formats per pàgines que corresponen a les entrades del llibre. Els llibres poden presentar-se en diferents idiomes i formats.</p><p>Només\r\nels centres i els CRP, identificats mitjançant l''adreça de correu del centre i la contrasenya\r\ncorresponent, poden crear llibres i designar un usuari/ària XTEC que\r\nels administri.</p><p>Els llibres es divideixen en capítols. Per a cada un d''ells, es poden definir 4 tipus d''accés per a un usuari/ària, que són: <strong>Sense accés</strong> (cal entrar prèviament i ser una persona autoritzada), <strong>Només lectura</strong>, <strong>Pot publicar amb aprovació</strong> <strong>prèvia</strong> i <strong>Pot publicar SENSE aprovació</strong><strong> prèvia</strong>. D''aquesta manera, diferents persones poden escriure diversos capítols simultàniament.<br /><br />Els llibres es poden llegir sense haver d''entrar a l''aplicació, excepte en els capítols sense accés, de manera que qualsevol persona pot veure''n el contingut.<br /></p>', '', 'Què és la prestatgeria digital de la XTEC?', '2009-12-10 19:56:59', 3, 'Y', 'ff9bed230b2a.jpg', 0, 'top'),
(19, NULL, '', '', '', '\r\n<p>Una vegada s''ha accedit a les pàgines d''un llibre, apareix una capçalera que indica el nom del capítol que s''està veient.</p><p> La capçalera té una funció informativa. Per desplaçar-vos entre pàgines, heu de fer servir les opcions que apareixen al peu de la pàgina.<br /> </p>', '', 'La capçalera', '2007-04-16 10:07:41', 4, 'Y', '19f4ee147677.png', 1, 'top'),
(20, NULL, '', '', '', '\r\n<p>Aquesta secció de les pàgines conté el llibre pròpiament dit. La informació que hi apareix consisteix en text i imatges i es pot afegir fàcilment mitjançant un editor visual, tal com s''explica en el pròxim capítol.<br /></p><p>El cos del llibre es formata en codi HTML, cosa que possibilita l''ús d''enllaços a pàgines externes i de totes les característiques d''aquest llenguatge de programació. L''aplicació no permet pujar objectes Flash ni vídeos al servidor, de manera que, si es volen enllaçar, caldrà que estiguin accessibles en un altre servidor a Internet i fer l''enllaç manualment.<br /></p><p><br /></p>', '', 'El cos del llibre', '2007-04-16 11:29:13', 4, 'Y', 'd1ca19ec5643.png', 3, 'top'),
(27, NULL, '', '', '', '\r\n <p>El procediment de creació de llibres nous és senzill. Una vegada s''hagi entrat a la prestatgeria digital, l''opció <strong>Crea un llibre nou</strong> permet accedir al formulari.</p><p align="center"> <img width="183" height="200" alt="llibres_006.png" src="/prestatgeria/centres/llibres_1/llibres_006.png" /></p><p>Es demanen les dades següents:</p><ul><li>Títol del llibre</li><li>Idioma: català, castellà, anglès o francès</li><li>Descripció del llibre</li><li>Estil o aparença</li><li>Col·lecció: agrupa llibres de temàtica relacionada</li><li>Descriptors: llista de paraules separades per comes que descriuen la temàtica del llibre. No poden contenir accents ni caràcters especials</li><li>Correu XTEC de la persona que administrarà el llibre</li><li>Contrasenya que es farà servir per accedir a l''administració del llibre: no ha de coincidir necessàriament amb la del correu de l''usuari/ària (això permet crear llibres i assignar-los a terceres persones)<br /></li><li>Indicar que s''accepten les condicions d''ús<br /></li></ul><p>Un cop introduïda tota aquesta informació, en clicar al botó <strong>Entra llibre</strong>, s''enviarà un correu a l''administrador/a en què se l''informarà de la creació d''un llibre i de les dades d''accés per a l''administració.<br /><br />Tot i que el llibre ja ha estat creat, no s''activarà fins que l''administrador/a faci clic a l''enllaç inclòs en el correu electrònic. D''aquesta manera, l''administrador/a de llibre dóna el vistiplau a la seva creació.</p>', '', 'Creació de llibres nous', '2011-07-04 10:44:32', 3, 'Y', '', 3, 'top'),
(28, NULL, '', '', '', '\r\n <p>El catàleg de llibres digitals conté la relació de llibres actius. Des de la pàgina inicial, s''hi pot accedir fent clic a l''opció <strong>Catàleg digital</strong>.</p><p align="center"><img width="183" height="200" src="/prestatgeria/centres/llibres_1/llibres_001_1.png" alt="llibres_001_1.png" /></p><p> </p><p> </p><p> </p>', '', 'El catàleg de llibres', '2011-07-04 10:44:32', 3, 'Y', '51407c63dabd.bmp', 1, 'top'),
(29, NULL, '', '', '', '\r\n<p> </p><p>Quan un usuari/ària afegeix una pàgina, la resta d''usuaris del llibre no se n''assabenten fins que tornen a visitar la prestatgeria i accedeixen al llibre.</p><p>La subscripció o sindicació és un mecanisme que permet als usuaris rebre aquesta informació sense haver d''accedir a la prestatgeria.<br /></p><p> </p><p>Per poder utilitzar la sindicació, l''usuari/ària ha de disposar d''alguna aplicació, com el Firefox o el Thunderbird, que sigui capaç de recollir aquesta informació i mostrar-la.</p><p> </p><p> </p>', '', 'Què significa subscriure''s a un llibre?', '2007-04-20 14:55:30', 8, 'Y', '', 1, 'top'),
(30, NULL, '', '', '', '\r\n<p> </p><p>Hi ha molt programari que permet obtenir informació de fonts RSS. A continuació s''explica el procediment per fer-ho amb el Firefox, navegador de codi obert disponible a <a title="Descàrrega del Firefox en català" target="_blank" href="http://www.softcatala.cat/prog167.htm">softcatala</a>.</p><p>El primer pas és accedir al catàleg digital.</p><p align="center"><img width="183" height="200" alt="llibres_001_1.png" src="/prestatgeria/centres/llibres_1/llibres_001_1.png" /><br /></p><p>Juntament amb la informació de cada llibre apareix la icona <img width="16" height="16" alt="llibres_300.png" src="/prestatgeria/centres/llibres_1/llibres_300.png" />. Es troba a la dreta de la pantalla:</p><p align="center"><img width="423" height="53" alt="llibres_301.png" src="/prestatgeria/centres/llibres_1/llibres_301.png" /> </p><p> </p><p> </p><p> En clicar-hi s''obre una pestanya nova en el navegador amb el contingut de les darreres pàgines que s''han afegit al llibre. A la part superior de la finestra apareix el següent:</p><p align="center"><img width="416" height="91" alt="llibres_302.png" src="/prestatgeria/centres/llibres_1/llibres_302.png" /><br /></p><p> </p><p> En clicar al botó <strong>Subscriu-te ara</strong>, apareix una finestra que demana a quina carpeta de les adreces d''interès es mostrarà al informació del canal RSS.<br /></p><p align="center"> <img width="317" height="142" src="/prestatgeria/centres/llibres_1/llibres_303.png" alt="llibres_303.png" /></p><p> </p><p> El procés es completa fent clic al botó <strong>D''acord</strong>. </p><p>A partir d''aquest moment, a les adreces d''interès apareix una carpeta amb el títol indicat al camp <strong>Nom</strong> de la finestra anterior. En posar-hi a sobre amb el punter del ratolí, apareix el seu contingut, consistent amb els títols dels darrers capítols que han sofert canvis en els continguts.<br /><br />Per accedir al llibre, només cal fer clic damunt el títol de la pàgina que es vol visitar. </p>', '', 'Subscripció a llibres', '2011-07-04 10:44:32', 8, 'Y', '', 2, 'top'),
(44, NULL, '', '', '', '\r\n<p> </p><p>\r\nL''aplicació dels llibres funciona, actualment, amb dos editors visuals (també coneguts amb el nom d''editors WYSIWYG): el Xinha i el TinyMCE.</p><p>Aquests editors permeten formatar els textos introduïts fàcilment. En el cas del Xinha, també afegeix la funcionalitat de pujar imatges al servidor via web, mentre que el TinyMCE ofereix la possibilitat de fer visualitzacions prèvies.<br /> </p><p>Tots dos tenen unes prestacions similars i, per a cada llibre, l''administrador/a pot escollir quin dels dos es farà servir. L''editor recomanat és el Xinha.</p><p> </p>', '', 'Els editors HTML', '2007-04-16 13:56:58', 6, 'Y', '', 2, 'top'),
(37, NULL, '', '', '', '\r\n<p align="left"> </p><p>La sindicació o subscripció a continguts és molt utilitzada a Internet. Cada vegada hi ha més pàgines de notícies o articles que proporcionen canals RSS, que fan possible la sindicació.&nbsp;</p><p align="left">Si esteu interessats en aprofundir en el món de la sindicació de continguts, trobareu informació extensa en el <a title="Curs D134" target="_blank" href="http://jasper.xtec.cat:7451/cdweb/dades/actu/actual_matform/materials/td134/d134m4/d134m4p6.htm">curs D134</a>. Una altra font d''informació molt interessant és <a title="RSS a la viquipèdia" target="_blank" href="http://ca.wikipedia.org/wiki/RSS">aquest article de la viquipèdia</a>.</p><p align="left"><br /></p>', '', 'Per saber-ne més', '2007-04-20 14:20:55', 8, 'Y', '', 3, 'top'),
(41, NULL, '', '', '', '\r\n<p>El peu de pàgina conté enllaços que permeten a l''usuari/ària interactuar amb l''aplicació.<br /></p><p>Els enllaços que apareixen depenen del perfil de l''usuari/ària. Els usuaris anònims  poden canviar de pàgina, tornar a l''índex del llibre, entrar a l''administració (si disposen de la contrasenya) i enviar pàgines noves. En aquest darrer cas, la pàgina només apareixerà una vegada hagi estat validada per l''administrador/a, tret que el llibre permeti la publicació sense validació.<br /> </p><p>Els administradors tenen, addicionalment, accés a l''edició de pàgines i al tancament de la sessió. </p>', '', 'El peu de pàgina', '2007-04-16 11:07:02', 4, 'Y', '2ae100214523.png', 2, 'top'),
(42, NULL, '', '', '', '\r\n<p> </p><p>Per afegir un capítol nou, cal accedir al llibre i validar-se com a administrador/a mitjançant l''enllaç <strong>Entra</strong>, ubicat al peu de pàgina.</p>\r\n<p>Els administradors d''un llibre disposen de l''enllaç <strong>Capítol nou</strong> a l''índex corresponent.</p>\r\n<p align="center"><img width="350" height="169" src="/prestatgeria/centres/llibres_1/llibres_021.png" alt="llibres_021.png" /></p>\r\n<p>El formulari de creació de capítols demana les dades següents:</p>\r\n<ul>\r\n<li>Número del capítol: es fa servir per a l''ordenació dels capítols.</li>\r\n<li>Nom o títol del capítol.</li>\r\n<li>Imatge del capítol: imatge que es mostra juntament amb la presentació del llibre (opcional).</li>\r\n<li>Permisos: indica si és d''accés restringit, si és de només lectura, si es poden fer enviaments anònims amb validació o si es poden fer enviaments anònims sense validació.</li>\r\n<li>Pàgina d''entrada: la primera pàgina que es mostra. Es recomana deixar l''opció per defecte.</li>\r\n<li>Format: permet escollir entre una o dues pàgines simultàniament.</li>\r\n<li>Dades que es demanen de l''usuari/ària (s''han de marcar).</li>\r\n<li>Adreça electrònica de notificació d''entrades noves.</li>\r\n<li>Text de presentació del llibre: text que es mostra a la pàgina prèvia de l''índex del llibre.</li>\r\n</ul>\r\n<p> </p>', '', 'Creació d''un capítol nou', '2011-07-04 10:44:32', 6, 'Y', '', 0, 'top'),
(43, NULL, '', '', '', '\r\n<p>Les pàgines del llibre es creen omplint el formulari de creació d''articles, al qual es pot accedir per dues vies:</p><ol><li>Fent clic a l''enllaç <strong>Afegeix</strong> del peu de pàgina</li><li>Editant una pàgina sense contingut<br /></li></ol><p> En editar una pàgina qualsevol, és possible canviar-la de capítol, mentre que, en crear-la, apareixerà sempre al final del capítol que s''està visitant.</p><p>El formulari de creació demana les dades següents:</p><ul><li>Text per mostrar: és el contingut de la pàgina.</li><li>Títol de la pàgina.<br /></li><li>El teu nom (opcional): el nom o àlies de la persona que envia la pàgina.</li><li>Adreça electrònica (opcional): adreça de la persona que fa l''enviament.</li><li>Imatge (opcional): imatge que apareixerà a la part superior de la pàgina.</li><li>URL (opcional): pàgina web de l''autor/a o pàgina relacionada amb la pàgina.<br /></li><li>Nom de l''URL (opcional): text que es mostrarà a l''enllaç corresponent a l''URL.<br /></li></ul><p> </p>Les dades opcionals poden no aparèixer si l''administrador/a del capítol ha decidit que no es demanaran.<br />', '', 'Creació de pàgines noves', '2007-04-16 13:30:15', 6, 'Y', 'f2f27635ec38.bmp', 1, 'top'),
(47, NULL, '', '', '', '\r\nL''editor recomanat per introduir el text del cos de les pàgines és el Xinha. La seva barra d''eines té aquest aspecte:<p align="center"><img width="467" height="59" alt="llibres_022.png" src="/prestatgeria/centres/llibres_1/llibres_022.png" /> </p><p>La majoria d''icones són comunes als programes d''ofimàtica més utilitzats, però n''hi ha algunes específiques d''aquest editor que són de gran importància.</p><p><img width="21" height="23" alt="llibres_023.png" src="/prestatgeria/centres/llibres_1/llibres_023.png" /> Commuta entre la visualització normal i la pantalla completa. En aquest segon mode, l''editor s''expandeix fins a ocupar la totalitat de la finestra, cosa que facilita la introducció de dades. (Nota: per desar el text, cal tornar a la visualització normal.)<br /></p><p><img width="21" height="23" alt="llibres_024.png" src="/prestatgeria/centres/llibres_1/llibres_024.png" /> Commuta entre el mode visual i el codi HTML. És útil per a aquelles persones que saben programar en HTML.<br /></p><p> </p><p><img width="21" height="23" alt="llibres_025.png" src="/prestatgeria/centres/llibres_1/llibres_025.png" /> Permet inserir o canviar una imatge. En clicar-hi, apareix la finestra següent:</p><p align="center"><img width="350" height="225" src="/prestatgeria/centres/llibres_1/llibres_026_1.png" alt="llibres_026_1.png" /></p><p align="left">La part superior de la finestra, <strong>Upload:</strong>, permet pujar imatges des de l''ordinador local al servidor: el botó <strong>Navega...</strong> obre una finestra de navegació des d''on localitzar la imatge i el botó <strong>Upload</strong> l''envia al servidor.</p><p align="left">Important: la mida màxima de les imatges és de 400 kB.<br /></p><p align="left">Una vegada al servidor, la imatge pot ser inserida a la pàgina del llibre. Per fer-ho, cal seleccionar la miniatura de la imatge que es vol inserir i clicar al botó <strong>D''acord</strong>.</p><p align="left">L''eliminació d''imatges del servidor es duu a terme clicant a la icona que representa un cubell d''escombraries. </p><p align="left">La icona del llapis que apareix a cada miniatura obre una finestra d''edició que permet fer algunes operacions bàsiques d''edició de la imatge, com són rotacions, canvi de dimensions, reducció a un fragment o mesures.</p><p>Atenció: per raons de seguretat, aquestes accions només les poden portar a terme els administradors dels llibres si prèviament han entrat a la prestatgeria. Altrament, qualsevol persona aliena al centre podria esborrar imatges o inserir-ne.<br /></p><p> </p>', '', 'L''editor Xinha', '2011-07-04 10:44:32', 6, 'Y', '', 4, 'top'),
(49, NULL, '', '', '', '\r\n<p>\r\n<br />Es poden definir usuaris per a cada capítol de cada llibre amb un nivell d''accés sobre els continguts d''entre els següents:</p><ul><li>Sense accés (capítol privat)<br /></li><li>Només lectura</li><li>Publicació amb aprovació prèvia</li><li>Publicació sense aprovació prèvia</li><li>Accés complet (només per als administradors)<br /> </li></ul><p>El permís <strong>Sense accés (capítol privat)</strong> fa que només puguin accedir al contingut del capítol els usuaris que apareixen a la taula de permisos i han entrat al llibre.</p><p>Els permisos de publicació (amb o sense validació) fan referència a la possibilitat d''afegir pàgines al capítol. La situació més habitual és la publicació amb validació, en la qual l''administrador/a rep un correu electrònic cada vegada que algú fa un enviament, que queda pendent de revisió a l''espera que sigui aprovat o rebutjat.<br /></p><p>Hi ha un usuari/ària especial, anomenat <strong>Tots</strong>, que fa referència als accessos anònims al llibre (usuaris que no han entrat al llibre).<br /></p><p>L''accés a l''administració dels usuaris només està disponible per a l''administrador/a del llibre i es duu a terme des de l''enllaç <strong>Edita</strong> ubicat al peu de pàgina de l''índex del capítol (no el confongueu amb l''índex del llibre).<br /></p>', '', 'Els permisos dels llibres', '2007-04-17 12:30:14', 7, 'Y', '', 0, 'top'),
(48, NULL, '', '', '', '\r\n<p> </p><p>L''altre editor visual disponible als llibres de la XTEC és el TinyMCE. La barra d''eines d''aquest editor té l''aspecte següent:</p><p align="center"><img width="410" height="20" src="/prestatgeria/centres/llibres_1/llibres_027.png" alt="llibres_027.png" /><br /> </p><p>Igual que en el cas del Xinha, disposa de les opcions de formatació bàsiques dels programes d''ofimàtica, però, a diferència d''aquest, no permet ni la visualització a pantalla completa, ni l''edició HTML, ni l''enviament d''imatges al servidor.</p><p>Com a contrapartida, ofereix dues opcions interessants:</p><p><img width="25" height="24" alt="llibres_028.png" src="/prestatgeria/centres/llibres_1/llibres_028.png" /> Introducció d''emoticones<br /></p><p> </p><p><img width="24" height="24" alt="llibres_029.png" src="/prestatgeria/centres/llibres_1/llibres_029.png" /> Visualització prèvia de la pàgina: obre una finestra amb el contingut de la pàgina tal com es veurà en ser enviada<br /></p><p> </p>', '', 'L''editor TinyMCE', '2011-07-04 10:44:32', 6, 'Y', '', 5, 'top'),
(50, NULL, '', '', '', '\r\n<p> </p><p>Per accedir a l''administració d''usuaris, cal anar a un capítol del llibre i clicar al botó <strong>Edita</strong> del peu de pàgina. </p><p align="center"> <img width="332" height="43" src="/prestatgeria/centres/llibres_1/llibres_400.png" alt="llibres_400.png" /></p><p> </p><p>A la part inferior del formulari d''edició, apareix la taula de permisos.</p><div align="center"><img width="416" height="151" src="/prestatgeria/centres/llibres_1/llibres_401.png" alt="llibres_401.png" /><br /></div><p>La taula mostra els usuaris que tenen accés al capítol i el nivell d''aquest accés. L''administrador/a sempre apareix i no es pot modificar. L''usuari/ària <strong>Tots</strong> fa referència als accessos sense validació.</p><p>Per donar accés a un usuari/ària existent (creat en un altre capítol del llibre), cal seleccionar-lo en el menú desplegable i clicar al botó <strong>Dóna accés</strong>. Si l''usuari/ària no existeix, cal accedir a l''edició d''usuaris.<br /></p><p>En fer clic al botó <strong>Edita els usuaris</strong>, apareix una taula amb les dades dels usuaris. Si no hi ha cap usuari/ària, a excepció de l''administrador/a, apareix buida.</p><p>Es poden importar usuaris des d''un fitxer <strong>.txt</strong> amb l''estructura següent (visiteu l''ajuda en línia per a més detalls):</p><p>usuari;contrasenya;correu_electrònic;nom_real;lletra_N<br /></p><p> </p><p>Per crear pocs usuaris, es pot utilitzar el formulari que apareix en clicar a <strong>Afegir un usuari/ària nou</strong>. Les dades demanades són les indicades anteriorment.</p><p> </p><p>Els usuaris que apareixen a la taula es poden editar i esborrar mitjançant els enllaços que apareixen a la columna <strong>Accions</strong>. En el cas de l''edició, es poden canviar totes les dades.</p><p>Important: els usuaris es defineixen a nivell de llibre, però els permisos d''accés ho fan a nivell de capítol. Per tant, perquè un usuari/ària pugui editar tots els capítols d''un llibre, només cal crear-lo una vegada en un capítol qualsevol, però cal donar-li accés a  tots ells de manera individual.<br /></p>', '', 'Administració d''usuaris', '2011-07-04 10:44:32', 7, 'Y', '', 1, 'top'),
(51, NULL, '', '', '', '\r\n<p> </p><p>Des de la pàgina inicial de la prestatgeria digital, es pot accedir als llibres de diverses formes: visitant el catàleg digital o clicant als blocs de llibres preferits, dels darrers creats o dels més llegits.</p><p>En clicar sobre un llibre, s''obre una pestanya (o finestra) nova al navegador i es mostra la pàgina de presentació i l''índex del llibre, que conté la llista de capítols. Els enllaços anomenats <strong>Índex</strong> ubicat als peus de pàgina fan referència a aquest índex.<br /></p><p>En clicar sobre un capítol, apareix l''índex del capítol, que conté la llista de les pàgines. En funció de la configuració del llibre, es pot mostrar una pàgina de benvinguda prèvia a l''índex del capítol.<br /></p>', '', 'L''índex del llibre i l''índex del capítol', '2007-04-16 10:05:15', 4, 'Y', '', 0, 'top'),
(52, NULL, '', '', '', '\r\n<p> </p><p>El tauler d''anuncis de llibres és un lloc on apareixen llibres que els seus administradors volen publicitar. S''hi accedeix des de l''opció <strong>Anuncis de llibres</strong> del menú principal.</p><p align="center"><img width="183" height="200" src="/prestatgeria/centres/llibres_1/llibres_003.png" alt="llibres_003.png" /> </p><p>Per fer que un llibre aparegui al tauler d''anuncis, cal entrar a la prestatgeria amb l''usuari/ària propietari del llibre i accedir al catàleg digital. Els llibres que pertanyen a aquest usuari/ària disposen de la icona <img width="18" height="18" src="/prestatgeria/centres/llibres_1/publi.png" alt="publi.png" />, que cal clicar per accedir al formulari per publicitar-ho.<br /></p><p> </p><p> </p><p>En el formulari, únicament es pot introduir el text de l''anunci, que es mostrarà juntament amb el títol del llibre, i un accés a aquest.</p><p>Els anuncis estaran actius entre 2 i 15 dies, en funció del nombre de llibres anunciats. Com més llibres hi hagi al tauler, menys dies hi apareixeran.<br /></p>', '', 'Anuncis de llibres', '2011-07-04 10:44:32', 3, 'Y', '', 5, 'top'),
(53, NULL, '', '', '', '\r\n<p> </p><p>Des de l''opció <strong>Preguntes més freqüents</strong> del menú de la pàgina inicial de la prestatgeria, s''accedeix a un entorn on trobareu respostes a preguntes habituals que altres usuaris han formulat prèviament.<br /></p><p> </p><p align="center">\r\n<img width="183" height="200" alt="llibres_002_1.png" src="/prestatgeria/centres/llibres_1/llibres_002_1.png" /></p><p>Les preguntes més freqüents s''agrupen en temes, el contingut de les quals es mostra i s''amaga fent clic damunt les icones de plegar i desplegar que apareixen al costat del títol.<br />\r\n<br /></p>', '', 'Preguntes més freqüents', '2011-07-04 10:44:32', 3, 'Y', '', 4, 'top'),
(55, NULL, '', '', '', '\r\n<p>La prestatgeria digital està destinada a la comunitat educativa de Catalunya. El servei està activat per a tots els centres docents, CRP, serveis educatius i altres entitats \r\npúbliques relacionades amb la docència i el Departament d''Educació.</p>Així doncs, un centre docent, un CRP, un servei educatiu o alguna altra entitat pública relacionada amb la docència i el Departament d''Ensenyament, pot crear llibres a la prestatgeria des del moment en que accedeix al servei.<br /><p align="center"> <img width="178" height="223" src="/prestatgeria/centres/llibres_1/llibres_005.png" alt="llibres_005.png" /></p>Per accedir al servei heu d''indicar el codi de centre i la contrasenya del correu XTEC. Aquestes dades es fan servir per verificar la vostra identitat. Una vegada el centre ha entrat, des de l''opció <strong>Gestiona els llibres</strong>, pot delegar a qualsevol usuari/ària xtec la capacitat de crear llibres en nom del centre.<br />', '', 'Activació del servei', '2011-11-30 12:33:47', 3, 'Y', '', 2, 'top'),
(67, NULL, '', '', '', '<p>&nbsp;</p><p align="center"><font size="3"><strong>Si jo fos Biòleg marí,</strong> em ficaria ek meu equip i aniria a visitar nous mars. Miraria com viuen els peixos i les plantes que hi ha allà. </font></p><p align="right"><font size="3"></font>J.S<br /></p>', '', 'Si jo fos Biòleg marí', '2008-01-20 22:15:05', 1, 'Y', '', -1, 'top'),
(68, NULL, 'David_nines@hotmail.com', '', '', '<br />\r\n  <p>Bones companys i companyes, a continuació us presento el quadern Virtual elaborat al llarg de tot aquest curs. El quadern virtual ens apropa una mica al coneixement d''un esport&nbsp;alternatiu amb moltes possibilitats educatives a l''estapa primària. Espero que gaudiu amb el Korfball.</p><br />\r\n  <p>Accés directe al <a title="original" href="http://clic.edu365.cat/qv_viewer/quaderns/dmarti67/elsesports/" target="_blank">quadern original</a></p><br />\r\n  <p>Accés directe al quadern amb <a title="infantil" href="http://clic.edu365.cat/qv_viewer/quaderns/dmarti67/elsesports/?skin=infantil" target="_blank">aparença infantil</a></p><br />\r\n  <p>Accés directe al quadern a la <a title="segona pàgina" href="http://clic.edu365.cat/qv_viewer/quaderns/dmarti67/elsesports/?section=2" target="_blank">segona pàgina</a> </p><br />\r\n  <p>&nbsp;</p><br />\r\n  <p>Fins la pròxima!! </p>', 'David Martínez Gutierrez', 'El Korfball', '2008-02-07 12:44:38', 2, 'Y', 'b96d53878fc6.jpg', -2, 'top'),
(69, NULL, '', '', '', '<br />\r\nThe Sun is Shining in the Sky<br />', '', 'The sun', '2008-02-08 12:22:17', 1, 'Y', '', -3, 'top'),
(76, NULL, '', '', '', '<br />\r\n<br />\r\n<p><span>Hace</span><span> </span><span>muchos</span><span> </span><span>años</span><span> </span><span>vivía</span><span> un Emperador que no </span><span>pensaba</span><span> </span><span>más</span><span> que en estrenar </span><span>trajes</span><span>. </span><span><br />\r\n</span></p><br />\r\n<br />\r\n', '', 'EL VESTIDO NUEVO DEL EMPERADOR', '2008-10-20 19:05:38', 6, 'N', '5ff65ca3592f.jpg', -10, 'top'),
(77, NULL, '', '', '', '<br />\r\n  <p>A continuació trobareu un enllaç a un quadern virtual per tal que podeu treballar tots els conceptes que heu estudiat en els últims dies.</p><br />\r\n  <p><a href="http://clic.edu365.cat/qv_viewer/quaderns/sperez65/atomienllac">Quadern virtual</a></p>', '', 'Àtom i enllaç', '2009-01-26 18:41:36', 5, 'Y', '', -11, 'top'),
(78, NULL, '', '', '', '<p><br />\r\nBenvolgut/da, <br /><br />aquesta és la primera entrada del llibre que t''acabo de crear, cal que la llegeixis, i no l''aprovis.<br /><br />És per fer-ne la comprovació que reps un missatge quan algú escriu al capítol que a partir d''avui gestionaràs tu.<br /><br />Bona prestatgeria.</p><p><br /><br /></p>', '', 'Benvnguda', '2009-02-17 12:28:02', 37, 'Y', '', -12, 'top'),
(79, NULL, '', '', '', '<br />\r\n  <h4 class="\\&quot;Estilo1\\&quot;"><font size="5">El cul de la lleona:</font></h4><br />\r\n  <p><a class="\\&quot;Estilo2\\&quot;" href="/&quot;http://www.ciutatdegirona.info/Catala/Llegendes/cullleona.html/&quot;"><img height="1" alt="\\&quot;La" src="/&quot;http://www.ciutatdegirona.info/Imatges/Detall%20Lleona.jpg/&quot;" width="1" border="0" longdesc="\\&quot;La" /></a><a class="Estilo2" href="http://www.ciutatdegirona.info/Catala/Llegendes/cullleona.html"><img height="162" alt="La Lleona de Girona" src="http://www.ciutatdegirona.info/Imatges/Detall%20Lleona.jpg" width="132" border="1" longdesc="La Lleona de Girona" /></a><a class="Estilo2" href="http://www.ciutatdegirona.info/Imatges/La%20Majordoma%20de%20Girona.jpg" target="_blank"></a></p><br />\r\n  <p>Diu la llegenda que qui vol ser bon gironí i no marxar mai de Girona o, si se n’ha d’anar, tornar-hi, ha de fer un petó al cul de la lleona. La columna de la lleona és una escultura que es troba al carrer de Calderers. Pot ser que aquesta fos part de l’anomenat Hostal de la Lleona en temps passats. Avui hi trobem una reproducció exacta de la columna original que es troba al Museu d’Art</p><br />\r\n  <p><strong><font size="5">La Majordoma:</font></strong></p><br />\r\n  <p><a class="Estilo2" href="http://www.ciutatdegirona.info/Imatges/La%20Majordoma%20de%20Girona.jpg" target="_blank"><img height="230" alt="Majordoma de Girona" hspace="10" src="http://www.ciutatdegirona.info/Imatges/La%20Majordoma%20de%20Gironam.jpg" width="173" align="left" vspace="2" border="0" longdesc="Lleona de Girona" /></a></p><br />\r\n  <p><a class="\\&quot;Estilo2\\&quot;" href="/&quot;http://www.ciutatdegirona.info/Imatges/La%20Majordoma%20de%20Girona.jpg/&quot;" target="\\&quot;_blank\\&quot;"><img height="1" alt="\\&quot;Majordoma" src="/&quot;http://www.ciutatdegirona.info/Imatges/La%20Majordoma%20de%20Gironam.jpg/&quot;" width="1" border="0" longdesc="\\&quot;Lleona" /></a></p><br />\r\n  <p>Aquesta llegenda de nova creació, diu així:</p><br />\r\n  <p>La Majordoma era una tia-àvia de Santa Afra que va acompanyar el bisbe quan va venir a viure a Girona. La Majordoma era una dona de més de cent anys immensament grassa, presumida i xafardera. També tenia anomenada per ser una bona cuinera i per la seva coneixença de les arts esotèriques. Anava vestida amb vestits de colors llampants i esquellarincs per fer notar el seu pas a la gent.</p><br />\r\n  <p>Les dots de cuinera de la Majordoma havia fet que inventés menjars molt saborosos que juntament amb la seva coneixença de les arts esotèriques li van permetre que, una vegada que es va enfadar molt, fes que totes les esglésies de Girona quedessin plenes de teranyines amb unes aranyes immenses.</p><br />\r\n  <p>Un dia, degut a una irreverència cap a Sant Narcís, aquest li va retirar els poders que tenia convertint-la en la riota de la ciutat, fins que un bon dia, va tenir una visió que preveia el martiri i mort de Sant Narcís i Sant Fèlix. </p><br />\r\n  <p>Quan les seus pressentiments es van fer realitat, la Majordoma es va tornar humil i es va dedicar a tenir cura dels malalts i desvalguts. Poc abans de morir, va fer encendre un foc davant de la porta de la Catedral i va inventar la sopa de menta. Quan va morir, els gironins que van carregar el seu cos van quedar admirats que a pesar de la seva grandària pesés menys que un pardalet.</p>', '', 'Llegendes de Girona', '2009-03-03 18:20:28', 6, 'N', '', -13, 'top'),
(72, NULL, '', '', '', 'No sé quin és<br />', '', 'Animal1', '2008-03-04 22:34:10', 1, 'Y', '', -6, 'top'),
(73, NULL, '', '', '', '<br />\r\n  <p align="justify"><font color="#02ff00" size="5"><strong>He fet servir el movie-maker per montar el video i les fotos les he tret del google. He triat aquesta canço perqué m''agrada i crec que es divertida. El que m''ha resultat mes cansat ha estat buscar totes le fotos per el google. Crec que podria millorar afegint alguna part de video. Jo crec que el meu treball a quedat bé i es divertit. </strong></font></p><br />\r\n  <p><font color="#02ff00" size="5"></font></p><br />\r\n  <p><font color="#02ff00" size="5"><strong>link:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font><a href="http://es.youtube.com/watch?v=tRnvodaxngs"><font color="#02ff00" size="5">http://es.youtube.com/watch?v=tRnvodaxngs</font></a></p>', '', 'M. Canals -- Ni de ellos ni de ellas (Toteking)', '2008-05-27 18:41:48', 8, 'N', '2d7a95339fdf.gif', -7, 'top'),
(74, NULL, '', '', '', '<br />\r\n<p> 1r premi Cartell</p><p><br />\r\n<br />\r\n</p><p class="\\&quot;MsoNormal\\&quot;"><span lang="\\&quot;CA\\&quot;">1r premi<span>            </span>Lucy Campos Vega<span>            </span>(IMG_01)<o:p /></span></p><br />\r\n<br />\r\n', '', 'Cartell', '2008-05-30 07:33:29', 1, 'Y', '', -8, 'top'),
(75, NULL, '', '', '', '<br />\r\n<div align="left"><span style="display: block; width: 150px; text-align: center;"><div align="left"><embed width="200" height="171" style="width: 200px; height: 171px;" pluginspage="http://www.macromedia.com/go/getflashplayer" src="http://www.bubbleshare.com/swfs/album_mini_bouncy.swf?3042" type="application/x-shockwave-flash" quality="high" bgcolor="#ffffff" allowscriptaccess="sameDomain" flashvars="rss_feed=http://www.bubbleshare.com/rss/121633.ec4251e0ead/feed.xml" /></div><span style="display: block; font-size: 9px; font-family: arial,helvetica,sans-serif;"></span></span></div><div align="center"><div style="text-align: left;"><font color="#996600">DIJOUS LLARDER<br /><br /></font></div></div><div></div><span style="display: block; width: 207px; height: 164px; text-align: center;"><embed width="206" height="158" style="width: 206px; height: 158px;" pluginspage="http://www.macromedia.com/go/getflashplayer" src="http://www.bubbleshare.com/swfs/album_mini_bouncy.swf?3190" type="application/x-shockwave-flash" quality="high" bgcolor="#ffffff" allowscriptaccess="sameDomain" flashvars="rss_feed=http://www.bubbleshare.com/rss/142772.e3fcc9d7121/feed.xml" /><br />', '', 'Imatges', '2008-10-16 11:43:35', 8, 'N', '', -9, 'top'),
(80, NULL, '', '', '', '<br />\r\n  <p style="margin: 0cm 0cm 0pt"><strong><span style="font-size: 14pt; color: #365f91; font-family: ">“La Pedrera - </span></strong><strong><span style="font-size: 14pt; color: #365f91; font-family: ">Casa Batlló</span></strong><strong><span style="font-size: 14pt; color: #365f91; font-family: ">”</span></strong><strong><span style="font-size: 14pt; color: #365f91; font-family: ">&nbsp;</span></strong><span lang="CA" style="font-size: 14pt; color: black; line-height: 115%; font-family: ">Finalista.- </span><strong style="mso-bidi-font-weight: normal"><em style="mso-bidi-font-style: normal"><span lang="CA" style="font-size: 14pt; color: #943634; line-height: 115%; font-family: ">Marina García</span></em></strong></p>', '', 'Educació infantil', '2009-05-01 13:24:53', 1, 'Y', '', -14, 'top');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
