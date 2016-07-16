-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: fdb13.runhosting.com
-- Generation Time: Jul 11, 2016 at 10:56 AM
-- Server version: 5.5.38-log
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2074371_testwp`
--
CREATE DATABASE IF NOT EXISTS `2074371_testwp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `2074371_testwp`;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` mediumint(9) NOT NULL,
  `u_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `time_create` time NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `u_id`, `content`, `date`, `time_create`, `title`) VALUES
(13, 5, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:18', 'Lorem Lorem'),
(14, 5, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:21', 'Lorem Lorem'),
(15, 3, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:22', 'Lorem Lorem'),
(16, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:23', 'Lorem Lorem'),
(17, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:24', 'Lorem Lorem'),
(18, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:25', 'Lorem Lorem'),
(19, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:26', 'Lorem Lorem'),
(20, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:27', 'Lorem Lorem'),
(21, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:28', 'Lorem Lorem'),
(22, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:29', 'Lorem Lorem'),
(23, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '03:58:30', 'Lorem Lorem'),
(24, 4, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2016-05-29', '04:13:56', 'Lorem Lorem');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `sort_order`, `status`) VALUES
(27, 'Мотоштаны', 40, 1),
(26, 'Мотокуртки', 30, 1),
(24, 'Шлемы', 10, 1),
(25, 'Мотоочки', 20, 1),
(28, 'Черепахи', 50, 1),
(29, 'Наколенники', 60, 1),
(30, 'Перчатки', 70, 1),
(31, 'Ботинки', 80, 1),
(32, 'Дождевики', 90, 1),
(33, 'Комбенизоны', 100, 1),
(34, 'Запчасти', 120, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `price` float NOT NULL,
  `availability` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_new` int(11) NOT NULL DEFAULT '0',
  `is_recommended` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `year` year(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `category_id`, `code`, `price`, `availability`, `brand`, `description`, `is_new`, `is_recommended`, `status`, `year`) VALUES
(162, 'Фара', 34, 120123, 200, 1, 'Китай', 'рафщшыгрвщшф', 0, 0, 1, NULL),
(160, 'AGVSPORT Storm', 24, 90002, 99, 1, 'Италия', 'Раздельный дождевой комбинезон Storm\r\n\r\nРаздельный водонепроницаемый дождевой комбинезон (куртка+брюки) с полиуретановым покрытием. Подкладка из полиэстера.\r\n2 внешних кармана.\r\nРегилируемый ремень на талии.\r\nСветоотражающий логотип.\r\nЛипучка на воротнике.', 0, 0, 1, NULL),
(161, 'AGVSPORT  Phantom', 24, 1000001, 427, 1, 'Италия', 'Кожаный слитный комбинезон Phantom черн/сер/бел\r\n\r\nКомбинезон всегда был и остается самой надежной спортивной мотоэкипировкой. За счёт плотного прилегания элементов защиты, прочной толстой кожи и цельного покроя обеспечивается самый высокий уровень защиты пилота.\r\nСпортивный цельный комбинезон AGVSPORT из коровьей кожи премиум-класса толщиной 1,1 мм и 1,3 мм в местах наибольшей уязвимости, устойчивой на разрыв и истирание.\r\nДышащая подкладка с сетчатой структурой из 100% полиэстера.\r\nВставки из перфорированной кожи на груди, спине, ногах и рукавах обеспечивают отличную вентиляцию.\r\nЭластичные текстильные вставки на рукавах, в паху и на задней части колена.\r\nСъемная CE защита в области предплечья, локтей и плечей и колен.\r\nДополнительная Titanium защита на плечах и коленях.\r\nСлайдеры из TPU (термопластичный полиуретан) на коленях.\r\nАэродинамический задний горб и защитная вставка спины.\r\nМягкая защита копчика.\r\nТройной шов с максимальной защитой на разрыв.\r\nВнутренний карман.\r\n', 0, 0, 1, NULL),
(159, 'IXS ORCA EVO', 32, 90001, 188, 1, 'Италия', 'Дождевой комбинезон ORCA EVO\r\n\r\nВодонепроницаемый дождевой комбинезон считается более надежной защитой от влаги, нежели раздельный, потому его часто используют в долгих туристических поездках.\r\nДождевик ORCA EVO изготовлен из материала 190T Nylon - очень легкого и водонепроницаемого нейлонового материала плотностью 70 ден.\r\nУдобная длинная молния с клапаном на липучке позоляет удобно надевать и снимать дождевик, не пропускает влагу внутрь.\r\nСветоотражающие элементы для пассивной безопасности в темное время суток.\r\nШирина манжет и штанин внизу регулируется ремешками на липучках.\r\nВоротник-стойка окантован мягким комфортным материалом.\r\nСетчатая подкладка в верхней части дождевика.', 0, 0, 1, NULL),
(158, 'FORMAFRECCIA', 31, 80004, 216, 1, 'Китай', 'Спортивные мотоботы FRECCIA бел/черн.\r\n\r\n-Синтетический материал\r\n- Аэродинамическая конструкция\r\n- Пластиковый тормоз в районе ахиллесова сухожилия\r\n- Дополнительное мягкое полимерное покрытие с памятью\r\n- Мягкая, дышащая, ячеистая антибактериальная подкладка\r\n- Гибкая двойная противоударная APS стелька\r\n- Литые сменные элементы пластиковой защиты\r\n- Пластмассовая сменная накладка для защиты голени снабжена вентиляционными отверстиями\r\n- Специальная легкая полимерная подушка в области икры и голени\r\n- Сменный стальной слайдер\r\n- Застежка на молнии, дополненная фиксатором на липучке\r\n- Прорезиненная накладка для облегчения переключения передач\r\n- Усиленная литая пластиковая защита пятки\r\n- Противоскользящая резиновая подошва', 0, 0, 1, NULL),
(157, 'JT PODIUM', 31, 80003, 239, 1, 'Китай', 'КРОССОВЫЕ МОТОБОТЫ JT PODIUM- Белые\r\n\r\nКроссовые мотоботы изготовлены из натуральной кожи и высококачественного синтетического материала.\r\nЛитые элементы пластиковой защиты.\r\nПрорезиненная PU тепловая защита тыльной стороны ботинка.\r\nЧетыре регулируемых ремешка для подгона по ноге.\r\nЗастежка на липучке вокруг голени.\r\nМягкое внутреннее полимерное покрытие с памятью принимает анатомическую форму и гарантирует идеальное облегание.\r\nВнутренняя и внешняя защита лодыжки.\r\nВнутренняя поверхность из микрофибры.\r\nСтальной стакан носка.\r\nСтальная накладка на носке крепящаяся на 5 винтах.\r\nМногослойная подошва TPR, с внутренней стороны состоит из материала, гасящего ударные нагрузки, имеет анатомическую форму.\r\nСоответствует сертификатам безопасности CE.', 0, 0, 1, NULL),
(156, 'AGVSPORT Renger', 24, 80002, 141, 1, 'Италия', 'Туристические мотоботинки Renger\r\n\r\nТуристические ботинки универсального применения изготовлены из кожи и текстиля CORDURA, это толстая нейлоновая ткань с особой структурой нити, с водоотталкивающей пропиткой и с полиуретановым покрытием.\r\nПодкладка 100% полиэстер.\r\nМягкие гофрированные вставки в местах сгиба увеличивающие комфорт.\r\nРезиновая противоскользящая подошва, которая не боится масла и бензина.\r\nДополнительная накладка для удобства переключения передач.\r\nЗастежка молния и липучка.\r\n', 0, 0, 1, NULL),
(155, 'FORMA IcePro', 31, 80001, 128, 1, 'Испания', 'Ботинки ICE PRO черные\r\n\r\nСпортивные мотоботы изготовлены из кожи и высококачественного синтетического материала PU (полиуретан), который по характеристикам не уступает натуральной коже, а по износостойкости превосходит её.\r\nАэродинамическая конструкция ботинок для удобства и легкости.\r\nПолноценная защита от скручивания F.C.S. (Flex Control System).\r\nЛитой пластиковый кожух крепится к стакану пятки шарниром, который разработан так, что никогда не поцарапает мотоцикл.\r\nНадежные пластиковые щитки для защиты голени и икры, дуга для защиты сухожилия сзади.\r\nПластиковый щиток в районе ахиллесова сухожилия имеет сменный сетчатый радиатор, выполняющий роль отвода воздуха.\r\nСменный двойной слайдер: верхний из магниевого сплава, нижний из пластика.\r\nЗастежка на молнии, дополненная двумя клапанами-фиксаторами на липучке.\r\nПрорезиненная накладка для облегчения переключения передач.\r\nСистема впуска воздуха A.I.S (Air Intake System) позволяет воздуху циркулировать, создавая отличную вентиляцию.\r\nРегулируемый эластичным ремнем подъем стопы.\r\nСпециальная легкая полимерная подушка в области икры и голени, которая гасит удар и приятно облегает ногу.\r\nПрорезиненная PU тепловая защита от двигателя.\r\nМягкая, дышащая, ячеистая антибактериальная подкладка обеспечивает достойную вентиляцию.\r\nПодкладка из мягкого материала Microfiber с дополнительным мягким полимерным покрытием с памятью принимает анатомическую форму и гарантирует идеальное облегание.\r\nАнтибактериальная, заменяемая стелька с полиуретановым покрытием и системой A.P.S. (Air Pump System) с верхним покрытием из микрофибры.\r\nВстроенные регулируемые каналы вентиляции.\r\nСвод стопы, укрепленный полиуретаном.\r\nПротивоскользящая резиновая подошва, которая не боится масла и бензина, ярко выраженный каблук для лучшего сцепления с подножкой.', 0, 0, 1, NULL),
(154, 'ONEAL MATRIX', 30, 70005, 25, 1, 'Китай', 'ПЕРЧАТКИ кроссовые MATRIX\r\n\r\nМатериал: 45% искусственная кожа, 40% нейлон, 15% полиэстер.\r\nСамые лёгкие и за счёт этого максимально комфортные перчатки от O''Neal со стильным дизайном.\r\nЛегко тянущиеся и эластичные материалы позволят подогнать перчатки идеально по размеру.\r\nМягкая искусственная кожа со стороны ладони с двойным слоем в изгибе большого пальца сделают очень приятным использование ваших перчаток.', 0, 0, 1, NULL),
(153, 'IXS NOVARA II', 30, 70004, 88, 1, 'Америка', 'Мото перчатки NOVARA II.\r\n\r\nПерчатки из козьей кожи\r\n\r\n- Лёгкая текстильная подкладка\r\n- Двойной слой кожи на мизинце\r\n- Защита "костяшек" из "карбона"\r\n- Двойной слой кожи с вентилиционными отверстиями на пальцах\r\n- Кожаная тыльная часть ладони\r\n- На запястье застежка Velcro\r\n\r\n- Внешний материал: 100% натуральная кожа; \r\n- Подкладка: 100% полиэстер;\r\nЗащита:50% карбон, 50% углерод.', 0, 0, 1, NULL),
(152, 'AGVSPORT Jet', 30, 70003, 33, 1, 'Италия', 'Мотоперчатки Jet\r\n\r\nКороткие спортивные перчатки из кожи с текстильными вставками идеальны для лета\r\nНа тыльной стороне руки и кончиках пальцев коровья кожа с высокой прочностью на разрыв и истирание\r\nЭластичный сетчатый текстиль между пальцев для комфорта и вентиляции,устойчив к истиранию\r\nСпециальный сетчатый материал на пальцах для лучшей вентиляции\r\nДополнительный слой из армированной ткани в местах наибольшей уязвимости\r\nПерчатки прошиты прочной нейлоновой нитью, двойным швом\r\nЗащита костяшек CARBON\r\nСлайдеры из TPR материала (термопластичная резина) на пальцах с воздухозаборниками\r\nВентиляционные отверстия на тыльной стороне руки\r\nАмортизирующая накладка в области запястья\r\nУдобная и надежная застежка-липучка\r\nСтильный фирменный дизайн.', 0, 0, 1, NULL),
(151, 'AGVSPORT  Silverstone', 30, 70002, 79, 1, 'Италия', 'Мотоперчатки кожаные Silverstone\r\n\r\nДлинные спортивные перчатки\r\nПерчатки сделаны из воловьей кожи с высокой прочностью на разрыв\r\nДополнительная защитная накладка из TPU (термопластичного полиуретана) на ладони\r\nПерфорированные кожаные группы на пальцах и с внешней стороны ладони для лучшей вентиляции\r\nВ местах максимального трения защитные накладки с двойным слоем кожи\r\nНа костяшках защита CARBON с дополнительным карманом вентиляции\r\nСиликоновые вставки на ладони и большом пальце для максимального сцепления\r\nДвойные швы с максимальной защитой на разрыв\r\nСпециальный армированный материал в местах наибольшей уязвимости\r\nПрочный эластичный текстиль между пальцев, устойчивый на истирание\r\nЭргономичный изгиб пальцев\r\nНа запястье удобная и надежная застежка-липучка\r\nМанжеты регулируются двойной широкой застежкой-липучкой, с внешней части которой защитные накладки\r\nДышащая подкладка из 100% полиэстера\r\nСтандарты безопасности EN 13594-2014', 0, 0, 1, NULL),
(150, 'AGVSPORT Monaco', 30, 70001, 67, 1, 'Италия', 'Мотоперчатки кожаные Monaco\r\n\r\nДлинные спортивные перчатки изготовлены из воловьей кожи с высокой прочностью на разрыв\r\nНа костяшках защита CARBON с дополнительным карманом вентиляции\r\nНакладки-слайдеры CARBON на пальцах\r\nЗащитные амортизирующие накладки на ладони, большом пальце и области запястья\r\nДвойной слой кожи в местах максимального трения\r\nНа боковой стороне ладони и мизинце армированный материал\r\nНа всех пальцах двойные швы с максимальной защитой на разрыв\r\nЭргономичный изгиб пальцев\r\nМанжеты регулируются двойной широкой застежкой-липучкой, с внешней части которой защитные накладки\r\nДышащая подкладка из 100% полиэстера\r\nСтандарты безопасности EN 13594-2014', 0, 0, 1, NULL),
(148, 'IXS X-Knee Protector GRANT', 29, 60002, 59, 1, 'Америка', 'Защита колен X-Knee Protector GRANT\r\n\r\nЗащита коленей X-Knee Protector GRANT \r\n- не стесняет движений\r\n- ударопрочный пластик\r\n- оптимальная вентиляция\r\n- эластичные регулируемые ремни', 0, 0, 1, NULL),
(149, 'ONEAL Pumpgun MX', 29, 60003, 50, 1, 'Китай', 'Защита колен Pumpgun MX\r\n\r\nШарнирные мотонаколенники.\r\nУдаропоглащающий литой пластик.\r\nБлагодаря шарнирной системе и эргономичному изгибу, защита повторяет структуру колена.\r\nПластиковая сетка для улучшения вентиляции.\r\nСистема липучек надежно фиксирует наколенник на ноге, не давая ему соскользнуть и провернуться.\r\nВнутренний слой из биопены обеспечивает плотное прилегание и комфорт.\r\nДля езды на мотоциклах, квадроциклах, снегоходах.', 0, 0, 1, NULL),
(147, 'AGVSPORT 003K', 29, 60001, 40, 1, 'Италия', 'Защита коленей 003K\r\n\r\nНаколенники из ударопоглощающего материала TPU (термопластичный полиуретан), устойчивого к истиранию, гарантируют защиту коленного сустава от травм, ушибов и переломов.\r\nМягкий амортизирующий слой с изнаночной стороны обеспечивает комфортное ношение наколенников.\r\nРегулируемые эластичные ремешки на липучке прочно и надежно фиксируют наколенник на ноге и не дают ему сползти.\r\nДышащий сетчатый материал и ячеистая структура элементов защиты обеспечивают отличную вентиляцию.\r\nНебольшой профиль наколенников позволяет надеть их под большинство мотоштанов.\r\nЛёгкий вес, идеальны для повседневного использования.', 0, 0, 1, NULL),
(146, 'ONEAL Underdog Protecto', 28, 50002, 89, 1, 'Китай', 'Черепаха Underdog Protecto черная\r\n\r\nЗащитная черепаха, сертифицированная по стандартам EN 1621.\r\nУдаропоглощающая защита на плечах, локтях, предплечьях, груди и спины; также дополнительные пластиковые вставки на плечах и локтях.\r\nЗащита спины съемная, сертифицирована по стндартам EN 1621-2, обеспечивая лучшую защиту от ударов.\r\nОснова черепахи изготовлена из прочной синтетической сетки, устойчивой к истиранию и разрывам, прекрасно держащей форму.\r\nШирокий фиксирующий пояс с надежной липучкой.\r\nВсе элементы защиты оборудованы регулировочными ремнями и позволяют точно подогнать размер, надежно фиксируя защиту на теле.\r\nМягкие элементы защиты имеют ячеистую конструкцию для лучшей вентиляции, амортизации и непревзойденного комфорта.\r\nДополнительное мягкое покрытие на ключицах, лопатках и плечевой кости.\r\nМодель совместима с защитой шеи, позволяя носить её с комфортом.', 0, 0, 1, NULL),
(145, 'Черепаха AGVSPORT', 28, 50001, 95, 1, 'Италия', 'Черепаха трансформер флуоресцентно желтая\r\n\r\nМультифункциональная черепаха-трансформер разработана байкерами для байкеров.\r\nЗащитные элементы черепахи выполнены из ударопоглощающего сверхпрочного материала TPU (термопластичный полиуретан) с перфорированной структурой, и гарантируют лучшую защиту и вентиляцию;\r\nЗа счёт анатомической формы защитные элементы плотно прилегают к телу, ремни-утяжки позволяют зафиксировать защиту, не давая ей провернуться при ударе;\r\nПлечи, локти и грудная клетка регулируются по объему ремешками, что позволяет подогнать черепаху точно под свой размер;\r\nТекстильная основа выполнена из специального сетчатого синтетического материала, который отлично держит форму, устойчив на разрыв и истирание и не растягивается при ношении;\r\nВнутренняя сторона элементов защиты выполнена из мягкого амортизирующего материала, что делает ношение черепахи комфортным. Уникальная разработка этой черепахи заключается в ее многофункциональности:\r\n1. Это полноценная черепаха с максимальной степенью защиты, снабженная карманом для телефона.\r\n2. Благодаря съемным рукавам, эту черепаху можно использовать в качестве жилетки и надевать с мотоциклетной курткой не вытаскивая из куртки защиту локтей и плеч.\r\n3. Отстегнув спину от черепахи, Вы можете использовать ее как обычную защиту спины.\r\n4. Спина состоит из двух частей и если Вы их разъедините, то получите два предмета, поясничный пояс и короткую спину.\r\nИ кроме того, приобретая эту черепаху, Вы одновременно приобретаете 5 предметов: Черепаха, жилетка, защита спины, короткая защита спины и поясничный пояс. Выгода налицо, и проблемы с защитой закрываются всего с одной покупкой.', 0, 0, 1, NULL),
(144, 'IXS Namib ll', 27, 40004, 100, 1, 'Америка', 'Текстильные летние штаны Namib ll\r\n\r\nСезон :\r\nЛето\r\nМембрана :\r\nНет\r\nТекстильные штаны из устойчивого к разрыву и истиранию полиэстера 500D AIRGUARD и полиамида 3D Airmesh;\r\nСетчатая подкладка из Полиамида\r\nВоздухопроницаемая вставка в паховой зоне брюк\r\n1 карман на талии\r\n2 вентиляционных кармана на молнии на штанинах и 1 вентиляционный карман на молнии на пояснице\r\nМожно дополнить внутренними штанами с водонепроницаемой мембраной (Thar X65990-LIN) (продаются отдельно)\r\nМатериалы:\r\nвнешний: 100% Полиамид; 3D Mesh = 100% Полиэстер\r\nподкладка: 100% Полиамид', 0, 0, 1, NULL),
(142, 'IXS SKAR GORE-TEX', 27, 40002, 338, 1, 'Америка', 'Кожаные штаны SKAR с мембраной GORE-TEX', 0, 0, 1, NULL),
(143, 'AGVSPORT  BELAY', 27, 40003, 192, 1, 'Италия', 'Мотоциклетные штаны BELAY\r\n\r\nСезон :\r\nОсень, Лето, Весна\r\nМембрана :\r\nЕсть\r\nВсесезонные туристические текстильные мотоштаны с мембраной и тепловой подстежкой;\r\nШтаны изготовлены из полиэстера MAXTEX 600D, устойчивого на разрыв и истирание;\r\nИнтегрированная подкладка REISSA - современный материал с воздухопроницаемой и водонепроницаемой мембраной.. Эта мембрана сделана из специализированного гидрофильного полиуретана, который обладает высокой проводимостью пара - отводит тепло и пот от человека - "дышащий материал" и водонепроницаемый;\r\nСъемная стеганая подкладка на молнии с утеплителем Thermolite, который обладает высокими теплоизолирующими свойствами за счет полого строения нитей. Материал прекрасно транспортирует влагу на верхние слои ткани, сохраняя тело сухим. Thermolite - это волокно, не теряющее своих свойств даже во влажном состоянии;\r\nСъёмная сертифицированная защита колен и дополнительные вставки из пеноматериала в области бедер обеспечивают высокий уровень защиты;\r\nПлиссированные вставки на коленях и на пояснице обеспечивают максимально плотное и удобное прилегание и комфорт во время движения;\r\nДва водонепроницаемых кармана на молнии спереди, один карман сбоку на липучке;\r\nДва кармана вентиляции спереди и один сзади обеспечивают отличную циркуляцию воздуха;\r\nРемни с липучками на талии позволяют подогнать штаны точно по фигуре;\r\nПрорезиненная вставка из искусственной кожи в области посадки предотвращает скольжение и протирание ткани;\r\nСветоотражающие элементы для пассивной безопасности в темное время суток;\r\nМолнии внизу штанин позволяют легко надеть штаны поверх мотобот;\r\nМолния на пояснице для соединения с курткой предотвращает перекручивание одежды при падении, а также защищает поясницу от ветра;\r\nЭти штаны достаточно универсальны, их можно носить в любую погоду, пристегивая и отстегивая теплую подкладку.', 0, 0, 1, NULL),
(141, 'AGVSPORT Willow', 27, 40001, 136, 1, 'Италия', 'Мотоциклетные кожаные штаны Willow\r\n\r\nСпортивные кожаные штаны, несомненно, считаются лучше текстильных по защитным качествам и долговечности. Шьются они из толстой кожи, которая стирается намного меньше текстиля, под дождем дольше остаются сухими и сохраняют тепло, имеют защитные вставки в области колен, голени и бёдер и слайдеры из ударопрочных материалов. Кожаные штаны - идеальный выбор для тех, кто любит скорость и ценит в экипировке прежде всего надежность.\r\nМотоштаны WILLOW изготовлены из воловьей матовой кожи толщиной 1.2мм и 1.4 мм в местах наибольшей уязвимости;\r\nВставки TERAMID KEVLAR в области паха;\r\nСетчатая дышащая подкладка из 100% полиэстера способствует циркуляции воздуха;\r\nШвы выполнены двойной строчкой с максимальной прочностью на разрыв;\r\nСъемная сертифицированная защита колена и голени, сменные слайдеры в области колена из ударопоглощающего материала TPU (термопластичный полиуретан) и мягкие вставки из пеноматериала в области бедер и копчика гарантируют высшую степень защиты;\r\nДля максимально комфортной посадки по фигуре предусмотрены плиссированные кожаные вставки внизу штанин, в области колен и на талии;\r\nЭргономичный изгиб штанин и удобный покрой на сидящую фигуру для езды с комфортом;\r\nНадежные и удобные молнии YKK с самофиксацией, ремни на липучках на талии;\r\nНа пояснице расположена молния с ответной частью для соединения с курткой позволяет избежать проворачивания куртки при падении, а также защищают поясницу от ветра.', 0, 0, 1, NULL),
(140, 'AGVSPORT Topanga', 26, 30005, 187, 1, 'Италия', 'Куртка кожаная Topanga синяя\r\n\r\n- Натуральная кожа;\r\n- В местах максимального трения двойной слой кожи;\r\n- Съемная защита в области плеч, локтей и спины;\r\n- Мягкая защита на спине из пеноматериала обеспечивает плотное прилегание и принимает анатомическую форму;\r\n- Специальный более мягкие материалы используются в области шеи, для максимального комфорта;\r\n- Эргономичный изгиб рукавов;\r\n- Укрепленные швы с максимальной защитой на разрыв;\r\n- 2 внешних кармана и 3 внутренних (один специальный медиа-карман разделенный на две секции (телефон и плеер), с отверстием для провода наушников и липучкой крепления проводов.);\r\n- Антибактериальная сетчатая подкладка;\r\n- Большие вентиляционные карманы в области плеч и по бокам.', 0, 0, 1, NULL),
(139, 'AGVSPORT Dragon', 26, 30004, 272, 1, 'Италия', 'Мотоциклетная кожаная куртка Dragon черная\r\n\r\nМотокуртки из натуральной кожи гарантируют большую степень защиты, нежели текстильные, так как шьются из толстой кожи, которая меньше стирается и рвется в случае падений. Такие куртки хороши для прохладной погоды, так как имеют низкую теплопроводность;\r\nКуртка DRAGON изготовлена из воловьей матовой кожи премиум-класса толщиной 1.2мм и 1.4 мм в местах наибольшей уязвимости с очень высокой прочностью на разрыв и истирание;\r\nСетчатая дышащая подкладка из 100% полиэстера и съёмный стеганый жилет-утеплитель на молнии;\r\nСъемная сертифицированная защита в области плеч, локтей и спины, мягкая защита на спине из пеноматериала толщиной 6 мм обеспечивает плотное прилегание и принимает анатомическую форму;\r\nУдобный крой и эргономичный изгиб рукавов обеспечивают оптимальный комфорт во время езды;\r\nУкрепленные швы с максимальной защитой на разрыв;\r\nНа талии резинка из гофрированной кожи для более плотного облегания;\r\nКуртка снабжена двумя карманами на молнии снаружи и и тремя внутренними ( 2 в подкладке, 1 на съемном жилете);\r\n2 кармана вентиляции спереди в области груди и 2 сзади в области подмышек для лучшей циркуляции воздуха;\r\nНадежная молния с липучками сверху и снизу, рукава также застегиваются на молнию и липучку. Воротник окантован мягким неопреном для комфорта и ветрозащиты;\r\nНа пояснице две молнии с ответной частью для пристёгивания куртки, длинная и короткая.', 0, 0, 1, NULL),
(138, 'ICON ASSOCIATE', 26, 30001, 311, 1, 'Китай', 'Жилет ASSOCIATE\r\n\r\nФирменное спортивное облегание от Icon – сложный крой по фигуре без ограничения свободы движений.\r\nРазмер жилета рассчитан на ношение поверх куртки.\r\nБразильская воловья кожа превосходного качества толщиной 1,1-1,3 мм.\r\nМеханически эластичные вставки на боках для идеальногооблегания по фигуре.\r\nЧерненые застежки-молнии со звеньями увеличенного размера, с язычками.\r\nСтратегически размещенные фрагменты из перфорированной лазером кожи для хорошей вентиляции.\r\nДекоративные вставки на плечах, кожаные, стеганые.\r\nДоступ к задней вставке на молниях, применяется для присоединения накладок.\r\nСъемная СЕ-сертифицированная защита спины из биогубки двойной плотности D30® Viper Back Protecto.', 0, 0, 1, NULL),
(137, 'IXS Curtis', 24, 30002, 199, 1, 'Америка', 'Кожаная куртка Curtis черно-красная\r\n\r\nМужская мотокуртка из высококачественной бычьей кожи наппа.\r\nДышащяя подкладка выполнена из смеси хлопка и полиестера.\r\nПо бокам плиссированные вставки, благодаря которым обеспечивается плотное прилегание.\r\nВоротник-стойка на кнопке.\r\nПять внешних карманов и три внутренних.\r\nЗащитные вставки GLADIATOR на плечах и локтях соответствуют стандартам безопасности и имеют сертификат EN1621-1.\r\nЗащита спины соответствует стандартам безопасности EN1621-2.\r\nВинтажный дизайн.\r\nМатериал:\r\nВерх: 100% кожа наппа\r\nПодкладка: 80% полиэстер, 20% хлопок\r\nТепловая Подкладка: 100% полиэстер', 0, 0, 1, NULL),
(135, 'PW', 25, 20004, 42, 1, 'Америка', 'Очки ретро чоппер\r\n\r\nСтекло с антизапотевающим покрытием\r\nЗащита от солнца UV400', 0, 0, 1, NULL),
(136, 'AGVSPORT Tracer', 26, 30003, 212, 1, 'Италия', 'Кожаная мото куртка Tracer\r\n\r\nКуртка Tracer сшита из толстой воловьей кожи толщиной 1.2 мм с очень высокой прочностью на разрыв и истирание. Хорошо подойдет для прохладной погоды, так как имеет низкую теплопроводность.\r\nУдобный крой и эргономичный изгиб рукавов обеспечивают оптимальный комфорт во время езды.\r\nСетчатая подкладка из 100% полиэстера.\r\nСъемная термоподкладка-жилетка с карманом.\r\nУкрепленные швы с максимальной защитой на разрыв.\r\nСъемная сертифицированная защита в области плеч, локтей.\r\nМягкая защита на спине из пеноматериала толщиной 10 мм обеспечивает плотное прилегание и принимает анатомическую форму.\r\nКуртка снабжена тремя карманами на молнии снаружи и тремя внутренними.\r\nЗастежка-молния с кнопкой на воротнике-стойке и на рукавах.\r\nВоротник-стойка с мягким неопреном с внутренней стороны обеспечивает плотное прилегание и хорошую ветрозащиту.\r\nРегулировочные ремни на талии.\r\nСтилизована под обычную куртку.', 0, 0, 1, NULL),
(134, 'Bobster Shield II', 25, 20003, 56, 1, 'Новая Зеландия', 'Цвет оправы чёрный, глянцевый.\r\nПенные уплотнители служат для максимально комфортного прилегания к лицу.\r\nЛинзы из прочного поликарбоната имеют 100%-ую защиту от UV-лучей.\r\nВ комплект входит чехол-салфетка из микроволокна.\r\n', 0, 0, 1, NULL),
(131, 'IXS  HX 297 ROUTE ', 24, 10009, 122, 1, 'Америка', 'Шлем для мотокросса HX 297 ROUTE с визором белый\r\n\r\nМатериал :\r\nПоликарбонат\r\nШторка :\r\nЕсть\r\nЗастежка :\r\nБугельная\r\nЦвет шлема:\r\nБелый\r\nШлем изготовлен из поликарбоната\r\nОдин из главных плюсов шлема - наличие визора;\r\nВизор из поликарбоната устойчив к царапинам;\r\nМногоканальная вентиляция в области подбородка и лба;\r\nРегулируемый и съемный козырек;\r\nСъемная моющаяся подкладка из гипоалергенных материалов; \r\nВстроенный солнцезащитный визор;\r\nСоответствует стандартам безопасности ECE\r\nВес шлема 1600+/-50гр.', 0, 0, 1, NULL),
(130, 'JT ALS1.0', 24, 10008, 99, 1, 'Индия', 'Шлем кроссовый ALS1.0 фиолетовый\r\n\r\nМатериал :\r\nПоликарбонат\r\nШлем изготовлен из поликарбоната\r\nЛегкий вес и аэродинамичная конструкция шлема позволяет носить его более длительное время\r\nУдобная быстросъемная конструкция креплений козырька\r\nДвухкомпонентный наполнитель EPS способствует лучшему поглощению ударных воздействий.\r\nВнутренний слой имеет вентиляционные каналы для более эффективного воздухообмена\r\nМягкая и комфортная, гигиенически обработанная подкладка легко снимается и моется\r\nСистема совместимости с защитой шеи\r\nРазвитая система вентиляции с очисткой воздуха\r\nУдобный дефлектор дыхания\r\nПрорезиненная прокладка для лучшего прилегания кроссовой маски\r\nСтильный фирменный дизайн\r\nСоответствует и превосходит стандарты безопасности DOT и ECE\r\nВес 1300+/-50 гр.', 0, 0, 1, NULL),
(132, 'Bobster ANTIFOG ANSI Z87', 25, 20001, 32, 1, 'Австралия', 'Очки Charger чёрные с дымчатыми линзами ANTIFOG ANSI Z87\r\n\r\nСолнцезащитные очки для езды на мотоцикле, лучшее сочетание безопасности и стиля.\r\nПрочная нейлоновая глянцевая оправа.\r\nЛинзы из поликарбоната с противотуманным покрытием ANTIFOG.\r\nОчки сертифицированы по стандартам ANSI Z87.\r\nОчки с данным уровнем защиты могут использоваться в качестве экипировки в военизированных играх \r\nи соревнованиях (страйкбол, пейнтбол, спортивная стрельба),\r\nв скоростных видах спорта (вело- и мотоспорт, водные и горные лыжи, парашютизм и т.д.), \r\nв экстремальных видах спорта, а также на промышленных объектах и стройках.\r\n100% защита от ультрафиолетовых лучей.\r\nШирина от дужки до дужки 129мм, высота оправы 42мм.', 0, 0, 1, NULL),
(129, 'ONEAL  10Series FLOW', 24, 10007, 231, 1, 'Англия', 'Кроссовый шлем 10Series FLOW красно-синий\r\n\r\nМатериал :\r\nПоликарбонат\r\nЦвет шлема:\r\nРазноцветный\r\nШлем для мотокросса изготовлен из поликарбоната.\r\nПодкладка анатомической формы, съемная, моющаяся, изготовлена из высококачественного гипоаллергенного материала, приятного на ощупь.\r\nРазвитые каналы вентиляции в зоне подбородка и затылка для максимального воздухообмена.\r\nПротестирован в аэродинамической трубе, имеет небольшой вес и низкое сопротивление на больших скоростях.\r\nМаксимально безопасный и комфортный, обладает отличной обзорностью.\r\nШирокая нижняя часть создает дополнительную защиту шеи.\r\nЗастежка: двойное D-образное кольцо.\r\nСоответствует и превосходит стандарты DOT и ECE 22.05.\r\nМасса: 1150 г.', 0, 0, 1, NULL),
(133, 'Ariete Vintage', 25, 20002, 37, 1, 'Англия', 'Очки-маска Vintage черные\r\n\r\nИтальянские винтажные очки ручной работы.\r\nРама выполнена из хромированной стали с боковой вентиляцией.\r\nВнутренняя поверхность каркаса из натуральной кожи.\r\nВнешняя поверхность из замши обеспечивает повышенную герметизацию.\r\nЦилиндрические линзы с защитой от ультрафиолетовых лучей и противотуманным покрытием ANTIFOG.\r\nУдобный эластичный ремешок с силиконовыми полосками позволяет очкам плотно держаться на шлеме, не сползая.', 0, 0, 1, NULL),
(127, 'IXS  HX333 STROKE', 24, 10005, 172, 1, 'Америка', 'Шлем модуляр HX333 STROKE желто-черный\r\n\r\nМатериал :\r\nПоликарбонат\r\nШторка :\r\nЕсть\r\nЗастежка :\r\nБугельная\r\nЦвет шлема:\r\nЖелтый\r\nШлем модуляр изготовлен из термопластика.\r\nСъемная моющаяся подкладка из высококачественного материала, гипоаллергенная, антибактериальная, анатомической формы.\r\nВстроенный солнцезащитный визор с удобной и надежной системой подъема.\r\nПротестирован в аэродинамической трубе, обладает повышенной шумоизоляцией.\r\nМаксимально безопасный и комфортный, соответствует и превосходит стандарты безопасности ECE 22.05.\r\nВизор прозрачный, устойчивый к царапинам (anti-scratch), с покрытием ANTIFOG.\r\nЯркий стильный дизайн.\r\nДвойная омологация P/J.\r\nВес 1550 г.', 0, 0, 1, NULL),
(126, 'Airoh MATHISSE RS X SPORT', 24, 10004, 145, 1, 'Италия', 'Шлем модуляр MATHISSE RS X SPORT\r\n\r\nМатериал :\r\nПоликарбонат\r\nШторка :\r\nЕсть\r\nЗастежка :\r\nБугельная\r\nЦвет шлема:\r\nЧёрный\r\nШлем модуляр изготовлен из термопластика.\r\nСъемная моющаяся подкладка из высококачественного материала, гипоаллергенная, антибактериальная, анатомической формы.\r\nВстроенный солнцезащитный визор с удобной и надежной системой подъема.\r\nПротестирован в аэродинамической трубе, обладает повышенной шумоизоляцией.\r\nМаксимально безопасный и комфортный, соответствует и превосходит стандарты безопасности ECE 22.05.\r\nВизор прозрачный, устойчивый к царапинам (anti-scratch), подготовлен к PINLOCK.\r\nСтойкое матовое покрытие.\r\nДвойная омологация P/J.\r\nВес 1500 г.', 0, 0, 1, NULL),
(125, 'XTR FFE1 Hazard Graphic', 24, 10003, 115, 1, 'Китай', 'Шлем интеграл FFE1 Hazard Graphic синий\r\n\r\nМатериал :\r\nТермопластик\r\nШторка :\r\nНет\r\nЗастежка :\r\nБугельная\r\nЦвет шлема:\r\nСиний\r\nШлем интеграл аэродинамической формы изготовлен из термопластика.\r\nДва размера внешней оболочки и внутреннего ударопоглощающего слоя EPS.\r\nEPS-вставка в зоне подбородка делает шлем еще более безопасным.\r\nОснащен дефлектором дыхания для защиты от запотевания визора.\r\nСистема вентиляции регулирует потоки воздуха благодаря входным отверстиям в зоне подбородка и лба, а так же задними отводными отверстиями в воздушном спойлере, что обеспечивает отличную циркуляцию воздуха.\r\nКлапаны системы вентиляции прорезинены , что облегчает и ускоряет процесс использования.\r\nСъёмная, моющаяся подкладка анатомической формы выполнена из качественных гипоаллергенных материалов, приятных на ощупь.\r\nПрозрачный визор легко снимается и меняется.\r\nШлем подготовлен для установки гарнитуры.\r\nМикрометрическая пряжка обеспечивает дополнительную безопасность, позволяя быстро снимать шлем и более точно подогнать его под размер головы.\r\nМаксимально безопасный и комфортный, соответствует стандартам безопасности DOT и ECE.\r\nСтильный яркий дизайн.\r\nВес 1399 г.', 0, 0, 1, NULL),
(124, 'IXS HX 215 Zenium', 24, 10002, 143.8, 1, 'Америка', 'Шлем интеграл HX 215 Zenium бело-серый\r\n\r\nМатериал :\r\nПоликарбонат\r\nШторка :\r\nЕсть\r\nЗастежка :\r\nБугельная\r\nЦвет шлема:\r\nБелый\r\nШлем интеграл аэродинамической формы изготовлен из поликарбоната.\r\nИмеет регулируемую вентиляцию в зоне лба и подбородка.\r\nОснащен дефлектором дыхания для защиты от запотевания визора.\r\nПрозрачный визор из поликарбоната, устойчив к царапинам, легко снимается. Подготовлен под PINLOCK\r\nВстроенное солнцезащитное стекло имеет очень удобную систему, которая расположена в доступном месте и позволит вам открывать-закрывать его даже если вы в перчатках.\r\nВнутренний ударопоглощающий слой из EPS.\r\nПодкладка легко снимается и моется, съемные щеки анатомической формы из хорошо вентилируемого сетчатого материала.\r\nПокрытие по технологии NMT, устойчивое к механическим повреждениям.', 0, 0, 1, NULL),
(123, 'Airoh Aster - X', 24, 10001, 81, 1, 'Италия', 'Шлем Интеграл ASTER-X REP.DOVIZIOSO\r\n\r\nМатериал :\r\nТермопластик\r\nШторка :\r\nНет\r\nЗастежка :\r\nБугельная\r\nЦвет шлема:\r\nРазноцветный\r\nОблегченный шлем-интеграл изготовлен из термопластика.\r\nАнатомическая структура подкладки делает ношение шлема комфортным, подкладка легко снимается и моется.\r\nКаналы вентиляции в зоне лба и подбородка обеспечивают отличный воздухообмен во время движения.\r\nШлем протестирован в аэродинамической трубе, обладает высокой шумоизоляцией и обтекаемой формой, что создает наименьшее сопротивление при поездке и не перегружает шею.\r\nПрозрачный визор, устойчивый к царапинам (anti-scratch) легко снимается и меняется.\r\nСоответствует стандартам безопасности CE 22.05;\r\nВес 1400 г.', 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_comment` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `products` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`id`, `user_name`, `user_phone`, `user_comment`, `user_id`, `date`, `products`, `status`) VALUES
(65, 'Иван', '89992070896', 'Доставка в ближайшее время', 16, '2016-06-28 09:03:19', '{"125":1,"134":1,"140":1,"143":1,"152":1,"158":1,"159":1}', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`) VALUES
(3, 'Александр', 'alex@mail.com', '111111', ''),
(4, 'Виктор Зинченко', 'zinchenko.us@gmail.com', '222222', 'admin'),
(5, 'Сергей', 'serg@mail.com', '111111', ''),
(6, 'Вова', 'eer@wsdw.co', '111111', ''),
(7, 'Ivan', 'koko@ko.ko', '3333333', ''),
(8, 'Fedorov Ivan', 'lorem@lorem.com', 'Bzawow9z', 'admin'),
(9, 'Dodo', 'lorem@lorem.com3', '111111', ''),
(10, 'новый юзер', 'go@go.com', '111111', ''),
(11, 'Ivan', 'Ivan@mail.ru', '12345678', ''),
(12, 'Limon', 'Limon@limon.com', 'LimonLimon', ''),
(13, 'Фёдоров Иван', 'Fedorov@Ivan.com', 'Fedorov', ''),
(14, 'Наталья', 'Natalya@mail.ru', '12345678', ''),
(15, 'Наталья', 'Natalya1@mail.ru', '12345678', ''),
(16, 'Иван', 'Fedorov.Ivan@gmail.com', '123456789', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;
--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
