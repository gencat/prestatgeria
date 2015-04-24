-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Temps de generació: 24-04-2015 a les 14:30:05
-- Versió del servidor: 5.5.43
-- Versió de PHP : 5.4.39-1+deb.sury.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de dades: `presta`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `012_chapter`
--

CREATE TABLE IF NOT EXISTS `012_chapter` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `ordre` int(11) NOT NULL DEFAULT '0',
  KEY `cid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Bolcant dades de la taula `012_chapter`
--

INSERT INTO `012_chapter` (`cid`, `ordre`) VALUES
(0, 0),
(2, 0),
(3, 0),
(0, 0),
(2, 0),
(3, 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `012_chapter_lang`
--

CREATE TABLE IF NOT EXISTS `012_chapter_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(5) NOT NULL DEFAULT 'ca',
  `title` varchar(100) NOT NULL DEFAULT '',
  `valida` tinyint(1) NOT NULL DEFAULT '0',
  `modified` varchar(20) NOT NULL DEFAULT '',
  `created` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Bolcant dades de la taula `012_chapter_lang`
--

INSERT INTO `012_chapter_lang` (`id`, `cid`, `lang`, `title`, `valida`, `modified`, `created`) VALUES
(0, 0, 'ca', 'Suggeriments', 0, '', ''),
(2, 2, 'ca', 'La prestatgeria digital', 1, '', ''),
(3, 3, 'ca', 'Ãšs dels llibres digitals', 1, '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `012_comment`
--

CREATE TABLE IF NOT EXISTS `012_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `author` varchar(100) NOT NULL DEFAULT '',
  `date` varchar(20) NOT NULL DEFAULT '',
  `validate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Bolcant dades de la taula `012_comment`
--

INSERT INTO `012_comment` (`id`, `question_id`, `comment`, `author`, `date`, `validate`) VALUES
(6, 32, 'Al meu institut, hem intentat moltes vegades validar el meu correu i mai ens deixa. Directament no hi ha espai a la pestanya de la web. No Ã©s un problema amb el nom d''usuari d''xtec perquÃ¨ a l''espai de proves em deixa crear llibres.', 'celia', '1263069440', 0),
(7, 1, 'No he pogut obrir el formulari d''inscripciÃ³. Ho he de fer desde el correu de centre?', 'Ã€ngels', '1290026495', 0),
(8, 1, 'He entrat al correu de centre per validar el servei i no em deixa.Estic a l''equip directiu. GrÃ cies\r\n', 'Angels ', '1290026978', 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `012_langs`
--

CREATE TABLE IF NOT EXISTS `012_langs` (
  `lang` varchar(5) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `012_langs`
--

INSERT INTO `012_langs` (`lang`, `name`) VALUES
('ca', 'Catal');

-- --------------------------------------------------------

--
-- Estructura de la taula `012_section`
--

CREATE TABLE IF NOT EXISTS `012_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `tid` int(11) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=13 ;

--
-- Bolcant dades de la taula `012_section`
--

INSERT INTO `012_section` (`id`, `cid`, `tid`, `ordre`) VALUES
(0, 0, 0, 0),
(2, 2, 0, 0),
(3, 2, 0, 10),
(4, 3, 0, 10),
(5, 3, 0, 0),
(6, 2, 0, 50),
(7, 2, 0, 40),
(8, 3, 0, 20),
(10, 3, 0, 15),
(11, 2, 0, 20);

-- --------------------------------------------------------

--
-- Estructura de la taula `012_section_lang`
--

CREATE TABLE IF NOT EXISTS `012_section_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(5) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `valida` tinyint(1) NOT NULL DEFAULT '0',
  `modified` varchar(20) NOT NULL DEFAULT '',
  `created` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Bolcant dades de la taula `012_section_lang`
--

INSERT INTO `012_section_lang` (`id`, `sid`, `lang`, `title`, `valida`, `modified`, `created`) VALUES
(0, 0, 'ca', 'Suggeriments nous', 0, '', ''),
(2, 2, 'ca', 'InscripciÃ³ al servei', 1, '', ''),
(3, 3, 'ca', 'CreaciÃ³ de llibres nous', 1, '', ''),
(4, 4, 'ca', 'IntroducciÃ³ de continguts nous', 1, '', ''),
(5, 5, 'ca', 'Com s''estructuren els continguts d''un llibre?', 1, '', ''),
(6, 6, 'ca', 'Altres opcions de la prestatgeria digital', 1, '', ''),
(7, 7, 'ca', 'Els catÃ legs de llibres', 1, '', ''),
(11, 11, 'ca', 'EdiciÃ³ de llibres', 1, '', '1179832437'),
(8, 8, 'ca', 'Aspectes avanÃ§ats d''administraciÃ³ dels llibres', 1, '', ''),
(10, 10, 'ca', 'AdministraciÃ³ bÃ sica dels llibres', 1, '', '1179833242');

-- --------------------------------------------------------

--
-- Estructura de la taula `012_suport`
--

CREATE TABLE IF NOT EXISTS `012_suport` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `tema` int(11) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=1 AUTO_INCREMENT=81 ;

--
-- Bolcant dades de la taula `012_suport`
--

INSERT INTO `012_suport` (`sid`, `tema`, `ordre`) VALUES
(1, 2, 0),
(2, 2, -15),
(3, 3, -15),
(4, 3, 0),
(5, 3, 0),
(6, 4, 0),
(7, 4, 0),
(8, 4, 0),
(9, 8, 0),
(10, 6, 0),
(11, 6, 15),
(12, 6, 30),
(13, 2, 0),
(14, 7, 0),
(15, 7, -15),
(16, 5, 0),
(17, 5, -15),
(18, 5, 0),
(19, 5, 0),
(20, 4, 0),
(21, 10, 0),
(22, 10, 0),
(23, 10, 0),
(24, 6, 15),
(25, 3, 15),
(26, 11, 15),
(27, 11, 0),
(28, 3, 30),
(29, 3, 15),
(30, 3, 15),
(31, 11, -15),
(32, 3, -15),
(33, 0, 0),
(35, 0, 0),
(36, 0, 0),
(37, 0, 0),
(38, 0, 0),
(39, 0, 0),
(40, 0, 0),
(41, 0, 0),
(42, 0, 0),
(43, 0, 0),
(44, 0, 0),
(45, 0, 0),
(46, 0, 0),
(47, 0, 0),
(48, 0, 0),
(49, 0, 0),
(50, 0, 0),
(51, 0, 0),
(52, 0, 0),
(53, 0, 0),
(54, 0, 0),
(55, 0, 0),
(56, 0, 0),
(57, 3, 0),
(58, 6, 30),
(59, 0, 0),
(60, 0, 0),
(61, 0, 0),
(62, 0, 0),
(63, 0, 0),
(64, 0, 0),
(65, 0, 0),
(66, 0, 0),
(67, 0, 0),
(68, 0, 0),
(69, 0, 0),
(70, 0, 0),
(71, 0, 0),
(72, 0, 0),
(73, 0, 0),
(74, 0, 0),
(75, 0, 0),
(76, 0, 0),
(77, 0, 0),
(78, 0, 0),
(79, 0, 0),
(80, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `012_suport_lang`
--

CREATE TABLE IF NOT EXISTS `012_suport_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(4) NOT NULL DEFAULT '',
  `question` varchar(255) NOT NULL DEFAULT '',
  `response` text,
  `other` text,
  `valida` tinyint(1) NOT NULL DEFAULT '0',
  `modified` varchar(20) DEFAULT NULL,
  `created` varchar(20) DEFAULT NULL,
  `clics` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Bolcant dades de la taula `012_suport_lang`
--

INSERT INTO `012_suport_lang` (`id`, `sid`, `lang`, `question`, `response`, `other`, `valida`, `modified`, `created`, `clics`) VALUES
(1, 1, 'ca', 'Qui es pot inscriure al servei?', '\r\n<p>NomÃ©s\r\nels centres, identificats mitjanÃ§ant el correu electrÃ²nic del centre i la contrasenya\r\ncorresponent, poden fer Ãºs del servei. Per formalitzar la inscripciÃ³, cal que una persona amb accÃ©s a la contrasenya del correu XTEC del centre completi el <a target="_blank" href="/prestatgeria/index.php?a=ins">formulari d''inscripciÃ³</a>.</p><p>La inscripciÃ³ nomÃ©s s''ha de fer una vegada.</p>', '\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '', 1338),
(2, 2, 'ca', 'QuÃ¨ Ã©s el servei de prestatgeria digital de la XTEC?', '\r\nÃ‰s un servei destinat a centres docents que permet escriure llibres vituals de\r\nmanera colÂ·laborativa i senzilla per mitjÃ  d''Internet. Els centres docents poden crear tants llibres virtuals com creguin conveninent i assignar-ne l''administraciÃ³ a professorat de la XTEC.\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '', 806),
(3, 3, 'ca', 'Qui pot crear llibres nous?', '\r\nNomÃ©s poden crear llibres els centres docents, els CRP, els Serveis\r\nEducatius i altres entitats pÃºbliques relacionades amb la docÃ¨ncia i el\r\nDepartament d''EducaciÃ³. TambÃ© les persones a qui s''ha autoritzat a crear llibres en nom dels centres o entitats.<br />\r\n						\r\n						\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '1177323257', '', 877),
(4, 4, 'ca', 'Quants llibres pot crear un mateix centre docent?', '\r\n<p>\r\nCada centre pot crear tants llibres com cregui oportÃº, no hi ha limitaciÃ³.<br /></p><p>Una vegada s''hagi creat un llibre, cal activar-lo. Els llibres que no s''hagin activat en un termini de 15 dies s''esborraran de forma automÃ tica. AixÃ­ mateix, els llibres que no hagin tingut cap consulta en un perÃ­ode de 6 mesos, tambÃ© s''esborraran de forma automÃ tica.<br /> </p>\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						', 1, '', '', 399),
(5, 5, 'ca', 'QuÃ¨ cal fer per crear un llibre nou?', '\r\n<p>Els llibres els poden crear els centres docents i altres entitats relacionades amb el Departament d''EducaciÃ³ de la Generalitat de Catalunya.<br /></p><p>El procediment de creaciÃ³ de llibres nous Ã©s senzill. Cal seguir les passes segÃ¼ents:</p><ul><li>Inscriure''s al servei de prestatgeria digital, si Ã©s que no s''ha fet abans.</li><li>Entrar a la prestatgeria digital com a centre docent amb les dades de correu de la XTEC.</li><li>Fer clic a l''opciÃ³ <a href="/prestatgeria/index.php?a=new"><strong>Crea un llibre nou</strong></a> des d''on es podrÃ  accedir al formulari de creaciÃ³ d''un llibre nou.</li><li>Omplir el formulari, acceptar les condicions d''Ãºs i fer clic al botÃ³ anomenat <strong>Entra llibre</strong>.<br /></li></ul>El formulari de creaciÃ³ d''un llibre nou demana les dades segÃ¼ents:<ul><li>TÃ­tol del llibre: serÃ  el nom amb el qual es reconeixerÃ  el llibre.<br /></li><li>Idioma: hi ha disponibles quatre idiomes per als textos informatius, formularis i icones del llibre. Aquests sÃ³n: catalÃ , castellÃ , anglÃ¨s i francÃ¨s.</li><li>DescripciÃ³ del llibre: serÃ  el text que apareixerÃ  a la contraportada del llibre.<br /></li><li>Estil o aparenÃ§a: permet escollir entre tres estils de llibre. Aquests sÃ³n: Classic, WorkBook i Modern.<br /></li><li>ColÂ·lecciÃ³: quan hi hagi colÂ·leccions disponibles, els llibres es podran associar a una colÂ·lecciÃ³. AixÃ² serÃ  Ãºtil per agrupar llibres de temÃ tica relacionada i poder-los filtrar en el catÃ leg general de llibres digitals.<br /></li><li>Descriptors:\r\nllista de paraules separades per comes que descriuen la temÃ tica del\r\nllibre. No poden contenir accents ni carÃ cters especials.</li><li>Correu XTEC de la persona que administrarÃ  el llibre.</li><li>Codi o contrasenya que es farÃ  servir per accedir a l''administraciÃ³ del llibre: no ha de coincidir necessÃ riament amb la del correu de l''usuari/Ã ria (aixÃ² permet crear\r\nllibres i assignar-los a terceres persones).<br /></li><li>Indicar que s''accepten les condicions d''Ãºs.<br /></li></ul><p>Una vegada introduÃ¯da tota aquesta informaciÃ³, en clicar al botÃ³ <strong>Entra llibre</strong>, s''enviarÃ  un correu a l''administrador/a del llibre en quÃ¨ se l''informarÃ  de la creaciÃ³ del llibre i de les dades d''accÃ©s d''administraciÃ³.<br /><br />Tot\r\ni que el llibre ja ha estat creat, no s''activarÃ  fins que\r\nl''administrador/a del llibre validi aquest llibre des de la mateixa prestatgeria. D''aquesta manera, l''administrador/a dÃ³na el\r\nvistiplau a la seva creaciÃ³.<br /></p>						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '1259148262', '', 1180),
(6, 6, 'ca', 'Com s''afegeix un capÃ­tol a un llibre?', '\r\n<p>Per afegir un capÃ­tol nou, cal accedir al llibre i validar-se com a administrador/a mitjanÃ§ant l''enllaÃ§ <strong>Entra</strong>, ubicat al peu de pÃ gina.</p>\r\n<p>Els administradors d''un llibre disposen de l''enllaÃ§ <strong>CapÃ­tol nou</strong> a l''Ã­ndex corresponent.</p><p> </p><p>El formulari de creaciÃ³ de capÃ­tols demana les dades segÃ¼ents:</p>\r\n<ul><li>NÃºmero del capÃ­tol: es fa servir per a l''ordenaciÃ³ dels capÃ­tols.</li><li>Nom o tÃ­tol del capÃ­tol.</li><li>Imatge del capÃ­tol: imatge que es mostra juntament amb la presentaciÃ³ del llibre.</li><li>Permisos: indica si Ã©s d''accÃ©s restringit, si Ã©s de nomÃ©s lectura,\r\nsi es poden fer enviaments anÃ²nims amb validaciÃ³ o si es poden fer\r\nenviaments anÃ²nims sense validaciÃ³.</li><li>PÃ gina d''entrada: la primera pÃ gina que es mostra. Es recomana deixar l''opciÃ³ per defecte.</li><li>Format: permet escollir entre una o dues pÃ gines simultÃ niament.</li><li>Dades que es demanen de l''usuari/Ã ria (s''han de marcar).</li><li>Correu electrÃ²nic de notificaciÃ³ d''entrades noves.</li><li>Text de presentaciÃ³ del llibre: text que es mostra a la pÃ gina prÃ¨via de l''Ã­ndex del llibre.</li></ul>\r\n						\r\n						', '\r\n						\r\n						\r\n						', 1, '', '', 356),
(7, 7, 'ca', 'Com s''afegeixen pÃ gines noves a un capÃ­tol?', '\r\n<p>Les pÃ gines del llibre es creen omplint el formulari de creaciÃ³ d''articles, al qual es pot accedir per dues vies:</p><ol><li>Fent clic a l''enllaÃ§ <strong>Afegeix</strong> del peu de pÃ gina.</li><li>Editant una pÃ gina sense contingut.<br /></li></ol><p>\r\nEn editar una pÃ gina qualsevol, Ã©s possible canviar-la de capÃ­tol,\r\nmentre que, en crear-la, apareixerÃ  sempre al final del capÃ­tol que\r\ns''estÃ  visitant.</p><p>El formulari de creaciÃ³ demana les dades segÃ¼ents:</p><ul><li>Text per mostrar: Ã©s el contingut de la pÃ gina.</li><li>TÃ­tol de la pÃ gina.<br /></li><li>El teu nom (opcional): el nom o Ã lies de la persona que envia la pÃ gina.</li><li>Correu electrÃ²nic (opcional): adreÃ§a de la persona que fa l''enviament.</li><li>Imatge (opcional): imatge que apareixerÃ  a la part superior de la pÃ gina. La mida mÃ xima permesa de les imatges Ã©s de 400 KB.<br /></li><li>URL (opcional): pÃ gina web de l''autor/a o pÃ gina relacionada amb la pÃ gina.<br /></li><li>Nom de l''URL (opcional): text que es mostrarÃ  a l''enllaÃ§ corresponent a l''URL.<br /></li></ul><p> </p>Les dades opcionals poden no aparÃ¨ixer si l''administrador/a del capÃ­tol ha decidit que no es demanaran.<br />						\r\n						\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						', 1, '', '', 396),
(8, 8, 'ca', 'Com es canvia l''estil o l''aspecte del llibre?', '\r\n<p>L''estil del llibre es pot modificar per dues vies diferents:</p><ol><li>Fent clic a l''enllaÃ§ <span style="font-weight: bold;">Edita</span> del peu de pÃ gina del llibre.</li><li>Modificant la fitxa del llibre en el catÃ leg digital.<br /></li></ol><p> </p><p>Una vegada dins el menÃº d''ediciÃ³, a l''opciÃ³ <strong>Estil del llibre</strong>,<strong> </strong>tan sols has de seleccionar l''aspecte que mÃ©s t''agradi de la llista i desar les dades.</p>\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						', 1, '', '', 179),
(9, 9, 'ca', 'Quines sÃ³n les diferÃ¨ncies entre els permisos d''ediciÃ³?', '\r\n<p>Les diferÃ¨ncies principals entre els permisos:  </p><p><strong>CapÃ­tol privat (requereix entrar-hi)</strong>: Ã©s d''accÃ©s restringit.<br /><br /><strong>NomÃ©s l''administrador/a del llibre pot afegir a aquest capÃ­tol</strong>: nomÃ©s de lectura per a la resta d''usuaris. L''administrador/a del llibre es l''Ãºnic que pot afegir contingut.<br /><br /><strong>S''admeten articles amb aprovaciÃ³ prÃ¨via</strong>: qualsevol usuari/Ã ria pot fer enviaments anÃ²nims i afegir contingut al llibre, perÃ² amb una validaciÃ³ prÃ¨via.<br /><br /><strong>Qualsevol pot publicar sense aprovaciÃ³ prÃ¨via</strong>: qualsevol usuari/Ã ria pot fer enviaments anÃ²nims i afegir contingut al llibre. Aquesta informaciÃ³ es publica sense una aprovaciÃ³ prÃ¨via.<br /></p>\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '', 306),
(10, 10, 'ca', 'Els meus llibres preferits', '\r\n<p>Si et valides al web amb les dades de correu de la XTEC, podrÃ s crear-te una llista de llibres preferits que et permetrÃ  accedir als llibres triats de forma rÃ pida. Arreu on vegis la icona <img width="26" height="19" src="/prestatgeria/pmf/images/prefer.png" alt="prefer.png" /> pots fer-hi clic i el llibre s''afegirÃ  a la llista de llibres preferits.</p><p>La llista de llibres preferits se situa a la columna de l''esquerra, just a sota del menÃº principal. </p>\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						', 1, '', '', 161),
(11, 11, 'ca', 'Publicita el meu llibre', '\r\n<p>Si ets administrador/a d''un llibre, pots publicitar-lo. Un llibre publicitat sortirÃ  a la pÃ gina d''inici durant un parell de dies. TambÃ© se situarÃ  al suro, al qual s''accedeix des de l''enllaÃ§ anomenat 				\r\n						<a onclick="showContent(''publi'','''','''','''','''','''','''')" href="/prestatgeria/index.php?a=publi" title="Anuncis de llibres">Anuncis de llibres</a> del menÃº principal de la columna de l''esquerra. Un llibre nomÃ©s pot estar anunciat una vegada en un mateix instant de temps. El temps de vida d''un anunci Ã©s inversament proporcial a la quantitat d''anuncis publicats (mÃ xim 15 dies i mÃ­nim 2 dies).</p><p>Pots anunciar un llibre des de la icona <img width="18" height="18" alt="publi.png" src="/prestatgeria/pmf/images/publi.png" />, que apareixerÃ  a la columna de la dreta del catÃ leg en els llibres dels quals ets administrador/a.<br /> </p>\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '', 229),
(12, 12, 'ca', 'EdiciÃ³ de les caracterÃ­stiques d''un llibre', '\r\nEls propietaris dels llibres, Ã©s a dir, els centres docents o les entitats que poden crear llibres, i els administradors dels llibres poden editar-ne les propietats. Els propietaris dels llibres poden, tambÃ©, canviar l''administrador/a dels llibres. Tot aixÃ² es pot fer des de la icona d''ediciÃ³ de les propietats d''un llibre <img width="18" height="18" alt="editfolder.png" src="/prestatgeria/pmf/images/editfolder.png" />, la qual trobareu a la columna de la dreta dels catÃ legs.\r\n						\r\n						', '\r\n						\r\n						', 1, '', '', 226),
(13, 13, 'ca', 'Crec que m''hauria de poder inscriure al servei i no ho aconsegueixo, quÃ¨ he de fer?', '\r\n<p>Si representes un centre docent o una entitat relacionada amb la docÃ¨ncia i el Departament d''EducaciÃ³, i has provat d''inscriure''t al servei i no t''ha estat possible, envia un missatge de correu a l''adreÃ§a: <a href="mailto:llibres@xtec.cat">llibres@xtec.cat</a>. Al  missatge, indica les dades segÃ¼ents:</p><ul><li>Nom oficial del centre o entitat</li><li>AdreÃ§a del centre o entitat</li><li>Municipi on estÃ  ubicat</li><li>Codi postal del centre</li></ul>En rebre un missatge d''aquestes caracterÃ­stiques, es comprovarÃ  que les dades siguin correctes i, si s''escau, es farÃ  possible la inscripciÃ³ al servei del centre o de l''entitat.<br />\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						', 1, '', '', 703),
(14, 14, 'ca', 'Cerca de llibres en el catÃ leg general', '\r\n<p>La quantitat de llibres que es poden acumular al catÃ leg de llibres general pot ser gran. Des de les opcions de cerca, Ã©s possible filtrar llibres segons uns criteris.</p><p>Podeu desplegar les opcions de cerca de llibres des de la icona <img width="41" height="19" src="/prestatgeria/pmf/images/search.png" alt="search.png" />.</p><p>El filtratge de llibres es pot portar a terme des dels criteris segÃ¼ents:</p><ul><li>El tÃ­tol del llibre contÃ© les paraules ------.</li><li>El nom del centre propietari del llibre Ã©s -----.</li><li>Els descriptors del llibre sÃ³n -----.</li><li>L''idioma del llibres Ã©s ------.</li><li>El municipi on Ã©s el centre Ã©s ------.</li><li>L''usuari/Ã ria administrador/a del llibre Ã©s -------.</li><li>La colÂ·lecciÃ³ a la qual pertany el llibre Ã©s -------.</li></ul>En alguns casos, Ã©s possible establir la cerca a partir d''un text en un camp lliure. En aquest cas, si es vol cercar per diferents paraules, cal escriure aquestes paraules separades amb un espai.<br />\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '', 252),
(15, 15, 'ca', 'QuÃ¨ sÃ³n els catÃ legs de llibres?', '\r\n<p>Els catÃ legs donen accÃ©s als llibres disponibles a la prestatgeria i a la informaciÃ³ relativa a aquests llibres. Hi ha dos tipus de catÃ legs:</p><p>El <a href="/prestatgeria/index.php?a=cataleg" title="AccÃ©s al catÃ leg de llibres">catÃ leg general</a>, on apareixen tots els llibres disponibles a la prestatgeria digital, agrupats de 15 en 15 i ordenats segons el criteri dels que tenen entrades mÃ©s recents.</p><p>El catÃ leg de centre, on apareixen els llibres vinculats a un mateix centre o entitat, ordenats pel nombre de pÃ gines.</p><p>A la darrera columna de les llistes, es poden trobar les icones segÃ¼ents:</p><p><table width="100%" cellspacing="1" cellpadding="1" border="0"><tbody><tr><td valign="top" style="width: 5%;"> <img width="18" height="18" src="/prestatgeria/pmf/images/folder.png" alt="folder.png" /><br /></td><td valign="top" style="width: 33%;"> Mostra la fitxa del llibre<br /></td><td valign="top" style="width: 33%;">DÃ³na accÃ©s a la fitxa amb informaciÃ³ del llibre. </td></tr><tr><td valign="top" style="width: 5%;"> <img width="26" height="19" src="/prestatgeria/pmf/images/prefer.png" alt="prefer.png" /><br /></td><td valign="top" style="width: 33%;"> Afegeix als llibres preferits<br /></td><td valign="top" style="width: 33%;"> Permet als usuaris que han entrat a la prestatgeria afegir un llibre a la llista de llibres preferits.<br /></td></tr><tr><td valign="top" style="width: 5%;"> <img width="19" height="19" src="/prestatgeria/pmf/images/comment.png" alt="comment.png" /><br /></td><td valign="top" style="width: 33%;"> Afegeix un comentari<br /></td><td valign="top" style="width: 33%;"> Permet als usuaris que han entrat a la prestatgeria afegir un comentari sobre un llibre.</td></tr><tr><td valign="top"><img width="18" height="18" src="/prestatgeria/pmf/images/editfolder.png" alt="editfolder.png" /><br /></td><td valign="top">Edita les caracterÃ­stiques del llibre<br /></td><td valign="top">NomÃ©s veuen aquesta icona els propietaris i els administradors d''un llibre. Els permet editar les caracterÃ­stiques d''un llibre.<br /></td></tr><tr><td valign="top"><img width="18" height="18" src="/prestatgeria/pmf/images/publi.png" alt="publi.png" /><br /></td><td valign="top">Publicita el teu llibre<br /></td><td valign="top">NomÃ©s els administradors d''un llibre veuen aquesta icona i els permet anunciar el llibre al portal.<br /></td></tr><tr><td valign="top"><img width="14" height="14" src="/prestatgeria/pmf/images/rss.gif" alt="rss.gif" /><br /></td><td valign="top">Subscriu-te al llibre<br /></td><td valign="top"><meta content="text/html; charset=utf-8" http-equiv="CONTENT-TYPE" /><title></title><meta content="OpenOffice.org 2.0  (Linux)" name="GENERATOR" /><meta content="20070418;7072900" name="CREATED" /><meta content="20070423;13382200" name="CHANGED" /><meta content="Jornada Esprial 2005" name="CLASSIFICATION" />Permet subscriure''s o sindicar-se a a un llibre i estar sempre al dia de les entrades noves que tingui.<style>@page { size: 21cm 29.7cm; margin: 2cm }\r\n		P { margin-bottom: 0.21cm }\r\n	--></style></td></tr></tbody></table></p>', '\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 2, '1177327188', '', 130),
(16, 16, 'ca', 'Els capÃ­tols', '<p>\r\nEls capÃ­tols sÃ³n cadascuna de les seccions que formen un llibre. El funcionament dels llibres i l''accÃ©s als seus continguts estan relacionats amb la configuraciÃ³ dels capÃ­tols. Els capÃ­tols estan formats per les pÃ gines del llibre.\r\n						\r\n						\r\n						\r\n						</p>', '\r\n						\r\n						\r\n						\r\n						', 1, '', '', 340),
(17, 17, 'ca', 'La contraportada del llibre', '\r\nLa contraportada contÃ© la descripciÃ³ principal del llibre. Al costat de la contraportada, hi ha la llista de capÃ­tols i l''enllaÃ§ a aquests.\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						', 1, '', '', 392),
(18, 18, 'ca', 'La relaciÃ³ de pÃ gines d''un capÃ­tol', '\r\nA mesura que s''afegeixen pÃ gines a un capÃ­tol, es genera un Ã­ndex des del qual, per mitjÃ  d''enllaÃ§os, Ã©s possible accedir al contingut d''aquestes pÃ gines.\r\n						\r\n						\r\n						', '\r\n<a href="suport.php?sid=7&amp;lang=ca" class="revisar">\r\n										Com s''afegeixen pÃ gines noves a un capÃ­tol?</a>\r\n						\r\n						\r\n						', 1, '', '1179832761', 348),
(19, 19, 'ca', 'Les pÃ gines dels capÃ­tols', '\r\n<p>Les pÃ gines dels capÃ­tols sÃ³n els elements que contenen la informaciÃ³ del llibre.</p><p>A cada pÃ gina se li ha de posar un tÃ­tol. SerÃ  des d''aquest tÃ­tol que es podrÃ  accedir al contingut de la pÃ gina a la llista de pÃ gines que es mostra a l''inici de cada capÃ­tol.<br /></p>\r\n						\r\n						', '\r\n<p><a href="suport.php?sid=18&amp;lang=ca" class="innactiu">\r\n										La relaciÃ³ de pÃ gines d''un capÃ­tol</a> </p><p><a class="revisar" href="suport.php?sid=7&amp;lang=ca">Com s''afegeixen pÃ gines noves a un capÃ­tol?</a>\r\n						\r\n						</p>\r\n						', 1, '', '', 131),
(20, 20, 'ca', 'De quines maneres es poden afegir pÃ gines a un llibre?', '\r\n<p>Les pÃ gines del llibre es creen omplint el formulari de creaciÃ³ d''articles, al qual es pot accedir per dues vies:</p><ol><li>Fent clic a l''enllaÃ§ <strong>Afegeix</strong> del peu de pÃ gina d''un capÃ­tol.</li><li>Editant una pÃ gina sense contingut.<br /></li></ol>\r\n						\r\n						', '\r\n						\r\n						', 1, '', '', 219),
(21, 21, 'ca', 'Com puc saber quan s''ha creat una pÃ gina nova al llibre?', '\r\nEls administradors dels capÃ­tols reben un correu electrÃ²nic automÃ tic cada vegada que hi ha una entrada nova al capÃ­tol o capÃ­tols que administren. GrÃ cies a aixÃ², poden saber quan hi ha continguts nous en els llibres, sense necessitat d''haver d''accedir a l''interior.\r\n						\r\n						', '\r\n						\r\n						', 1, '', '1179833227', 209),
(22, 22, 'ca', 'Puc evitar rebre una notificaciÃ³ cada vegada que s''entri una pÃ gina nova al llibre?', '\r\n<p>Per a cadascun dels capÃ­tols del llibre, es pot decidir a quina adreÃ§a de correu electrÃ²nic s''envia una notificaciÃ³ quan s''entra una pÃ gina nova.</p><p>No rebreu aquesta notificaciÃ³ si editeu el capÃ­tol i deixeu buit el camp <strong>Correu electrÃ²nic de l''administrador</strong>.</p><p>&nbsp;</p>\r\n						', '\r\n						\r\n						', 2, '1179834538', '', 5),
(23, 23, 'ca', 'Com puc validar o aprovar pÃ gines noves?', '\r\n<p>Si l''entrada de pÃ gines noves als capÃ­tols Ã©s lliure amb aprovaciÃ³ prÃ¨via. Els continguts no seran visibles als usuaris fins que els continguts no hagin estat aprovats.</p><p>L''admininistrador/a d''un capÃ­tol pot validar o aprovar els continguts des del seu interior desprÃ©s de fer clic sobre el tÃ­tol dels capÃ­tols. Una vegada a dins, trobarÃ  un apartat anomenat <strong style="color: #000000;">Articles que necessiten aprovaciÃ³</strong><span style="color: #000000;"> amb la llista de pÃ gines pendents de validaciÃ³. Per a cadascuna trobarÃ  un enllaÃ§ que obrirÃ  la pÃ gina d''aprovaciÃ³ de continguts.</span><br /></p>\r\n						', '\r\n						\r\n						', 1, '', '1179834751', 195),
(24, 24, 'ca', 'Puc esborrar l''anunci d''un llibre o modificar-lo?', '\r\n<p>Els anuncis dels llibres no es poden modificar directament, perÃ² es poden esborrar i, una vegada esborrats, es poden tornar a crear. Per esborrar l''anunci d''un llibre del qual s''Ã©s administrador/a, cal entrar al catÃ leg, buscar el llibre del qual es vol esborrar l''anunci i fer clic a la icona <img width="18" height="18" src="/prestatgeria/pmf/images/publi.png" alt="publi.png" />.</p><p>El sistema avisarÃ  conforme el llibre ja tÃ© un anunci actiu i donarÃ  l''opciÃ³ de forÃ§ar-ne la caducitat o, el que Ã©s el mateix, esborrar-lo.<br /></p>\r\n						\r\n						', '\r\n						\r\n						\r\n						', 1, '', '1179832673', 168),
(25, 25, 'ca', 'QuÃ¨ sÃ³n les colÂ·leccions?', '\r\n<p>Les colÂ·leccions serveixen per agrupar llibres d''una mateixa tipologia, els quals, posteriorment, es podran filtrar fÃ cilment des de les opcions de cerca del catÃ leg.</p><p align="center"><img width="61" height="27" alt="search.png" src="/prestatgeria/pmf/images/search.png" /></p><p>Quan es crea un llibre nou, si es creu oportÃº, es pot associar a una de les colÂ·leccions disponibles.<br /></p><p>Les colÂ·leccions es proposen directament des de la XTEC. No obstant, es poden proposar colÂ·leccions noves des de l''adreÃ§a de correu: llibres@xtec.cat.<br /></p><p>Hi ha dos tipus de colÂ·leccions:</p><ul><li>Les permanents, que no caduquen mai.</li><li>Les temporals, que nomÃ©s estan disponibles per ser associades als llibres durant un perÃ­ode determinat de temps. Normalment, s''associen a esdeveniments lligats amb el calendari.<br /></li></ul><p><strong>AtenciÃ³:</strong> Una vegada s''ha associat un llibre a una colÂ·lecciÃ³, ja no es pot canviar a una altra. Si no es tÃ© clar a quina colÂ·lecciÃ³ pot pertÃ nyer un llibre, el millor Ã©s no associar-lo a cap.<br /></p>\r\n						\r\n						', '\r\n						\r\n						\r\n						', 1, '', '1179819101', 190),
(26, 26, 'ca', 'He assignat un llibre a una colÂ·lecciÃ³. El puc canviar de colÂ·lecciÃ³?', '\r\nUna vegada s''ha associat un llibre a una colÂ·lecciÃ³ no es pot canviar de colÂ·lecciÃ³. Si l''associaciÃ³ s''ha fet per error, podeu demanar, per mitjÃ  de l''adreÃ§a de correu <a href="mailto:llibres@xtec.cat">llibres@xtec.cat</a>, que us treguin el llibre de la colÂ·lecciÃ³ i, aleshores, us serÃ  possible fer-ho.\r\n						\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						', 1, '', '1179826421', 111),
(27, 27, 'ca', 'Tinc un llibre i el vull associar a una colÂ·lecciÃ³. QuÃ¨ he de fer?', '\r\n<p>NomÃ©s podrÃ s fer aixÃ² si el llibre no ha estat associat amb anterioritat a una colÂ·lecciÃ³.</p><p>Si Ã©s aixÃ­ i ets l''administrador/a del llibre, el pots editar des de la icona <img width="18" height="18" src="/prestatgeria/pmf/images/editfolder.png" alt="editfolder.png" /> del catÃ leg i associar-lo a una de les colÂ·leccions disponibles.<br /></p>\r\n						\r\n						\r\n						\r\n						', '\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '1179826369', 179),
(28, 28, 'ca', 'Quins criteris puc utilitzar per assignar descriptors als llibres?', '\r\n<p>Els descriptors s''han d''entrar separats per comes, amb minÃºscules, amb\r\nles paraules sense accents ni diÃ¨resis i sense espais. Un parell\r\nd''exemples de descriptors vÃ lids sÃ³n: <strong>tecnologia,mecanica,eso</strong> o bÃ© <strong>catala,poesia</strong>. Un descriptor de l''estil <strong>catalÃ ,poesia</strong> no Ã©s vÃ lid.</p><p>Aquests descriptors els podrÃ  modificar l''administrador/a del llibre\r\ncada vegada que ho cregui oportÃº des de la icona <img width="18" height="18" alt="editfolder.png" src="/prestatgeria/pmf/images/editfolder.png" /> del catÃ leg de llibres.\r\n						</p><p>Us recomanem seguir les pautes segÃ¼ents a l''hora de crear o editar els descriptors d''un llibre:</p><ul><li>Abans d''escriure un descriptor nou, mireu-vos si existeixen alguns descriptors similars. En aquest cas, Ã©s millor que feu servir el descriptor que ja existeix, ja que, com mÃ©s llibres hi hagi amb el mateix descriptor, millor.</li><li>No feu Ãºs de descriptors de l''estil <strong>poesia catalana</strong>, ja que el resultat serÃ  <strong>poesiacatalana</strong> el qual es poc Ãºtil i no us ajudarÃ  a agrupar o a cercar el llibre. Ã‰s molt millor escriure <strong>poesia,catalana</strong> o, si ja existeix el descriptor <strong>catala</strong>, escriure <strong>poesia,catala</strong>. AixÃ­ aconseguireu associar al llibre els descriptors <strong>poesia</strong> i <strong>catala</strong>, amb la qual cosa el podreu buscar amb qualsevol dels dos termes i, a mÃ©s, feu mÃ©s gran la suma d''aquests descriptors.<br /></li></ul>\r\n						', '\r\n						\r\n						', 1, '', '1179825331', 148),
(29, 29, 'ca', 'QuÃ¨ sÃ³n els descriptors?', '\r\n<p>Els descriptors sÃ³n paraules que podeu associar als llibres. Un llibre pot tenir tants descriptors com es vulgui. Us seran Ãºtils per:</p><ul><li>Associar llibres d''una mateixa temÃ tica, Ã rea curricular, nivell educatiu...</li><li>Filtrar llibres que tinguin els mateixos descriptors des de les opcions de cerca del catÃ leg.</li></ul><p>A mesura que es creen descriptors nous, es crea el nÃºvol de descriptors que apareix a la columna de l''esquerra de la pÃ gina d''inici i, tambÃ©, a la zona central, si voleu veure''ls tots.</p><p><img width="565" height="374" src="/prestatgeria/pmf/images/nuvol.png" alt="nuvol.png" /></p>\r\n						\r\n						', '\r\n<ul><li><a href="suport.php?sid=28&amp;lang=ca">Quins criteris puc utilitzar per assignar descriptors als llibres?</a></li></ul>\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '1179823933', 192),
(30, 30, 'ca', 'Com funciona el nÃºvol de descriptors?', '\r\n<p>El nÃºvol mostra els descriptors que han estat associats als llibres. La mida del text amb el qual es mostren els descriptors Ã©s directament proporcial al nombre de llibres que els han referenciat. Per tant, si voleu donar mÃ©s importÃ ncia a una matÃ¨ria o Ã mbit temÃ tic, podeu associar els vostres llibres a aquesta matÃ¨ria o Ã mbit temÃ tic.<br /><br /> </p>\r\n						', '\r\n						\r\n						', 1, '', '1179824634', 204),
(31, 31, 'ca', 'Com s''editen les dades que es mostren a la Prestatgeria?', '\r\n<p>Els llibres es poden editar des de dos punts de vista:</p><ul><li>El punt de vista del propietari/Ã ria del llibre, Ã©s a dir, el centre.</li><li>El punt de vista de l''administrador/a del llibre.</li></ul><p>El centre pot editar l''administrador/a del llibre i el codi d''administraciÃ³. per tant, pot canviar la persona que administra el llibre. El centre tambÃ© pot esborrar completament un llibre.</p><p><strong>AtenciÃ³:</strong> Quan s''esborra un llibre, es perden totes les dades que contÃ©, incloses les imatges del llibre i la informaciÃ³ no es pot recuperar.<br /></p><p>L''administrador/a del llibre pot canviar-li el tÃ­tol, la descripciÃ³, l''aspecte, l''idioma i els descriptors. TambÃ© pot associar el llibre a una colÂ·lecciÃ³, si Ã©s que no ha estat associat a cap colÂ·lecciÃ³ anteriorment.</p><p>Podeu accedir a l''ediciÃ³ d''un llibre des de la icona <img width="18" height="18" alt="editfolder.png" src="/prestatgeria/pmf/images/editfolder.png" /> de la Prestatgeria una vegada us hÃ giu registrat.<br /></p>\r\n						', '\r\n						\r\n						', 1, '', '1179825614', 799),
(32, 32, 'ca', 'Com es pot delegar a una persona o a diverses persones del centre la creaciÃ³ de llibres nous?', '\r\n<p>Des de \r\nl''opciÃ³ del menÃº <strong>Gestiona els llibres</strong>, els centres poden delegar la creaciÃ³ de llibres nous a persones que creguin oportunes.</p><p><img width="526" height="213" alt="delega.png" src="/prestatgeria/pmf/images/delega.png" /> </p><p>Per delegar la creaciÃ³ de llibres a terceres persones, heu d''escriure la seva adreÃ§a de correu de la XTEC en el quadre de text. Aquestes persones, prÃ¨viament, han d''haver-se validat almenys una vegada a la Prestatgeria.</p><p><strong>AtenciÃ³:</strong> En el moment de delegar creadors de llibres, assegureu-vos molt bÃ© que heu escrit el nom d''usuari/Ã ria correctament. </p>\r\n						', '\r\n						\r\n						', 1, '', '', 576),
(35, 35, 'ca', 'COM PUC ESBORRAR UNA PÃ€GINA SI M''HE EQUIVOCAT?', '', '', 0, NULL, '1196191528', 0),
(33, 33, 'ca', 'Com accedir a un llibre ja iniciat', '', '', 0, NULL, '1181897936', 14),
(34, 34, 'ca', 'nova', 'Contingut<img width="526" height="213" src="/prestatgeria/pmf/images/delega.png" alt="delega.png" />\r\n						', '\r\n						', 1, '1186556439', '1186556469', 0),
(36, 36, 'ca', 'Com s''esborra si t''equivoques al llibre?', '', '', 0, NULL, '1196196273', 0),
(37, 37, 'ca', 'Es pot pujar so ?', '', '', 0, NULL, '1198698229', 0),
(38, 38, 'ca', 'Com poder esborrar un llibre', '', '', 0, NULL, '1202825541', 0),
(39, 39, 'ca', 'Com fer la recerca per trobar tots els llibres d''un mateix centre?', '', '', 0, NULL, '1203722527', 0),
(40, 40, 'ca', 'com modificar una dada en un llibre ja editat?', '', '', 0, NULL, '1207144974', 0),
(41, 41, 'ca', 'Com es pot eliminar un llibre?', '', '', 0, NULL, '1207598932', 0),
(42, 42, 'ca', 'Com puc crear un llibre i no activar-lo immediatament', 'a edicciÃ³ de llibre, trobar un casella per activar-lo o desactivar-lo', '', 0, NULL, '1208889622', 0),
(43, 43, 'ca', 'Com puc crear un llibre i no activar-lo immediatament', 'a edicciÃ³ de llibre, trobar un casella per activar-lo o desactivar-lo', '', 0, NULL, '1208889875', 0),
(44, 44, 'ca', 'Â¿se pueden imprimir en papel los libros digitales?', '', '', 0, NULL, '1211318455', 0),
(45, 45, 'ca', 'per inscriure''s', '', '', 0, NULL, '1231495332', 0),
(46, 46, 'ca', 'no surten les 2 pÃ gines fetes numerades', '', '', 0, NULL, '1231948959', 0),
(47, 47, 'ca', 'Es poden descarregar?', '', '', 0, NULL, '1232033144', 0),
(48, 48, 'ca', 'Voldria saber si Ã©s possible afegir arxius de so als llibres (en formait mp3).', '', '', 0, NULL, '1233163838', 0),
(49, 49, 'ca', 'he creat un llibre i ara no el trobo', '', '', 0, NULL, '1235634852', 0),
(50, 50, 'ca', '<he creat dos cops el mateix llibre. Com ho puc esborrar?', '', '', 0, NULL, '1236103206', 0),
(51, 51, 'ca', 'Ã©s possible canviar la propietat de centre d''un llibre ', '', '', 0, NULL, '1239801045', 0),
(52, 52, 'ca', 'inserir imatges', '', '', 0, NULL, '1240415111', 0),
(53, 53, 'ca', 'Com podem esborrar un llibre creat?', '', '', 0, NULL, '1243241808', 0),
(54, 54, 'ca', 'Quin ofici es els que transportaven les pedres des del port de Barcelon fins a la Catedral Santa Maria', '', '', 0, NULL, '1245170463', 0),
(55, 55, 'ca', 'Com es posen les pÃ gines perque tambÃ© surtin a l''index?', '', '', 0, NULL, '1250583064', 0),
(56, 56, 'ca', 'Com puc esborrar el contingut del llibre? Cal fer-ho article per article o hi ha alguna manera de poder esborrar-ho tot?', '', '', 0, NULL, '1251964008', 0),
(57, 57, 'ca', 'ImportaciÃ³ de llibres', '\r\n<p>Per importar un llibre heu de fer clic a l''enllaÃ§ <strong>Crea un llibre nou</strong> i seleccionar la opciÃ³ <strong>Importa un llibre</strong>. La pÃ gina de creaciÃ³ del llibre ens quedarÃ  de la segÃ¼ent manera:<br /></p><p align="center"><img width="789" height="628" src="/prestatgeria/pmf/images/importa_un_llibre.png" alt="importa_un_llibre.png" /></p><p>En el camp de <strong>Fitxer d''importaciÃ³</strong> caldrÃ  carregar el fitxer d''importaciÃ³ en format .xml des del vostre ordinador.</p><p>La resta de camps els haureu de completar de la mateixa manera com si estiguÃ©ssiu creant un llibre nou.<br /></p>\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', '\r\n<p>\r\n<a href="/prestatgeria/pmf/suport.php?sid=5&amp;lang=ca" title="QuÃ¨ cal fer per crear un llibre nou?">QuÃ¨ cal fer per crear un llibre nou?\r\n		</a></p><p><a title="ExportaciÃ³ de llibres" href="/prestatgeria/pmf/suport.php?sid=58&amp;lang=ca">ExportaciÃ³ de llibres</a> <br /></p>\r\n						', 1, '', '1260531110', 290),
(58, 58, 'ca', 'ExportaciÃ³ de llibres', '\r\n<p>La prestatgeria us permet exportar els vostres llibres a diferents formats. Si visiteu la fitxa d''un llibre del qual en sou propietari us apareixeran les diferents opcions d''exportaciÃ³ que podeu utilitzar. <br /></p><p align="center"><img width="459" height="319" alt="fitxa_export.png" src="/prestatgeria/pmf/images/fitxa_export.png" /></p><strong><p>&nbsp;</p></strong><p><strong><img width="16" height="16" src="/prestatgeria/pmf/images/export_book.png" alt="export_book.png" /> exportaciÃ³ de la prestatgeria</strong></p><p>Aquesta opciÃ³ d''exportaciÃ³ permet obtenir un fitxer en format xml del llibre. Aquesta funcionalitat estÃ  especialment pensada per <strong>exportar llibres des de l''espai de proves i cursos</strong><span style="font-weight: bold;"> </span>per posteriorment poder importar-los cap a la Prestatgeria final.<br /></p><strong><p>&nbsp;</p></strong><p><strong><img width="16" height="16" src="/prestatgeria/pmf/images/html.png" alt="html.png" />&nbsp;exportaciÃ³ a html</strong></p><p>Aquesta opciÃ³ d''exportaciÃ³ permet exportar el contingut del llibre en format html. S''obtÃ© un fitxer comprimit en format zip que contÃ© el conjunt de les pÃ gines del llibre en format html.</p><p>Per poder visualitzar i navegar a travÃ©s del llibre, heu de descomprimir el zip i posteriorment podeu obrir el fitxer <em>index.html</em>.</p><p>Aquesta funcionalitat estÃ  especialment indicada per poder <strong>consultar el contingut del llibre en mode fora de lÃ­nia</strong> o per <strong>integrar el llibre en qualsevol pÃ gina web</strong>. La imatge de mÃ©s avall mostra com es visualitza en el navegador el llibre <em>&quot;Com funcionen els llibres&quot;</em> que hem exportat en format html.<br /></p><p align="center"><img width="900" height="565" alt="html_export_3.png" src="/prestatgeria/pmf/images/html_export_3.png" /><br /></p><strong><p>&nbsp;</p></strong><p><strong><img width="16" height="16" src="/prestatgeria/pmf/images/scorm.png" alt="scorm.png" />&nbsp;exportaciÃ³ a scorm</strong><br /></p><p>Aquesta opciÃ³ d''exportaciÃ³ permet exportar el llibre\r\ncom un recurs scorm. D''aquesta manera el fitxer obtingut es pot <strong>integrar  com a recurs en un curs de Moodle</strong>.</p><p>En la imatge de mÃ©s avall podeu veure com queda el llibre <em>&quot;Com funcionen els llibres&quot;</em> integrat dins un curs d''Ã€gora.</p><p align="center"><img width="900" height="371" alt="scorm_export.png" src="/prestatgeria/pmf/images/scorm_export.png" /><br /></p><p>\r\n						</p>\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', '\r\n<a title="ImportaciÃ³ de llibres" href="/prestatgeria/pmf/suport.php?sid=57&amp;lang=ca">ImportaciÃ³ de llibres</a>\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						\r\n						', 1, '', '1260531340', 240),
(59, 59, 'ca', 'a partir del 10 de gener s''esborraran els llibres digitals del catÃ leg?', '', '', 0, NULL, '1261510664', 0),
(60, 60, 'ca', 'Com puc canviar la contrasenya per tal que hi entrin els alumnes?', '', '', 0, NULL, '1261650549', 0),
(61, 61, 'ca', 'com puc canviar una contrasenya?', '', '', 0, NULL, '1261650866', 0),
(62, 62, 'ca', 'Com es fa per incloure una imatge?', '', '', 0, NULL, '1261651165', 0),
(63, 63, 'ca', 'Com s''esborren els llibres?', '', '', 0, NULL, '1261651363', 0),
(64, 64, 'ca', 'Si vull penjar videos, ho he de fer per forÃ§a mitjanÃ§ant You tube? Si no Ã©s aixÃ­, com? GrÃ cies.', '', '', 0, NULL, '1262043963', 0),
(65, 65, 'ca', 'He vist en alguns llibres que dins de cada capÃ­tol s''han editat subapartats i jo no me''n surto', '', '', 0, NULL, '1264173633', 0),
(66, 66, 'ca', 'com s''elimina un llibre ?', '', '', 0, NULL, '1265307890', 0),
(67, 67, 'ca', 'com crear un llibre', '', '', 0, NULL, '1268287720', 0),
(68, 68, 'ca', 'Com passar un llibre de proves de la prestatgeria de proves  a la "normal"?', '', '', 0, NULL, '1269011368', 0),
(69, 69, 'ca', 'Com comenÃ§o un llibre', '', '', 0, NULL, '1269443182', 0),
(70, 70, 'ca', 'com s''afegeixen pÃ gines en un capÃ­tol', '', '', 0, NULL, '1271660252', 0),
(71, 71, 'ca', 'Com donar-se d''alta?', 'Posar una pestanya en la pÃ gina d''inici', '', 0, NULL, '1271667268', 0),
(72, 72, 'ca', 'No puc trobar el meu llibre,com puc fer-ho?', '', '', 0, NULL, '1273913200', 0),
(73, 73, 'ca', 'com exportar el llibre', '', '', 0, NULL, '1273934390', 0),
(74, 74, 'ca', 'Com passar un llibre de la prestatgeria de proves a la prestatgeria norma', '', '', 0, NULL, '1274540237', 0),
(75, 75, 'ca', 'com em registro?', 'no ho se', '', 0, NULL, '1274896792', 0),
(76, 76, 'ca', 'com activar un llibre', '', '', 0, NULL, '1274980834', 0),
(77, 77, 'ca', 'Com es penja un video?', '', '', 0, NULL, '1286874000', 0),
(78, 78, 'ca', 'Com ho de fer per inscriure''m?', '', '', 0, NULL, '1290072125', 0),
(79, 79, 'ca', 'Com puc esborrar un llibre digital?', '', '', 0, NULL, '1292789378', 0),
(80, 80, 'ca', 'Com evitar que en el llibre quedin els textos editats amb la barra de desplaÃ§ament de text', '', '', 0, NULL, '1294940407', 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `admin_category`
--

CREATE TABLE IF NOT EXISTS `admin_category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(254) NOT NULL,
  `sortorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Bolcant dades de la taula `admin_category`
--

INSERT INTO `admin_category` (`cid`, `name`, `description`, `sortorder`) VALUES
(1, 'Sistema', 'Mòduls de sistema', 1),
(4, 'Continguts', 'Mòduls que proporcionen continguts per als usuaris', 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `admin_module`
--

CREATE TABLE IF NOT EXISTS `admin_module` (
  `amid` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`amid`),
  KEY `mid_cid` (`mid`,`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Bolcant dades de la taula `admin_module`
--

INSERT INTO `admin_module` (`amid`, `mid`, `cid`, `sortorder`) VALUES
(1, 1, 1, 9),
(2, 14, 1, 13),
(3, 8, 1, 11),
(4, 5, 1, 9),
(5, 12, 1, 0),
(6, 22, 1, 16),
(7, 21, 1, 15),
(8, 2, 1, 9),
(9, 19, 1, 15),
(10, 3, 4, 0),
(11, 18, 1, 14),
(12, 26, 4, 0),
(13, 6, 1, 10),
(14, 9, 4, 0),
(15, 10, 1, 12),
(16, 11, 1, 13),
(17, 7, 1, 0),
(18, 16, 4, 0),
(19, 15, 1, 0),
(20, 17, 4, 17),
(21, 23, 1, 0),
(22, 13, 1, 0),
(23, 20, 4, 0),
(24, 30, 4, 14),
(25, 31, 4, 14),
(26, 29, 1, 17),
(27, 27, 4, 13),
(28, 33, 4, 13),
(29, 34, 1, 18),
(30, 35, 1, 19),
(31, 36, 4, 11);

-- --------------------------------------------------------

--
-- Estructura de la taula `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `bkey` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `url` longtext NOT NULL,
  `mid` int(11) NOT NULL DEFAULT '0',
  `filter` longtext NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `collapsable` int(11) NOT NULL DEFAULT '1',
  `defaultstate` int(11) NOT NULL DEFAULT '1',
  `refresh` int(11) NOT NULL DEFAULT '0',
  `last_update` datetime NOT NULL,
  `language` varchar(30) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`bid`),
  KEY `active_idx` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Bolcant dades de la taula `blocks`
--

INSERT INTO `blocks` (`bid`, `bkey`, `title`, `content`, `url`, `mid`, `filter`, `active`, `collapsable`, `defaultstate`, `refresh`, `last_update`, `language`, `description`) VALUES
(8, 'LastEntries', 'Els llibres amb entrades més recents', '', '', 30, 'a:0:{}', 1, 1, 0, 3600, '2014-01-10 12:38:19', '', ''),
(9, 'MostPages', 'Els llibres amb més pàgines', '', '', 30, 'a:0:{}', 1, 1, 0, 3600, '2014-01-10 12:38:19', '', ''),
(10, 'MostReaded', 'Els llibres més llegits', '', '', 30, 'a:0:{}', 1, 1, 0, 3600, '2014-01-10 12:38:19', '', ''),
(11, 'Cloud', 'Descriptors', '', '', 30, 'a:0:{}', 1, 0, 1, 3600, '2014-01-10 12:38:19', '', ''),
(12, 'NewBooks', 'Els darrers llibres creats', '', '', 30, 'a:0:{}', 1, 1, 0, 3600, '2014-01-10 12:38:19', '', ''),
(13, 'ActivationNotify', 'Activació de llibres', '', '', 30, 'a:0:{}', 1, 0, 1, 3600, '2014-01-10 12:38:19', '', ''),
(14, 'MyBooks', 'Els meus llibres', '', '', 30, 'a:0:{}', 1, 0, 1, 3600, '2014-01-10 12:38:19', '', ''),
(6, 'Mainmenu', 'Menú principal', '', '', 30, 'a:0:{}', 1, 0, 1, 3600, '2014-01-10 12:38:19', '', ''),
(15, 'MyPrefered', 'Els meus llibres preferits', '', '', 30, 'a:0:{}', 1, 0, 1, 3600, '2014-01-10 12:38:19', '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `block_placements`
--

CREATE TABLE IF NOT EXISTS `block_placements` (
  `pid` int(11) NOT NULL DEFAULT '0',
  `bid` int(11) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0',
  KEY `bid_pid_idx` (`bid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcant dades de la taula `block_placements`
--

INSERT INTO `block_placements` (`pid`, `bid`, `sortorder`) VALUES
(1, 10, 5),
(1, 9, 4),
(1, 8, 3),
(1, 12, 2),
(3, 13, 1),
(2, 11, 2),
(3, 5, 0),
(2, 15, 1),
(2, 14, 0),
(1, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `block_positions`
--

CREATE TABLE IF NOT EXISTS `block_positions` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `name_idx` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Bolcant dades de la taula `block_positions`
--

INSERT INTO `block_positions` (`pid`, `name`, `description`) VALUES
(1, 'left', 'Blocs de l''esquerra'),
(2, 'right', 'Blocs de la dreta'),
(3, 'center', 'Blocs centrals');

-- --------------------------------------------------------

--
-- Estructura de la taula `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `bookId` bigint(20) NOT NULL AUTO_INCREMENT,
  `schoolCode` varchar(12) NOT NULL,
  `bookTitle` varchar(100) NOT NULL,
  `bookLang` varchar(2) NOT NULL,
  `bookAdminName` varchar(12) NOT NULL,
  `bookHits` bigint(20) NOT NULL DEFAULT '0',
  `bookLastVisit` varchar(20) NOT NULL,
  `bookDateInit` varchar(20) NOT NULL,
  `bookState` tinyint(4) NOT NULL DEFAULT '-1',
  `bookDescript` varchar(255) NOT NULL DEFAULT '#',
  `collectionId` mediumint(9) NOT NULL,
  `bookActivationCode` varchar(40) NOT NULL,
  `lastEntry` varchar(20) NOT NULL,
  `bookPages` bigint(20) NOT NULL,
  `newBookAdminName` varchar(12) NOT NULL,
  PRIMARY KEY (`bookId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Bolcant dades de la taula `books`
--

INSERT INTO `books` (`bookId`, `schoolCode`, `bookTitle`, `bookLang`, `bookAdminName`, `bookHits`, `bookLastVisit`, `bookDateInit`, `bookState`, `bookDescript`, `collectionId`, `bookActivationCode`, `lastEntry`, `bookPages`, `newBookAdminName`) VALUES
(1, 'llibres', 'Com funcionen els llibres?', 'ca', 'llibres', 46846, '1429867067', '1176191035', 1, '#', 5, 'e0b43d7adf04f77c81d846f9d8eee988', '1275308924', 28, ''),
(2, 'e3009369', 'Llibre número 1', 'ca', 'usu1', 1, '1429876059', '1429875793', 1, '##demo#', 0, '', '1429876698', 4, '');

-- --------------------------------------------------------

--
-- Estructura de la taula `books_allowed`
--

CREATE TABLE IF NOT EXISTS `books_allowed` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(12) NOT NULL,
  `schoolCode` varchar(12) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=710 ;

--
-- Bolcant dades de la taula `books_allowed`
--

INSERT INTO `books_allowed` (`aid`, `userName`, `schoolCode`) VALUES
(708, 'usu1', 'e3009369'),
(709, 'usu2', 'e3009369');

-- --------------------------------------------------------

--
-- Estructura de la taula `books_anounces`
--

CREATE TABLE IF NOT EXISTS `books_anounces` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `bookId` int(11) NOT NULL DEFAULT '0',
  `schoolCode` varchar(12) NOT NULL DEFAULT '',
  `text` varchar(225) NOT NULL DEFAULT '',
  `dateInit` varchar(20) NOT NULL DEFAULT '',
  `dateEnd` varchar(20) NOT NULL DEFAULT '',
  `bookTitle` varchar(100) NOT NULL DEFAULT '',
  `adminName` varchar(12) NOT NULL DEFAULT '',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `color` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `books_bookcollections`
--

CREATE TABLE IF NOT EXISTS `books_bookcollections` (
  `collectionId` int(11) NOT NULL AUTO_INCREMENT,
  `collectionName` varchar(50) NOT NULL DEFAULT '',
  `collectionState` tinyint(50) NOT NULL DEFAULT '0',
  `collectionAutoInit` varchar(20) NOT NULL DEFAULT '',
  `collectionAutoOut` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`collectionId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Bolcant dades de la taula `books_bookcollections`
--

INSERT INTO `books_bookcollections` (`collectionId`, `collectionName`, `collectionState`, `collectionAutoInit`, `collectionAutoOut`) VALUES
(1, 'Sant Jordi 2007', 0, '', ''),
(2, 'Llibres de viatges i vacances', 1, '', ''),
(3, 'Sortides escolars', 1, '', ''),
(4, 'Laboratori', 1, '', ''),
(5, 'Manuals d''ús', 1, '', ''),
(6, 'Experiències d''aula', 1, '', ''),
(7, 'Projectes d''aula', 1, '', ''),
(8, 'Municipis de Catalunya', 1, '', ''),
(9, 'Activitats esportives', 1, '', ''),
(10, 'El nostre medi ambient', 1, '', ''),
(11, 'Nadal 2007', 0, '', ''),
(12, 'Sant Jordi 2008', 0, '1204056500', '1211832500'),
(13, 'Sant Jordi 2009', 0, '1238867293', '1244137693'),
(14, 'Sant Jordi 2010', 1, '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `books_comment`
--

CREATE TABLE IF NOT EXISTS `books_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `bookId` int(11) NOT NULL,
  `userName` varchar(12) NOT NULL,
  `date` varchar(20) NOT NULL,
  `text` mediumtext NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `books_descriptors`
--

CREATE TABLE IF NOT EXISTS `books_descriptors` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `descriptor` varchar(50) NOT NULL DEFAULT '',
  `number` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `books_descriptors`
--

INSERT INTO `books_descriptors` (`did`, `descriptor`, `number`) VALUES
(1, 'demo', 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `books_nav`
--

CREATE TABLE IF NOT EXISTS `books_nav` (
  `unid` int(11) NOT NULL AUTO_INCREMENT,
  `sessid` varchar(50) NOT NULL DEFAULT '',
  `booksOrder` varchar(12) NOT NULL DEFAULT '',
  `filter` varchar(20) NOT NULL DEFAULT '',
  `init` int(11) NOT NULL DEFAULT '0',
  `bookId` int(11) NOT NULL DEFAULT '0',
  `filterValue` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`unid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `books_schools`
--

CREATE TABLE IF NOT EXISTS `books_schools` (
  `schoolId` int(11) NOT NULL AUTO_INCREMENT,
  `schoolCode` varchar(12) NOT NULL DEFAULT '',
  `schoolName` varchar(200) NOT NULL DEFAULT '',
  `schoolType` varchar(50) NOT NULL DEFAULT '',
  `schoolDateIns` varchar(20) NOT NULL DEFAULT '',
  `schoolState` tinyint(1) NOT NULL DEFAULT '1',
  `schoolCity` varchar(100) NOT NULL,
  `schoolZipCode` varchar(12) NOT NULL,
  `schoolRegion` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`schoolId`),
  KEY `schoolCode` (`schoolCode`),
  KEY `schoolCity` (`schoolCity`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Bolcant dades de la taula `books_schools`
--

INSERT INTO `books_schools` (`schoolId`, `schoolCode`, `schoolName`, `schoolType`, `schoolDateIns`, `schoolState`, `schoolCity`, `schoolZipCode`, `schoolRegion`) VALUES
(1, 'llibres', 'Llibres', '', '1176190985', 1, 'Departament d''Educació', '', ''),
(2, 'e3009369', 'Escola Saavedra', 'ESC', '1349700747', 1, 'Tarragona', '43003', 'Tarragona');

-- --------------------------------------------------------

--
-- Estructura de la taula `books_schools_info`
--

CREATE TABLE IF NOT EXISTS `books_schools_info` (
  `schoolInfo` int(11) NOT NULL AUTO_INCREMENT,
  `schoolCode` varchar(12) NOT NULL DEFAULT '',
  `schoolName` varchar(200) NOT NULL DEFAULT '',
  `schoolType` varchar(50) NOT NULL DEFAULT '',
  `schoolCity` varchar(100) NOT NULL,
  `schoolZipCode` varchar(12) NOT NULL,
  `schoolRegion` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`schoolInfo`),
  UNIQUE KEY `schoolCode_2` (`schoolCode`),
  KEY `schoolCode` (`schoolCode`),
  KEY `schoolName` (`schoolName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4895 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `books_userbooks`
--

CREATE TABLE IF NOT EXISTS `books_userbooks` (
  `ubid` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(12) NOT NULL DEFAULT '',
  `bookId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ubid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=741 ;

--
-- Bolcant dades de la taula `books_userbooks`
--

INSERT INTO `books_userbooks` (`ubid`, `userName`, `bookId`) VALUES
(740, 'admin', 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `categories_category`
--

CREATE TABLE IF NOT EXISTS `categories_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '1',
  `is_locked` tinyint(4) NOT NULL DEFAULT '0',
  `is_leaf` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `sort_value` int(11) NOT NULL DEFAULT '0',
  `display_name` text,
  `display_desc` text,
  `path` text,
  `ipath` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(1) NOT NULL DEFAULT 'A',
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_categories_parent` (`parent_id`),
  KEY `idx_categories_is_leaf` (`is_leaf`),
  KEY `idx_categories_name` (`name`),
  KEY `idx_categories_ipath` (`ipath`,`is_leaf`,`status`),
  KEY `idx_categories_status` (`status`),
  KEY `idx_categories_ipath_status` (`ipath`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10002 ;

--
-- Bolcant dades de la taula `categories_category`
--

INSERT INTO `categories_category` (`id`, `parent_id`, `is_locked`, `is_leaf`, `name`, `value`, `sort_value`, `display_name`, `display_desc`, `path`, `ipath`, `status`, `obj_status`, `cr_date`, `cr_uid`, `lu_date`, `lu_uid`) VALUES
(1, 0, 1, 0, '__SYSTEM__', '', 0, 'b:0;', 'b:0;', '/__SYSTEM__', '/1', 'A', 'A', '2009-11-20 11:14:54', 0, '2009-11-20 11:14:54', 0),
(2, 1, 0, 0, 'Modules', '', 0, 'a:1:{s:2:"ca";s:6:"Mòduls";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules', '/1/2', 'A', 'A', '2009-11-20 11:14:55', 0, '2009-11-20 11:14:55', 0),
(3, 1, 0, 0, 'General', '', 0, 'a:1:{s:2:"ca";s:7:"General";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General', '/1/3', 'A', 'A', '2009-11-20 11:14:55', 0, '2009-11-20 11:14:55', 0),
(4, 3, 0, 0, 'YesNo', '', 0, 'a:1:{s:2:"ca";s:5:"Sí/No";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/YesNo', '/1/3/4', 'A', 'A', '2009-11-20 11:14:55', 0, '2009-11-20 11:14:55', 0),
(5, 4, 0, 1, '1 - Yes', '', 0, 'b:0;', 'b:0;', '/__SYSTEM__/General/YesNo/1 - Yes', '/1/3/4/5', 'A', 'A', '2009-11-20 11:14:55', 0, '2009-11-20 11:14:55', 0),
(6, 4, 0, 1, '2 - No', '', 0, 'b:0;', 'b:0;', '/__SYSTEM__/General/YesNo/2 - No', '/1/3/4/6', 'A', 'A', '2009-11-20 11:14:56', 0, '2009-11-20 11:14:56', 0),
(10, 3, 0, 0, 'Pending Status Extended', '', 0, 'a:1:{s:2:"ca";s:16:"Estats (estesos)";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Extended', '/1/3/10', 'A', 'A', '2009-11-20 11:14:56', 0, '2009-11-20 11:14:56', 0),
(11, 10, 0, 1, 'Pending', '', 0, 'a:1:{s:2:"ca";s:7:"Pendent";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Extended/Pending', '/1/3/10/11', 'A', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(12, 10, 0, 1, 'Checked', '', 0, 'a:1:{s:2:"ca";s:7:"Activat";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Extended/Checked', '/1/3/10/12', 'A', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(13, 10, 0, 1, 'Approved', '', 0, 'a:1:{s:2:"ca";s:7:"Aprovat";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Extended/Approved', '/1/3/10/13', 'A', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(14, 10, 0, 1, 'Online', '', 0, 'a:1:{s:2:"ca";s:8:"En línia";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Extended/Online', '/1/3/10/14', 'A', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(15, 10, 0, 1, 'Rejected', '', 0, 'a:1:{s:2:"ca";s:7:"Refusat";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Extended/Rejected', '/1/3/10/15', 'A', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(16, 3, 0, 0, 'Gender', '', 0, 'a:1:{s:2:"ca";s:6:"Gènere";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Gender', '/1/3/16', 'A', 'A', '2009-11-20 11:14:58', 0, '2009-11-20 11:14:58', 0),
(17, 16, 0, 1, 'Male', '', 0, 'a:1:{s:2:"ca";s:4:"Home";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Gender/Male', '/1/3/16/17', 'A', 'A', '2009-11-20 11:14:58', 0, '2009-11-20 11:14:58', 0),
(18, 16, 0, 1, 'Female', '', 0, 'a:1:{s:2:"ca";s:4:"Dona";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Gender/Female', '/1/3/16/18', 'A', 'A', '2009-11-20 11:14:58', 0, '2009-11-20 11:14:58', 0),
(19, 3, 0, 0, 'Title', '', 0, 'a:1:{s:2:"ca";s:5:"Títol";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Title', '/1/3/19', 'A', 'A', '2009-11-20 11:14:58', 0, '2009-11-20 11:14:58', 0),
(20, 19, 0, 1, 'Dr', '', 0, 'a:1:{s:2:"ca";s:3:"Dr.";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Title/Dr', '/1/3/19/20', 'A', 'A', '2009-11-20 11:14:59', 0, '2009-11-20 11:14:59', 0),
(21, 19, 0, 1, 'Prof', '', 0, 'a:1:{s:2:"ca";s:5:"Prof.";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Title/Prof', '/1/3/19/21', 'A', 'A', '2009-11-20 11:14:59', 0, '2009-11-20 11:14:59', 0),
(22, 19, 0, 1, 'Mag', '', 0, 'a:1:{s:2:"ca";s:4:"Mag.";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Title/Mag', '/1/3/19/13', 'A', 'A', '2009-11-20 11:14:59', 0, '2009-11-20 11:14:59', 0),
(23, 3, 0, 0, 'ActiveStatus', '', 0, 'a:1:{s:2:"ca";s:20:"Estat de l''activitat";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/ActiveStatus', '/1/3/22', 'A', 'A', '2009-11-20 11:15:00', 0, '2009-11-20 11:15:00', 0),
(24, 23, 0, 1, 'Active', '', 0, 'a:1:{s:2:"ca";s:5:"Actiu";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/ActiveStatus/Active', '/1/3/22/23', 'A', 'A', '2009-11-20 11:15:00', 0, '2009-11-20 11:15:00', 0),
(25, 23, 0, 1, 'Inactive', '', 0, 'a:1:{s:2:"ca";s:7:"Inactiu";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/ActiveStatus/Inactive', '/1/3/22/24', 'A', 'A', '2009-11-20 11:15:01', 0, '2009-11-20 11:15:01', 0),
(26, 3, 0, 0, 'Pending Status Basic', '', 0, 'a:1:{s:2:"ca";s:6:"Estats";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Basic', '/1/3/25', 'A', 'A', '2009-11-20 11:15:02', 0, '2009-11-20 11:15:02', 0),
(27, 26, 0, 1, 'Pending', '', 0, 'a:1:{s:2:"ca";s:7:"Pendent";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Basic/Pending', '/1/3/25/26', 'A', 'A', '2009-11-20 11:15:03', 0, '2009-11-20 11:15:03', 0),
(28, 26, 0, 1, 'Approved', '', 0, 'a:1:{s:2:"ca";s:7:"Aprovat";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/General/Pending Status Basic/Approved', '/1/3/25/27', 'A', 'A', '2009-11-20 11:15:03', 0, '2009-11-20 11:15:03', 0),
(29, 1, 0, 0, 'Users', '', 0, 'a:1:{s:2:"ca";s:7:"Usuaris";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Users', '/1/29', 'A', 'A', '2009-11-20 11:15:03', 0, '2009-11-20 11:15:03', 0),
(30, 2, 0, 0, 'Global', '', 0, 'a:1:{s:2:"ca";s:6:"Global";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global', '/1/2/30', 'A', 'A', '2009-11-20 11:15:04', 0, '2009-11-20 11:15:04', 0),
(31, 30, 0, 1, 'Arts & Entertainment', '', 0, 'a:1:{s:2:"ca";s:20:"Arts i entreteniment";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global/Arts & Entertainment', '/1/2/30/31', 'A', 'A', '2009-11-20 11:15:04', 0, '2009-11-20 11:15:04', 0),
(32, 30, 0, 1, 'Default', '', 0, 'a:1:{s:2:"ca";s:11:"Per defecte";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global/Default', '/1/2/30/32', 'A', 'A', '2009-11-20 11:15:04', 0, '2009-11-20 11:15:04', 0),
(33, 30, 0, 1, 'Information Technology', '', 0, 'a:1:{s:2:"ca";s:28:"Tecnologies de la informació";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global/Information Technology', '/1/2/30/33', 'A', 'A', '2009-11-20 11:15:04', 0, '2009-11-20 11:15:04', 0),
(34, 30, 0, 1, 'Politics', '', 0, 'a:1:{s:2:"ca";s:8:"Política";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global/Politics', '/1/2/30/34', 'A', 'A', '2009-11-20 11:15:05', 0, '2009-11-20 11:15:05', 0),
(35, 30, 0, 1, 'Science', '', 0, 'a:1:{s:2:"ca";s:7:"Ciència";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global/Science', '/1/2/30/35', 'A', 'A', '2009-11-20 11:15:05', 0, '2009-11-20 11:15:05', 0),
(36, 30, 0, 1, 'Society', '', 0, 'a:1:{s:2:"ca";s:8:"Societat";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global/Society', '/1/2/30/36', 'A', 'A', '2009-11-20 11:15:05', 0, '2009-11-20 11:15:05', 0),
(37, 30, 0, 1, 'Sports', '', 0, 'a:1:{s:2:"ca";s:7:"Esports";}', 'a:1:{s:2:"en";s:0:"";}', '/__SYSTEM__/Modules/Global/Sports', '/1/2/30/37', 'A', 'A', '2009-11-20 11:15:05', 0, '2009-11-20 11:15:05', 0),
(10000, 2, 0, 0, 'News', '', 0, 'a:1:{s:2:"ca";s:10:"_NEWS_NAME";}', 'a:1:{s:2:"ca";s:49:"Proporciona un sistema de publicació de notícies.";}', '/__SYSTEM__/Modules/News', '/1/2/10000', 'A', 'A', '2009-11-20 11:20:48', 2, '2009-11-20 11:20:49', 2),
(10001, 2, 0, 0, 'Pages', '', 0, 'a:1:{s:2:"ca";s:11:"_PAGES_NAME";}', 'a:1:{s:2:"ca";s:18:"Pàgines estàtiques";}', '/__SYSTEM__/Modules/Pages', '/1/2/10001', 'A', 'A', '2009-11-21 17:38:14', 2, '2009-11-21 17:38:14', 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `categories_mapmeta`
--

CREATE TABLE IF NOT EXISTS `categories_mapmeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_categories_mapmeta` (`meta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `categories_mapobj`
--

CREATE TABLE IF NOT EXISTS `categories_mapobj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modname` varchar(60) NOT NULL DEFAULT '',
  `tablename` varchar(60) NOT NULL,
  `obj_id` int(11) NOT NULL DEFAULT '0',
  `obj_idcolumn` varchar(60) NOT NULL DEFAULT 'id',
  `reg_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  `reg_property` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_categories_mapobj` (`modname`,`tablename`,`obj_id`,`obj_idcolumn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `categories_registry`
--

CREATE TABLE IF NOT EXISTS `categories_registry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modname` varchar(60) NOT NULL DEFAULT '',
  `tablename` varchar(60) NOT NULL DEFAULT '',
  `property` varchar(60) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_categories_registry` (`modname`,`tablename`,`property`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Bolcant dades de la taula `categories_registry`
--

INSERT INTO `categories_registry` (`id`, `modname`, `tablename`, `property`, `category_id`, `obj_status`, `cr_date`, `cr_uid`, `lu_date`, `lu_uid`) VALUES
(3, 'News', 'news', 'Main', 30, 'A', '2011-09-13 14:48:16', 2, '2011-09-13 14:48:16', 2),
(2, 'Pages', 'pages', 'Main', 30, 'A', '2009-11-21 17:38:14', 2, '2009-11-21 17:38:14', 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gtype` tinyint(4) NOT NULL DEFAULT '0',
  `description` varchar(200) NOT NULL,
  `prefix` varchar(25) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `nbuser` int(11) NOT NULL DEFAULT '0',
  `nbumax` int(11) NOT NULL DEFAULT '0',
  `link` int(11) NOT NULL DEFAULT '0',
  `uidmaster` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Bolcant dades de la taula `groups`
--

INSERT INTO `groups` (`gid`, `name`, `gtype`, `description`, `prefix`, `state`, `nbuser`, `nbumax`, `link`, `uidmaster`) VALUES
(1, 'Usuaris', 0, 'Grup per defecte dels usuaris', 'usr', 0, 0, 0, 0, 0),
(2, 'Administradors', 0, 'Grup per defecte dels administradors', 'adm', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `group_applications`
--

CREATE TABLE IF NOT EXISTS `group_applications` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '0',
  `application` longtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`app_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `group_membership`
--

CREATE TABLE IF NOT EXISTS `group_membership` (
  `gid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  KEY `gid_uid` (`uid`,`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcant dades de la taula `group_membership`
--

INSERT INTO `group_membership` (`gid`, `uid`) VALUES
(2, 2),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10);

-- --------------------------------------------------------

--
-- Estructura de la taula `group_perms`
--

CREATE TABLE IF NOT EXISTS `group_perms` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL DEFAULT '0',
  `realm` int(11) NOT NULL DEFAULT '0',
  `component` varchar(255) NOT NULL,
  `instance` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `bond` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Bolcant dades de la taula `group_perms`
--

INSERT INTO `group_perms` (`pid`, `gid`, `sequence`, `realm`, `component`, `instance`, `level`, `bond`) VALUES
(1, 2, 0, 0, '.*', '.*', 800, 0),
(3, 1, 4, 0, '.*', '.*', 300, 0),
(7, -1, 1, 0, 'Profile:MembersOnlineblock:', 'Connectats::', 0, 0),
(5, 0, 5, 0, '.*', '.*', 200, 0),
(6, 1, 3, 0, 'HTMLblock::', 'Proves i cursos::', 0, 0),
(8, -1, 2, 0, 'books:newbooksblock:', '.*', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `hooks`
--

CREATE TABLE IF NOT EXISTS `hooks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `object` varchar(64) NOT NULL,
  `action` varchar(64) NOT NULL,
  `smodule` varchar(64) NOT NULL,
  `stype` varchar(64) NOT NULL,
  `tarea` varchar(64) NOT NULL,
  `tmodule` varchar(64) NOT NULL,
  `ttype` varchar(64) NOT NULL,
  `tfunc` varchar(64) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `smodule` (`smodule`),
  KEY `smodule_tmodule` (`smodule`,`tmodule`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `hook_area`
--

CREATE TABLE IF NOT EXISTS `hook_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(40) NOT NULL,
  `subowner` varchar(40) DEFAULT NULL,
  `areatype` varchar(1) NOT NULL,
  `category` varchar(20) NOT NULL,
  `areaname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `areaidx` (`areaname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Bolcant dades de la taula `hook_area`
--

INSERT INTO `hook_area` (`id`, `owner`, `subowner`, `areatype`, `category`, `areaname`) VALUES
(1, 'Users', NULL, 's', 'ui_hooks', 'subscriber.users.ui_hooks.user'),
(2, 'Users', NULL, 's', 'ui_hooks', 'subscriber.users.ui_hooks.registration'),
(3, 'Users', NULL, 's', 'ui_hooks', 'subscriber.users.ui_hooks.login_screen'),
(4, 'Users', NULL, 's', 'ui_hooks', 'subscriber.users.ui_hooks.login_block'),
(8, 'News', NULL, 's', 'ui_hooks', 'subscriber.news.ui_hooks.articles'),
(9, 'News', NULL, 's', 'filter_hooks', 'subscriber.news.filter_hooks.articles'),
(10, 'Pages', NULL, 's', 'ui_hooks', 'subscriber.pages.ui_hooks.pages'),
(11, 'Pages', NULL, 's', 'filter_hooks', 'subscriber.pages.filter_hooks.pagesfilter'),
(12, 'Blocks', NULL, 's', 'ui_hooks', 'subscriber.blocks.ui_hooks.htmlblock.content');

-- --------------------------------------------------------

--
-- Estructura de la taula `hook_binding`
--

CREATE TABLE IF NOT EXISTS `hook_binding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sowner` varchar(40) NOT NULL,
  `subsowner` varchar(40) DEFAULT NULL,
  `powner` varchar(40) NOT NULL,
  `subpowner` varchar(40) DEFAULT NULL,
  `sareaid` int(11) NOT NULL,
  `pareaid` int(11) NOT NULL,
  `category` varchar(20) NOT NULL,
  `sortorder` smallint(6) NOT NULL DEFAULT '999',
  PRIMARY KEY (`id`),
  KEY `sortidx` (`sareaid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `hook_provider`
--

CREATE TABLE IF NOT EXISTS `hook_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(40) NOT NULL,
  `subowner` varchar(40) DEFAULT NULL,
  `pareaid` int(11) NOT NULL,
  `hooktype` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `classname` varchar(60) NOT NULL,
  `method` varchar(20) NOT NULL,
  `serviceid` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nameidx` (`pareaid`,`hooktype`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `hook_runtime`
--

CREATE TABLE IF NOT EXISTS `hook_runtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sowner` varchar(40) NOT NULL,
  `subsowner` varchar(40) DEFAULT NULL,
  `powner` varchar(40) NOT NULL,
  `subpowner` varchar(40) DEFAULT NULL,
  `sareaid` int(11) NOT NULL,
  `pareaid` int(11) NOT NULL,
  `eventname` varchar(100) NOT NULL,
  `classname` varchar(60) NOT NULL,
  `method` varchar(20) NOT NULL,
  `serviceid` varchar(60) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `hook_subscriber`
--

CREATE TABLE IF NOT EXISTS `hook_subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(40) NOT NULL,
  `subowner` varchar(40) DEFAULT NULL,
  `sareaid` int(11) NOT NULL,
  `hooktype` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `eventname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `myindex` (`eventname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Bolcant dades de la taula `hook_subscriber`
--

INSERT INTO `hook_subscriber` (`id`, `owner`, `subowner`, `sareaid`, `hooktype`, `category`, `eventname`) VALUES
(1, 'Users', NULL, 1, 'display_view', 'ui_hooks', 'users.ui_hooks.user.display_view'),
(2, 'Users', NULL, 1, 'form_edit', 'ui_hooks', 'users.ui_hooks.user.form_edit'),
(3, 'Users', NULL, 1, 'validate_edit', 'ui_hooks', 'users.ui_hooks.user.validate_edit'),
(4, 'Users', NULL, 1, 'process_edit', 'ui_hooks', 'users.ui_hooks.user.process_edit'),
(5, 'Users', NULL, 1, 'form_delete', 'ui_hooks', 'users.ui_hooks.user.form_delete'),
(6, 'Users', NULL, 1, 'validate_delete', 'ui_hooks', 'users.ui_hooks.user.validate_delete'),
(7, 'Users', NULL, 1, 'process_delete', 'ui_hooks', 'users.ui_hooks.user.process_delete'),
(8, 'Users', NULL, 2, 'display_view', 'ui_hooks', 'users.ui_hooks.registration.display_view'),
(9, 'Users', NULL, 2, 'form_edit', 'ui_hooks', 'users.ui_hooks.registration.form_edit'),
(10, 'Users', NULL, 2, 'validate_edit', 'ui_hooks', 'users.ui_hooks.registration.validate_edit'),
(11, 'Users', NULL, 2, 'process_edit', 'ui_hooks', 'users.ui_hooks.registration.process_edit'),
(12, 'Users', NULL, 2, 'form_delete', 'ui_hooks', 'users.ui_hooks.registration.form_delete'),
(13, 'Users', NULL, 2, 'validate_delete', 'ui_hooks', 'users.ui_hooks.registration.validate_delete'),
(14, 'Users', NULL, 2, 'process_delete', 'ui_hooks', 'users.ui_hooks.registration.process_delete'),
(15, 'Users', NULL, 3, 'form_edit', 'ui_hooks', 'users.ui_hooks.login_screen.form_edit'),
(16, 'Users', NULL, 3, 'validate_edit', 'ui_hooks', 'users.ui_hooks.login_screen.validate_edit'),
(17, 'Users', NULL, 3, 'process_edit', 'ui_hooks', 'users.ui_hooks.login_screen.process_edit'),
(18, 'Users', NULL, 4, 'form_edit', 'ui_hooks', 'users.ui_hooks.login_block.form_edit'),
(19, 'Users', NULL, 4, 'validate_edit', 'ui_hooks', 'users.ui_hooks.login_block.validate_edit'),
(20, 'Users', NULL, 4, 'process_edit', 'ui_hooks', 'users.ui_hooks.login_block.process_edit'),
(28, 'News', NULL, 8, 'display_view', 'ui_hooks', 'news.ui_hooks.articles.display_view'),
(29, 'News', NULL, 8, 'form_edit', 'ui_hooks', 'news.ui_hooks.articles.form_edit'),
(30, 'News', NULL, 8, 'form_delete', 'ui_hooks', 'news.ui_hooks.articles.form_delete'),
(31, 'News', NULL, 8, 'validate_edit', 'ui_hooks', 'news.ui_hooks.articles.validate_edit'),
(32, 'News', NULL, 8, 'validate_delete', 'ui_hooks', 'news.ui_hooks.articles.validate_delete'),
(33, 'News', NULL, 8, 'process_edit', 'ui_hooks', 'news.ui_hooks.articles.process_edit'),
(34, 'News', NULL, 8, 'process_delete', 'ui_hooks', 'news.ui_hooks.articles.process_delete'),
(35, 'News', NULL, 9, 'filter', 'filter_hooks', 'news.filter_hooks.articles.filter'),
(36, 'Pages', NULL, 10, 'display_view', 'ui_hooks', 'pages.ui_hooks.pages.display_view'),
(37, 'Pages', NULL, 10, 'form_edit', 'ui_hooks', 'pages.ui_hooks.pages.form_edit'),
(38, 'Pages', NULL, 10, 'form_delete', 'ui_hooks', 'pages.ui_hooks.pages.form_delete'),
(39, 'Pages', NULL, 10, 'validate_edit', 'ui_hooks', 'pages.ui_hooks.pages.validate_edit'),
(40, 'Pages', NULL, 10, 'validate_delete', 'ui_hooks', 'pages.ui_hooks.pages.validate_delete'),
(41, 'Pages', NULL, 10, 'process_edit', 'ui_hooks', 'pages.ui_hooks.pages.process_edit'),
(42, 'Pages', NULL, 10, 'process_delete', 'ui_hooks', 'pages.ui_hooks.pages.process_delete'),
(43, 'Pages', NULL, 11, 'filter', 'filter_hooks', 'pages.filter_hooks.pages.filter'),
(44, 'Blocks', NULL, 12, 'form_edit', 'ui_hooks', 'blocks.ui_hooks.htmlblock.content.form_edit');

-- --------------------------------------------------------

--
-- Estructura de la taula `IWwebbox`
--

CREATE TABLE IF NOT EXISTS `IWwebbox` (
  `iw_pid` int(11) NOT NULL AUTO_INCREMENT,
  `iw_url` varchar(255) NOT NULL DEFAULT '',
  `iw_ref` varchar(10) NOT NULL DEFAULT '',
  `iw_scrolls` tinyint(1) NOT NULL DEFAULT '1',
  `iw_description` varchar(255) NOT NULL DEFAULT '',
  `iw_width` int(11) NOT NULL DEFAULT '100',
  `iw_height` int(11) NOT NULL DEFAULT '600',
  `iw_widthunit` varchar(10) NOT NULL DEFAULT '%',
  `pn_obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `pn_cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `pn_cr_uid` int(11) NOT NULL DEFAULT '0',
  `pn_lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `pn_lu_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iw_pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `IWwebbox`
--

INSERT INTO `IWwebbox` (`iw_pid`, `iw_url`, `iw_ref`, `iw_scrolls`, `iw_description`, `iw_width`, `iw_height`, `iw_widthunit`, `pn_obj_status`, `pn_cr_date`, `pn_cr_uid`, `pn_lu_date`, `pn_lu_uid`) VALUES
(1, 'http://agora/prestatgeria/pmf/', 'pmf', 1, '', 100, 1200, '%', 'A', '2009-11-21 17:41:00', 2, '2012-12-21 10:12:07', 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `displayname` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `regid` int(11) NOT NULL DEFAULT '0',
  `directory` varchar(64) NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT '0',
  `official` tinyint(4) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `admin_capable` tinyint(4) NOT NULL DEFAULT '0',
  `user_capable` tinyint(4) NOT NULL DEFAULT '0',
  `profile_capable` tinyint(4) NOT NULL DEFAULT '0',
  `message_capable` tinyint(4) NOT NULL DEFAULT '0',
  `state` smallint(6) NOT NULL DEFAULT '0',
  `credits` varchar(255) NOT NULL,
  `changelog` varchar(255) NOT NULL,
  `help` varchar(255) NOT NULL,
  `license` varchar(255) NOT NULL,
  `securityschema` longtext NOT NULL,
  `url` varchar(64) NOT NULL,
  `capabilities` longtext NOT NULL,
  `core_min` varchar(9) NOT NULL,
  `core_max` varchar(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state` (`state`),
  KEY `mod_state` (`name`,`state`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Bolcant dades de la taula `modules`
--

INSERT INTO `modules` (`id`, `name`, `type`, `displayname`, `description`, `regid`, `directory`, `version`, `official`, `author`, `contact`, `admin_capable`, `user_capable`, `profile_capable`, `message_capable`, `state`, `credits`, `changelog`, `help`, `license`, `securityschema`, `url`, `capabilities`, `core_min`, `core_max`) VALUES
(1, 'Extensions', 3, 'Mòduls', 'Gestioneu els vostres mòduls i connectors.', 0, 'Extensions', '3.7.10', 1, 'Jim McDonald, Mark West', 'http://www.zikula.org', 1, 0, 0, 0, 3, '', '', '', '', 'a:1:{s:12:"Extensions::";s:2:"::";}', 'extensions', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(2, 'Admin', 3, 'Tauler d''administració', 'Gestió del propi tauler d''administració.', 0, 'Admin', '1.9.1', 1, 'Mark West', 'http://www.markwest.me.uk/', 1, 0, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:7:"Admin::";s:38:"Admin Category name::Admin Category ID";}', 'adminpanel', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(5, 'Blocks', 3, 'Blocs', 'Administració dels blocs i la seva posició.', 0, 'Blocks', '3.8.2', 1, 'Jim McDonald, Mark West', 'http://www.mcdee.net/, http://www.markwest.me.uk/', 1, 1, 0, 0, 3, '', '', '', '', 'a:4:{s:8:"Blocks::";s:30:"Block key:Block title:Block ID";s:16:"Blocks::position";s:26:"Position name::Position ID";s:23:"Menutree:menutreeblock:";s:26:"Block ID:Link Name:Link ID";s:19:"ExtendedMenublock::";s:17:"Block ID:Link ID:";}', 'blocs', 'a:3:{s:15:"hook_subscriber";a:1:{s:7:"enabled";b:1;}s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(6, 'Categories', 3, 'Categories', 'Categoria d''administració.', 0, 'Categories', '1.2.1', 1, 'Robert Gasch', 'rgasch@gmail.com', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:20:"Categories::Category";s:40:"Category ID:Category Path:Category IPath";}', 'categories', 'a:2:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(7, 'Errors', 3, 'Errors', 'Mòdul de visualització d''errors.', 0, 'Errors', '1.1.1', 1, 'Brian Lindner <Furbo>', 'furbo@sigtauonline.com', 0, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:8:"Errors::";s:2:"::";}', 'errors', 'a:1:{s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(8, 'Groups', 3, 'Grups', 'Mòdul d''administració de grups d''usuaris', 0, 'Groups', '2.3.2', 1, 'Mark West, Franky Chestnut, Michael Halbook', 'http://www.markwest.me.uk/, http://dev.pnconcept.com, http://www.halbrooktech.com', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:8:"Groups::";s:10:"Group ID::";}', 'grups', 'a:2:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(38, 'Legal', 2, 'Legal info manager', 'Provides an interface for managing the site''s legal documents.', 0, 'Legal', '2.0.1', 0, '', '', 0, 0, 0, 0, 1, '', '', '', '', 'a:8:{s:7:"Legal::";s:2:"::";s:18:"Legal::legalnotice";s:2:"::";s:17:"Legal::termsofuse";s:2:"::";s:20:"Legal::privacypolicy";s:2:"::";s:16:"Legal::agepolicy";s:2:"::";s:29:"Legal::accessibilitystatement";s:2:"::";s:30:"Legal::cancellationrightpolicy";s:2:"::";s:22:"Legal::tradeconditions";s:2:"::";}', 'legalmod', 'a:2:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '1.3.0', '1.3.99'),
(11, 'Mailer', 3, 'Mailer', 'El mòdul Mailer, proporciona un API de correu i l''administració de la configuració del correu.', 0, 'Mailer', '1.3.2', 1, 'Mark West', 'http://www.markwest.me.uk/', 1, 0, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:8:"Mailer::";s:2:"::";}', 'mailer', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(13, 'PageLock', 3, 'Gestor del bloqueig de pàgines', 'Proporciona la capacitat de bloquejar pàgines quan s''estan utilitzant.', 0, 'PageLock', '1.1.1', 1, 'Jorn Wildt', 'http://www.elfisk.dk', 0, 0, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/install.txt', 'pndocs/license.txt', 'a:1:{s:10:"PageLock::";s:2:"::";}', 'pagelock', 'a:0:{}', '', ''),
(14, 'Permissions', 3, 'Permisos', 'Gestió dels permisos d''usuari/ària.', 0, 'Permissions', '1.1.1', 1, 'Jim McDonald, M.Maes', 'http://www.mcdee.net/, http://www.mmaes.com', 1, 0, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/install.txt', 'pndocs/license.txt', 'a:1:{s:13:"Permissions::";s:2:"::";}', 'permisos', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(40, 'Search', 3, 'Motor de cerca', 'Paràmetres del cercador intern del lloc.', 0, 'Search', '1.5.2', 0, '', '', 0, 0, 0, 0, 1, '', '', '', '', 'a:1:{s:8:"Search::";s:13:"Module name::";}', 'cerca', 'a:2:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(18, 'SecurityCenter', 3, 'Seguretat', 'Administració i configuració de la seguretat del lloc.', 0, 'SecurityCenter', '1.4.4', 1, 'Mark West', 'http://www.markwest.me.uk', 1, 0, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:16:"SecurityCenter::";s:2:"::";}', 'centredeseguretat', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(19, 'Settings', 3, 'Paràmetres generals', 'Interfície de configuració general del lloc.', 0, 'Settings', '2.9.7', 1, 'Simon Wunderlin', '', 1, 0, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:10:"Settings::";s:2:"::";}', 'Paràmetres', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(21, 'Theme', 3, 'Entorns visuals', 'Mòdul d''entorns visuals per a la gestió de l''aspecte del lloc, el renderitzat de les plantilles i la memòria cau.', 0, 'Theme', '3.4.2', 1, 'Mark West', 'http://www.markwest.me.uk/', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:7:"Theme::";s:12:"Theme name::";}', 'entorn visual', 'a:2:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(22, 'Users', 3, 'Usuaris', 'Proporciona una interfície per configurar i administrar els comptes dels usuaris. Incorpora totes les funcionalitats necessàries, però pot treballar estretament amb el mòdul de perfil.', 0, 'Users', '2.2.0', 1, 'Xiaoyu Huang, Drak', 'class007@sina.com, drak@zikula.org', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:2:{s:7:"Users::";s:14:"Uname::User ID";s:16:"Users::MailUsers";s:2:"::";}', 'usuaris', 'a:4:{s:14:"authentication";a:1:{s:7:"version";s:3:"1.0";}s:15:"hook_subscriber";a:1:{s:7:"enabled";b:1;}s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '1.3.0', ''),
(30, 'Books', 2, 'Llibres', 'Integració d''un sistema MyScrapBook múltiple al Zikula', 0, 'Books', '2.0.0', 0, 'Albert Pérez Monfort & Francesc Bassas', 'http://phobos.xtec.cat/llibres', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:7:"Books::";s:2:"::";}', 'Books', 'a:2:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(31, 'IWwebbox', 2, 'Webbox', 'Show external web sites into the site.', 0, 'IWwebbox', '3.0.0', 0, 'Albert Pérez Monfort (intraweb@xtec.cat)', 'http://phobos.xtec.cat/intraweb', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:10:"IWwebbox::";s:2:"::";}', 'IWwebbox', 'a:2:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(29, 'AuthLDAP', 2, 'AuthLDAP', 'Permet validar els centres per LDAP.', 0, 'AuthLDAP', '1.0.1', 0, 'Mike Goldfinger', 'MikeGoldfinger@linuxmail.org', 1, 0, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:10:"AuthLDAP::";s:2:"::";}', 'AuthLDAP', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(27, 'Pages', 2, 'Pàgines estàtiques', 'Permet gestionar pàgines estàtiques.', 0, 'Pages', '2.5.0', 1, 'The Zikula Development Team', 'http://www.zikula.org/', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/install.txt', 'pndocs/license.txt', 'a:2:{s:7:"Pages::";s:18:"Page name::Page ID";s:15:"Pages:category:";s:13:"Category ID::";}', 'pages', 'a:3:{s:15:"hook_subscriber";a:1:{s:7:"enabled";b:1;}s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '1.3.0', ''),
(32, 'Scribite', 2, 'Scribite', 'Editors visuals per al Zikula', 0, 'Scribite', '4.3.0', 0, 'sven schomacker aka hilope', 'http://code.zikula.org/scribite/', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/scribite!-documentation-eng.pdf', 'pndocs/license.txt', 'a:1:{s:10:"Scribite::";s:12:"Modulename::";}', 'scribite', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '1.3.0', '1.3.99'),
(37, 'EZComments', 2, 'Comentaris', 'Permet adjuntar comentaris a tota mena de continguts', 0, 'EZComments', '3.0.0', 0, '', '', 0, 0, 0, 0, 1, '', '', '', '', 'a:3:{s:12:"EZComments::";s:25:"Module:Item ID:Comment ID";s:21:"EZComments::trackback";s:15:"Module:Item ID:";s:20:"EZComments::pingback";s:15:"Module:Item ID:";}', 'comentaris', 'a:4:{s:13:"hook_provider";a:1:{s:7:"enabled";b:1;}s:15:"hook_subscriber";a:1:{s:7:"enabled";b:1;}s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '1.3.0', ''),
(35, 'XtecMailer', 2, 'Mailer XTEC', 'Amplia les funcionalitats del mòdul Mailer per poder enviar correu electrònic utilitzant el servei web de la XTEC', 0, 'XtecMailer', '1.0.0', 0, 'Francesc Bassas i Bullich', '', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/help.txt', 'pndocs/license.txt', 'a:1:{s:12:"XtecMailer::";s:2:"::";}', 'XtecMailer', 'a:1:{s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}}', '', ''),
(36, 'News', 2, 'Notícies', 'Proporciona un sistema d''addició, edició, esborrament i administració de notícies.', 0, 'News', '3.0.0', 1, 'Mark West, Mateo Tibaquira, Erik Spaan', 'http://code.zikula.org/news', 1, 1, 0, 0, 3, 'pndocs/credits.txt', 'pndocs/changelog.txt', 'pndocs/install.txt', 'pndocs/license.txt', 'a:3:{s:6:"News::";s:26:"Contributor ID::Article ID";s:19:"News:pictureupload:";s:2:"::";s:24:"News:publicationdetails:";s:2:"::";}', 'Notícies', 'a:3:{s:15:"hook_subscriber";a:1:{s:7:"enabled";b:1;}s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '1.3.0', ''),
(39, 'Profile', 2, 'Profile', 'Provides a personal account control panel for each registered user, an interface to administer the personal information items displayed within it, and a registered users list functionality. Works in close unison with the ''Users'' module.', 0, 'Profile', '1.6.1', 0, '', '', 0, 0, 0, 0, 1, '', '', '', '', 'a:6:{s:9:"Profile::";s:2:"::";s:13:"Profile::view";s:2:"::";s:13:"Profile::item";s:56:"DynamicUserData PropertyName::DynamicUserData PropertyID";s:16:"Profile:Members:";s:2:"::";s:22:"Profile:Members:recent";s:2:"::";s:22:"Profile:Members:online";s:2:"::";}', 'profile', 'a:3:{s:7:"profile";a:1:{s:7:"version";s:3:"1.0";}s:5:"admin";a:1:{s:7:"version";s:3:"1.0";}s:4:"user";a:1:{s:7:"version";s:3:"1.0";}}', '1.3.0', '1.3.99');

-- --------------------------------------------------------

--
-- Estructura de la taula `module_deps`
--

CREATE TABLE IF NOT EXISTS `module_deps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modid` int(11) NOT NULL DEFAULT '0',
  `modname` varchar(64) NOT NULL,
  `minversion` varchar(10) NOT NULL,
  `maxversion` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Bolcant dades de la taula `module_deps`
--

INSERT INTO `module_deps` (`id`, `modid`, `modname`, `minversion`, `maxversion`, `status`) VALUES
(79, 5, 'Scribite', '5.0.0', '', 2),
(80, 37, 'Akismet', '2.0', '', 2),
(81, 36, 'Scribite', '4.2.1', '', 2),
(82, 36, 'EZComments', '3.0.1', '', 2),
(83, 27, 'Scribite', '4.2.1', '', 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `module_vars`
--

CREATE TABLE IF NOT EXISTS `module_vars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modname` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `value` longtext,
  PRIMARY KEY (`id`),
  KEY `mod_var` (`modname`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=497 ;

--
-- Bolcant dades de la taula `module_vars`
--

INSERT INTO `module_vars` (`id`, `modname`, `name`, `value`) VALUES
(1, 'Extensions', 'itemsperpage', 'i:25;'),
(420, '/EventHandlers', 'Extensions', 'a:2:{i:0;a:3:{s:9:"eventname";s:27:"controller.method_not_found";s:8:"callable";a:2:{i:0;s:17:"Extensions_HookUI";i:1;s:5:"hooks";}s:6:"weight";i:10;}i:1;a:3:{s:9:"eventname";s:27:"controller.method_not_found";s:8:"callable";a:2:{i:0;s:17:"Extensions_HookUI";i:1;s:14:"moduleservices";}s:6:"weight";i:10;}}'),
(3, 'Permissions', 'filter', 'i:1;'),
(4, 'Permissions', 'warnbar', 'i:1;'),
(5, 'Permissions', 'rowview', 'i:20;'),
(6, 'Permissions', 'rowedit', 'i:20;'),
(7, 'Permissions', 'lockadmin', 'i:1;'),
(8, 'Permissions', 'adminid', 'i:1;'),
(9, 'Groups', 'itemsperpage', 'i:25;'),
(10, 'Groups', 'defaultgroup', 's:1:"1";'),
(11, 'Groups', 'mailwarning', 'i:0;'),
(12, 'Groups', 'hideclosed', 'i:0;'),
(13, 'Blocks', 'collapseable', 's:1:"1";'),
(14, 'Users', 'itemsperpage', 's:2:"25";'),
(15, 'Users', 'reg_allowreg', 's:1:"0";'),
(16, 'Users', 'reg_verifyemail', 's:1:"2";'),
(17, 'Users', 'reg_Illegalusername', 's:97:"root, adm, linux, webmaster, admin, god, administrator, administrador, nobody, anonymous, anonimo";'),
(18, 'Users', 'reg_Illegaldomains', 's:0:"";'),
(19, 'Users', 'reg_Illegaluseragents', 's:0:"";'),
(20, 'Users', 'reg_noregreasons', 's:44:"El registre d''usuaris nous està desactivat"";'),
(21, 'Users', 'reg_uniemail', 's:1:"0";'),
(22, 'Users', 'reg_notifyemail', 's:0:"";'),
(425, 'Users', 'chgpass_expiredays', 's:1:"0";'),
(24, 'Users', 'userimg', 's:11:"images/menu";'),
(26, 'Users', 'minpass', 's:1:"5";'),
(27, 'Users', 'anonymous', 's:5:"Guest";'),
(424, 'Users', 'chgemail_expiredays', 's:1:"0";'),
(29, 'Users', 'loginviaoption', 's:1:"0";'),
(30, 'Users', 'moderation', 's:1:"0";'),
(31, 'Users', 'hash_method', 's:3:"md5";'),
(32, 'Users', 'login_redirect', 's:1:"1";'),
(33, 'Users', 'reg_question', 's:0:"";'),
(34, 'Users', 'reg_answer', 's:0:"";'),
(427, 'Users', 'allowgravatars', 's:1:"1";'),
(36, 'Theme', 'modulesnocache', 's:0:"";'),
(37, 'Theme', 'enablecache', 'b:0;'),
(38, 'Theme', 'compile_check', 'b:1;'),
(39, 'Theme', 'cache_lifetime', 'i:3600;'),
(40, 'Theme', 'force_compile', 'b:0;'),
(41, 'Theme', 'trimwhitespace', 'b:0;'),
(42, 'Theme', 'makelinks', 'b:0;'),
(43, 'Theme', 'maxsizeforlinks', 'i:30;'),
(44, 'Theme', 'itemsperpage', 'i:25;'),
(45, 'Admin', 'modulesperrow', 's:1:"3";'),
(46, 'Admin', 'itemsperpage', 's:2:"15";'),
(47, 'Admin', 'defaultcategory', 's:1:"4";'),
(48, 'Admin', 'modulestylesheet', 's:11:"navtabs.css";'),
(49, 'Admin', 'admingraphic', 's:1:"1";'),
(50, 'Admin', 'startcategory', 's:1:"1";'),
(51, 'Admin', 'ignoreinstallercheck', 'b:0;'),
(52, 'Admin', 'admintheme', 's:0:"";'),
(53, 'Admin', 'displaynametype', 's:1:"1";'),
(54, 'ZConfig', 'debug', 's:1:"0";'),
(55, 'ZConfig', 'sitename', 's:26:"La Prestatgeria de la XTEC";'),
(300, 'ZConfig', 'updatelastchecked', 'i:1429868365;'),
(57, 'ZConfig', 'slogan', 's:18:"Llibres compartits";'),
(58, 'ZConfig', 'metakeywords', 's:27:"prestatgeria, XTEC, llibres";'),
(60, 'ZConfig', 'startdate', 's:7:"11/2009";'),
(61, 'ZConfig', 'adminmail', 's:16:"llibres@xtec.cat";'),
(62, 'ZConfig', 'Default_Theme', 's:5:"Shelf";'),
(63, 'ZConfig', 'anonymous', 's:9:"Anònim/a";";'),
(64, 'ZConfig', 'timezone_offset', 's:1:"0";'),
(65, 'ZConfig', 'timezone_server', 's:1:"0";'),
(66, 'ZConfig', 'funtext', 's:1:"1";'),
(67, 'ZConfig', 'reportlevel', 's:1:"0";'),
(68, 'ZConfig', 'startpage', 's:4:"News";'),
(303, 'ZConfig', 'updatecheck', 's:1:"1";'),
(301, 'ZConfig', 'updatefrequency', 'i:7;'),
(71, 'ZConfig', 'seclevel', 's:4:"High";'),
(72, 'ZConfig', 'secmeddays', 's:1:"7";'),
(73, 'ZConfig', 'secinactivemins', 's:2:"45";'),
(74, 'ZConfig', 'Version_Num', 's:5:"1.3.9";'),
(75, 'ZConfig', 'Version_ID', 's:6:"Zikula";'),
(76, 'ZConfig', 'Version_Sub', 's:3:"vai";'),
(77, 'ZConfig', 'debug_sql', 's:1:"0";'),
(78, 'ZConfig', 'language', 's:3:"cat";'),
(79, 'ZConfig', 'locale', 's:5:"ca_ES";'),
(80, 'ZConfig', 'multilingual', 's:1:"0";'),
(81, 'ZConfig', 'useflags', 's:1:"0";'),
(82, 'ZConfig', 'AllowableHTML', 'a:110:{s:3:"!--";i:2;s:1:"a";i:2;s:4:"abbr";i:0;s:7:"acronym";i:0;s:7:"address";i:0;s:6:"applet";i:0;s:4:"area";i:0;s:7:"article";i:0;s:5:"aside";i:0;s:5:"audio";i:0;s:1:"b";i:2;s:4:"base";i:0;s:8:"basefont";i:0;s:3:"bdo";i:0;s:3:"big";i:0;s:10:"blockquote";i:2;s:2:"br";i:2;s:6:"button";i:0;s:6:"canvas";i:0;s:7:"caption";i:0;s:6:"center";i:2;s:4:"cite";i:0;s:4:"code";i:0;s:3:"col";i:0;s:8:"colgroup";i:0;s:7:"command";i:0;s:8:"datalist";i:0;s:2:"dd";i:0;s:3:"del";i:0;s:7:"details";i:0;s:3:"dfn";i:0;s:3:"dir";i:0;s:3:"div";i:2;s:2:"dl";i:0;s:2:"dt";i:0;s:2:"em";i:2;s:5:"embed";i:2;s:8:"fieldset";i:0;s:10:"figcaption";i:0;s:6:"figure";i:0;s:4:"font";i:0;s:6:"footer";i:0;s:4:"form";i:0;s:2:"h1";i:1;s:2:"h2";i:1;s:2:"h3";i:1;s:2:"h4";i:1;s:2:"h5";i:1;s:2:"h6";i:1;s:6:"header";i:0;s:6:"hgroup";i:0;s:2:"hr";i:2;s:1:"i";i:2;s:6:"iframe";i:2;s:3:"img";i:2;s:5:"input";i:0;s:3:"ins";i:0;s:6:"keygen";i:0;s:3:"kbd";i:0;s:5:"label";i:0;s:6:"legend";i:0;s:2:"li";i:2;s:3:"map";i:0;s:4:"mark";i:0;s:4:"menu";i:0;s:7:"marquee";i:0;s:5:"meter";i:0;s:3:"nav";i:0;s:4:"nobr";i:0;s:6:"object";i:2;s:2:"ol";i:2;s:8:"optgroup";i:0;s:6:"option";i:0;s:6:"output";i:0;s:1:"p";i:2;s:5:"param";i:2;s:3:"pre";i:2;s:8:"progress";i:0;s:1:"q";i:0;s:2:"rp";i:0;s:2:"rt";i:0;s:4:"ruby";i:0;s:1:"s";i:0;s:4:"samp";i:0;s:6:"script";i:0;s:7:"section";i:0;s:6:"select";i:0;s:5:"small";i:0;s:6:"source";i:0;s:4:"span";i:0;s:6:"strike";i:0;s:6:"strong";i:2;s:3:"sub";i:0;s:7:"summary";i:0;s:3:"sup";i:0;s:5:"table";i:2;s:5:"tbody";i:2;s:2:"td";i:2;s:8:"textarea";i:0;s:5:"tfoot";i:0;s:2:"th";i:2;s:5:"thead";i:0;s:4:"time";i:0;s:2:"tr";i:2;s:2:"tt";i:2;s:1:"u";i:0;s:2:"ul";i:2;s:3:"var";i:0;s:5:"video";i:0;s:3:"wbr";i:0;}'),
(83, 'ZConfig', 'theme_change', 'b:0;'),
(84, 'ZConfig', 'htmlentities', 's:1:"1";'),
(85, 'ZConfig', 'UseCompression', 's:1:"0";'),
(302, 'ZConfig', 'updateversion', 's:5:"1.3.8";'),
(440, 'ZConfig', 'defaultmetadescription', 's:18:"Llibres compartits";'),
(442, 'ZConfig', 'idsmail', 'i:0;'),
(443, 'ZConfig', 'idsrulepath', 's:32:"config/phpids_zikula_default.xml";'),
(444, 'ZConfig', 'idssoftblock', 'i:1;'),
(445, 'ZConfig', 'idsfilter', 's:3:"xml";'),
(446, 'ZConfig', 'idsimpactthresholdone', 'i:1;'),
(447, 'ZConfig', 'idsimpactthresholdtwo', 'i:10;'),
(448, 'ZConfig', 'idsimpactthresholdthree', 'i:25;'),
(449, 'ZConfig', 'idsimpactthresholdfour', 'i:75;'),
(450, 'ZConfig', 'idsimpactmode', 'i:1;'),
(451, 'ZConfig', 'idshtmlfields', 'a:1:{i:0;s:14:"POST.__wysiwyg";}'),
(452, 'ZConfig', 'idsjsonfields', 'a:1:{i:0;s:15:"POST.__jsondata";}'),
(453, 'ZConfig', 'idsexceptions', 'a:12:{i:0;s:10:"GET.__utmz";i:1;s:10:"GET.__utmc";i:2;s:18:"REQUEST.linksorder";i:3;s:15:"POST.linksorder";i:4;s:19:"REQUEST.fullcontent";i:5;s:16:"POST.fullcontent";i:6;s:22:"REQUEST.summarycontent";i:7;s:19:"POST.summarycontent";i:8;s:19:"REQUEST.filter.page";i:9;s:16:"POST.filter.page";i:10;s:20:"REQUEST.filter.value";i:11;s:17:"POST.filter.value";}'),
(454, 'SecurityCenter', 'htmlpurifierConfig', 's:3914:"a:10:{s:4:"Attr";a:15:{s:14:"AllowedClasses";N;s:19:"AllowedFrameTargets";a:0:{}s:10:"AllowedRel";a:3:{s:8:"nofollow";b:1;s:11:"imageviewer";b:1;s:8:"lightbox";b:1;}s:10:"AllowedRev";a:0:{}s:13:"ClassUseCDATA";N;s:15:"DefaultImageAlt";N;s:19:"DefaultInvalidImage";s:0:"";s:22:"DefaultInvalidImageAlt";s:13:"Invalid image";s:14:"DefaultTextDir";s:3:"ltr";s:8:"EnableID";b:0;s:16:"ForbiddenClasses";a:0:{}s:11:"IDBlacklist";a:0:{}s:17:"IDBlacklistRegexp";N;s:8:"IDPrefix";s:0:"";s:13:"IDPrefixLocal";s:0:"";}s:10:"AutoFormat";a:10:{s:13:"AutoParagraph";b:0;s:6:"Custom";a:0:{}s:14:"DisplayLinkURI";b:0;s:7:"Linkify";b:0;s:22:"PurifierLinkify.DocURL";s:3:"#%s";s:15:"PurifierLinkify";b:0;s:33:"RemoveEmpty.RemoveNbsp.Exceptions";a:2:{s:2:"td";b:1;s:2:"th";b:1;}s:22:"RemoveEmpty.RemoveNbsp";b:0;s:11:"RemoveEmpty";b:0;s:28:"RemoveSpansWithoutAttributes";b:0;}s:3:"CSS";a:9:{s:14:"AllowImportant";b:0;s:11:"AllowTricky";b:0;s:12:"AllowedFonts";N;s:17:"AllowedProperties";N;s:13:"DefinitionRev";i:1;s:19:"ForbiddenProperties";a:0:{}s:12:"MaxImgLength";s:6:"1200px";s:11:"Proprietary";b:0;s:7:"Trusted";b:0;}s:5:"Cache";a:3:{s:14:"DefinitionImpl";s:10:"Serializer";s:14:"SerializerPath";N;s:21:"SerializerPermissions";i:493;}s:4:"Core";a:17:{s:17:"AggressivelyFixLt";b:1;s:13:"CollectErrors";b:0;s:13:"ColorKeywords";a:17:{s:6:"maroon";s:7:"#800000";s:3:"red";s:7:"#FF0000";s:6:"orange";s:7:"#FFA500";s:6:"yellow";s:7:"#FFFF00";s:5:"olive";s:7:"#808000";s:6:"purple";s:7:"#800080";s:7:"fuchsia";s:7:"#FF00FF";s:5:"white";s:7:"#FFFFFF";s:4:"lime";s:7:"#00FF00";s:5:"green";s:7:"#008000";s:4:"navy";s:7:"#000080";s:4:"blue";s:7:"#0000FF";s:4:"aqua";s:7:"#00FFFF";s:4:"teal";s:7:"#008080";s:5:"black";s:7:"#000000";s:6:"silver";s:7:"#C0C0C0";s:4:"gray";s:7:"#808080";}s:25:"ConvertDocumentToFragment";b:1;s:31:"DirectLexLineNumberSyncInterval";i:0;s:8:"Encoding";s:5:"utf-8";s:21:"EscapeInvalidChildren";b:0;s:17:"EscapeInvalidTags";b:0;s:24:"EscapeNonASCIICharacters";b:0;s:14:"HiddenElements";a:2:{s:6:"script";b:1;s:5:"style";b:1;}s:8:"Language";s:2:"en";s:9:"LexerImpl";N;s:19:"MaintainLineNumbers";N;s:17:"NormalizeNewlines";b:1;s:16:"RemoveInvalidImg";b:1;s:28:"RemoveProcessingInstructions";b:0;s:20:"RemoveScriptContents";N;}s:6:"Filter";a:6:{s:6:"Custom";a:0:{}s:27:"ExtractStyleBlocks.Escaping";b:1;s:24:"ExtractStyleBlocks.Scope";N;s:27:"ExtractStyleBlocks.TidyImpl";N;s:18:"ExtractStyleBlocks";b:0;s:7:"YouTube";b:0;}s:4:"HTML";a:26:{s:7:"Allowed";N;s:17:"AllowedAttributes";N;s:15:"AllowedElements";N;s:14:"AllowedModules";N;s:18:"Attr.Name.UseCDATA";b:0;s:12:"BlockWrapper";s:1:"p";s:11:"CoreModules";a:7:{s:9:"Structure";b:1;s:4:"Text";b:1;s:9:"Hypertext";b:1;s:4:"List";b:1;s:22:"NonXMLCommonAttributes";b:1;s:19:"XMLCommonAttributes";b:1;s:16:"CommonAttributes";b:1;}s:13:"CustomDoctype";N;s:12:"DefinitionID";N;s:13:"DefinitionRev";i:1;s:7:"Doctype";N;s:20:"FlashAllowFullScreen";b:0;s:19:"ForbiddenAttributes";a:0:{}s:17:"ForbiddenElements";a:0:{}s:12:"MaxImgLength";i:1200;s:8:"Nofollow";b:0;s:6:"Parent";s:3:"div";s:11:"Proprietary";b:0;s:9:"SafeEmbed";b:1;s:10:"SafeObject";b:1;s:6:"Strict";b:0;s:7:"TidyAdd";a:0:{}s:9:"TidyLevel";s:6:"medium";s:10:"TidyRemove";a:0:{}s:7:"Trusted";b:0;s:5:"XHTML";b:1;}s:6:"Output";a:6:{s:21:"CommentScriptContents";b:1;s:12:"FixInnerHTML";b:1;s:11:"FlashCompat";b:1;s:7:"Newline";N;s:8:"SortAttr";b:0;s:10:"TidyFormat";b:0;}s:4:"Test";a:1:{s:12:"ForceNoIconv";b:0;}s:3:"URI";a:16:{s:14:"AllowedSchemes";a:6:{s:4:"http";b:1;s:5:"https";b:1;s:6:"mailto";b:1;s:3:"ftp";b:1;s:4:"nntp";b:1;s:4:"news";b:1;}s:4:"Base";N;s:13:"DefaultScheme";s:4:"http";s:12:"DefinitionID";N;s:13:"DefinitionRev";i:1;s:7:"Disable";b:0;s:15:"DisableExternal";b:0;s:24:"DisableExternalResources";b:0;s:16:"DisableResources";b:0;s:4:"Host";N;s:13:"HostBlacklist";a:0:{}s:12:"MakeAbsolute";b:0;s:5:"Munge";N;s:14:"MungeResources";b:0;s:14:"MungeSecretKey";N;s:22:"OverrideAllowedSchemes";b:1;}}";'),
(89, 'ZConfig', 'errordisplay', 'i:1;'),
(90, 'ZConfig', 'errorlog', 'i:0;'),
(91, 'ZConfig', 'errorlogtype', 'i:0;'),
(92, 'ZConfig', 'errormailto', 's:14:"jo@example.com";'),
(93, 'ZConfig', 'siteoff', 'i:0;'),
(94, 'ZConfig', 'siteoffreason', 's:0:"";'),
(95, 'ZConfig', 'starttype', 's:4:"user";'),
(96, 'ZConfig', 'startfunc', 's:4:"view";'),
(97, 'ZConfig', 'startargs', 's:16:"displayonindex=1";'),
(98, 'ZConfig', 'entrypoint', 's:9:"index.php";'),
(99, 'ZConfig', 'secure_domain', 's:0:"";'),
(100, 'ZConfig', 'language_detect', 's:1:"0";'),
(101, 'ZConfig', 'shorturls', 'b:0;'),
(102, 'ZConfig', 'shorturlstype', 's:1:"0";'),
(441, 'ZConfig', 'useids', 'i:0;'),
(104, 'ZConfig', 'shorturlsseparator', 's:1:"-";'),
(105, 'ZConfig', 'shorturlsstripentrypoint', 'b:0;'),
(106, 'ZConfig', 'shorturlsdefaultmodule', 's:0:"";'),
(107, 'ZConfig', 'signcookies', 'i:1;'),
(108, 'ZConfig', 'signingkey', 's:40:"fd22b65ca2bd96512c9ad9ac097ed5c41851b6f2";'),
(109, 'ZConfig', 'sessionipcheck', 'i:0;'),
(110, 'ZConfig', 'keyexpiry', 'i:0;'),
(111, 'ZConfig', 'gc_probability', 'i:100;'),
(112, 'ZConfig', 'anonymoussessions', 'i:1;'),
(113, 'ZConfig', 'sessionstoretofile', 'i:0;'),
(114, 'ZConfig', 'sessionsavepath', 's:0:"";'),
(115, 'ZConfig', 'sessionauthkeyua', 'b:0;'),
(116, 'ZConfig', 'sessionname', 's:5:"ZKSID";'),
(117, 'ZConfig', 'sessionregenerate', 'b:1;'),
(118, 'ZConfig', 'sessionrandregenerate', 's:1:"0";'),
(119, 'ZConfig', 'sessionregeneratefreq', 'i:10;'),
(304, 'ZConfig', 'language_i18n', 's:2:"ca";'),
(121, 'ZConfig', 'profilemodule', 's:0:"";'),
(122, 'ZConfig', 'messagemodule', 's:0:"";'),
(123, 'Admin_Messages', 'itemsperpage', 'i:25;'),
(124, 'Admin_Messages', 'allowsearchinactive', 'b:0;'),
(125, 'SecurityCenter', 'itemsperpage', 's:2:"10";'),
(126, 'ZConfig', 'enableanticracker', 's:1:"1";'),
(127, 'ZConfig', 'emailhackattempt', 's:1:"1";'),
(128, 'ZConfig', 'loghackattempttodb', 's:1:"1";'),
(129, 'ZConfig', 'onlysendsummarybyemail', 's:1:"1";'),
(130, 'ZConfig', 'usehtaccessbans', 'i:1;'),
(131, 'ZConfig', 'filtergetvars', 's:1:"1";'),
(132, 'ZConfig', 'filtercookievars', 's:1:"1";'),
(133, 'ZConfig', 'filterpostvars', 's:1:"1";'),
(134, 'ZConfig', 'filterarrays', 'i:0;'),
(135, 'ZConfig', 'extrapostprotection', 'i:0;'),
(136, 'ZConfig', 'extragetprotection', 'i:0;'),
(137, 'ZConfig', 'checkmultipost', 'i:1;'),
(138, 'ZConfig', 'maxmultipost', 'i:4;'),
(139, 'ZConfig', 'zipcompress', 'i:0;'),
(140, 'ZConfig', 'compresslevel', 'i:9;'),
(141, 'ZConfig', 'cpuloadmonitor', 'i:0;'),
(142, 'ZConfig', 'cpumaxload', 'd:10;'),
(143, 'ZConfig', 'ccisessionpath', 's:0:"";'),
(144, 'ZConfig', 'htaccessfilelocation', 's:9:".htaccess";'),
(145, 'ZConfig', 'nocookiebanthreshold', 'i:10;'),
(146, 'ZConfig', 'nocookiewarningthreshold', 'i:2;'),
(147, 'ZConfig', 'fastaccessbanthreshold', 'i:40;'),
(148, 'ZConfig', 'fastaccesswarnthreshold', 'i:10;'),
(149, 'ZConfig', 'javababble', 'i:0;'),
(150, 'ZConfig', 'javaencrypt', 'i:0;'),
(151, 'ZConfig', 'preservehead', 'i:0;'),
(152, 'ZConfig', 'outputfilter', 's:1:"0";'),
(153, 'ZConfig', 'summarycontent', 's:1179:"Attention site admin of %sitename%.\r\n\r\nOn %date% at %time% the Zikula code has detected that somebody tried to send information to your site that may have been intended as a hack. Do not panic, it may be harmless: maybe this detection was triggered by something you did! Anyway, it was detected and blocked. \r\n\r\nThe suspicious activity was recognized in %filename% on line %linenumber%, and is of the type %type%. \r\n\r\nAdditional information given by the code which detected this: %additionalinfo%.\r\n\r\nBelow you will find a lot of information obtained about this attempt, that may help you to find  what happened and maybe who did it.\r\n\r\n\r\n=====================================\r\nInformation about this user:\r\n=====================================\r\nZikula username:  %username%\r\nRegistered email of this Zikula user: %useremail%\r\nRegistered real name of this Zikula user: %userrealname%\r\nIP numbers: (note: when you are dealing with a real cracker these IP numbers might not be from the actual computer he is working on)\r\n\r\nIP according to HTTP_CLIENT_IP: %httpclientip%\r\nIP according to REMOTE_ADDR: %remoteaddr%\r\nIP according to GetHostByName($REMOTE_ADDR): %gethostbyremoteaddr%";'),
(154, 'ZConfig', 'fullcontent', 's:1363:"=====================================\r\nInformation in the $_REQUEST array\r\n=====================================\r\n%requestarray%\r\n\r\n=====================================\r\nInformation in the $_GET array\r\nThis is about variables that may have been in the URL string or in a ''GET'' type form.\r\n=====================================\r\n%getarray%\r\n\r\n=====================================\r\nInformation in the $_POST array\r\nThis is about visible and invisible form elements.\r\n=====================================\r\n%postarray%\r\n\r\n=====================================\r\nBrowser information\r\n=====================================\r\n%browserinfo%\r\n\r\n=====================================\r\nInformation in the $_SERVER array\r\n=====================================\r\n%serverarray%\r\n\r\n=====================================\r\nInformation in the $_ENV array\r\n=====================================\r\n%envarray%\r\n\r\n=====================================\r\nInformation in the $_COOKIE array\r\n=====================================\r\n%cookiearray%\r\n\r\n=====================================\r\nInformation in the $_FILES array\r\n=====================================\r\n%filearray%\r\n\r\n=====================================\r\nInformation in the $_SESSION array\r\nThis is session info. The variables\r\nstarting with PNSV are Zikula Session Variables.\r\n=====================================\r\n%sessionarray%";'),
(155, 'Categories', 'userrootcat', 's:17:"/__SYSTEM__/Users";'),
(156, 'Categories', 'allowusercatedit', 'i:0;'),
(157, 'Categories', 'autocreateusercat', 'i:0;'),
(158, 'Categories', 'autocreateuserdefaultcat', 'i:0;'),
(159, 'Categories', 'userdefaultcatname', 's:7:"Default";'),
(163, 'Mailer', 'mailertype', 'i:5;'),
(164, 'Mailer', 'charset', 's:10:"ISO-8859-1";'),
(165, 'Mailer', 'encoding', 's:4:"8bit";'),
(166, 'Mailer', 'html', 'b:1;'),
(167, 'Mailer', 'wordwrap', 'i:50;'),
(168, 'Mailer', 'msmailheaders', 'b:0;'),
(169, 'Mailer', 'sendmailpath', 's:18:"/usr/sbin/sendmail";'),
(170, 'Mailer', 'smtpauth', 'b:1;'),
(171, 'Mailer', 'smtpserver', 's:13:"smtp.xtec.cat";'),
(172, 'Mailer', 'smtpport', 'i:25;'),
(173, 'Mailer', 'smtptimeout', 'i:10;'),
(174, 'Mailer', 'smtpusername', 's:7:"llibres";'),
(175, 'Mailer', 'smtppassword', 's:5:"agora";'),
(439, 'ZConfig', 'defaultpagetitle', 's:26:"La Prestatgeria de la XTEC";'),
(495, 'Mailer', 'smtpsecuremethod', 's:0:"";'),
(183, 'ZConfig', 'log_last_rotate', 'i:1360947368;'),
(362, 'News', 'itemsperpage', 'i:25;'),
(361, 'News', 'storyorder', 'i:1;'),
(376, 'News', 'notifyonpending_fromaddress', 's:0:"";'),
(363, 'News', 'permalinkformat', 's:38:"%year%/%monthnum%/%day%/%articletitle%";'),
(364, 'News', 'enablecategorization', 'b:1;'),
(193, 'AuthPN', 'authmodules', 's:18:"iw_AuthLDAP,AuthPN";'),
(421, 'ZConfig', 'idnnames', 'b:1;'),
(423, '/EventHandlers', 'Users', 'a:4:{i:0;a:3:{s:9:"eventname";s:19:"get.pending_content";s:8:"callable";a:2:{i:0;s:29:"Users_Listener_PendingContent";i:1;s:22:"pendingContentListener";}s:6:"weight";i:10;}i:1;a:3:{s:9:"eventname";s:15:"user.login.veto";s:8:"callable";a:2:{i:0;s:35:"Users_Listener_ForcedPasswordChange";i:1;s:28:"forcedPasswordChangeListener";}s:6:"weight";i:10;}i:2;a:3:{s:9:"eventname";s:21:"user.logout.succeeded";s:8:"callable";a:2:{i:0;s:34:"Users_Listener_ClearUsersNamespace";i:1;s:27:"clearUsersNamespaceListener";}s:6:"weight";i:10;}i:3;a:3:{s:9:"eventname";s:25:"frontcontroller.exception";s:8:"callable";a:2:{i:0;s:34:"Users_Listener_ClearUsersNamespace";i:1;s:27:"clearUsersNamespaceListener";}s:6:"weight";i:10;}}'),
(204, 'Books', 'bookSoftwareUrl', 's:25:"http://agora/prestatgeria";'),
(205, 'Books', 'bookSoftwareUri', 's:13:"/prestatgeria";'),
(206, 'Books', 'canCreateToOthers', 's:1:"1";'),
(207, 'Books', 'mailDomServer', 's:9:"@xtec.cat";'),
(208, 'Books', 'booksDatabase', 's:6:"presta";'),
(209, 'Books', 'serverImageFolder', 's:32:"/dades/prestatgeria/html/centres";'),
(210, 'Books', 'everyBodyCanCreate', 'i:0;'),
(211, 'Pages', 'itemsperpage', 'i:25;'),
(212, 'Pages', 'enablecategorization', 'b:1;'),
(213, 'Pages', 'addcategorytitletopermalink', 'b:1;'),
(214, 'Pages', 'def_displaywrapper', 'b:1;'),
(215, 'Pages', 'def_displaytitle', 'b:1;'),
(216, 'Pages', 'def_displaycreated', 'b:1;'),
(217, 'Pages', 'def_displayupdated', 'b:1;'),
(218, 'Pages', 'def_displaytextinfo', 'b:1;'),
(219, 'Pages', 'def_displayprint', 'b:1;'),
(220, 'IWwebbox', 'url', 's:31:"http://phobos.xtec.cat/intraweb";'),
(221, 'IWwebbox', 'width', 's:3:"100";'),
(222, 'IWwebbox', 'height', 's:3:"600";'),
(223, 'IWwebbox', 'scrolls', 's:1:"1";'),
(224, 'IWwebbox', 'widthunit', 's:1:"%";'),
(225, 'Scribite', 'editors_path', 's:25:"modules/Scribite/includes";'),
(226, 'Scribite', 'xinha_language', 's:2:"en";'),
(227, 'Scribite', 'xinha_skin', 's:9:"blue-look";'),
(228, 'Scribite', 'xinha_barmode', 's:7:"reduced";'),
(229, 'Scribite', 'xinha_width', 's:4:"auto";'),
(230, 'Scribite', 'xinha_height', 's:4:"auto";'),
(231, 'Scribite', 'xinha_style', 's:39:"modules/Scribite/style/xinha/editor.css";'),
(232, 'Scribite', 'xinha_statusbar', 's:1:"1";'),
(233, 'Scribite', 'xinha_converturls', 's:1:"1";'),
(234, 'Scribite', 'xinha_showloading', 's:1:"1";'),
(236, 'Scribite', 'tinymce_language', 's:2:"en";'),
(237, 'Scribite', 'tinymce_style', 's:45:"modules/scribite/pnconfig/tiny_mce/editor.css";'),
(238, 'Scribite', 'tinymce_theme', 's:6:"simple";'),
(239, 'Scribite', 'tinymce_width', 's:3:"75%";'),
(240, 'Scribite', 'tinymce_height', 's:3:"400";'),
(241, 'Scribite', 'tinymce_dateformat', 's:8:"%Y-%m-%d";'),
(242, 'Scribite', 'tinymce_timeformat', 's:8:"%H:%M:%S";'),
(243, 'Scribite', 'tinymce_activeplugins', 's:0:"";'),
(487, 'Scribite', 'ckeditor_style_editor', 's:43:"modules/Scribite/style/ckeditor/content.css";'),
(486, 'Scribite', 'xinha_style_stylist', 's:40:"modules/Scribite/style/xinha/stylist.css";'),
(247, 'Scribite', 'fckeditor_height', 's:3:"400";'),
(249, 'Scribite', 'openwysiwyg_barmode', 's:4:"full";'),
(250, 'Scribite', 'openwysiwyg_width', 's:3:"400";'),
(251, 'Scribite', 'openwysiwyg_height', 's:3:"300";'),
(252, 'Scribite', 'nicedit_fullpanel', 'i:0;'),
(253, 'Scribite', 'yui_type', 's:6:"Simple";'),
(254, 'Scribite', 'yui_width', 's:4:"auto";'),
(255, 'Scribite', 'yui_height', 's:3:"300";'),
(256, 'Scribite', 'yui_dombar', 'b:1;'),
(257, 'Scribite', 'yui_animate', 'b:1;'),
(258, 'Scribite', 'yui_collapse', 'b:1;'),
(475, 'systemplugin.imagine', 'thumb_dir', 's:20:"systemplugin.imagine";'),
(476, 'systemplugin.imagine', 'thumb_auto_cleanup', 'b:0;'),
(290, 'ZConfig', 'nocookiewarnthreshold', 'i:2;'),
(291, 'Scribite', 'DefaultEditor', 's:5:"xinha";'),
(292, 'Users', 'accountdisplaygraphics', 's:1:"1";'),
(293, 'Users', 'accountitemsperpage', 's:2:"25";'),
(294, 'Users', 'accountitemsperrow', 's:1:"5";'),
(296, 'Users', 'changeemail', 's:1:"1";'),
(297, 'Users', 'avatarpath', 's:13:"images/avatar";'),
(426, 'Users', 'reg_expiredays', 's:1:"0";'),
(299, 'Admin', 'moduledescription', 'i:1;'),
(306, 'ZConfig', 'languageurl', 's:1:"0";'),
(307, 'ZConfig', 'ajaxtimeout', 'i:5000;'),
(308, 'ZConfig', 'permasearch', 's:161:"À,Á,Â,Ã,Å,à,á,â,ã,å,Ò,Ó,Ô,Õ,Ø,ò,ó,ô,õ,ø,È,É,Ê,Ë,è,é,ê,ë,Ç,ç,Ì,Í,Î,Ï,ì,í,î,ï,Ù,Ú,Û,ù,ú,û,ÿ,Ñ,ñ,ß,ä,Ä,ö,Ö,ü,Ü";'),
(388, 'News', 'picupload_index_float', 's:4:"left";'),
(309, 'ZConfig', 'permareplace', 's:114:"A,A,A,A,A,a,a,a,a,a,O,O,O,O,O,o,o,o,o,o,E,E,E,E,e,e,e,e,C,c,I,I,I,I,i,i,i,i,U,U,U,u,u,u,y,N,n,ss,ae,Ae,oe,Oe,ue,Ue";'),
(310, 'Theme', 'cssjscombine', 'b:0;'),
(311, 'Theme', 'cssjscompress', 'b:0;'),
(312, 'Theme', 'cssjsminify', 'b:0;'),
(313, 'Theme', 'cssjscombine_lifetime', 'i:3600;'),
(386, 'News', 'picupload_enabled', 'b:0;'),
(385, 'News', 'pdflink_headerlogo_width', 's:2:"30";'),
(384, 'News', 'pdflink_headerlogo', 's:14:"tcpdf_logo.jpg";'),
(381, 'News', 'pdflink', 'b:0;'),
(472, 'News', 'pdflink_enablecache', 'b:1;'),
(471, 'News', 'itemsperadminpage', 'i:15;'),
(380, 'News', 'notifyonpending_html', 'b:1;'),
(377, 'News', 'notifyonpending_toname', 's:0:"";'),
(378, 'News', 'notifyonpending_toaddress', 's:0:"";'),
(379, 'News', 'notifyonpending_subject', 's:54:"A News Publisher article has been submitted for review";'),
(329, 'Pages', 'showpermalinkinput', 's:1:"1";'),
(474, 'systemplugin.imagine', 'version', 's:5:"1.0.0";'),
(485, 'Scribite', 'xinha_style_dynamiccss', 's:43:"modules/Scribite/style/xinha/DynamicCSS.css";'),
(387, 'News', 'picupload_allowext', 's:11:"jpg,gif,png";'),
(374, 'News', 'notifyonpending', 'b:0;'),
(375, 'News', 'notifyonpending_fromname', 's:0:"";'),
(372, 'News', 'enabledescriptionvar', 'b:0;'),
(373, 'News', 'descriptionvarchars', 'i:250;'),
(371, 'News', 'enablecategorybasedpermissions', 'b:1;'),
(369, 'News', 'enablemorearticlesincat', 'b:0;'),
(370, 'News', 'morearticlesincat', 'i:0;'),
(366, 'News', 'enableattribution', 'b:0;'),
(367, 'News', 'catimagepath', 's:18:"images/categories/";'),
(368, 'News', 'enableajaxedit', 'b:0;'),
(365, 'News', 'refereronprint', 'i:0;'),
(360, 'News', 'storyhome', 'i:10;'),
(389, 'News', 'picupload_article_float', 's:4:"left";'),
(390, 'News', 'picupload_maxfilesize', 's:6:"500000";'),
(391, 'News', 'picupload_maxpictures', 's:1:"3";'),
(392, 'News', 'picupload_sizing', 's:1:"0";'),
(393, 'News', 'picupload_picmaxwidth', 's:3:"600";'),
(394, 'News', 'picupload_picmaxheight', 's:3:"600";'),
(395, 'News', 'picupload_thumbmaxwidth', 's:3:"150";'),
(396, 'News', 'picupload_thumbmaxheight', 's:3:"150";'),
(397, 'News', 'picupload_thumb2maxwidth', 's:3:"200";'),
(398, 'News', 'picupload_thumb2maxheight', 's:3:"200";'),
(399, 'News', 'picupload_uploaddir', 's:21:"images/news_picupload";'),
(400, 'AuthLDAP', 'authldap_serveradr', 's:25:"xoidpro.educacio.intranet";'),
(401, 'AuthLDAP', 'authldap_basedn', 's:23:"cn=users,dc=xtec,dc=cat";'),
(402, 'AuthLDAP', 'authldap_bindas', 's:0:"";'),
(403, 'AuthLDAP', 'authldap_bindpass', 's:0:"";'),
(404, 'AuthLDAP', 'authldap_searchdn', 's:23:"cn=users,dc=xtec,dc=cat";'),
(405, 'AuthLDAP', 'authldap_searchattr', 's:2:"cn";'),
(406, 'AuthLDAP', 'authldap_protocol', 's:1:"3";'),
(407, 'AuthLDAP', 'authldap_pnldap', 'N;'),
(408, 'AuthLDAP', 'authldap_hash_method', 's:4:"none";'),
(409, '/EventHandlers', 'AuthLDAP', 'a:1:{i:0;a:3:{s:9:"eventname";s:28:"module.users.ui.login.failed";s:8:"callable";a:2:{i:0;s:18:"AuthLDAP_Listeners";i:1;s:19:"tryAuthLDAPListener";}s:6:"weight";i:10;}}'),
(410, 'XtecMailer', 'enabled', 's:1:"1";'),
(411, 'XtecMailer', 'idApp', 's:9:"PRESTATGE";'),
(412, 'XtecMailer', 'replyAddress', 's:16:"llibres@xtec.cat";'),
(413, 'XtecMailer', 'sender', 's:8:"educacio";'),
(414, 'XtecMailer', 'environment', 's:3:"INT";'),
(415, 'XtecMailer', 'contenttype', 's:1:"2";'),
(416, 'XtecMailer', 'log', 's:0:"";'),
(417, 'XtecMailer', 'debug', 's:0:"";'),
(418, 'XtecMailer', 'logpath', 's:0:"";'),
(419, '/EventHandlers', 'XtecMailer', 'a:1:{i:0;a:3:{s:9:"eventname";s:29:"module.mailer.api.sendmessage";s:8:"callable";a:2:{i:0;s:20:"XtecMailer_Listeners";i:1;s:8:"sendMail";}s:6:"weight";i:10;}}'),
(428, 'Users', 'gravatarimage', 's:12:"gravatar.gif";'),
(429, 'Users', 'login_displayapproval', 's:1:"0";'),
(430, 'Users', 'login_displaydelete', 'b:0;'),
(431, 'Users', 'login_displayinactive', 's:1:"0";'),
(432, 'Users', 'login_displayverify', 's:1:"0";'),
(433, 'Users', 'use_password_strength_meter', 's:1:"0";'),
(434, 'Users', 'moderation_order', 's:1:"0";'),
(435, 'Users', 'reg_autologin', 's:1:"0";'),
(436, 'Groups', 'primaryadmingroup', 'i:2;'),
(437, 'Categories', 'EntityCategorySubclasses', 'a:0:{}'),
(438, 'Theme', 'enable_mobile_theme', 'b:0;'),
(455, 'ZConfig', 'sessioncsrftokenonetime', 'i:0;'),
(496, 'ZConfig', 'pagetitle', 's:11:"%pagetitle%";'),
(470, '/EventHandlers', 'News', 'a:2:{i:0;a:3:{s:9:"eventname";s:19:"get.pending_content";s:8:"callable";a:2:{i:0;s:13:"News_Handlers";i:1;s:14:"pendingContent";}s:6:"weight";i:10;}i:1;a:3:{s:9:"eventname";s:23:"module.content.gettypes";s:8:"callable";a:2:{i:0;s:13:"News_Handlers";i:1;s:8:"getTypes";}s:6:"weight";i:10;}}'),
(477, 'systemplugin.imagine', 'presets', 'a:1:{s:7:"default";C:27:"SystemPlugin_Imagine_Preset":178:{x:i:2;a:7:{s:5:"width";i:100;s:6:"height";i:100;s:4:"mode";N;s:9:"extension";N;s:8:"__module";N;s:9:"__imagine";N;s:16:"__transformation";N;};m:a:1:{s:7:"\0*\0name";s:7:"default";}}}'),
(478, 'Scribite', 'nicedit_xhtml', 'i:1;'),
(479, 'Scribite', 'ckeditor_language', 's:2:"en";'),
(480, 'Scribite', 'ckeditor_barmode', 's:4:"Full";'),
(481, 'Scribite', 'ckeditor_maxheight', 's:3:"400";'),
(482, '/EventHandlers', 'Scribite', 'a:1:{i:0;a:3:{s:9:"eventname";s:13:"core.postinit";s:8:"callable";a:2:{i:0;s:18:"Scribite_Listeners";i:1;s:8:"coreinit";}s:6:"weight";i:10;}}'),
(483, 'Scribite', 'markitup_width', 's:3:"65%";'),
(484, 'Scribite', 'markitup_height', 's:5:"400px";'),
(488, 'Scribite', 'ckeditor_skin', 's:4:"kama";'),
(489, 'Theme', 'cache_lifetime_mods', 'i:0;'),
(490, 'Theme', 'render_compile_check', 'b:1;'),
(491, 'Theme', 'render_force_compile', 'b:0;'),
(492, 'Theme', 'render_cache', 'i:0;'),
(493, 'Theme', 'render_lifetime', 'i:0;'),
(494, 'Theme', 'render_expose_template', 'b:0;');

-- --------------------------------------------------------

--
-- Estructura de la taula `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `urltitle` varchar(255) DEFAULT NULL,
  `hometext` longtext NOT NULL,
  `bodytext` longtext NOT NULL,
  `counter` int(11) DEFAULT '0',
  `contributor` varchar(25) NOT NULL,
  `approver` int(11) DEFAULT '0',
  `notes` longtext NOT NULL,
  `displayonindex` tinyint(4) NOT NULL DEFAULT '0',
  `language` varchar(30) NOT NULL,
  `allowcomments` tinyint(4) NOT NULL DEFAULT '0',
  `format_type` tinyint(4) NOT NULL DEFAULT '0',
  `published_status` tinyint(4) DEFAULT '0',
  `ffrom` datetime DEFAULT NULL,
  `tto` datetime DEFAULT NULL,
  `weight` tinyint(4) DEFAULT '0',
  `pn_pictures` int(11) DEFAULT '0',
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  `pictures` int(11) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `news`
--

INSERT INTO `news` (`sid`, `title`, `urltitle`, `hometext`, `bodytext`, `counter`, `contributor`, `approver`, `notes`, `displayonindex`, `language`, `allowcomments`, `format_type`, `published_status`, `ffrom`, `tto`, `weight`, `pn_pictures`, `obj_status`, `cr_date`, `cr_uid`, `lu_date`, `lu_uid`, `pictures`) VALUES
(1, 'News introduction article', 'news_introduction_article', 'A news article is divided into an article teaser text (which is the lead-in text you are reading now) and an article body text (which you can view by clicking on the article''s title or the ''Read more'' link). The teaser will generally be a short introduction to the article, but if you plan to publish only very short bulletins, the teaser can contain the full draft and the article body can be left empty. Click on the article title for more information about Zikula''s News publisher module.', '<h3>More about the News module</h3>\r\n  <p>You are now reading the body text of the article (starting as from the ''More about the News module'' title above). Both the article teaser and the article body can contain URL links, images, mark-up (HTML tags and, if you have the additional necessary add-ons installed, other mark-up languages such as BBCode) You can learn more about the News module by reading the <a href="http://code.zikula.org/news/wiki#Documentation">News Wiki Documentation</a>.</p>\r\n  <h3>Some more details</h3>\r\n  <p><img src="modules/News/pnimages/admin.gif" width="48" height="48" class="z-floatleft" alt="News publisher admin image" />To control what HTML tags can be included in an article to format and enhance it, the site administrator should set the desired tags to enabled status by visiting the <a href="index.php?module=SecurityCenter&amp;type=admin&amp;func=allowedhtml">Security centre</a>. With the News module, you can take advantage of Zikula''s permissions system to control who gets what access to which parts of the News module. A moderator group can be created, containing registered site users who can add, edit and delete articles. This is just a simple example: the Zikula permissions system is sufficiently flexible to let you implement practically any organisation you want.</p>\r\n  <p>You can edit or delete this introductory article by clicking on the link beside the article title, or you can visit to the <a href="index.php?module=News&amp;type=admin&amp;func=view">News admin pages</a>.</p>', 12, 'admin', 0, '', 1, '', 0, 5, 0, '2011-09-13 14:48:16', NULL, 0, 0, 'A', '2011-09-13 14:48:16', 2, '2011-09-13 14:49:31', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `objectdata_attributes`
--

CREATE TABLE IF NOT EXISTS `objectdata_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(80) NOT NULL,
  `object_id` int(11) NOT NULL DEFAULT '0',
  `object_type` varchar(80) NOT NULL,
  `value` longtext NOT NULL,
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `object_type` (`object_type`),
  KEY `object_id` (`object_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Bolcant dades de la taula `objectdata_attributes`
--

INSERT INTO `objectdata_attributes` (`id`, `attribute_name`, `object_id`, `object_type`, `value`, `obj_status`, `cr_date`, `cr_uid`, `lu_date`, `lu_uid`) VALUES
(1, 'code', 5, 'categories_category', 'Y', 'A', '2009-11-20 11:14:56', 0, '2009-11-20 11:14:56', 0),
(2, 'code', 6, 'categories_category', 'N', 'A', '2009-11-20 11:14:56', 0, '2009-11-20 11:14:56', 0),
(3, 'code', 11, 'categories_category', 'P', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(4, 'code', 12, 'categories_category', 'C', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(5, 'code', 13, 'categories_category', 'A', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(6, 'code', 14, 'categories_category', 'O', 'A', '2009-11-20 11:14:57', 0, '2009-11-20 11:14:57', 0),
(7, 'code', 15, 'categories_category', 'R', 'A', '2009-11-20 11:14:58', 0, '2009-11-20 11:14:58', 0),
(8, 'code', 17, 'categories_category', 'M', 'A', '2009-11-20 11:14:58', 0, '2009-11-20 11:14:58', 0),
(9, 'code', 18, 'categories_category', 'F', 'A', '2009-11-20 11:14:58', 0, '2009-11-20 11:14:58', 0),
(10, 'code', 24, 'categories_category', 'A', 'A', '2009-11-20 11:15:01', 0, '2009-11-20 11:15:01', 0),
(11, 'code', 25, 'categories_category', 'I', 'A', '2009-11-20 11:15:02', 0, '2009-11-20 11:15:02', 0),
(12, 'code', 27, 'categories_category', 'P', 'A', '2009-11-20 11:15:03', 0, '2009-11-20 11:15:03', 0),
(13, 'code', 28, 'categories_category', 'A', 'A', '2009-11-20 11:15:03', 0, '2009-11-20 11:15:03', 0),
(14, 'code', 5, 'categories_category', 'Y', 'A', '2011-04-12 10:01:21', 0, '2011-04-12 10:01:21', 0),
(15, 'code', 6, 'categories_category', 'N', 'A', '2011-04-12 10:01:21', 0, '2011-04-12 10:01:21', 0),
(16, 'code', 11, 'categories_category', 'P', 'A', '2011-04-12 10:01:21', 0, '2011-04-12 10:01:21', 0),
(17, 'code', 12, 'categories_category', 'C', 'A', '2011-04-12 10:01:21', 0, '2011-04-12 10:01:21', 0),
(18, 'code', 13, 'categories_category', 'A', 'A', '2011-04-12 10:01:22', 0, '2011-04-12 10:01:22', 0),
(19, 'code', 14, 'categories_category', 'O', 'A', '2011-04-12 10:01:22', 0, '2011-04-12 10:01:22', 0),
(20, 'code', 15, 'categories_category', 'R', 'A', '2011-04-12 10:01:22', 0, '2011-04-12 10:01:22', 0),
(21, 'code', 17, 'categories_category', 'M', 'A', '2011-04-12 10:01:22', 0, '2011-04-12 10:01:22', 0),
(22, 'code', 18, 'categories_category', 'F', 'A', '2011-04-12 10:01:22', 0, '2011-04-12 10:01:22', 0),
(23, 'code', 24, 'categories_category', 'A', 'A', '2011-04-12 10:01:23', 0, '2011-04-12 10:01:23', 0),
(24, 'code', 25, 'categories_category', 'I', 'A', '2011-04-12 10:01:23', 0, '2011-04-12 10:01:23', 0),
(25, 'code', 27, 'categories_category', 'P', 'A', '2011-04-12 10:01:23', 0, '2011-04-12 10:01:23', 0),
(26, 'code', 28, 'categories_category', 'A', 'A', '2011-04-12 10:01:24', 0, '2011-04-12 10:01:24', 0),
(27, 'code', 5, 'categories_category', 'Y', 'A', '2011-04-12 10:01:26', 0, '2011-04-12 10:01:26', 0),
(28, 'code', 6, 'categories_category', 'N', 'A', '2011-04-12 10:01:26', 0, '2011-04-12 10:01:26', 0),
(29, 'code', 11, 'categories_category', 'P', 'A', '2011-04-12 10:01:26', 0, '2011-04-12 10:01:26', 0),
(30, 'code', 12, 'categories_category', 'C', 'A', '2011-04-12 10:01:26', 0, '2011-04-12 10:01:26', 0),
(31, 'code', 13, 'categories_category', 'A', 'A', '2011-04-12 10:01:26', 0, '2011-04-12 10:01:26', 0),
(32, 'code', 14, 'categories_category', 'O', 'A', '2011-04-12 10:01:27', 0, '2011-04-12 10:01:27', 0),
(33, 'code', 15, 'categories_category', 'R', 'A', '2011-04-12 10:01:27', 0, '2011-04-12 10:01:27', 0),
(34, 'code', 17, 'categories_category', 'M', 'A', '2011-04-12 10:01:27', 0, '2011-04-12 10:01:27', 0),
(35, 'code', 18, 'categories_category', 'F', 'A', '2011-04-12 10:01:27', 0, '2011-04-12 10:01:27', 0),
(36, 'code', 24, 'categories_category', 'A', 'A', '2011-04-12 10:01:28', 0, '2011-04-12 10:01:28', 0),
(37, 'code', 25, 'categories_category', 'I', 'A', '2011-04-12 10:01:28', 0, '2011-04-12 10:01:28', 0),
(38, 'code', 27, 'categories_category', 'P', 'A', '2011-04-12 10:01:28', 0, '2011-04-12 10:01:28', 0),
(39, 'code', 28, 'categories_category', 'A', 'A', '2011-04-12 10:01:28', 0, '2011-04-12 10:01:28', 0),
(40, '_Legal_termsOfUseAccepted', 5, 'users', '2014-01-10T11:40:20+0000', 'A', '2014-01-10 12:40:20', 2, '2014-01-10 12:40:20', 2),
(41, '_Legal_privacyPolicyAccepted', 5, 'users', '2014-01-10T11:40:20+0000', 'A', '2014-01-10 12:40:20', 2, '2014-01-10 12:40:20', 2),
(42, '_Legal_agePolicyConfirmed', 5, 'users', '2014-01-10T11:40:20+0000', 'A', '2014-01-10 12:40:20', 2, '2014-01-10 12:40:20', 2),
(52, '_Users_isVerified', 6, 'users', '0', 'A', '2015-04-24 13:29:21', 2, '2015-04-24 13:29:21', 2),
(53, '_Users_isVerified', 7, 'users', '0', 'A', '2015-04-24 13:30:46', 2, '2015-04-24 13:30:46', 2),
(54, '_Users_isVerified', 8, 'users', '0', 'A', '2015-04-24 13:31:20', 2, '2015-04-24 13:31:20', 2),
(55, '_Users_isVerified', 9, 'users', '0', 'A', '2015-04-24 13:31:59', 2, '2015-04-24 13:31:59', 2),
(56, '_Users_isVerified', 10, 'users', '0', 'A', '2015-04-24 13:40:02', 2, '2015-04-24 13:40:02', 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `objectdata_log`
--

CREATE TABLE IF NOT EXISTS `objectdata_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_type` varchar(80) NOT NULL DEFAULT '',
  `object_id` int(11) NOT NULL DEFAULT '0',
  `op` varchar(16) NOT NULL DEFAULT '',
  `diff` text,
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `objectdata_meta`
--

CREATE TABLE IF NOT EXISTS `objectdata_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(40) NOT NULL DEFAULT '',
  `tablename` varchar(40) NOT NULL DEFAULT '',
  `idcolumn` varchar(40) NOT NULL DEFAULT '',
  `obj_id` int(11) NOT NULL DEFAULT '0',
  `permissions` varchar(255) DEFAULT NULL,
  `dc_title` varchar(80) DEFAULT NULL,
  `dc_author` varchar(80) DEFAULT NULL,
  `dc_subject` varchar(255) DEFAULT NULL,
  `dc_keywords` varchar(128) DEFAULT NULL,
  `dc_description` varchar(255) DEFAULT NULL,
  `dc_publisher` varchar(128) DEFAULT NULL,
  `dc_contributor` varchar(128) DEFAULT NULL,
  `dc_startdate` datetime DEFAULT '1970-01-01 00:00:00',
  `dc_enddate` datetime DEFAULT '1970-01-01 00:00:00',
  `dc_type` varchar(128) DEFAULT NULL,
  `dc_format` varchar(128) DEFAULT NULL,
  `dc_uri` varchar(255) DEFAULT NULL,
  `dc_source` varchar(128) DEFAULT NULL,
  `dc_language` varchar(32) DEFAULT NULL,
  `dc_relation` varchar(255) DEFAULT NULL,
  `dc_coverage` varchar(64) DEFAULT NULL,
  `dc_entity` varchar(64) DEFAULT NULL,
  `dc_comment` varchar(255) DEFAULT NULL,
  `dc_extra` varchar(255) DEFAULT NULL,
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `pagelock`
--

CREATE TABLE IF NOT EXISTS `pagelock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `cdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `session` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `ipno` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `pagelock`
--

INSERT INTO `pagelock` (`id`, `name`, `cdate`, `edate`, `session`, `title`, `ipno`) VALUES
(1, 'Newsnews1', '2015-04-24 14:25:34', '2015-04-24 14:26:45', 'ki2mqh042558qpspr8sitiacfcuenv3m', 'admin', '192.168.33.1');

-- --------------------------------------------------------

--
-- Estructura de la taula `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageid` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext NOT NULL,
  `urltitle` longtext NOT NULL,
  `content` longtext NOT NULL,
  `counter` int(11) NOT NULL DEFAULT '0',
  `displaywrapper` tinyint(4) NOT NULL DEFAULT '1',
  `displaytitle` tinyint(4) NOT NULL DEFAULT '1',
  `displaycreated` tinyint(4) NOT NULL DEFAULT '1',
  `displayupdated` tinyint(4) NOT NULL DEFAULT '1',
  `displaytextinfo` tinyint(4) NOT NULL DEFAULT '1',
  `displayprint` tinyint(4) NOT NULL DEFAULT '1',
  `language` varchar(30) NOT NULL,
  `obj_status` varchar(1) NOT NULL DEFAULT 'A',
  `cr_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `cr_uid` int(11) NOT NULL DEFAULT '0',
  `lu_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `lu_uid` int(11) NOT NULL DEFAULT '0',
  `metadescription` longtext NOT NULL,
  `metakeywords` longtext NOT NULL,
  PRIMARY KEY (`pageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `pages`
--

INSERT INTO `pages` (`pageid`, `title`, `urltitle`, `content`, `counter`, `displaywrapper`, `displaytitle`, `displaycreated`, `displayupdated`, `displaytextinfo`, `displayprint`, `language`, `obj_status`, `cr_date`, `cr_uid`, `lu_date`, `lu_uid`, `metadescription`, `metakeywords`) VALUES
(1, 'Condicions d''ús del servei', 'Condicions-dus-del-servei', '<div class="page" style="font-family:Verdana, Arial, Helvetica, sans-serif; ">\r\n		<div class="mainTitle">Condicions d''ús de la prestatgeria digital</div>\r\n\r\n		<hr />\r\n		<p><strong>Finalitat del servei d''edició de llibres en línia de la XTEC</strong></p>\r\n		<p style="padding-left:20px;">La finalitat principal és posar a l’abast de la comunitat educativa depenent de l''administració catalana materials i procediments que, basats en les Tecnologies de la Informació i la Comunicació, contribueixin a facilitar, actualitzar i millorar les estratègies pedagògiques per la qual cosa proporciona gratuïtament l''esmentat servei d''edició de llibres en línia.</p>\r\n		\r\n		<p><strong>Paper d’intermediària de la XTEC</strong></p>\r\n		<p style="padding-left:20px;">Tenint en compte l’elevat nombre de llibres hostatjats, la XTEC no pot vetllar per l’ús correcte de tots i cadascun d’ells, ni en l’aspecte social ni en el didàctic ni en el lingüístic, tot i que confia que les direccions de centre a qui encomana aquest servei vetllaran perquè se''n faci un bon ús, ajustat al marc legal vigent a l''Estat espanyol, als costums i protocols establerts a Internet i a la finalitat pedagògica a què està destinat el servei.</p>\r\n		\r\n		<p><strong>Responsabilitat per continguts</strong></p>\r\n\r\n		<p style="padding-left:20px;">La direcció del centre, com a dipositària de la clau d’accés privada al servei, és responsable de les activitats didàctiques i continguts desenvolupats a través d''aquesta eina d''edició en línia.</p>\r\n		\r\n		<p><strong>Avís de continguts inadequats</strong></p>\r\n		<p style="padding-left:20px;">En cas que es produís qualsevol mena de vulneració de la legalitat vigent o de les condicions establertes en aquest mateix document per al servei, hi ha un formulari per comunicar-la. Un cop s''hagi procedit a comprovar les raons adduïdes, la XTEC modificarà o retirarà, si escau, els continguts inadequats, sense avís previ.</p>\r\n		\r\n		<p><strong>Durada del servei</strong></p>\r\n		<p style="padding-left:20px;">Un cop sol·licitat el servei per part de la direcció del centre, si no s''activa en un termini de 15 dies, es donarà de baixa. Així mateix, si en un termini de 6 mesos no hi ha hagut cap visita, es procedirà a la retirada del llibre. En ambdós casos, la retirada és automàtica, és a dir, sense avís previ.</p>\r\n		\r\n		<p><strong>Enllaços externs</strong></p>\r\n\r\n		<p style="padding-left:20px;">La XTEC no es fa responsable de la informació que es pugui obtenir a través d''enllaços a sistemes externs que no siguin dependents d''aquesta entitat. Tanmateix, us agrairem molt que ens notifiqueu qualsevol irregularitat que hi aprecieu per tal que puguem esmenar l’error de la manera que escaigui.</p>\r\n		\r\n		<p><strong>Propietat intel·lectual</strong></p>\r\n		<p style="padding-left:20px;">Els llibres en línia i tots els seus continguts, incloent-hi els textos, imatges, so i qualsevol altre material, són propietat del centre docent o de les terceres persones que n’hagin autoritzat l’ús dels continguts al centre docent en concret, l’autoria dels quals s''ha de fer constar a les pàgines corresponents. Atesa la finalitat educativa del servei, sotmetem tots aquests materials a una llicència de Creative Commons, que es reserva el dret de reconeixement de l’autoria i d’exigir que no se’n faci cap mena d’ús comercial. També obliga a compartir els materials emprats per a la construcció de noves obres sota la mateixa llicència.</p>\r\n		\r\n		<p><strong>Política de privadesa</strong></p>\r\n		<p style="padding-left:20px;">Les galetes, formularis o altres mitjans de naturalesa anàloga generades per la XTEC són eines destinades a fer més eficient el nostre servei. Les dades obtingudes no serviran per establir perfils que vulnerin el cercle de privadesa de les persones usuàries ni seran cedides per a usos comercials i/o publicitaris.</p>\r\n	</div>', 4816, 0, 0, 0, 0, 0, 0, '', 'A', '2009-11-21 17:39:53', 2, '2009-11-21 17:39:53', 2, '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `scribite`
--

CREATE TABLE IF NOT EXISTS `scribite` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `modname` varchar(64) NOT NULL DEFAULT '',
  `modfuncs` longtext NOT NULL,
  `modareas` longtext NOT NULL,
  `modeditor` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Bolcant dades de la taula `scribite`
--

INSERT INTO `scribite` (`mid`, `modname`, `modfuncs`, `modareas`, `modeditor`) VALUES
(1, 'About', 'a:1:{i:0;s:6:"modify";}', 'a:1:{i:0;s:10:"about_info";}', '-'),
(2, 'Admin_Messages', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:22:"admin_messages_content";}', '-'),
(3, 'Blocks', 'a:1:{i:0;s:6:"modify";}', 'a:1:{i:0;s:14:"blocks_content";}', '-'),
(4, 'Book', 'a:1:{i:0;s:3:"all";}', 'a:1:{i:0;s:7:"content";}', '-'),
(5, 'ContentExpress', 'a:3:{i:0;s:0:"";i:1;s:10:"newcontent";i:2;s:11:"editcontent";}', 'a:1:{i:0;s:4:"text";}', '-'),
(6, 'crpCalendar', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:22:"crpcalendar_event_text";}', '-'),
(7, 'crpVideo', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:13:"video_content";}', '-'),
(8, 'cotype', 'a:2:{i:0;s:3:"new";i:1;s:4:"edit";}', 'a:1:{i:0;s:4:"text";}', '-'),
(10, 'element', 'a:5:{i:0;s:11:"start_topic";i:1;s:9:"add_topic";i:2;s:10:"edit_topic";i:3;s:10:"view_topic";i:4;s:9:"edit_post";}', 'a:1:{i:0;s:4:"comm";}', '-'),
(11, 'eventia', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:26:"eventia_course_description";}', '-'),
(12, 'FAQ', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:9:"faqanswer";}', '-'),
(13, 'htmlpages', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:17:"htmlpages_content";}', '-'),
(14, 'Mailer', 'a:1:{i:0;s:10:"testconfig";}', 'a:1:{i:0;s:11:"mailer_body";}', '-'),
(15, 'mediashare', 'a:3:{i:0;s:8:"addmedia";i:1;s:8:"edititem";i:2;s:8:"addalbum";i:3;s:9:"editalbum";}', 'a:1:{i:0;s:3:"all";}', '-'),
(16, 'News', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:2:{i:0;s:13:"news_hometext";i:1;s:13:"news_bodytext";}', 'xinha'),
(17, 'Newsletter', 'a:1:{i:0;s:11:"add_message";}', 'a:1:{i:0;s:7:"message";}', '-'),
(18, 'PagEd', 'a:1:{i:0;s:3:"all";}', 'a:1:{i:0;s:5:"PagEd";}', '-'),
(19, 'Pages', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:13:"pages_content";}', '-'),
(20, 'pagesetter', 'a:1:{i:0;s:7:"pubedit";}', 'a:1:{i:0;s:3:"all";}', '-'),
(21, 'PhotoGallery', 'a:2:{i:0;s:11:"editgallery";i:1;s:9:"editphoto";}', 'a:1:{i:0;s:17:"photogallery_desc";}', '-'),
(22, 'pncommerce', 'a:1:{i:0;s:8:"itemedit";}', 'a:1:{i:0;s:15:"ItemDescription";}', '-'),
(23, 'pnForum', 'a:4:{i:0;s:9:"viewtopic";i:1;s:8:"newtopic";i:2;s:8:"editpost";i:3;s:5:"reply";}', 'a:1:{i:0;s:7:"message";}', '-'),
(24, 'pnhelp', 'a:1:{i:0;s:4:"edit";}', 'a:1:{i:0;s:4:"text";}', '-'),
(25, 'pnMessages', 'a:2:{i:0;s:5:"newpm";i:1;s:10:"replyinbox";}', 'a:1:{i:0;s:7:"message";}', '-'),
(26, 'pnWebLog', 'a:2:{i:0;s:10:"addposting";i:1;s:7:"addpage";}', 'a:1:{i:0;s:9:"xinhatext";}', '-'),
(27, 'Profile', 'a:1:{i:0;s:6:"modify";}', 'a:3:{i:0;s:14:"prop_signature";i:1;s:14:"prop_extrainfo";i:2;s:15:"prop_yinterests";}', '-'),
(28, 'PostCalendar', 'a:1:{i:0;s:3:"all";}', 'a:1:{i:0;s:11:"description";}', '-'),
(29, 'Reviews', 'a:2:{i:0;s:3:"new";i:1;s:6:"modify";}', 'a:1:{i:0;s:14:"reviews_review";}', '-'),
(30, 'ShoppingCart', 'a:1:{i:0;s:3:"all";}', 'a:1:{i:0;s:11:"description";}', '-'),
(31, 'tFAQ', 'a:2:{i:0;s:4:"view";i:1;s:6:"modify";}', 'a:1:{i:0;s:8:"tfanswer";}', '-'),
(32, 'Web_Links', 'a:3:{i:0;s:8:"linkview";i:1;s:7:"addlink";i:2;s:17:"modifylinkrequest";}', 'a:1:{i:0;s:11:"description";}', '-'),
(33, 'books', 'a:1:{i:0;s:3:"all";}', 'a:1:{i:0;s:3:"all";}', 'xinha');

-- --------------------------------------------------------

--
-- Estructura de la taula `sc_intrusion`
--

CREATE TABLE IF NOT EXISTS `sc_intrusion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `tag` varchar(40) DEFAULT NULL,
  `value` longtext NOT NULL,
  `page` longtext NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `ip` varchar(40) NOT NULL,
  `impact` int(11) NOT NULL DEFAULT '0',
  `filters` longtext NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `session_info`
--

CREATE TABLE IF NOT EXISTS `session_info` (
  `sessid` varchar(40) NOT NULL,
  `ipaddr` varchar(32) NOT NULL,
  `lastused` datetime DEFAULT '1970-01-01 00:00:00',
  `uid` int(11) DEFAULT '0',
  `remember` tinyint(4) NOT NULL DEFAULT '0',
  `vars` longtext NOT NULL,
  PRIMARY KEY (`sessid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcant dades de la taula `session_info`
--

INSERT INTO `session_info` (`sessid`, `ipaddr`, `lastused`, `uid`, `remember`, `vars`) VALUES
('opbolc2fl2adn1sg7pkmlkg2lh81f37n', 'b44aab0625ab749bf5a23cce99d45b6d', '2015-04-24 14:29:12', 0, 0, '/|a:3:{s:4:"rand";a:0:{}s:9:"useragent";s:40:"8dc5a42a4714d665ae50047ac272c03dd4c22fc9";s:3:"uid";i:0;}_zikula_messages|a:0:{}');

-- --------------------------------------------------------

--
-- Estructura de la taula `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `displayname` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `regid` int(11) NOT NULL DEFAULT '0',
  `directory` varchar(64) NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT '0',
  `official` tinyint(4) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `user` tinyint(4) NOT NULL DEFAULT '0',
  `system` tinyint(4) NOT NULL DEFAULT '0',
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `credits` varchar(255) NOT NULL,
  `changelog` varchar(255) NOT NULL,
  `help` varchar(255) NOT NULL,
  `license` varchar(255) NOT NULL,
  `xhtml` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Bolcant dades de la taula `themes`
--

INSERT INTO `themes` (`id`, `name`, `type`, `displayname`, `description`, `regid`, `directory`, `version`, `official`, `author`, `contact`, `admin`, `user`, `system`, `state`, `credits`, `changelog`, `help`, `license`, `xhtml`) VALUES
(2, 'Atom', 3, 'Àtom', 'Entorn visual auxiliar que genera pàgines en el format de sindicació Atom.', 0, 'Atom', '1.0', 0, 'Franz Skaaning', '', 0, 0, 1, 1, '', '', '', '', 0),
(9, 'Andreas08', 3, 'Andreas08', 'Based on the theme Andreas08 by Andreas Viklund and extended for Zikula with the CSS Framework ''fluid960gs''.', 0, 'Andreas08', '2.0', 0, '', '', 1, 1, 0, 1, '', '', '', '', 1),
(10, 'Mobile', 3, 'Mobile', 'The mobile theme is an auxiliary theme designed specially for outputting pages in a mobile-friendly format.', 0, 'Mobile', '1.0', 0, '', '', 0, 0, 1, 1, '', '', '', '', 1),
(4, 'Printer', 3, 'Impressora', 'L''entorn visual Printer és un entorn visual auxiliar dissenyat per mostrar les pàgines en un format adequat per a la impressió', 0, 'Printer', '2.0', 0, 'Mark West', '', 0, 0, 1, 1, '', '', '', '', 1),
(5, 'RSS', 3, 'RSS', 'The RSS theme is an auxiliary theme designed specially for outputting pages as an RSS feed.', 0, 'RSS', '1.0', 0, 'Mark West', '', 0, 0, 1, 1, 'docs/credits.txt', 'docs/changelog.txt', 'docs/help.txt', 'docs/license.txt', 0),
(8, 'Shelf', 3, 'Intraweb prestatgeria', 'Entorn visual desenvolupat per l''equip del projecte Intraweb', 0, 'Shelf', '1.0', 0, 'Toni Ginard & Albert Bachiller', 'toni.ginard@gmail.com', 1, 1, 1, 1, '', '', '', 'GNU/GPL', 1),
(11, 'SeaBreeze', 3, 'SeaBreeze', 'L''entorn visual SeaBreeze es va refer completament pel Zikula 1.0, amb nous colors i imatges.', 0, 'SeaBreeze', '3.2', 0, '', '', 0, 1, 0, 1, '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `userblocks`
--

CREATE TABLE IF NOT EXISTS `userblocks` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `bid` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `last_update` datetime DEFAULT NULL,
  KEY `bid_uid_idx` (`uid`,`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcant dades de la taula `userblocks`
--

INSERT INTO `userblocks` (`uid`, `bid`, `active`, `last_update`) VALUES
(2, 17, 1, '2011-04-06 13:14:28'),
(2, 12, 1, '2012-07-18 09:17:22'),
(2, 8, 1, '2012-07-18 09:20:09'),
(2, 9, 1, '2012-07-18 09:20:05'),
(2, 10, 1, '2012-07-18 09:25:36'),
(2, 16, 1, '2011-04-06 13:14:28'),
(4909, 8, 1, '2011-04-14 13:12:08'),
(4909, 9, 1, '2011-04-14 13:12:13'),
(4909, 10, 1, '2011-04-14 13:12:17'),
(5, 8, 1, '2012-10-09 10:31:34'),
(5, 9, 1, '2012-10-09 11:40:48'),
(5, 10, 0, '2011-04-13 11:37:50'),
(4909, 17, 1, '2011-09-15 12:04:58'),
(4909, 12, 0, '2011-09-15 12:04:58'),
(4909, 16, 1, '2011-09-15 12:04:58'),
(4910, 8, 0, '2012-06-15 14:41:13'),
(4910, 9, 0, '2012-06-15 14:41:13'),
(4910, 10, 0, '2012-06-15 14:41:13'),
(4911, 8, 0, '2012-07-18 09:32:28'),
(4911, 9, 0, '2012-07-18 09:32:28'),
(4911, 10, 0, '2012-07-18 09:32:28'),
(10, 12, 0, '2015-04-24 13:42:07'),
(10, 8, 0, '2015-04-24 13:42:07'),
(10, 9, 0, '2015-04-24 13:42:07'),
(10, 10, 0, '2015-04-24 13:42:07'),
(6, 12, 0, '2015-04-24 13:43:48'),
(6, 8, 0, '2015-04-24 13:43:48'),
(6, 9, 0, '2015-04-24 13:43:48'),
(6, 10, 0, '2015-04-24 13:43:48');

-- --------------------------------------------------------

--
-- Estructura de la taula `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(25) NOT NULL,
  `email` varchar(60) NOT NULL,
  `user_regdate` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `pass` varchar(138) NOT NULL,
  `ublockon` tinyint(4) NOT NULL DEFAULT '0',
  `ublock` longtext NOT NULL,
  `theme` varchar(255) NOT NULL,
  `activated` smallint(6) NOT NULL DEFAULT '0',
  `lastlogin` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `passreminder` varchar(255) NOT NULL,
  `approved_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `approved_by` int(11) NOT NULL DEFAULT '0',
  `tz` varchar(30) NOT NULL,
  `locale` varchar(5) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `uname` (`uname`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Bolcant dades de la taula `users`
--

INSERT INTO `users` (`uid`, `uname`, `email`, `user_regdate`, `pass`, `ublockon`, `ublock`, `theme`, `activated`, `lastlogin`, `passreminder`, `approved_date`, `approved_by`, `tz`, `locale`) VALUES
(2, 'admin', 'llibres@xtec.cat', '2009-11-20 11:15:53', '1$$6142bfd56a583d891f0b1dcdbb2a9ef8', 0, '', '', 1, '2015-04-24 12:24:13', '', '2009-11-20 11:15:53', 2, '', ''),
(5, 'llibres', 'llibres@xtec.cat', '2014-01-10 11:40:20', '1$$6142bfd56a583d891f0b1dcdbb2a9ef8', 0, '', '', 1, '1970-01-01 00:00:00', '', '2014-01-10 11:40:20', 2, '', ''),
(6, 'usu1', 'usu1@xtec.cat', '2015-04-24 11:29:21', '1$$6142bfd56a583d891f0b1dcdbb2a9ef8', 0, '', '', 1, '2015-04-24 11:43:48', '(Contrasenya facilitada per l''administrador/a del lloc web)', '2015-04-24 11:29:21', 2, '', ''),
(7, 'usu2', 'usu2@xtec.cat', '2015-04-24 11:30:46', '1$$6142bfd56a583d891f0b1dcdbb2a9ef8', 0, '', '', 1, '1970-01-01 00:00:00', '(Contrasenya facilitada per l''administrador/a del lloc web)', '2015-04-24 11:30:46', 2, '', ''),
(8, 'usu3', 'usu3@xtec.cat', '2015-04-24 11:31:20', '1$$6142bfd56a583d891f0b1dcdbb2a9ef8', 0, '', '', 1, '1970-01-01 00:00:00', '(Contrasenya facilitada per l''administrador/a del lloc web)', '2015-04-24 11:31:20', 2, '', ''),
(9, 'usu4', 'usu4@xtec.cat', '2015-04-24 11:31:59', '1$$6142bfd56a583d891f0b1dcdbb2a9ef8', 0, '', '', 1, '1970-01-01 00:00:00', '(Contrasenya facilitada per l''administrador/a del lloc web)', '2015-04-24 11:31:59', 2, '', ''),
(10, 'e3009369', 'e3009369@xtec.cat', '2015-04-24 11:40:02', '1$$6142bfd56a583d891f0b1dcdbb2a9ef8', 0, '', '', 1, '2015-04-24 11:42:07', '(Contrasenya facilitada per l''administrador/a del lloc web)', '2015-04-24 11:40:02', 2, '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `users_verifychg`
--

CREATE TABLE IF NOT EXISTS `users_verifychg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `changetype` tinyint(4) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `newemail` varchar(60) NOT NULL,
  `verifycode` varchar(138) NOT NULL,
  `created_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `workflows`
--

CREATE TABLE IF NOT EXISTS `workflows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metaid` int(11) NOT NULL DEFAULT '0',
  `module` varchar(255) NOT NULL DEFAULT '',
  `schemaname` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `type` smallint(6) NOT NULL DEFAULT '1',
  `obj_table` varchar(40) NOT NULL DEFAULT '',
  `obj_idcolumn` varchar(40) NOT NULL DEFAULT '',
  `obj_id` int(11) NOT NULL DEFAULT '0',
  `busy` int(11) NOT NULL DEFAULT '0',
  `debug` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
