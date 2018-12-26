/*
Navicat MySQL Data Transfer

Source Server         : UnaiCaribbean
Source Server Version : 50555
Source Host           : 37.252.96.44:3306
Source Database       : dbcaribbean

Target Server Type    : MYSQL
Target Server Version : 50555
File Encoding         : 65001

Date: 2018-05-27 21:15:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ajuste
-- ----------------------------
DROP TABLE IF EXISTS `ajuste`;
CREATE TABLE `ajuste` (
  `idajuste` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dias` tinyint(2) unsigned NOT NULL COMMENT 'Cantidad de dias que permaneceran las cuentas y fotos de los clientes en el sistema',
  PRIMARY KEY (`idajuste`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of ajuste
-- ----------------------------
INSERT INTO `ajuste` VALUES ('1', '21');

-- ----------------------------
-- Table structure for archivo
-- ----------------------------
DROP TABLE IF EXISTS `archivo`;
CREATE TABLE `archivo` (
  `idarchivo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) unsigned NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `size` double NOT NULL COMMENT 'tamaño del archivo en bytes',
  `fecha_subida` datetime NOT NULL,
  `descargado` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1: SI; 2:No',
  `fecha_descarga` datetime DEFAULT NULL,
  `es_bonificacion` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1: Si; 2:No',
  `tipo_archivo` tinyint(4) DEFAULT '1' COMMENT '1: fotografia; 2:video',
  `estado_arc` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: activo; 0: anulado',
  PRIMARY KEY (`idarchivo`),
  KEY `fk_archivo_cliente_1` (`idcliente`),
  CONSTRAINT `fk_archivo_cliente_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2633 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of archivo
-- ----------------------------
INSERT INTO `archivo` VALUES ('2420', '104', 'O1234-12.jpg', '0', '2018-05-05 03:36:09', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2421', '105', 'P1234-11.jpg', '0', '2018-05-05 03:36:10', '1', '2018-05-07 15:25:01', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2422', '106', 'Q1234-07.jpg', '0', '2018-05-05 03:36:10', '1', '2018-05-06 22:20:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2423', '105', 'P1234-03.jpg', '0', '2018-05-05 03:36:10', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2424', '104', 'O1234-19.jpg', '0', '2018-05-05 03:36:11', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2425', '104', 'O1234-13.jpg', '0', '2018-05-05 03:36:11', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2426', '105', 'XYZ123-16.jpg', '0', '2018-05-05 03:36:12', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2427', '106', 'as123-17.jpg', '0', '2018-05-05 03:36:12', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2428', '104', 'O1234-15.jpg', '0', '2018-05-05 03:36:13', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2429', '105', 'P1234-15.jpg', '0', '2018-05-05 03:36:13', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2430', '105', 'XYZ123-01.jpg', '0', '2018-05-05 03:36:13', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2431', '105', 'P1234-17.jpg', '0', '2018-05-05 03:36:14', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2432', '104', 'O1234-17.jpg', '0', '2018-05-05 03:36:14', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2433', '105', 'XYZ123-13.jpg', '0', '2018-05-05 03:36:15', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2434', '104', 'O1234-11.jpg', '0', '2018-05-05 03:36:15', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2435', '105', 'P1234-24.jpg', '0', '2018-05-05 03:36:15', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2436', '106', 'Q1234-32.jpg', '0', '2018-05-05 03:36:16', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2437', '106', 'as123-20.jpg', '0', '2018-05-05 03:36:16', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2438', '106', 'Q1234-10.jpg', '0', '2018-05-05 03:36:16', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2439', '106', 'Q1234-27.jpg', '0', '2018-05-05 03:36:17', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2440', '105', 'P1234-29.jpg', '0', '2018-05-05 03:36:17', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2441', '105', 'P1234-25.jpg', '0', '2018-05-05 03:36:17', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2442', '105', 'XYZ111-06.jpg', '0', '2018-05-05 03:36:18', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2443', '105', 'XYZ111-07.jpg', '0', '2018-05-05 03:36:19', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2444', '105', 'P1234-28.jpg', '0', '2018-05-05 03:36:19', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2445', '106', 'Q1234-03.jpg', '0', '2018-05-05 03:36:19', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2446', '106', 'as111-20.jpg', '0', '2018-05-05 03:36:20', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2447', '105', 'XYZ123-02.jpg', '0', '2018-05-05 03:36:21', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2448', '105', 'P1234-10.jpg', '0', '2018-05-05 03:36:21', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2449', '105', 'P1234-13.jpg', '0', '2018-05-05 03:36:21', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2450', '105', 'XYZ123-06.jpg', '0', '2018-05-05 03:36:22', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2451', '106', 'as111-17.jpg', '0', '2018-05-05 03:36:23', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2452', '104', 'O1234-18.jpg', '0', '2018-05-05 03:36:23', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2453', '105', 'XYZ111-02.jpg', '0', '2018-05-05 03:36:24', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2454', '106', 'Q1234-18.jpg', '0', '2018-05-05 03:36:24', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2455', '106', 'Q1234-04.jpg', '0', '2018-05-05 03:36:24', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2456', '106', 'as111-05.jpg', '0', '2018-05-05 03:36:25', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2457', '105', 'XYZ222-07.jpg', '0', '2018-05-05 03:36:25', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2458', '106', 'Q1234-26.jpg', '0', '2018-05-05 03:36:25', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2459', '106', 'as123-02.jpg', '0', '2018-05-05 03:36:26', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2460', '106', 'as123-03.jpg', '0', '2018-05-05 03:36:26', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2461', '106', 'as111-10.jpg', '0', '2018-05-05 03:36:27', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2462', '106', 'Q1234-34.jpg', '0', '2018-05-05 03:36:27', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2463', '105', 'P1234-06.jpg', '0', '2018-05-05 03:36:27', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2464', '106', 'as111-01.jpg', '0', '2018-05-05 03:36:28', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2465', '104', 'O1234-07.jpg', '0', '2018-05-05 03:36:29', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2466', '105', 'XYZ222-12.jpg', '0', '2018-05-05 03:36:29', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2467', '105', 'XYZ222-03.jpg', '0', '2018-05-05 03:36:30', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2468', '105', 'XYZ111-10.jpg', '0', '2018-05-05 03:36:30', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2469', '105', 'P1234-21.jpg', '0', '2018-05-05 03:36:31', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2470', '105', 'XYZ123-04.jpg', '0', '2018-05-05 03:36:31', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2471', '106', 'Q1234-31.jpg', '0', '2018-05-05 03:36:31', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2472', '105', 'XYZ123-09.jpg', '0', '2018-05-05 03:36:32', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2473', '105', 'XYZ111-12.jpg', '0', '2018-05-05 03:36:32', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2474', '106', 'as123-05.jpg', '0', '2018-05-05 03:36:33', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2475', '105', 'XYZ111-05.jpg', '0', '2018-05-05 03:36:33', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2476', '105', 'XYZ111-11.jpg', '0', '2018-05-05 03:36:34', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2477', '105', 'P1234-30.jpg', '0', '2018-05-05 03:36:34', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2478', '106', 'Q1234-12.jpg', '0', '2018-05-05 03:36:34', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2479', '106', 'as123-14.jpg', '0', '2018-05-05 03:36:35', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2480', '105', 'XYZ222-13.jpg', '0', '2018-05-05 03:36:35', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2481', '106', 'as111-07.jpg', '0', '2018-05-05 03:36:36', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2482', '105', 'P1234-07.jpg', '0', '2018-05-05 03:36:36', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2483', '106', 'as111-12.jpg', '0', '2018-05-05 03:36:37', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2484', '105', 'XYZ111-13.jpg', '0', '2018-05-05 03:36:37', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2485', '105', 'P1234-19.jpg', '0', '2018-05-05 03:36:37', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2486', '105', 'P1234-14.jpg', '0', '2018-05-05 03:36:38', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2487', '106', 'Q1234-30.jpg', '0', '2018-05-05 03:36:38', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2488', '105', 'XYZ123-12.jpg', '0', '2018-05-05 03:36:38', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2489', '105', 'XYZ111-16.jpg', '0', '2018-05-05 03:36:39', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2490', '106', 'Q1234-01.jpg', '0', '2018-05-05 03:36:39', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2491', '106', 'Q1234-21.jpg', '0', '2018-05-05 03:36:39', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2492', '106', 'Q1234-06.jpg', '0', '2018-05-05 03:36:40', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2493', '106', 'Q1234-25.jpg', '0', '2018-05-05 03:36:40', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2494', '105', 'XYZ123-11.jpg', '0', '2018-05-05 03:36:41', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2495', '104', 'O1234-08.jpg', '0', '2018-05-05 03:36:41', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2496', '106', 'as123-13.jpg', '0', '2018-05-05 03:36:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2497', '106', 'as123-15.jpg', '0', '2018-05-05 03:36:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2498', '105', 'XYZ111-09.jpg', '0', '2018-05-05 03:36:43', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2499', '104', 'O1234-10.jpg', '0', '2018-05-05 03:36:43', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2500', '105', 'P1234-20.jpg', '0', '2018-05-05 03:36:44', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2501', '106', 'Q1234-11.jpg', '0', '2018-05-05 03:36:44', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2502', '106', 'as111-11.jpg', '0', '2018-05-05 03:36:44', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2503', '105', 'XYZ123-08.jpg', '0', '2018-05-05 03:36:45', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2504', '105', 'XYZ123-07.jpg', '0', '2018-05-05 03:36:46', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2505', '106', 'as123-08.jpg', '0', '2018-05-05 03:36:46', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2506', '106', 'as111-14.jpg', '0', '2018-05-05 03:36:47', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2507', '104', 'O1234-04.jpg', '0', '2018-05-05 03:36:47', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2508', '104', 'O1234-03.jpg', '0', '2018-05-05 03:36:48', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2509', '105', 'XYZ222-02.jpg', '0', '2018-05-05 03:36:48', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2510', '105', 'P1234-33.jpg', '0', '2018-05-05 03:36:48', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2511', '104', 'O1234-09.jpg', '0', '2018-05-05 03:36:49', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2512', '106', 'as111-19.jpg', '0', '2018-05-05 03:36:50', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2513', '105', 'XYZ222-10.jpg', '0', '2018-05-05 03:36:50', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2514', '106', 'as123-06.jpg', '0', '2018-05-05 03:36:51', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2515', '105', 'XYZ123-03.jpg', '0', '2018-05-05 03:36:51', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2516', '105', 'XYZ222-09.jpg', '0', '2018-05-05 03:36:52', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2517', '106', 'Q1234-09.jpg', '0', '2018-05-05 03:36:52', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2518', '106', 'as123-12.jpg', '0', '2018-05-05 03:36:52', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2519', '105', 'P1234-01.jpg', '0', '2018-05-05 03:36:53', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2520', '105', 'P1234-32.jpg', '0', '2018-05-05 03:36:53', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2521', '106', 'as111-18.jpg', '0', '2018-05-05 03:36:53', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2522', '105', 'XYZ222-06.jpg', '0', '2018-05-05 03:36:54', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2523', '106', 'as111-02.jpg', '0', '2018-05-05 03:36:55', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2524', '106', 'Q1234-20.jpg', '0', '2018-05-05 03:36:55', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2525', '105', 'P1234-34.jpg', '0', '2018-05-05 03:36:55', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2526', '106', 'Q1234-22.jpg', '0', '2018-05-05 03:36:55', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2527', '105', 'P1234-22.jpg', '0', '2018-05-05 03:36:56', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2528', '106', 'as111-03.jpg', '0', '2018-05-05 03:36:56', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2529', '104', 'O1234-05.jpg', '0', '2018-05-05 03:36:57', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2530', '104', 'O1234-06.jpg', '0', '2018-05-05 03:36:57', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2531', '106', 'Q1234-14.jpg', '0', '2018-05-05 03:36:58', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2532', '105', 'XYZ222-15.jpg', '0', '2018-05-05 03:36:58', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2533', '106', 'as123-04.jpg', '0', '2018-05-05 03:36:59', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2534', '106', 'as123-10.jpg', '0', '2018-05-05 03:37:00', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2535', '106', 'Q1234-15.jpg', '0', '2018-05-05 03:37:00', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2536', '105', 'XYZ123-15.jpg', '0', '2018-05-05 03:37:00', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2537', '106', 'as111-09.jpg', '0', '2018-05-05 03:37:01', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2538', '106', 'Q1234-19.jpg', '0', '2018-05-05 03:37:01', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2539', '106', 'Q1234-24.jpg', '0', '2018-05-05 03:37:01', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2540', '105', 'P1234-02.jpg', '0', '2018-05-05 03:37:02', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2541', '105', 'P1234-16.jpg', '0', '2018-05-05 03:37:02', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2542', '106', 'as111-15.jpg', '0', '2018-05-05 03:37:02', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2543', '106', 'Q1234-23.jpg', '0', '2018-05-05 03:37:03', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2544', '105', 'P1234-18.jpg', '0', '2018-05-05 03:37:03', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2545', '105', 'XYZ111-18.jpg', '0', '2018-05-05 03:37:03', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2546', '105', 'XYZ123-14.jpg', '0', '2018-05-05 03:37:04', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2547', '105', 'XYZ111-08.jpg', '0', '2018-05-05 03:37:04', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2548', '106', 'Q1234-05.jpg', '0', '2018-05-05 03:37:05', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2549', '105', 'XYZ222-04.jpg', '0', '2018-05-05 03:37:05', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2550', '106', 'as123-09.jpg', '0', '2018-05-05 03:37:06', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2551', '105', 'P1234-26.jpg', '0', '2018-05-05 03:37:06', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2552', '106', 'Q1234-02.jpg', '0', '2018-05-05 03:37:06', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2553', '105', 'XYZ111-19.jpg', '0', '2018-05-05 03:37:07', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2554', '106', 'Q1234-16.jpg', '0', '2018-05-05 03:37:07', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2555', '105', 'P1234-12.jpg', '0', '2018-05-05 03:37:07', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2556', '104', 'O1234-16.jpg', '0', '2018-05-05 03:37:08', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2557', '105', 'P1234-04.jpg', '0', '2018-05-05 03:37:08', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2558', '104', 'O1234-01.jpg', '0', '2018-05-05 03:37:08', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2559', '106', 'as123-01.jpg', '0', '2018-05-05 03:37:09', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2560', '106', 'as123-19.jpg', '0', '2018-05-05 03:37:09', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2561', '105', 'XYZ111-01.jpg', '0', '2018-05-05 03:37:10', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2562', '105', 'P1234-09.jpg', '0', '2018-05-05 03:37:10', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2563', '105', 'P1234-08.jpg', '0', '2018-05-05 03:37:10', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2564', '105', 'P1234-35.jpg', '0', '2018-05-05 03:37:10', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2565', '106', 'as123-11.jpg', '0', '2018-05-05 03:37:11', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2566', '105', 'P1234-05.jpg', '0', '2018-05-05 03:37:11', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2567', '106', 'as111-08.jpg', '0', '2018-05-05 03:37:12', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2568', '105', 'P1234-31.jpg', '0', '2018-05-05 03:37:12', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2569', '106', 'as111-04.jpg', '0', '2018-05-05 03:37:12', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2570', '106', 'as111-16.jpg', '0', '2018-05-05 03:37:13', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2571', '105', 'XYZ111-14.jpg', '0', '2018-05-05 03:37:13', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2572', '105', 'XYZ111-15.jpg', '0', '2018-05-05 03:37:14', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2573', '104', 'O1234-14.jpg', '0', '2018-05-05 03:37:14', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2574', '106', 'Q1234-13.jpg', '0', '2018-05-05 03:37:15', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2575', '105', 'XYZ222-01.jpg', '0', '2018-05-05 03:37:15', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2576', '106', 'as123-18.jpg', '0', '2018-05-05 03:37:16', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2577', '105', 'XYZ111-20.jpg', '0', '2018-05-05 03:37:16', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2578', '104', 'O1234-02.jpg', '0', '2018-05-05 03:37:17', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2579', '104', 'O1234-20.jpg', '0', '2018-05-05 03:37:17', '1', '2018-05-05 14:27:11', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2580', '105', 'P1234-27.jpg', '0', '2018-05-05 03:37:17', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2581', '105', 'XYZ111-17.jpg', '0', '2018-05-05 03:37:18', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2582', '105', 'P1234-23.jpg', '0', '2018-05-05 03:37:18', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2583', '105', 'XYZ222-05.jpg', '0', '2018-05-05 03:37:19', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2584', '105', 'XYZ222-14.jpg', '0', '2018-05-05 03:37:19', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2585', '105', 'XYZ111-04.jpg', '0', '2018-05-05 03:37:20', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2586', '105', 'XYZ222-11.jpg', '0', '2018-05-05 03:37:20', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2587', '106', 'as111-13.jpg', '0', '2018-05-05 03:37:21', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2588', '106', 'Q1234-28.jpg', '0', '2018-05-05 03:37:21', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2589', '106', 'Q1234-08.jpg', '0', '2018-05-05 03:37:21', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2590', '106', 'Q1234-29.jpg', '0', '2018-05-05 03:37:21', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2591', '105', 'XYZ123-10.jpg', '0', '2018-05-05 03:37:22', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2592', '105', 'XYZ111-03.jpg', '0', '2018-05-05 03:37:23', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2593', '106', 'as123-16.jpg', '0', '2018-05-05 03:37:23', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2594', '106', 'as111-06.jpg', '0', '2018-05-05 03:37:24', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2595', '106', 'Q1234-17.jpg', '0', '2018-05-05 03:37:24', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2596', '105', 'XYZ123-05.jpg', '0', '2018-05-05 03:37:24', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2597', '106', 'Q1234-35.jpg', '0', '2018-05-05 03:37:25', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2598', '106', 'Q1234-33.jpg', '0', '2018-05-05 03:37:25', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2599', '105', 'XYZ222-08.jpg', '0', '2018-05-05 03:37:25', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2600', '106', 'as123-07.jpg', '0', '2018-05-05 03:37:26', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2601', '109', 'Z1234-05.jpg', '0', '2018-05-06 22:46:57', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2602', '107', 'X1234-06.jpg', '0', '2018-05-06 22:46:58', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2603', '108', 'Y1234-05.jpg', '0', '2018-05-06 22:46:58', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2604', '108', 'Y1234-02.jpg', '0', '2018-05-06 22:46:59', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2605', '108', 'Y1234-06.jpg', '0', '2018-05-06 22:46:59', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2606', '107', 'X1234-01.jpg', '0', '2018-05-06 22:47:00', '1', '2018-05-07 00:16:50', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2607', '109', 'Z1234-04.jpg', '0', '2018-05-06 22:47:00', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2608', '107', 'X1234-03.jpg', '0', '2018-05-06 22:47:01', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2609', '109', 'Z1234-03.jpg', '0', '2018-05-06 22:47:01', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2610', '107', 'X1234-02.jpg', '0', '2018-05-06 22:47:02', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2611', '107', 'X1234-05.jpg', '0', '2018-05-06 22:47:02', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2612', '108', 'Y1234-04.jpg', '0', '2018-05-06 22:47:03', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2613', '107', 'X1234-04.jpg', '0', '2018-05-06 22:47:03', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2614', '109', 'Z1234-02.jpg', '0', '2018-05-06 22:47:04', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2615', '108', 'Y1234-03.jpg', '0', '2018-05-06 22:47:04', '1', '2018-05-07 15:38:19', '2', '1', '1');
INSERT INTO `archivo` VALUES ('2616', '109', 'Z1234-01.jpg', '0', '2018-05-06 22:47:05', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2617', '108', 'Y1234-01.jpg', '0', '2018-05-06 22:47:05', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2618', '113', 'PAGAPO-1105070002.jpg', '75118', '2018-05-07 16:00:41', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2619', '112', 'TACANO-1105070002.jpg', '75118', '2018-05-07 16:00:41', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2620', '112', 'TACANO-1105070003.jpg', '78980', '2018-05-07 16:00:41', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2621', '112', 'TACANO-1105070004.jpg', '81119', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2622', '112', 'TACANO-1105070005.jpg', '87923', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2623', '112', 'TACANO-1105070001.jpg', '82568', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2624', '113', 'PAGAPO-1105070006.jpg', '53665', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2625', '113', 'PAGAPO-1105070003.jpg', '78980', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2626', '113', 'PAGAPO-1105070004.jpg', '81119', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2627', '112', 'TACANO-1105070006.jpg', '53665', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2628', '112', 'TACANO-1105070007.jpg', '193061', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2629', '113', 'PAGAPO-1105070001.jpg', '82568', '2018-05-07 16:00:42', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2630', '113', 'PAGAPO-1105070005.jpg', '87923', '2018-05-07 16:00:43', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2631', '113', 'PAGAPO-1105070007.jpg', '193061', '2018-05-07 16:00:43', '2', null, '2', '1', '1');
INSERT INTO `archivo` VALUES ('2632', '113', 'Album-02.jpg', '786771', '2018-05-17 21:07:43', '2', null, '2', '1', '0');

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `idbanner` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idtipobanner` int(11) unsigned NOT NULL,
  `idseccion` int(11) unsigned NOT NULL,
  `titulo_ba` varchar(255) DEFAULT NULL,
  `imagen_ba` varchar(255) NOT NULL,
  `idusuario` int(11) unsigned NOT NULL,
  `createdat` datetime NOT NULL,
  `updatedat` datetime NOT NULL,
  `size` double NOT NULL COMMENT 'tamaño en bytes',
  `tipo_imagen` varchar(255) NOT NULL COMMENT 'png, jpg, gif',
  `estado_ba` tinyint(1) NOT NULL DEFAULT '1',
  `acepta_texto` char(2) DEFAULT 'SI' COMMENT 'SI: si acepta texto dinamico sobre slider\r\nNO: no acepta texto dinamico sobre slider',
  `bg_position` varchar(255) DEFAULT 'center center' COMMENT 'center top;\r\ncenter center;\r\ncenter bottom;\r\nleft top;\r\nleft center;\r\nleft bottom;\r\nright top;\r\nright center;\r\nright bottom;',
  `data_offset_start` varchar(255) DEFAULT NULL,
  `data_offset_end` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idbanner`),
  KEY `fk_banner_tipo_banner_1` (`idtipobanner`) USING BTREE,
  KEY `fk_banner_seccion_1` (`idseccion`) USING BTREE,
  CONSTRAINT `fk_banner_seccion_1` FOREIGN KEY (`idseccion`) REFERENCES `seccion` (`idseccion`),
  CONSTRAINT `fk_banner_tipo_banner_1` FOREIGN KEY (`idtipobanner`) REFERENCES `tipo_banner` (`idtipobanner`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('4', '1', '1', 'CARIBBEAN PHOTO STUDIO', 'bannerbodad-20170826215302.jpg', '2', '2017-08-06 05:09:34', '2017-11-21 19:01:10', '99016', 'image/jpeg', '0', 'NO', 'center center', '-150 100', '150 100');
INSERT INTO `banner` VALUES ('5', '1', '1', 'MEMORIES MADE TOGETHER', '1550x800-1-20170814113105.jpg', '2', '2017-08-14 11:31:05', '2017-11-21 19:01:07', '276361', 'image/jpeg', '0', 'NO', 'center center', '250 -100', '-250 100');
INSERT INTO `banner` VALUES ('6', '1', '1', 'EVENTOS', 'IMG_2458-20171121204349.jpg', '2', '2017-08-27 13:29:03', '2017-11-21 20:43:49', '978821', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('7', '1', '1', null, 'Ivette-44-20171121184943.jpg', '2', '2017-11-21 18:49:43', '2017-11-21 20:43:40', '6132212', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('8', '1', '1', '2', 'IMG_2428-20171121204316.jpg', '2', '2017-11-21 19:02:11', '2017-11-21 20:43:37', '576794', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('9', '1', '1', null, 'IMG_2453-20171121190450.jpg', '2', '2017-11-21 19:04:50', '2017-11-21 19:09:29', '12648786', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('10', '1', '1', 'SDFHG', 'IMG_2453-20171121190535.jpg', '2', '2017-11-21 19:05:35', '2017-11-21 19:09:30', '12648786', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('11', '1', '1', 'SDFHG', 'IMG_2453-20171121190620.jpg', '2', '2017-11-21 19:06:20', '2017-11-21 19:09:30', '12648786', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('12', '1', '1', 'SDFHG', 'IMG_2453-20171121190703.jpg', '2', '2017-11-21 19:07:03', '2017-11-21 19:09:31', '12648786', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('13', '1', '1', 'SDFHG', 'IMG_2453-20171121190754.jpg', '2', '2017-11-21 19:07:54', '2017-11-21 19:10:00', '12648786', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('14', '1', '1', 'SDFHG', 'IMG_2453-20171121204401.jpg', '2', '2017-11-21 19:08:36', '2017-11-21 20:44:01', '2673004', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('15', '1', '1', null, 'P1500271-20171121204621.jpg', '2', '2017-11-21 20:46:21', '2017-11-21 20:47:25', '2320562', 'image/jpeg', '0', 'SI', 'center center', null, null);
INSERT INTO `banner` VALUES ('16', '1', '1', null, 'P1500271-20171121204658.jpg', '2', '2017-11-21 20:46:58', '2017-11-21 20:47:28', '2320562', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('17', '1', '1', null, '004-20171229154519.jpg', '2', '2017-11-21 20:47:09', '2018-02-26 23:38:07', '220269', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('18', '1', '1', null, 'IMG_2463-20171121204831.jpg', '2', '2017-11-21 20:48:31', '2017-11-21 20:53:43', '2306779', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('19', '1', '1', null, 'MGEG5200-20171121205040.jpg', '2', '2017-11-21 20:50:40', '2017-11-21 20:53:38', '1496608', 'image/jpeg', '0', 'SI', 'center center', null, null);
INSERT INTO `banner` VALUES ('20', '1', '1', null, '002-20171229153604.jpg', '2', '2017-11-21 20:53:27', '2018-02-26 23:38:10', '113052', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('21', '1', '1', null, '001-20171229154805.jpg', '2', '2017-11-21 20:54:10', '2018-02-26 23:38:04', '99566', 'image/jpeg', '0', 'SI', 'center center', null, null);
INSERT INTO `banner` VALUES ('22', '1', '1', null, '003-20171229154021.jpg', '2', '2017-11-21 20:55:27', '2018-02-26 23:38:17', '123720', 'image/jpeg', '0', 'SI', 'center center', null, null);
INSERT INTO `banner` VALUES ('23', '1', '1', null, '1550x800-1-20180228170922.jpg', '2', '2018-02-28 17:09:22', '2018-02-28 17:09:22', '276361', 'image/jpeg', '1', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('24', '1', '1', null, 'bannerbodad-20180228170942.jpg', '2', '2018-02-28 17:09:42', '2018-02-28 17:09:42', '99016', 'image/jpeg', '1', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('25', '1', '1', null, 'banner1-20180228222547.jpg', '2', '2018-02-28 22:25:47', '2018-02-28 22:25:47', '758354', 'image/jpeg', '1', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('26', '1', '1', '1', 'banner1-20180228222553.jpg', '2', '2018-02-28 22:25:53', '2018-02-28 22:26:25', '758354', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('27', '1', '1', '1', 'banner1-20180228222556.jpg', '2', '2018-02-28 22:25:56', '2018-02-28 22:26:22', '758354', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('28', '1', '1', '1', 'banner1-20180228222559.jpg', '2', '2018-02-28 22:25:59', '2018-02-28 22:26:19', '758354', 'image/jpeg', '0', 'NO', 'center center', null, null);
INSERT INTO `banner` VALUES ('29', '1', '1', '1', 'banner1-20180228222601.jpg', '2', '2018-02-28 22:26:01', '2018-02-28 22:26:15', '758354', 'image/jpeg', '0', 'NO', 'center center', null, null);

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `idblog` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `codigo_vimeo` varchar(255) DEFAULT NULL,
  `codigo_youtube` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `texto_link` varchar(255) DEFAULT NULL,
  `estado_bl` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idblog`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of blog
-- ----------------------------
INSERT INTO `blog` VALUES ('1', 'FIESTA SUPLIDORES TOURS POINT @ HARD ROCK CAFÉ PC', '<p></p><p><span>Tours Point celebra su fiesta anual de suplidores, esta vez en Hard Rock Café Punta Cana, con la participación de Pavel Núñez y José Montoro…</span></p><p></p>', 'Admin', '2017-11-18 00:00:00', 'noticia1-20171208231544.jpg', null, 'SpYSzsohRus', null, null, '1');
INSERT INTO `blog` VALUES ('2', 'FIESTA SUPLIDORES NEXUS @ HARD ROCK CAFÉ PC', '<p></p><p><span>El pasado viernes estuvimos cubriendo la 3<sup>ra</sup> Premiación Anual de Suplidores de Nexus Tours. Se montó un Photobooth que estuvo operando durante toda la noche…</span></p><p><br/></p><p></p>', 'GS', '2017-11-17 00:00:00', 'noticia2-20171208232710.jpg', null, null, null, null, '1');
INSERT INTO `blog` VALUES ('3', '2X1 SUBWAY @ PUNTA CANA & LA ROMANA', '<p></p><p>Subway Punta Cana y Subway La Romana, celebran su evento mundial 2x1, ver el video aquí…</p><p></p>', 'GS', '2017-11-03 00:00:00', 'noticia3-20171208233337.jpg', '245013786', null, null, null, '1');

-- ----------------------------
-- Table structure for blog_imagen
-- ----------------------------
DROP TABLE IF EXISTS `blog_imagen`;
CREATE TABLE `blog_imagen` (
  `idblogimagen` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idblog` int(11) unsigned NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `orden` int(4) DEFAULT NULL,
  `estado` int(2) DEFAULT '1',
  PRIMARY KEY (`idblogimagen`),
  KEY `fk_blog_imagen_blog_1` (`idblog`),
  CONSTRAINT `fk_blog_imagen_blog_1` FOREIGN KEY (`idblog`) REFERENCES `blog` (`idblog`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of blog_imagen
-- ----------------------------
INSERT INTO `blog_imagen` VALUES ('91', '3', 'KQSiSduY5H.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('92', '3', 'r9xOVFg3Hz.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('93', '3', 'T1fcnQLzLN.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('94', '3', 'W9cDhNnOjk.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('95', '3', 'mf1GxxfLFU.jpg', null, '0');
INSERT INTO `blog_imagen` VALUES ('96', '3', 'y7fWgocOZt.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('97', '3', 'VC6JMoNP7I.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('98', '3', '3FsJKG99fx.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('99', '3', 'F1fB8wGokx.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('100', '3', 'iaJK4V6KRH.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('101', '3', 'Lj7z0L8see.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('102', '3', 'KrUsxMpIkl.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('103', '3', 'ypio0PhvGo.jpg', null, '0');
INSERT INTO `blog_imagen` VALUES ('104', '3', 'vjQ27MIoPq.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('105', '3', 'zVL0hneUxH.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('106', '3', 'a2EbIcJYYp.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('107', '3', 'Sm2vlykII5.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('108', '3', 'thvGUMuhBO.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('109', '3', 'NzWZWMLvyy.jpg', null, '0');
INSERT INTO `blog_imagen` VALUES ('110', '3', 'XoxdkNBwCB.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('111', '3', 'SEq7fyEVXY.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('112', '3', 'CEt4oeLyn1.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('113', '3', 'svnLToAaUg.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('114', '3', 'bFbY3YNaGJ.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('115', '3', 'zBnrORpTzP.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('116', '3', 'KCuKTSYNpF.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('117', '3', 'pyUZzHZjPl.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('118', '3', '88xKjPeS9d.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('119', '3', 'FbBFBZxFNw.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('120', '3', 'webpxPN83Z.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('121', '3', 'L3xnFWySJb.jpg', null, '0');
INSERT INTO `blog_imagen` VALUES ('122', '3', 'VpmrXUT9z4.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('123', '3', 'ZbaevMWlNp.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('124', '3', 'mWFFdzJ3RO.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('125', '3', 'ACV662VrbS.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('126', '3', '7D2UNJExl9.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('127', '3', 'YgnTfWAffq.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('128', '3', 'x2cukuO90t.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('129', '3', 'ALEMbcBZlF.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('130', '3', 'UodPC4Pc40.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('131', '3', 'hf1g3rWEqy.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('132', '3', 'YHCEmPd6T4.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('133', '3', 'Gd8dYs2ckc.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('134', '3', 'mXBOVwH45M.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('135', '3', 'M7F0PRakN1.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('136', '3', '5ct0vOvSsf.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('137', '3', 'VRliKBflQu.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('138', '3', 'bIP6wyL4UU.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('139', '3', 'FnDBuKDpbO.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('140', '3', 'm9VCdmyRN7.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('141', '3', 'qfnVaiYXXc.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('142', '3', 'hJRudcZ2lZ.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('143', '3', 'rgqesCQrXv.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('144', '3', 'E0EcGayzLW.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('145', '3', 'dLWgRfYL6F.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('146', '3', '7AsSnrGnLF.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('147', '3', 'w76b8W2jgQ.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('148', '3', 'a5IY0eG5kt.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('149', '3', 'qF742Xi8Rn.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('150', '3', 'Q7BqWtmxLo.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('151', '3', 'NbVa65t52q.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('152', '3', 'kWdYxHJa7U.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('153', '3', 'h3iozQ9EL3.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('154', '3', 'lwqD6XO8Kt.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('155', '3', 'hHrWT86sHS.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('156', '3', '3IIltjBOa5.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('157', '3', '0UZD7mcZ9k.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('158', '3', 'ZpERUS3TVp.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('159', '3', 'ABm0QODGfA.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('160', '3', 'Yfee7tdSAT.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('161', '3', 'OtQHQhnd23.jpg', null, '0');
INSERT INTO `blog_imagen` VALUES ('162', '3', 'Trw0DFXGZe.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('163', '3', '0eYbl3Fq66.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('164', '3', 'DdgnwyqXGQ.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('165', '3', '6kpOiq2Zwm.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('166', '3', 'wjaJiHr1Sy.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('167', '3', 'NPBsN6Ew0c.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('168', '3', 'tNpLbZClEn.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('169', '3', 'WRYBJStMMo.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('170', '3', 'xEHFL9nExb.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('171', '3', 'eXxYZAfJRp.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('172', '3', 'oEhnipKvoT.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('173', '3', 'Mkn7BnCERo.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('174', '3', '7oSYGgcJjd.jpg', null, '1');
INSERT INTO `blog_imagen` VALUES ('175', '3', 'cch2i6PkzQ.jpg', null, '1');

-- ----------------------------
-- Table structure for blog_post
-- ----------------------------
DROP TABLE IF EXISTS `blog_post`;
CREATE TABLE `blog_post` (
  `idblogpost` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idblog` int(11) unsigned NOT NULL,
  `autor_post` varchar(255) DEFAULT NULL,
  `comentario` tinytext,
  `fecha_post` datetime DEFAULT NULL,
  `estado_bp` tinyint(4) NOT NULL DEFAULT '1',
  `idblogpost_origen` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`idblogpost`),
  KEY `fk_blog_post_blog_1` (`idblog`),
  CONSTRAINT `fk_blog_post_blog_1` FOREIGN KEY (`idblog`) REFERENCES `blog` (`idblog`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of blog_post
-- ----------------------------
INSERT INTO `blog_post` VALUES ('1', '3', 'Marty', 'Morbi accumsan odio lacus, sollicitudin pulvinar magna vulputate sed. Aliquam non rutrum massa, sed dictum magna. Cum sociis natoque penatibus et magnis dis parturient montes.', '2017-10-05 00:23:28', '0', null);
INSERT INTO `blog_post` VALUES ('2', '3', 'Allen', 'Accumsan odio lacus, sollicitudin pulvinar magna vulputate sed. Aliquam non rutrum massa, sed dictum magna. Cum sociis natoque penatibus et magnis dis parturient montes.', '2017-10-04 08:24:17', '0', null);

-- ----------------------------
-- Table structure for capa_slider
-- ----------------------------
DROP TABLE IF EXISTS `capa_slider`;
CREATE TABLE `capa_slider` (
  `idcapaslider` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idbanner` int(11) unsigned NOT NULL,
  `texto` tinytext,
  `color` varchar(255) DEFAULT NULL,
  `fontsize` double DEFAULT NULL,
  `data_y` varchar(255) DEFAULT 'bottom' COMMENT 'top, middle, bottom',
  `data_x` varchar(255) DEFAULT 'left' COMMENT 'left, center, right',
  `offset_horizontal` int(8) DEFAULT NULL,
  `offset_vertical` int(8) DEFAULT NULL,
  `data_width` double DEFAULT NULL,
  `line_height` double DEFAULT NULL,
  PRIMARY KEY (`idcapaslider`),
  KEY `fk_capa_slider_banner_1` (`idbanner`),
  CONSTRAINT `fk_capa_slider_banner_1` FOREIGN KEY (`idbanner`) REFERENCES `banner` (`idbanner`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of capa_slider
-- ----------------------------
INSERT INTO `capa_slider` VALUES ('1', '4', 'Fotografía y video para toda ocasión', 'rgba(1,27,94,1)', '60', 'bottom', 'center', '50', '130', '850', '60');
INSERT INTO `capa_slider` VALUES ('2', '4', 'La solidez de un lider', 'rgba(1,27,94,1)', '35', 'bottom', 'center', '0', '50', '300', '30');
INSERT INTO `capa_slider` VALUES ('3', '5', 'Fotografiamos sus excursiones', 'rgba(32,46,120,1)', '100', 'middle', 'left', '70', '0', '530', '100');
INSERT INTO `capa_slider` VALUES ('4', '5', 'Booguie, caballos, speed boat, Catamarán, etc.', 'rgba(255,255,255,1)', '40', 'middle', 'left', '70', '160', '500', '50');
INSERT INTO `capa_slider` VALUES ('5', '6', 'Cobertura de eventos sociales', 'rgba(255,255,255,1)', '70', 'top', 'center', '80', '140', '900', '70');
INSERT INTO `capa_slider` VALUES ('6', '6', '', 'rgba(255,255,255,1)', '35', 'bottom', 'left', '80', '100', '200', '35');
INSERT INTO `capa_slider` VALUES ('7', '15', '', 'rgba(255,255,255,1)', '70', 'bottom', 'left', '80', '140', '300', '70');
INSERT INTO `capa_slider` VALUES ('8', '15', '', 'rgba(255,255,255,1)', '35', 'bottom', 'left', '80', '100', '200', '35');
INSERT INTO `capa_slider` VALUES ('9', '19', '', 'rgba(255,255,255,1)', '70', 'bottom', 'left', '80', '140', '300', '70');
INSERT INTO `capa_slider` VALUES ('10', '19', '', 'rgba(255,255,255,1)', '35', 'bottom', 'left', '80', '100', '200', '35');
INSERT INTO `capa_slider` VALUES ('11', '20', '', 'rgba(255,255,255,1)', '70', 'bottom', 'left', '80', '140', '300', '70');
INSERT INTO `capa_slider` VALUES ('12', '20', '', 'rgba(255,255,255,1)', '35', 'bottom', 'left', '80', '100', '200', '35');
INSERT INTO `capa_slider` VALUES ('13', '21', '', 'rgba(255,255,255,1)', '70', 'bottom', 'left', '80', '140', '300', '70');
INSERT INTO `capa_slider` VALUES ('14', '21', '', 'rgba(255,255,255,1)', '35', 'bottom', 'left', '80', '100', '200', '35');
INSERT INTO `capa_slider` VALUES ('15', '22', '', 'rgba(255,255,255,1)', '70', 'bottom', 'left', '80', '140', '300', '70');
INSERT INTO `capa_slider` VALUES ('16', '22', '', 'rgba(255,255,255,1)', '35', 'bottom', 'left', '80', '100', '200', '35');

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_sessions
-- ----------------------------
INSERT INTO `ci_sessions` VALUES ('36287d9e55ee0f64982619c264526c043f1934fa', '152.0.130.18', '1526470068', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363437303036383B);
INSERT INTO `ci_sessions` VALUES ('395ff4f0539a38d0a5c12554d1899e8706c3ef7c', '152.0.130.18', '1526470364', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363437303036383B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('774c58edf0ede9c48f25dfba4b10168a0a09ab4f', '152.0.130.18', '1526470068', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363437303036383B);
INSERT INTO `ci_sessions` VALUES ('8b17b08b8361104e99a7d33133b4af08ed658647', '152.0.130.18', '1526470398', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363437303339383B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('e8039d5780dc143e16adc873a73a7bb1a6ef52f4', '152.0.130.18', '1526470425', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363437303339383B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('3359e148f86580d3a8004d5e28903097c0a68ad8', '85.84.231.161', '1526492807', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363439323830373B);
INSERT INTO `ci_sessions` VALUES ('08d3a31568a44b638bb67a56fa225fc0e4b5e5f4', '85.84.231.161', '1526492807', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363439323830373B);
INSERT INTO `ci_sessions` VALUES ('7c933879965f3a63d1093572af2392e8efa48280', '85.84.231.161', '1526492807', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363439323830373B);
INSERT INTO `ci_sessions` VALUES ('5273922193e5966ef5660ef736a25004b9ccae96', '152.0.130.18', '1526529245', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363532383935303B);
INSERT INTO `ci_sessions` VALUES ('67fbe7be1378922cb77c08d77d3c232507ed9df4', '152.0.130.18', '1526529302', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363532393235333B);
INSERT INTO `ci_sessions` VALUES ('7e2c0e83473bf33f518ee2a7e0237e88eadc9d75', '152.0.130.18', '1526556297', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363535363035353B);
INSERT INTO `ci_sessions` VALUES ('ef08446701839702e3b37a10ae8242ad3bbf7ef6', '152.0.130.18', '1526556576', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363535363335363B);
INSERT INTO `ci_sessions` VALUES ('08f9faacb4818f12f68d65df3f097705d7b6ba0f', '152.0.130.18', '1526556873', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363535363731373B);
INSERT INTO `ci_sessions` VALUES ('09bc3988c847698b4db5a099f991024edb19ed6e', '148.0.102.32', '1526583993', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363538333939333B);
INSERT INTO `ci_sessions` VALUES ('0baf1ef16e14b20b45bc6f64efab9015b5e4f4fb', '148.0.102.32', '1526584076', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363538333939333B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('b876694524bad7b9a7103018d3ab0697fe60f6b3', '148.0.102.32', '1526583993', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363538333939333B);
INSERT INTO `ci_sessions` VALUES ('7c824d972edf1a7981460424289bed1e51de2f6c', '66.102.6.168', '1526586941', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363538363934313B);
INSERT INTO `ci_sessions` VALUES ('57b5498a61d7ad611b18d63d88869bb0a263a581', '66.249.80.8', '1526586941', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363538363934313B);
INSERT INTO `ci_sessions` VALUES ('c69f8053629b575d7c14d1d41e81d73b26038596', '66.102.6.168', '1526586941', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363538363934313B);
INSERT INTO `ci_sessions` VALUES ('2ab92f67f3c69b74e1007d34f61d78ac6741d3c2', '165.227.223.85', '1526608533', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363630383533333B);
INSERT INTO `ci_sessions` VALUES ('eebff1e636d3c3f990e9093b0253f877d38e3ac1', '165.227.223.85', '1526608533', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363630383533333B);
INSERT INTO `ci_sessions` VALUES ('d9dcd2d5a097056c85e81538deaa7b0eff747702', '165.227.223.85', '1526608533', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363630383533333B);
INSERT INTO `ci_sessions` VALUES ('18263ee1b8f9b49c5423cbafbcd089e24f109cda', '138.197.65.92', '1526614127', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363631343132373B);
INSERT INTO `ci_sessions` VALUES ('f37e6da6fef5706c9244af4447bedaa0f509314f', '138.197.65.92', '1526614127', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363631343132373B);
INSERT INTO `ci_sessions` VALUES ('06451093d343e60500937b66e60c4d80e7fe62f2', '138.197.65.92', '1526614127', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363631343132373B);
INSERT INTO `ci_sessions` VALUES ('66396bb5d9327bc9476a7c3be6c9e0534ba3624f', '192.162.24.11', '1526628412', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363632383431323B);
INSERT INTO `ci_sessions` VALUES ('1abeb5cfb3e7a2aca4f272b10b9c56b14f140fa6', '192.162.24.11', '1526628412', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363632383431323B);
INSERT INTO `ci_sessions` VALUES ('6b047d78fd87a83f42cf6e081c4d9037009f296b', '192.162.24.11', '1526628413', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363632383431323B);
INSERT INTO `ci_sessions` VALUES ('94ab48729ad22406c2c5164949bc06980af1159b', '152.167.195.97', '1526783640', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738333634303B);
INSERT INTO `ci_sessions` VALUES ('f22d2b8d3f2820cc4396b0e13404f84812e09a82', '152.167.195.97', '1526783937', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738333634303B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('4d7c14eb3de34e69a8eca81bead9ac539e2ee035', '152.167.195.97', '1526783641', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738333634303B);
INSERT INTO `ci_sessions` VALUES ('11dc883ac74302c0c4a7f867f3702214514d13a6', '152.167.195.97', '1526784032', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738343033323B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('00db2c2ae36527b5c85c8a79c84164f1157700eb', '152.167.195.97', '1526784033', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738343033333B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('0087490e9c16a5b12fd8f497a84d881d0d3af5bc', '152.167.195.97', '1526784034', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738343033333B736573735F63705F6973616E67616D65727C613A31303A7B733A393A2269647573756172696F223B733A313A2232223B733A373A226964677275706F223B733A313A2232223B733A393A226B65795F677275706F223B733A393A226B65795F61646D696E223B733A383A22757365726E616D65223B733A353A2241444D494E223B733A383A226D6F6E656465726F223B4E3B733A383A2269646964696F6D61223B733A323A226573223B733A363A226C6F67676564223B623A313B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B733A373A22636C69656E7465223B733A353A2241444D494E223B733A353A22656D61696C223B733A31333A2241646D696E6973747261646F72223B7D);
INSERT INTO `ci_sessions` VALUES ('b35a3444c9c24590e55015cbeb9308d9f0278dc7', '152.167.195.97', '1526784237', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738343033343B736573735F63705F6973616E67616D65727C613A31313A7B733A393A226964636C69656E7465223B733A333A22313039223B733A373A226964677275706F223B693A333B733A393A226B65795F677275706F223B733A31313A226B65795F636C69656E7465223B733A383A2269646964696F6D61223B733A323A22656E223B733A383A22757365726E616D65223B4E3B733A383A226D6F6E656465726F223B733A323A223135223B733A393A2270726F63657361646F223B733A313A2231223B733A363A226C6F67676564223B623A313B733A373A22636C69656E7465223B733A353A225A31323334223B733A353A22656D61696C223B733A353A225A31323334223B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B7D);
INSERT INTO `ci_sessions` VALUES ('efa1e0684a6cf91cdf3060a4747f4e9c53d81dad', '152.167.195.97', '1526785028', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738353032383B736573735F63705F6973616E67616D65727C613A31313A7B733A393A226964636C69656E7465223B733A333A22313039223B733A373A226964677275706F223B693A333B733A393A226B65795F677275706F223B733A31313A226B65795F636C69656E7465223B733A383A2269646964696F6D61223B733A323A22656E223B733A383A22757365726E616D65223B4E3B733A383A226D6F6E656465726F223B733A323A223135223B733A393A2270726F63657361646F223B733A313A2231223B733A363A226C6F67676564223B623A313B733A373A22636C69656E7465223B733A353A225A31323334223B733A353A22656D61696C223B733A353A225A31323334223B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B7D);
INSERT INTO `ci_sessions` VALUES ('165a002504f934064cbbb81904ad97995f74e5e9', '152.167.195.97', '1526785028', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738353032383B736573735F63705F6973616E67616D65727C613A31313A7B733A393A226964636C69656E7465223B733A333A22313039223B733A373A226964677275706F223B693A333B733A393A226B65795F677275706F223B733A31313A226B65795F636C69656E7465223B733A383A2269646964696F6D61223B733A323A22656E223B733A383A22757365726E616D65223B4E3B733A383A226D6F6E656465726F223B733A323A223135223B733A393A2270726F63657361646F223B733A313A2231223B733A363A226C6F67676564223B623A313B733A373A22636C69656E7465223B733A353A225A31323334223B733A353A22656D61696C223B733A353A225A31323334223B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B7D);
INSERT INTO `ci_sessions` VALUES ('9779def5cbe244c324e3337e690b386a049782ac', '152.167.195.97', '1526785028', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363738353032383B736573735F63705F6973616E67616D65727C613A31313A7B733A393A226964636C69656E7465223B733A333A22313039223B733A373A226964677275706F223B693A333B733A393A226B65795F677275706F223B733A31313A226B65795F636C69656E7465223B733A383A2269646964696F6D61223B733A323A22656E223B733A383A22757365726E616D65223B4E3B733A383A226D6F6E656465726F223B733A323A223135223B733A393A2270726F63657361646F223B733A313A2231223B733A363A226C6F67676564223B623A313B733A373A22636C69656E7465223B733A353A225A31323334223B733A353A22656D61696C223B733A353A225A31323334223B733A31313A226E6F6D6272655F666F746F223B733A31343A2273696E2D696D6167656E2E706E67223B7D);
INSERT INTO `ci_sessions` VALUES ('0e47bd281f4707f6b3d2fde4369c70718559a651', '40.77.190.30', '1526798312', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363739383331323B);
INSERT INTO `ci_sessions` VALUES ('9cf76f1c480459d1a94fb82fd88b4982ea90ec9e', '40.77.190.30', '1526798312', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363739383331323B);
INSERT INTO `ci_sessions` VALUES ('7d8f486835755e7f1c54446821e95b6662d79441', '40.77.190.30', '1526798312', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363739383331323B);
INSERT INTO `ci_sessions` VALUES ('b188783f862cc4fa0a3fa96f00d6ca5340a9680e', '66.249.66.152', '1526803616', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363830333631363B);
INSERT INTO `ci_sessions` VALUES ('1075098f56ae84f4b9ce8b6802f28e8661395fca', '66.249.66.152', '1526803617', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363830333631373B);
INSERT INTO `ci_sessions` VALUES ('9c91a9a46f148d755cc3fe0048e703f7e7e49fd5', '66.249.66.152', '1526835234', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363833353233343B);
INSERT INTO `ci_sessions` VALUES ('968576b95a3093b17f02fd03173ad765bf944cda', '66.249.66.152', '1526835235', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363833353233353B);
INSERT INTO `ci_sessions` VALUES ('cc3f4aff47652349af796d2f0917fbd6e182621b', '66.249.66.156', '1526835652', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363833353635323B);
INSERT INTO `ci_sessions` VALUES ('ac5697b7f5664c1e0b3b4a4436f3e78841f087e1', '66.249.66.156', '1526835652', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363833353635323B);
INSERT INTO `ci_sessions` VALUES ('acbf7f28891186d1f3bfd755377548da80d8c73a', '69.171.240.20', '1526904527', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363930343532373B);
INSERT INTO `ci_sessions` VALUES ('5853903e078cde35ab8fc1c59aa0cfc7efac9523', '69.171.240.17', '1526904527', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363930343532373B);
INSERT INTO `ci_sessions` VALUES ('c60901a060e1755346703f66fdc8bbd497b9d89a', '69.171.240.18', '1526904528', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363930343532373B);
INSERT INTO `ci_sessions` VALUES ('3fb9f8171ceb0559d6a67ba9f8a8404e7b6cbc5b', '192.162.24.11', '1526965320', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363936353332303B);
INSERT INTO `ci_sessions` VALUES ('3439664d5530eb4fcbaa1f8df35e1e2137c4fa74', '192.162.24.11', '1526965320', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363936353332303B);
INSERT INTO `ci_sessions` VALUES ('c0c1654542b68765e799b3c628aea1af193527a7', '192.162.24.11', '1526965320', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532363936353332303B);
INSERT INTO `ci_sessions` VALUES ('1b7e5d7538237a40c442221e62ae031b8b42bdc0', '192.162.24.11', '1527040496', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373034303439363B);
INSERT INTO `ci_sessions` VALUES ('890a375377a7d7691fca76903da9bf40418a263c', '192.162.24.11', '1527040496', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373034303439363B);
INSERT INTO `ci_sessions` VALUES ('6333667bbde9939459cbea3a7ec83e78508f3422', '192.162.24.11', '1527040497', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373034303439363B);
INSERT INTO `ci_sessions` VALUES ('60bc6b5cafd0694fc27cb4bfc64337e085e6483e', '192.162.24.11', '1527154797', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373135343739373B);
INSERT INTO `ci_sessions` VALUES ('c5e4e1b836d25e9c53b0b469fa673657fd5e9294', '192.162.24.11', '1527154797', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373135343739373B);
INSERT INTO `ci_sessions` VALUES ('dd9639d6536e91a66e8f4968f8cbeacdf7f18d31', '192.162.24.11', '1527154797', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373135343739373B);
INSERT INTO `ci_sessions` VALUES ('799fcb29d3ef928c61ac7373d83bb6f1ed687df0', '37.14.11.7', '1527343186', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373334333138363B);
INSERT INTO `ci_sessions` VALUES ('c4f8b2afd2886da7a9a46c14d33a5cd4bb88f92b', '37.14.11.7', '1527343186', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373334333138363B);
INSERT INTO `ci_sessions` VALUES ('4660599fd7309ab17c91bc3262ddb2a5e6b2d488', '37.14.11.7', '1527343186', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373334333138363B);
INSERT INTO `ci_sessions` VALUES ('bc37fb8372d0e132b2105c31ce9784bf1673f0ff', '85.87.96.88', '1527349518', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373334393531383B);
INSERT INTO `ci_sessions` VALUES ('184cd3fef9f543f248bf7195b5fc9cc32065c7b1', '85.87.96.88', '1527349531', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373334393531383B);
INSERT INTO `ci_sessions` VALUES ('445ef7875530d52ba31ca4c79469a75d452e245d', '85.87.96.88', '1527349518', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373334393531383B);
INSERT INTO `ci_sessions` VALUES ('92625b1f5f44744a7f096ee9830a1352c96bcf5d', '200.104.220.120', '1527350009', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373335303030393B);
INSERT INTO `ci_sessions` VALUES ('397c59a5bf102c41889147b4c109f8ee880e4f4a', '200.104.220.120', '1527350009', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373335303030393B);
INSERT INTO `ci_sessions` VALUES ('2e7e267234e879b6d986424422c84ac283b6b1e1', '200.104.220.120', '1527350009', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373335303030393B);
INSERT INTO `ci_sessions` VALUES ('5638270d6e676f66a676afde4a4e99cb3cb8b9bb', '173.252.92.118', '1527351143', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373335313134333B);
INSERT INTO `ci_sessions` VALUES ('7547b07c3057ce9ce3093b0867fdce86eac81e13', '173.252.92.116', '1527351143', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373335313134333B);
INSERT INTO `ci_sessions` VALUES ('c1438b35f7434af36bfd044536f21ce6a0898fb0', '173.252.92.117', '1527351143', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373335313134333B);
INSERT INTO `ci_sessions` VALUES ('e00b80483338a68483ea8b5ff3707db28cd58c1e', '165.227.190.239', '1527383230', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373338333233303B);
INSERT INTO `ci_sessions` VALUES ('4f0aac4799a0c9a12a9e10195f8e418986ee7b44', '165.227.190.239', '1527383230', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373338333233303B);
INSERT INTO `ci_sessions` VALUES ('37a2cdd51fa36c42aced1f9747b833c6eba2954f', '165.227.190.239', '1527383231', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373338333233303B);
INSERT INTO `ci_sessions` VALUES ('09a9058695a2bfbbb08cecacdf4ae63b759bb31b', '192.162.24.11', '1527414372', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373431343337323B);
INSERT INTO `ci_sessions` VALUES ('deba778afe0ad5c3fe37ff6392d879e16b5f6eec', '192.162.24.11', '1527414372', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373431343337323B);
INSERT INTO `ci_sessions` VALUES ('639df6a4c33508e4b0828200a69b252ec6a469b2', '192.162.24.11', '1527414372', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373431343337323B);
INSERT INTO `ci_sessions` VALUES ('1947c2f528f6c4d39d08d932ae73a59f1d47e4d6', '66.249.88.136', '1527452431', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323433313B);
INSERT INTO `ci_sessions` VALUES ('3c060ac378d7bed54a720389c776ecc25e6b924f', '66.249.88.138', '1527452431', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323433313B);
INSERT INTO `ci_sessions` VALUES ('b3f473a79deb225c005bd7cf525fe67642f961ae', '66.249.88.138', '1527452431', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323433313B);
INSERT INTO `ci_sessions` VALUES ('2411322afc94a1d99ee696f74845111219f849b3', '66.249.88.140', '1527452431', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323433313B);
INSERT INTO `ci_sessions` VALUES ('3d9df6db6872848c940a06141be3b73386f1ab26', '66.249.88.138', '1527452432', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323433323B);
INSERT INTO `ci_sessions` VALUES ('5527cc29b4b7d8d35960e18a55c02bde4623c229', '66.249.88.140', '1527452432', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323433323B);
INSERT INTO `ci_sessions` VALUES ('ff56e8e8c80b329776cb8c82cfacb122978c9837', '66.249.93.215', '1527452466', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323436363B);
INSERT INTO `ci_sessions` VALUES ('e7256ac583bc9235dfef68e6ed173b4d81c9f5a4', '66.249.93.214', '1527452466', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323436363B);
INSERT INTO `ci_sessions` VALUES ('b9ec4db2b29d31b2e7d4f5e40fd52e66f0e23480', '66.249.93.214', '1527452466', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323436363B);
INSERT INTO `ci_sessions` VALUES ('f67a41692070f23ba9b8bddcd9dca29bb897d0e0', '66.249.93.214', '1527452466', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323436363B);
INSERT INTO `ci_sessions` VALUES ('38b7fe6cba4405b05f778b3ac86a7f139e011dac', '66.249.93.214', '1527452466', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323436363B);
INSERT INTO `ci_sessions` VALUES ('d7efbb7b3728b038ccb70f8d7c604038fe59b8d8', '66.249.93.216', '1527452466', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323436363B);
INSERT INTO `ci_sessions` VALUES ('556560a3b55030b99dc0b7dfbb3a41f69b7b0d2d', '66.249.88.144', '1527452590', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323539303B);
INSERT INTO `ci_sessions` VALUES ('47ee84c2f35bc381f00adb355e8e2b7aae2a928c', '66.249.88.143', '1527452590', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323539303B);
INSERT INTO `ci_sessions` VALUES ('7c0458f2e010622ab944946104611fe899a3e957', '66.249.88.145', '1527452590', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323539303B);
INSERT INTO `ci_sessions` VALUES ('8b7d0f9940b27aa9bf82c046726c7c11d81c8d3f', '66.249.88.145', '1527452591', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323539313B);
INSERT INTO `ci_sessions` VALUES ('9c940aea7544f6e6274104ee5fb28c9f31edea6f', '66.249.88.144', '1527452591', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323539313B);
INSERT INTO `ci_sessions` VALUES ('c0122c2c00632532017609a2accd82c4dc88c353', '66.249.88.143', '1527452591', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323539313B);
INSERT INTO `ci_sessions` VALUES ('1e4276c737cbcd76d369a9139b37200f772a444c', '66.249.93.216', '1527452610', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323631303B);
INSERT INTO `ci_sessions` VALUES ('6700679ea9a88ac02328c4af4b76a6b6182b594e', '66.249.93.214', '1527452610', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323631303B);
INSERT INTO `ci_sessions` VALUES ('1d33cb43c4375c9bf65794377d0c1b1bd1641370', '66.249.93.215', '1527452610', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323631303B);
INSERT INTO `ci_sessions` VALUES ('d4eb4c2e0fb4e4b93d788753f9244d7be8ca1ef7', '66.249.93.214', '1527452610', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323631303B);
INSERT INTO `ci_sessions` VALUES ('908642296a141839504f0ead42aa3ff97bc5e9d0', '66.249.93.214', '1527452610', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323631303B);
INSERT INTO `ci_sessions` VALUES ('44c53248b026ae0ee75e22efafd598159ec0b8a8', '66.249.93.216', '1527452610', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373435323631303B);
INSERT INTO `ci_sessions` VALUES ('d51adb9f5ef79b24ada505ad33909b3706f2da6f', '179.7.152.184', '1527471594', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373437313539343B);
INSERT INTO `ci_sessions` VALUES ('5f453c3eec2330d8f294425d76beeea88e4d2640', '179.7.152.184', '1527471594', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373437313539343B);
INSERT INTO `ci_sessions` VALUES ('e8f3c79da02ce1ecd526e246921f339e8691b9c7', '179.7.152.184', '1527471595', 0x5F5F63695F6C6173745F726567656E65726174657C693A313532373437313539353B);

-- ----------------------------
-- Table structure for cliente
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `idcliente` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `createdat` datetime NOT NULL,
  `updatedat` datetime NOT NULL,
  `fecha_salida` date DEFAULT NULL COMMENT 'Fecha de estadia hasta cuando se quedará el cliente en la isla',
  `hotel` varchar(255) DEFAULT NULL,
  `habitacion` varchar(255) DEFAULT NULL,
  `monedero` float DEFAULT '0',
  `telefono` varchar(255) DEFAULT NULL,
  `codigo` varchar(255) NOT NULL,
  `idexcursion` int(11) unsigned NOT NULL,
  `fecha_excursion` date NOT NULL,
  `idexcursionvideo` int(11) unsigned DEFAULT NULL,
  `iduser_reg` int(11) unsigned NOT NULL,
  `fecha_anula` datetime DEFAULT NULL,
  `iduser_anula` int(11) unsigned DEFAULT NULL,
  `procesado` smallint(6) DEFAULT '1' COMMENT '1: NO PROCESADO; 3: PENDIENTE; 4: COMPLETO',
  `ididioma` char(2) DEFAULT 'en',
  `estado_cl` tinyint(4) NOT NULL DEFAULT '1',
  `deposito` float DEFAULT NULL COMMENT 'el deposito inicial del monedero',
  `paquete` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1: Paquete All Inclusive; \r\n2: Digital Fun; \r\n3: Single foto',
  `precio_paquete` float NOT NULL,
  `precio_adicional` float DEFAULT NULL,
  `solicita_bonificacion` int(11) DEFAULT '2' COMMENT '1:SI; 2:NO',
  `verifica_email` int(11) DEFAULT '2' COMMENT '1:SI; 2:NO (Despues de solicitar fotografia gratis verifica el email)',
  PRIMARY KEY (`idcliente`),
  KEY `fk_cliente_excursion_1` (`idexcursion`),
  CONSTRAINT `fk_cliente_excursion_1` FOREIGN KEY (`idexcursion`) REFERENCES `excursion` (`idexcursion`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cliente
-- ----------------------------
INSERT INTO `cliente` VALUES ('89', null, null, null, null, '2018-05-04 22:30:11', '2018-05-05 00:48:16', null, null, null, '50', null, 'O1234', '1', '2018-05-04', null, '2', null, null, '1', 'en', '0', '50', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('90', null, null, null, null, '2018-05-04 22:30:11', '2018-05-05 00:48:16', null, null, null, '25', null, 'P1234', '2', '2018-05-04', null, '2', null, null, '1', 'en', '0', '25', '3', '15', '10', '2', '2');
INSERT INTO `cliente` VALUES ('91', null, null, null, null, '2018-05-04 22:30:11', '2018-05-05 00:48:16', null, null, null, '0', null, 'Q1234', '1', '2018-05-04', null, '2', null, null, '1', 'en', '0', '0', '2', '69', null, '2', '2');
INSERT INTO `cliente` VALUES ('92', null, null, null, null, '2018-05-05 01:00:47', '2018-05-05 01:11:13', null, null, null, '50', null, 'O1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '50', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('93', null, null, null, null, '2018-05-05 01:00:47', '2018-05-05 01:11:13', null, null, null, '25', null, 'P1234', '2', '2018-05-05', null, '2', null, null, '1', 'en', '0', '25', '3', '15', '10', '2', '2');
INSERT INTO `cliente` VALUES ('94', null, null, null, null, '2018-05-05 01:00:47', '2018-05-05 01:11:13', null, null, null, '0', null, 'Q1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '0', '2', '69', null, '2', '2');
INSERT INTO `cliente` VALUES ('95', null, null, null, null, '2018-05-05 01:14:37', '2018-05-05 01:17:33', null, null, null, '50', null, 'O1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '50', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('96', null, null, null, null, '2018-05-05 01:14:37', '2018-05-05 01:17:33', null, null, null, '25', null, 'P1234', '2', '2018-05-05', null, '2', null, null, '1', 'en', '0', '25', '3', '15', '10', '2', '2');
INSERT INTO `cliente` VALUES ('97', null, null, null, null, '2018-05-05 01:14:37', '2018-05-05 01:17:33', null, null, null, '0', null, 'Q1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '0', '2', '69', null, '2', '2');
INSERT INTO `cliente` VALUES ('98', null, null, null, null, '2018-05-05 01:19:01', '2018-05-05 01:30:25', null, null, null, '50', null, 'O1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '50', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('99', null, null, null, null, '2018-05-05 01:19:01', '2018-05-05 01:30:25', null, null, null, '25', null, 'P1234', '2', '2018-05-05', null, '2', null, null, '1', 'en', '0', '25', '3', '15', '10', '2', '2');
INSERT INTO `cliente` VALUES ('100', null, null, null, null, '2018-05-05 01:19:01', '2018-05-05 01:30:25', null, null, null, '0', null, 'Q1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '0', '2', '69', null, '2', '2');
INSERT INTO `cliente` VALUES ('101', null, null, null, null, '2018-05-05 01:42:55', '2018-05-05 03:35:22', null, null, null, '50', null, 'O1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '50', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('102', null, null, null, null, '2018-05-05 01:42:55', '2018-05-05 03:35:22', null, null, null, '25', null, 'P1234', '2', '2018-05-05', null, '2', null, null, '1', 'en', '0', '25', '3', '15', '10', '2', '2');
INSERT INTO `cliente` VALUES ('103', null, null, null, null, '2018-05-05 01:42:55', '2018-05-05 03:35:22', null, null, null, '0', null, 'Q1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '0', '0', '2', '69', null, '2', '2');
INSERT INTO `cliente` VALUES ('104', null, null, null, null, '2018-05-05 03:35:59', '2018-05-05 03:35:59', null, null, null, '0', null, 'O1234', '1', '2018-05-05', null, '2', null, null, '4', 'en', '1', '50', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('105', null, null, null, null, '2018-05-05 03:35:59', '2018-05-05 03:35:59', null, null, null, '10', null, 'P1234', '2', '2018-05-05', null, '2', null, null, '1', 'en', '1', '25', '3', '15', '10', '2', '2');
INSERT INTO `cliente` VALUES ('106', null, null, 'jm@hementxe.com', null, '2018-05-05 03:35:59', '2018-05-05 03:35:59', null, null, null, '0', null, 'Q1234', '1', '2018-05-05', null, '2', null, null, '1', 'en', '1', '0', '2', '69', null, '1', '1');
INSERT INTO `cliente` VALUES ('107', null, null, 'jm@hementxe.com', null, '2018-05-06 22:44:54', '2018-05-06 22:44:54', null, null, null, '0', null, 'X1234', '1', '2018-05-06', null, '2', null, null, '1', 'en', '1', '0', '2', '69', null, '1', '1');
INSERT INTO `cliente` VALUES ('108', null, null, 'davide.goey@gmail.com', null, '2018-05-06 22:44:54', '2018-05-07 15:41:54', null, null, null, '0', null, 'Y1234', '2', '2018-05-06', null, '2', null, null, '1', 'en', '1', '0', '2', '69', null, '1', '1');
INSERT INTO `cliente` VALUES ('109', null, null, null, null, '2018-05-06 22:44:54', '2018-05-07 15:42:38', null, null, null, '15', null, 'Z1234', '1', '2018-05-06', null, '2', null, null, '1', 'en', '1', '15', '2', '69', null, '2', '2');
INSERT INTO `cliente` VALUES ('110', null, null, null, null, '2018-05-07 15:55:28', '2018-05-07 15:55:28', null, null, null, '50', null, 'ALLINC', '1', '2018-05-07', null, '2', null, null, '1', 'en', '1', '50', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('111', null, null, null, null, '2018-05-07 15:55:28', '2018-05-07 15:55:28', null, null, null, '99', null, 'FULLPA', '1', '2018-05-07', null, '2', null, null, '1', 'en', '1', '99', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('112', null, null, null, null, '2018-05-07 15:55:28', '2018-05-07 15:55:28', null, null, null, '10', null, 'TACANO', '1', '2018-05-07', null, '2', null, null, '1', 'en', '1', '10', '1', '99', null, '2', '2');
INSERT INTO `cliente` VALUES ('113', null, null, null, null, '2018-05-07 15:55:28', '2018-05-07 15:55:28', null, null, null, '55', null, 'PAGAPO', '1', '2018-05-07', null, '2', null, null, '1', 'en', '1', '55', '2', '69', null, '2', '2');

-- ----------------------------
-- Table structure for color
-- ----------------------------
DROP TABLE IF EXISTS `color`;
CREATE TABLE `color` (
  `idcolor` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `rgba` varchar(255) DEFAULT NULL,
  `estado_co` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; 1:activo',
  PRIMARY KEY (`idcolor`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of color
-- ----------------------------
INSERT INTO `color` VALUES ('1', 'BLANCO', 'rgba(255,255,255,1)', '1');
INSERT INTO `color` VALUES ('2', 'NEGRO', 'rgba(0,0,0,1)', '1');
INSERT INTO `color` VALUES ('3', 'ROJO', 'rgba(194,3,41,1)', '1');
INSERT INTO `color` VALUES ('4', 'AZUL', 'rgba(53, 61, 86,1)', '1');
INSERT INTO `color` VALUES ('5', 'AMARILLO', 'rgba(246, 188, 26,1)', '1');
INSERT INTO `color` VALUES ('6', 'VERDE', 'rgba(30, 150, 88,1)', '1');

-- ----------------------------
-- Table structure for dependiente
-- ----------------------------
DROP TABLE IF EXISTS `dependiente`;
CREATE TABLE `dependiente` (
  `iddependiente` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) unsigned NOT NULL,
  `codigo` varchar(255) NOT NULL,
  PRIMARY KEY (`iddependiente`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of dependiente
-- ----------------------------
INSERT INTO `dependiente` VALUES ('8', '90', 'XYZ111');
INSERT INTO `dependiente` VALUES ('9', '90', 'XYZ123');
INSERT INTO `dependiente` VALUES ('10', '90', 'XYZ222');
INSERT INTO `dependiente` VALUES ('11', '91', 'as123');
INSERT INTO `dependiente` VALUES ('12', '91', 'as111');
INSERT INTO `dependiente` VALUES ('13', '93', 'XYZ111');
INSERT INTO `dependiente` VALUES ('14', '93', 'XYZ123');
INSERT INTO `dependiente` VALUES ('15', '93', 'XYZ222');
INSERT INTO `dependiente` VALUES ('16', '94', 'as123');
INSERT INTO `dependiente` VALUES ('17', '94', 'as111');
INSERT INTO `dependiente` VALUES ('18', '96', 'XYZ111');
INSERT INTO `dependiente` VALUES ('19', '96', 'XYZ123');
INSERT INTO `dependiente` VALUES ('20', '96', 'XYZ222');
INSERT INTO `dependiente` VALUES ('21', '97', 'as123');
INSERT INTO `dependiente` VALUES ('22', '97', 'as111');
INSERT INTO `dependiente` VALUES ('23', '99', 'XYZ111');
INSERT INTO `dependiente` VALUES ('24', '99', 'XYZ123');
INSERT INTO `dependiente` VALUES ('25', '99', 'XYZ222');
INSERT INTO `dependiente` VALUES ('26', '100', 'as123');
INSERT INTO `dependiente` VALUES ('27', '100', 'as111');
INSERT INTO `dependiente` VALUES ('28', '102', 'XYZ111');
INSERT INTO `dependiente` VALUES ('29', '102', 'XYZ123');
INSERT INTO `dependiente` VALUES ('30', '102', 'XYZ222');
INSERT INTO `dependiente` VALUES ('31', '103', 'as123');
INSERT INTO `dependiente` VALUES ('32', '103', 'as111');
INSERT INTO `dependiente` VALUES ('33', '105', 'XYZ111');
INSERT INTO `dependiente` VALUES ('34', '105', 'XYZ123');
INSERT INTO `dependiente` VALUES ('35', '105', 'XYZ222');
INSERT INTO `dependiente` VALUES ('36', '106', 'as123');
INSERT INTO `dependiente` VALUES ('37', '106', 'as111');
INSERT INTO `dependiente` VALUES ('38', '109', 'zxy123');
INSERT INTO `dependiente` VALUES ('39', '109', 'zzz111');
INSERT INTO `dependiente` VALUES ('40', '110', 'ALL01');
INSERT INTO `dependiente` VALUES ('41', '113', 'PAGA01');
INSERT INTO `dependiente` VALUES ('42', '113', 'PAGA02');
INSERT INTO `dependiente` VALUES ('43', '113', 'PAGA03');

-- ----------------------------
-- Table structure for descuento
-- ----------------------------
DROP TABLE IF EXISTS `descuento`;
CREATE TABLE `descuento` (
  `iddescuento` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dias` int(4) unsigned NOT NULL,
  `descuento` int(11) NOT NULL,
  PRIMARY KEY (`iddescuento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of descuento
-- ----------------------------
INSERT INTO `descuento` VALUES ('1', '1', '20');
INSERT INTO `descuento` VALUES ('2', '20', '50');

-- ----------------------------
-- Table structure for detalle
-- ----------------------------
DROP TABLE IF EXISTS `detalle`;
CREATE TABLE `detalle` (
  `iddetalle` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idmovimiento` int(11) unsigned NOT NULL,
  `idpaquete` int(11) unsigned DEFAULT NULL,
  `idproducto` int(8) DEFAULT NULL,
  `tipo_adicional` tinyint(1) DEFAULT NULL COMMENT '1: foto adicional; 2:video_adicional',
  `cantidad` int(4) NOT NULL,
  `precio` int(8) NOT NULL,
  `descuento` float DEFAULT NULL,
  `total_detalle` float NOT NULL,
  `idcolor` int(8) unsigned DEFAULT NULL,
  `genero` varchar(1) DEFAULT NULL COMMENT 'H: hombre; M: mujer',
  `tipo_detalle` tinyint(1) DEFAULT '1' COMMENT '1: compra online; 2: merchandising (pedido)',
  `estado_det` tinyint(1) DEFAULT '2' COMMENT '1:pendiente; 2:entregado',
  PRIMARY KEY (`iddetalle`),
  KEY `fk_detalle_movimiento_1` (`idmovimiento`) USING BTREE,
  CONSTRAINT `fk_detalle_movimiento_1` FOREIGN KEY (`idmovimiento`) REFERENCES `movimiento` (`idmovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of detalle
-- ----------------------------
INSERT INTO `detalle` VALUES ('105', '93', null, null, null, '20', '5', null, '99', null, null, '1', '1');
INSERT INTO `detalle` VALUES ('106', '94', null, null, null, '1', '15', null, '15', null, null, '1', '1');

-- ----------------------------
-- Table structure for detalle_archivo
-- ----------------------------
DROP TABLE IF EXISTS `detalle_archivo`;
CREATE TABLE `detalle_archivo` (
  `iddetallearchivo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iddetalle` int(11) unsigned NOT NULL,
  `idarchivo` int(11) unsigned NOT NULL,
  PRIMARY KEY (`iddetallearchivo`),
  KEY `fk_detalle_archivo_archivo_1` (`idarchivo`) USING BTREE,
  KEY `fk_detalle_archivo_detalle_1` (`iddetalle`) USING BTREE,
  CONSTRAINT `fk_detalle_archivo_detalle_1` FOREIGN KEY (`iddetalle`) REFERENCES `detalle` (`iddetalle`),
  CONSTRAINT `fk_detalle_archivo_archivo_1` FOREIGN KEY (`idarchivo`) REFERENCES `archivo` (`idarchivo`)
) ENGINE=InnoDB AUTO_INCREMENT=767 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of detalle_archivo
-- ----------------------------
INSERT INTO `detalle_archivo` VALUES ('746', '105', '2420');
INSERT INTO `detalle_archivo` VALUES ('747', '105', '2424');
INSERT INTO `detalle_archivo` VALUES ('748', '105', '2425');
INSERT INTO `detalle_archivo` VALUES ('749', '105', '2428');
INSERT INTO `detalle_archivo` VALUES ('750', '105', '2432');
INSERT INTO `detalle_archivo` VALUES ('751', '105', '2434');
INSERT INTO `detalle_archivo` VALUES ('752', '105', '2452');
INSERT INTO `detalle_archivo` VALUES ('753', '105', '2465');
INSERT INTO `detalle_archivo` VALUES ('754', '105', '2495');
INSERT INTO `detalle_archivo` VALUES ('755', '105', '2499');
INSERT INTO `detalle_archivo` VALUES ('756', '105', '2507');
INSERT INTO `detalle_archivo` VALUES ('757', '105', '2508');
INSERT INTO `detalle_archivo` VALUES ('758', '105', '2511');
INSERT INTO `detalle_archivo` VALUES ('759', '105', '2529');
INSERT INTO `detalle_archivo` VALUES ('760', '105', '2530');
INSERT INTO `detalle_archivo` VALUES ('761', '105', '2556');
INSERT INTO `detalle_archivo` VALUES ('762', '105', '2558');
INSERT INTO `detalle_archivo` VALUES ('763', '105', '2573');
INSERT INTO `detalle_archivo` VALUES ('764', '105', '2578');
INSERT INTO `detalle_archivo` VALUES ('765', '105', '2579');
INSERT INTO `detalle_archivo` VALUES ('766', '106', '2421');

-- ----------------------------
-- Table structure for email
-- ----------------------------
DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `idemail` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idtipoemail` int(11) unsigned NOT NULL,
  `ididioma` char(2) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `estado_em` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`idemail`),
  KEY `fk_contenido_email_idioma_1` (`ididioma`) USING BTREE,
  KEY `fk_email_tipo_email_1` (`idtipoemail`) USING BTREE,
  CONSTRAINT `fk_contenido_email_idioma_1` FOREIGN KEY (`ididioma`) REFERENCES `idioma` (`ididioma`),
  CONSTRAINT `fk_email_tipo_email_1` FOREIGN KEY (`idtipoemail`) REFERENCES `tipo_email` (`idtipoemail`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of email
-- ----------------------------
INSERT INTO `email` VALUES ('1', '1', 'es', 'Bienvenida', '<p>Estimado Sr/Sra. <br/>Les damos nuestra cordial bienvenida y le agradecemos la oportunidad que nos brinda para encargarnos de sus fotos vacacionales.En breve le comunicaremos sobre la disponibilidad de sus fotográfias en su espacio privado.</p>', '1');
INSERT INTO `email` VALUES ('5', '2', 'es', 'Ya están disponibles sus fotos', '<p><span style=\"font-size: 14px;float: none;\">Estimado Sr/Sra.</span><br/>Puede acceder a su espacio privado desde este enlace:</p>', '1');
INSERT INTO `email` VALUES ('6', '3', 'es', 'Tiene disponibles sus fotos', '<p><span style=\"font-size: 14px;float: none;\">Estimado Sr/Sra.</span><br/>Le recordamos que puede acceder a su espacio privado desde este enlace:</p>', '1');
INSERT INTO `email` VALUES ('7', '4', 'es', 'Aproveche este descuento para adquirir sus fotos', '<p>Estimado Sr/Sra.Adquiera sus fotos ahora con un descuento del 20%<br/>Puede acceder a su espacio privado desde este enlace:</p>', '1');
INSERT INTO `email` VALUES ('8', '5', 'es', 'Ultima oportunidad para adquirir sus fotos, ahora con un 50% de descuento!', '<p>Estimado Sr/Sra. Le informamos que vamos a proceder a eliminar sus fotos de nuestros servidores.Dispondrá de 3 días para adquirir sus fotos con un 50% de descuentos.Una vez eliminadas no podrá volver a acceder a su espacio privado.Puede acceder a su espacio privado desde este enlace:</p>', '1');
INSERT INTO `email` VALUES ('9', '6', 'es', 'Resumen de su compra', 'Gracias por su compra', '1');

-- ----------------------------
-- Table structure for excursion
-- ----------------------------
DROP TABLE IF EXISTS `excursion`;
CREATE TABLE `excursion` (
  `idexcursion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `precio_pack` float NOT NULL,
  `precio_primera` float NOT NULL,
  `precio_adicional` float NOT NULL,
  `createdat` datetime NOT NULL,
  `updatedat` datetime NOT NULL,
  `iduser_reg` int(11) unsigned NOT NULL COMMENT 'usuario que registra',
  `fecha_anula` datetime DEFAULT NULL,
  `iduser_anula` int(11) unsigned DEFAULT NULL COMMENT 'usuario que anula',
  `estado_exc` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; 1: activo',
  `precio_all` float NOT NULL,
  PRIMARY KEY (`idexcursion`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of excursion
-- ----------------------------
INSERT INTO `excursion` VALUES ('1', 'MARINA CARIBE', '69', '15', '10', '2017-12-20 04:55:19', '2018-02-26 23:23:18', '2', '2018-03-29 22:23:18', '2', '1', '99');
INSERT INTO `excursion` VALUES ('2', 'BEBE CATAMARAN', '69', '15', '10', '2017-12-20 04:56:13', '2018-02-28 12:11:52', '2', '2018-03-29 22:23:20', '2', '1', '99');
INSERT INTO `excursion` VALUES ('3', 'NEXUS CLASICA', '69', '15', '10', '2018-01-04 05:44:50', '2018-02-21 21:00:41', '2', '2018-03-29 22:23:23', '2', '1', '99');
INSERT INTO `excursion` VALUES ('4', 'MANOLOS', '69', '15', '10', '2018-02-28 12:39:42', '2018-02-28 12:39:42', '2', '2018-03-29 22:23:26', '2', '1', '99');
INSERT INTO `excursion` VALUES ('5', 'RAIFY TOUR', '69', '15', '10', '2018-02-28 22:03:45', '2018-02-28 22:03:45', '2', '2018-03-29 22:23:28', '2', '1', '99');
INSERT INTO `excursion` VALUES ('6', 'ALL INCLUSIVE', '69', '15', '10', '2018-03-29 22:12:00', '2018-03-29 22:25:30', '2', null, null, '0', '99');
INSERT INTO `excursion` VALUES ('7', 'DIGITAL FUN PASS', '69', '15', '10', '2018-03-29 22:16:06', '2018-03-29 22:24:09', '2', null, null, '0', '99');
INSERT INTO `excursion` VALUES ('8', 'ALL INCLUSIVE CASH', '69', '15', '10', '2018-04-19 23:35:02', '2018-04-19 23:35:02', '2', null, null, '0', '99');
INSERT INTO `excursion` VALUES ('9', 'NEXUS SUBMARINO', '69', '15', '10', '2018-05-07 15:00:30', '2018-05-07 15:01:39', '2', '2018-05-07 15:02:22', '2', '0', '0');
INSERT INTO `excursion` VALUES ('10', 'INFINITY', '69', '15', '10', '2018-05-07 15:02:56', '2018-05-07 21:55:26', '2', null, null, '1', '99');
INSERT INTO `excursion` VALUES ('11', 'CARLOS', '69', '15', '10', '2018-05-07 15:07:58', '2018-05-07 21:47:46', '2', null, null, '1', '99');
INSERT INTO `excursion` VALUES ('12', 'OUTBACK SAFARI', '79', '15', '10', '2018-05-10 03:41:51', '2018-05-17 13:33:10', '2', null, null, '1', '99');
INSERT INTO `excursion` VALUES ('13', 'OTRA NUEVA EXCURSION', '169', '110', '115', '2018-05-14 15:58:43', '2018-05-14 15:58:43', '2', null, null, '1', '199');

-- ----------------------------
-- Table structure for excursion_video
-- ----------------------------
DROP TABLE IF EXISTS `excursion_video`;
CREATE TABLE `excursion_video` (
  `idexcursionvideo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idexcursion` int(11) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `nombre_video` varchar(255) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1' COMMENT '0: anulado; 1: activo',
  PRIMARY KEY (`idexcursionvideo`),
  KEY `fk_excursion_video_excursion_1` (`idexcursion`),
  CONSTRAINT `fk_excursion_video_excursion_1` FOREIGN KEY (`idexcursion`) REFERENCES `excursion` (`idexcursion`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of excursion_video
-- ----------------------------
INSERT INTO `excursion_video` VALUES ('16', '1', '2018-05-05', '05052018-01.mp4', '117445757', '1');
INSERT INTO `excursion_video` VALUES ('17', '2', '2018-05-05', '05052018-02.mp4', '117445757', '1');
INSERT INTO `excursion_video` VALUES ('18', '1', '0000-00-00', '20180507-01.mp4', '0', '1');
INSERT INTO `excursion_video` VALUES ('19', '1', '2018-05-07', '07052018-01.mp4', '0', '1');

-- ----------------------------
-- Table structure for ficha
-- ----------------------------
DROP TABLE IF EXISTS `ficha`;
CREATE TABLE `ficha` (
  `idficha` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idseccioncontenido` int(11) unsigned NOT NULL,
  `titulo_fi` varchar(255) NOT NULL,
  `descripcion_corta` varchar(255) DEFAULT NULL,
  `descripcion_fi` text,
  `icono_fi` varchar(255) DEFAULT NULL,
  `codigo_vimeo` varchar(255) DEFAULT NULL,
  `codigo_youtube` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `texto_link` varchar(255) DEFAULT NULL COMMENT 'texto del boton que linkea a la web site',
  `estado_fi` varchar(255) NOT NULL DEFAULT '1' COMMENT '1:activo; 0:anulado',
  PRIMARY KEY (`idficha`),
  KEY `fk_ficha_seccion_contenido_1` (`idseccioncontenido`) USING BTREE,
  CONSTRAINT `fk_ficha_seccion_contenido_1` FOREIGN KEY (`idseccioncontenido`) REFERENCES `seccion_contenido` (`idseccioncontenido`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of ficha
-- ----------------------------
INSERT INTO `ficha` VALUES ('1', '6', 'REGÍSTRATE', 'Introduce el código provisto en tu Photopass*', 'Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Pellentesque vitae dui.rg', 'halcyon-icon-user', null, null, null, null, '1');
INSERT INTO `ficha` VALUES ('2', '6', 'SELECCIONA TUS FOTOS', 'Haz tu paquete o compra fotos y videos individuales', 'Etiam turpis tortor, finibus quis urna eu, venenatis dapibus leo. Etiam sit amet fringilla.', 'halcyon-icon-photo-camera', null, null, null, null, '1');
INSERT INTO `ficha` VALUES ('3', '6', 'PAGOS CON PAYPAL Y TARJETA', 'Selecciona tu método de pago y completa tu compra descargando tus imágenes.', 'Aliquam pretium diam a elit dignissim, sit amet sodales neque tristique. Duis non.', 'halcyon-interface-icon-credit-card', null, null, null, null, '1');
INSERT INTO `ficha` VALUES ('4', '4', 'FOTOGRAFÍA SOCIAL', 'Nuestro servicio de Fotografía social está orientado a todo tipo de eventos como Bodas, banquetes, fiestas,...', '<p>Despreocupese de todo y contrate nuestro servicio de <b>Fotografía social</b>. Dispondrá de un equipo dedicado a capturar todos aquellos momentos más importantes de su celebración.</p>', 'halcyon-icon-photos', null, null, 'http://www.hementxe.com', 'DISEÑO PAGINAS WEB', '1');
INSERT INTO `ficha` VALUES ('5', '4', 'EXCURSIONES', null, '', 'halcyon-icon-photos', null, 'Ree-byztoJs', null, null, '1');
INSERT INTO `ficha` VALUES ('6', '4', 'VIDEO SOCIAL', '-', '<p>TEXTO</p>', 'halcyon-icon-photos', '245013583', null, null, null, '1');
INSERT INTO `ficha` VALUES ('7', '4', 'VIDEO CORPORATIVO', '-', '', 'halcyon-icon-photos', null, 'BfOdWSiyWoc', null, null, '1');
INSERT INTO `ficha` VALUES ('8', '4', 'DESTINATION WEEDINGS', null, '', 'halcyon-icon-photos', null, null, null, null, '1');
INSERT INTO `ficha` VALUES ('9', '4', 'FOTO & VIDEO 360', null, null, 'halcyon-icon-photos', null, null, null, null, '1');
INSERT INTO `ficha` VALUES ('10', '4', 'DFB', null, null, 'halcyon-icon-photos', null, null, null, null, '0');

-- ----------------------------
-- Table structure for ficha_imagen
-- ----------------------------
DROP TABLE IF EXISTS `ficha_imagen`;
CREATE TABLE `ficha_imagen` (
  `idfichaimagen` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idficha` int(11) unsigned NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` int(2) DEFAULT '1',
  PRIMARY KEY (`idfichaimagen`),
  KEY `fk_ficha_imagen_ficha_1` (`idficha`),
  CONSTRAINT `fk_ficha_imagen_ficha_1` FOREIGN KEY (`idficha`) REFERENCES `ficha` (`idficha`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of ficha_imagen
-- ----------------------------
INSERT INTO `ficha_imagen` VALUES ('1', '4', 'qhA0hI1Kd3.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('2', '4', 's1zeP0EgUN.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('3', '4', 'KDlX1lfFWH.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('4', '4', 'aDTTXLsWm9.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('5', '5', 'EpdB1Yj4bz.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('6', '6', 'eg003ALO4Q.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('7', '6', 'FrFafibiRb.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('8', '4', 'qtYwcVifZm.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('9', '4', '5pa2rbMO3f.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('10', '4', 'ZAxj0Rs9v6.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('11', '4', 'FwtwoODr66.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('12', '4', 'MolXkj1rZH.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('13', '4', 'HnBxQ7Yijm.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('14', '4', 'EaYel18L9q.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('15', '4', 'wAIrKJu14V.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('16', '4', 'CccRk3Vet7.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('17', '4', 'KnA5EbmiEQ.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('18', '4', 'HMHIrv0PUh.jpg', '0');
INSERT INTO `ficha_imagen` VALUES ('19', '4', 'mlNtDXOJXh.jpg', '1');
INSERT INTO `ficha_imagen` VALUES ('20', '4', 'Hdaw72kDzu.jpg', '1');
INSERT INTO `ficha_imagen` VALUES ('21', '4', 'J9yg8usgEO.jpg', '1');
INSERT INTO `ficha_imagen` VALUES ('22', '4', 'dl4QbPva6L.jpg', '1');
INSERT INTO `ficha_imagen` VALUES ('23', '4', '6vaGhWgZRg.jpg', '1');

-- ----------------------------
-- Table structure for grupo
-- ----------------------------
DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `idgrupo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_gr` varchar(255) NOT NULL,
  `key_grupo` varchar(100) DEFAULT NULL,
  `estado_gr` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:habilitado; 0:anulado;',
  PRIMARY KEY (`idgrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grupo
-- ----------------------------
INSERT INTO `grupo` VALUES ('1', 'SU', 'key_root', '1');
INSERT INTO `grupo` VALUES ('2', 'ADMINISTRADOR', 'key_admin', '1');
INSERT INTO `grupo` VALUES ('3', 'CLIENTE', 'key_cliente', '1');
INSERT INTO `grupo` VALUES ('4', 'OPERADOR', 'key_ope', '1');
INSERT INTO `grupo` VALUES ('5', 'SUPERVISOR', 'key_super', '1');

-- ----------------------------
-- Table structure for icono
-- ----------------------------
DROP TABLE IF EXISTS `icono`;
CREATE TABLE `icono` (
  `idicono` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `icono` varchar(255) NOT NULL,
  `idtipoicono` int(11) unsigned NOT NULL,
  PRIMARY KEY (`idicono`)
) ENGINE=InnoDB AUTO_INCREMENT=386 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of icono
-- ----------------------------
INSERT INTO `icono` VALUES ('1', 'add', 'halcyon-icon-add', '1');
INSERT INTO `icono` VALUES ('2', 'add-1', 'halcyon-icon-add-1', '1');
INSERT INTO `icono` VALUES ('3', 'add-2', 'halcyon-icon-add-2', '1');
INSERT INTO `icono` VALUES ('4', 'add-3', 'halcyon-icon-add-3', '1');
INSERT INTO `icono` VALUES ('5', 'agenda', 'halcyon-icon-agenda', '1');
INSERT INTO `icono` VALUES ('6', 'alarm', 'halcyon-icon-alarm', '1');
INSERT INTO `icono` VALUES ('7', 'alarm-1', 'halcyon-icon-alarm-1', '1');
INSERT INTO `icono` VALUES ('8', 'alarm-clock', 'halcyon-icon-alarm-clock', '1');
INSERT INTO `icono` VALUES ('9', 'alarm-clock-1', 'halcyon-icon-alarm-clock-1', '1');
INSERT INTO `icono` VALUES ('10', 'albums', 'halcyon-icon-albums', '1');
INSERT INTO `icono` VALUES ('11', 'app', 'halcyon-icon-app', '1');
INSERT INTO `icono` VALUES ('12', 'archive', 'halcyon-icon-archive', '1');
INSERT INTO `icono` VALUES ('13', 'archive-1', 'halcyon-icon-archive-1', '1');
INSERT INTO `icono` VALUES ('14', 'archive-2', 'halcyon-icon-archive-2', '1');
INSERT INTO `icono` VALUES ('15', 'archive-3', 'halcyon-icon-archive-3', '1');
INSERT INTO `icono` VALUES ('16', 'attachment', 'halcyon-icon-attachment', '1');
INSERT INTO `icono` VALUES ('17', 'back', 'halcyon-icon-back', '1');
INSERT INTO `icono` VALUES ('18', 'battery', 'halcyon-icon-battery', '1');
INSERT INTO `icono` VALUES ('19', 'battery-1', 'halcyon-icon-battery-1', '1');
INSERT INTO `icono` VALUES ('20', 'battery-2', 'halcyon-icon-battery-2', '1');
INSERT INTO `icono` VALUES ('21', 'battery-3', 'halcyon-icon-battery-3', '1');
INSERT INTO `icono` VALUES ('22', 'battery-4', 'halcyon-icon-battery-4', '1');
INSERT INTO `icono` VALUES ('23', 'battery-5', 'halcyon-icon-battery-5', '1');
INSERT INTO `icono` VALUES ('24', 'battery-6', 'halcyon-icon-battery-6', '1');
INSERT INTO `icono` VALUES ('25', 'battery-7', 'halcyon-icon-battery-7', '1');
INSERT INTO `icono` VALUES ('26', 'battery-8', 'halcyon-icon-battery-8', '1');
INSERT INTO `icono` VALUES ('27', 'battery-9', 'halcyon-icon-battery-9', '1');
INSERT INTO `icono` VALUES ('28', 'binoculars', 'halcyon-icon-binoculars', '1');
INSERT INTO `icono` VALUES ('29', 'blueprint', 'halcyon-icon-blueprint', '1');
INSERT INTO `icono` VALUES ('30', 'bluetooth', 'halcyon-icon-bluetooth', '1');
INSERT INTO `icono` VALUES ('31', 'bluetooth-1', 'halcyon-icon-bluetooth-1', '1');
INSERT INTO `icono` VALUES ('32', 'bookmark', 'halcyon-icon-bookmark', '1');
INSERT INTO `icono` VALUES ('33', 'bookmark-1', 'halcyon-icon-bookmark-1', '1');
INSERT INTO `icono` VALUES ('34', 'briefcase', 'halcyon-icon-briefcase', '1');
INSERT INTO `icono` VALUES ('35', 'broken-link', 'halcyon-icon-broken-link', '1');
INSERT INTO `icono` VALUES ('36', 'calculator', 'halcyon-icon-calculator', '1');
INSERT INTO `icono` VALUES ('37', 'calculator-1', 'halcyon-icon-calculator-1', '1');
INSERT INTO `icono` VALUES ('38', 'calendar', 'halcyon-icon-calendar', '1');
INSERT INTO `icono` VALUES ('39', 'calendar-1', 'halcyon-icon-calendar-1', '1');
INSERT INTO `icono` VALUES ('40', 'calendar-2', 'halcyon-icon-calendar-2', '1');
INSERT INTO `icono` VALUES ('41', 'calendar-3', 'halcyon-icon-calendar-3', '1');
INSERT INTO `icono` VALUES ('42', 'calendar-4', 'halcyon-icon-calendar-4', '1');
INSERT INTO `icono` VALUES ('43', 'calendar-5', 'halcyon-icon-calendar-5', '1');
INSERT INTO `icono` VALUES ('44', 'calendar-6', 'halcyon-icon-calendar-6', '1');
INSERT INTO `icono` VALUES ('45', 'calendar-7', 'halcyon-icon-calendar-7', '1');
INSERT INTO `icono` VALUES ('46', 'checked', 'halcyon-icon-checked', '1');
INSERT INTO `icono` VALUES ('47', 'checked-1', 'halcyon-icon-checked-1', '1');
INSERT INTO `icono` VALUES ('48', 'clock', 'halcyon-icon-clock', '1');
INSERT INTO `icono` VALUES ('49', 'clock-1', 'halcyon-icon-clock-1', '1');
INSERT INTO `icono` VALUES ('50', 'close', 'halcyon-icon-close', '1');
INSERT INTO `icono` VALUES ('51', 'cloud', 'halcyon-icon-cloud', '1');
INSERT INTO `icono` VALUES ('52', 'cloud-computing', 'halcyon-icon-cloud-computing', '1');
INSERT INTO `icono` VALUES ('53', 'cloud-computing-1', 'halcyon-icon-cloud-computing-1', '1');
INSERT INTO `icono` VALUES ('54', 'cloud-computing-2', 'halcyon-icon-cloud-computing-2', '1');
INSERT INTO `icono` VALUES ('55', 'cloud-computing-3', 'halcyon-icon-cloud-computing-3', '1');
INSERT INTO `icono` VALUES ('56', 'cloud-computing-4', 'halcyon-icon-cloud-computing-4', '1');
INSERT INTO `icono` VALUES ('57', 'cloud-computing-5', 'halcyon-icon-cloud-computing-5', '1');
INSERT INTO `icono` VALUES ('58', 'command', 'halcyon-icon-command', '1');
INSERT INTO `icono` VALUES ('59', 'compact-disc', 'halcyon-icon-compact-disc', '1');
INSERT INTO `icono` VALUES ('60', 'compact-disc-1', 'halcyon-icon-compact-disc-1', '1');
INSERT INTO `icono` VALUES ('61', 'compact-disc-2', 'halcyon-icon-compact-disc-2', '1');
INSERT INTO `icono` VALUES ('62', 'compass', 'halcyon-icon-compass', '1');
INSERT INTO `icono` VALUES ('63', 'compose', 'halcyon-icon-compose', '1');
INSERT INTO `icono` VALUES ('64', 'controls', 'halcyon-icon-controls', '1');
INSERT INTO `icono` VALUES ('65', 'controls-1', 'halcyon-icon-controls-1', '1');
INSERT INTO `icono` VALUES ('66', 'controls-2', 'halcyon-icon-controls-2', '1');
INSERT INTO `icono` VALUES ('67', 'controls-3', 'halcyon-icon-controls-3', '1');
INSERT INTO `icono` VALUES ('68', 'controls-4', 'halcyon-icon-controls-4', '1');
INSERT INTO `icono` VALUES ('69', 'controls-5', 'halcyon-icon-controls-5', '1');
INSERT INTO `icono` VALUES ('70', 'controls-6', 'halcyon-icon-controls-6', '1');
INSERT INTO `icono` VALUES ('71', 'controls-7', 'halcyon-icon-controls-7', '1');
INSERT INTO `icono` VALUES ('72', 'controls-8', 'halcyon-icon-controls-8', '1');
INSERT INTO `icono` VALUES ('73', 'controls-9', 'halcyon-icon-controls-9', '1');
INSERT INTO `icono` VALUES ('74', 'database', 'halcyon-icon-database', '1');
INSERT INTO `icono` VALUES ('75', 'database-1', 'halcyon-icon-database-1', '1');
INSERT INTO `icono` VALUES ('76', 'database-2', 'halcyon-icon-database-2', '1');
INSERT INTO `icono` VALUES ('77', 'database-3', 'halcyon-icon-database-3', '1');
INSERT INTO `icono` VALUES ('78', 'diamond', 'halcyon-icon-diamond', '1');
INSERT INTO `icono` VALUES ('79', 'diploma', 'halcyon-icon-diploma', '1');
INSERT INTO `icono` VALUES ('80', 'dislike', 'halcyon-icon-dislike', '1');
INSERT INTO `icono` VALUES ('81', 'dislike-1', 'halcyon-icon-dislike-1', '1');
INSERT INTO `icono` VALUES ('82', 'divide', 'halcyon-icon-divide', '1');
INSERT INTO `icono` VALUES ('83', 'divide-1', 'halcyon-icon-divide-1', '1');
INSERT INTO `icono` VALUES ('84', 'division', 'halcyon-icon-division', '1');
INSERT INTO `icono` VALUES ('85', 'document', 'halcyon-icon-document', '1');
INSERT INTO `icono` VALUES ('86', 'download', 'halcyon-icon-download', '1');
INSERT INTO `icono` VALUES ('87', 'edit', 'halcyon-icon-edit', '1');
INSERT INTO `icono` VALUES ('88', 'edit-1', 'halcyon-icon-edit-1', '1');
INSERT INTO `icono` VALUES ('89', 'eject', 'halcyon-icon-eject', '1');
INSERT INTO `icono` VALUES ('90', 'eject-1', 'halcyon-icon-eject-1', '1');
INSERT INTO `icono` VALUES ('91', 'equal', 'halcyon-icon-equal', '1');
INSERT INTO `icono` VALUES ('92', 'equal-1', 'halcyon-icon-equal-1', '1');
INSERT INTO `icono` VALUES ('93', 'equal-2', 'halcyon-icon-equal-2', '1');
INSERT INTO `icono` VALUES ('94', 'error', 'halcyon-icon-error', '1');
INSERT INTO `icono` VALUES ('95', 'exit', 'halcyon-icon-exit', '1');
INSERT INTO `icono` VALUES ('96', 'exit-1', 'halcyon-icon-exit-1', '1');
INSERT INTO `icono` VALUES ('97', 'exit-2', 'halcyon-icon-exit-2', '1');
INSERT INTO `icono` VALUES ('98', 'eyeglasses', 'halcyon-icon-eyeglasses', '1');
INSERT INTO `icono` VALUES ('99', 'fast-forward', 'halcyon-icon-fast-forward', '1');
INSERT INTO `icono` VALUES ('100', 'fast-forward-1', 'halcyon-icon-fast-forward-1', '1');
INSERT INTO `icono` VALUES ('101', 'fax', 'halcyon-icon-fax', '1');
INSERT INTO `icono` VALUES ('102', 'file', 'halcyon-icon-file', '1');
INSERT INTO `icono` VALUES ('103', 'file-1', 'halcyon-icon-file-1', '1');
INSERT INTO `icono` VALUES ('104', 'file-2', 'halcyon-icon-file-2', '1');
INSERT INTO `icono` VALUES ('105', 'film', 'halcyon-icon-film', '1');
INSERT INTO `icono` VALUES ('106', 'fingerprint', 'halcyon-icon-fingerprint', '1');
INSERT INTO `icono` VALUES ('107', 'flag', 'halcyon-icon-flag', '1');
INSERT INTO `icono` VALUES ('108', 'flag-1', 'halcyon-icon-flag-1', '1');
INSERT INTO `icono` VALUES ('109', 'flag-2', 'halcyon-icon-flag-2', '1');
INSERT INTO `icono` VALUES ('110', 'flag-3', 'halcyon-icon-flag-3', '1');
INSERT INTO `icono` VALUES ('111', 'flag-4', 'halcyon-icon-flag-4', '1');
INSERT INTO `icono` VALUES ('112', 'focus', 'halcyon-icon-focus', '1');
INSERT INTO `icono` VALUES ('113', 'folder', 'halcyon-icon-folder', '1');
INSERT INTO `icono` VALUES ('114', 'folder-1', 'halcyon-icon-folder-1', '1');
INSERT INTO `icono` VALUES ('115', 'folder-2', 'halcyon-icon-folder-2', '1');
INSERT INTO `icono` VALUES ('116', 'folder-3', 'halcyon-icon-folder-3', '1');
INSERT INTO `icono` VALUES ('117', 'folder-4', 'halcyon-icon-folder-4', '1');
INSERT INTO `icono` VALUES ('118', 'folder-5', 'halcyon-icon-folder-5', '1');
INSERT INTO `icono` VALUES ('119', 'folder-6', 'halcyon-icon-folder-6', '1');
INSERT INTO `icono` VALUES ('120', 'folder-7', 'halcyon-icon-folder-7', '1');
INSERT INTO `icono` VALUES ('121', 'folder-8', 'halcyon-icon-folder-8', '1');
INSERT INTO `icono` VALUES ('122', 'folder-9', 'halcyon-icon-folder-9', '1');
INSERT INTO `icono` VALUES ('123', 'folder-10', 'halcyon-icon-folder-10', '1');
INSERT INTO `icono` VALUES ('124', 'folder-11', 'halcyon-icon-folder-11', '1');
INSERT INTO `icono` VALUES ('125', 'folder-12', 'halcyon-icon-folder-12', '1');
INSERT INTO `icono` VALUES ('126', 'folder-13', 'halcyon-icon-folder-13', '1');
INSERT INTO `icono` VALUES ('127', 'folder-14', 'halcyon-icon-folder-14', '1');
INSERT INTO `icono` VALUES ('128', 'folder-15', 'halcyon-icon-folder-15', '1');
INSERT INTO `icono` VALUES ('129', 'folder-16', 'halcyon-icon-folder-16', '1');
INSERT INTO `icono` VALUES ('130', 'folder-17', 'halcyon-icon-folder-17', '1');
INSERT INTO `icono` VALUES ('131', 'folder-18', 'halcyon-icon-folder-18', '1');
INSERT INTO `icono` VALUES ('132', 'folder-19', 'halcyon-icon-folder-19', '1');
INSERT INTO `icono` VALUES ('133', 'forbidden', 'halcyon-icon-forbidden', '1');
INSERT INTO `icono` VALUES ('134', 'funnel', 'halcyon-icon-funnel', '1');
INSERT INTO `icono` VALUES ('135', 'garbage', 'halcyon-icon-garbage', '1');
INSERT INTO `icono` VALUES ('136', 'garbage-1', 'halcyon-icon-garbage-1', '1');
INSERT INTO `icono` VALUES ('137', 'garbage-2', 'halcyon-icon-garbage-2', '1');
INSERT INTO `icono` VALUES ('138', 'gift', 'halcyon-icon-gift', '1');
INSERT INTO `icono` VALUES ('139', 'help', 'halcyon-icon-help', '1');
INSERT INTO `icono` VALUES ('140', 'hide', 'halcyon-icon-hide', '1');
INSERT INTO `icono` VALUES ('141', 'hold', 'halcyon-icon-hold', '1');
INSERT INTO `icono` VALUES ('142', 'home', 'halcyon-icon-home', '1');
INSERT INTO `icono` VALUES ('143', 'home-1', 'halcyon-icon-home-1', '1');
INSERT INTO `icono` VALUES ('144', 'home-2', 'halcyon-icon-home-2', '1');
INSERT INTO `icono` VALUES ('145', 'hourglass', 'halcyon-icon-hourglass', '1');
INSERT INTO `icono` VALUES ('146', 'hourglass-1', 'halcyon-icon-hourglass-1', '1');
INSERT INTO `icono` VALUES ('147', 'hourglass-2', 'halcyon-icon-hourglass-2', '1');
INSERT INTO `icono` VALUES ('148', 'hourglass-3', 'halcyon-icon-hourglass-3', '1');
INSERT INTO `icono` VALUES ('149', 'house', 'halcyon-icon-house', '1');
INSERT INTO `icono` VALUES ('150', 'id-card', 'halcyon-icon-id-card', '1');
INSERT INTO `icono` VALUES ('151', 'id-card-1', 'halcyon-icon-id-card-1', '1');
INSERT INTO `icono` VALUES ('152', 'id-card-2', 'halcyon-icon-id-card-2', '1');
INSERT INTO `icono` VALUES ('153', 'id-card-3', 'halcyon-icon-id-card-3', '1');
INSERT INTO `icono` VALUES ('154', 'id-card-4', 'halcyon-icon-id-card-4', '1');
INSERT INTO `icono` VALUES ('155', 'id-card-5', 'halcyon-icon-id-card-5', '1');
INSERT INTO `icono` VALUES ('156', 'idea', 'halcyon-icon-idea', '1');
INSERT INTO `icono` VALUES ('157', 'incoming', 'halcyon-icon-incoming', '1');
INSERT INTO `icono` VALUES ('158', 'infinity', 'halcyon-icon-infinity', '1');
INSERT INTO `icono` VALUES ('159', 'info', 'halcyon-icon-info', '1');
INSERT INTO `icono` VALUES ('160', 'internet', 'halcyon-icon-internet', '1');
INSERT INTO `icono` VALUES ('161', 'key', 'halcyon-icon-key', '1');
INSERT INTO `icono` VALUES ('162', 'lamp', 'halcyon-icon-lamp', '1');
INSERT INTO `icono` VALUES ('163', 'layers', 'halcyon-icon-layers', '1');
INSERT INTO `icono` VALUES ('164', 'layers-1', 'halcyon-icon-layers-1', '1');
INSERT INTO `icono` VALUES ('165', 'like', 'halcyon-icon-like', '1');
INSERT INTO `icono` VALUES ('166', 'like-1', 'halcyon-icon-like-1', '1');
INSERT INTO `icono` VALUES ('167', 'like-2', 'halcyon-icon-like-2', '1');
INSERT INTO `icono` VALUES ('168', 'link', 'halcyon-icon-link', '1');
INSERT INTO `icono` VALUES ('169', 'list', 'halcyon-icon-list', '1');
INSERT INTO `icono` VALUES ('170', 'list-1', 'halcyon-icon-list-1', '1');
INSERT INTO `icono` VALUES ('171', 'lock', 'halcyon-icon-lock', '1');
INSERT INTO `icono` VALUES ('172', 'lock-1', 'halcyon-icon-lock-1', '1');
INSERT INTO `icono` VALUES ('173', 'locked', 'halcyon-icon-locked', '1');
INSERT INTO `icono` VALUES ('174', 'locked-1', 'halcyon-icon-locked-1', '1');
INSERT INTO `icono` VALUES ('175', 'locked-2', 'halcyon-icon-locked-2', '1');
INSERT INTO `icono` VALUES ('176', 'locked-3', 'halcyon-icon-locked-3', '1');
INSERT INTO `icono` VALUES ('177', 'locked-4', 'halcyon-icon-locked-4', '1');
INSERT INTO `icono` VALUES ('178', 'locked-5', 'halcyon-icon-locked-5', '1');
INSERT INTO `icono` VALUES ('179', 'locked-6', 'halcyon-icon-locked-6', '1');
INSERT INTO `icono` VALUES ('180', 'login', 'halcyon-icon-login', '1');
INSERT INTO `icono` VALUES ('181', 'magic-wand', 'halcyon-icon-magic-wand', '1');
INSERT INTO `icono` VALUES ('182', 'magnet', 'halcyon-icon-magnet', '1');
INSERT INTO `icono` VALUES ('183', 'magnet-1', 'halcyon-icon-magnet-1', '1');
INSERT INTO `icono` VALUES ('184', 'magnet-2', 'halcyon-icon-magnet-2', '1');
INSERT INTO `icono` VALUES ('185', 'map', 'halcyon-icon-map', '1');
INSERT INTO `icono` VALUES ('186', 'map-1', 'halcyon-icon-map-1', '1');
INSERT INTO `icono` VALUES ('187', 'map-2', 'halcyon-icon-map-2', '1');
INSERT INTO `icono` VALUES ('188', 'map-location', 'halcyon-icon-map-location', '1');
INSERT INTO `icono` VALUES ('189', 'megaphone', 'halcyon-icon-megaphone', '1');
INSERT INTO `icono` VALUES ('190', 'megaphone-1', 'halcyon-icon-megaphone-1', '1');
INSERT INTO `icono` VALUES ('191', 'menu2', 'halcyon-icon-menu2', '1');
INSERT INTO `icono` VALUES ('192', 'menu-1', 'halcyon-icon-menu-1', '1');
INSERT INTO `icono` VALUES ('193', 'menu-2', 'halcyon-icon-menu-2', '1');
INSERT INTO `icono` VALUES ('194', 'menu-3', 'halcyon-icon-menu-3', '1');
INSERT INTO `icono` VALUES ('195', 'menu-4', 'halcyon-icon-menu-4', '1');
INSERT INTO `icono` VALUES ('196', 'microphone', 'halcyon-icon-microphone', '1');
INSERT INTO `icono` VALUES ('197', 'microphone-1', 'halcyon-icon-microphone-1', '1');
INSERT INTO `icono` VALUES ('198', 'minus', 'halcyon-icon-minus', '1');
INSERT INTO `icono` VALUES ('199', 'minus-1', 'halcyon-icon-minus-1', '1');
INSERT INTO `icono` VALUES ('200', 'more', 'halcyon-icon-more', '1');
INSERT INTO `icono` VALUES ('201', 'more-1', 'halcyon-icon-more-1', '1');
INSERT INTO `icono` VALUES ('202', 'more-2', 'halcyon-icon-more-2', '1');
INSERT INTO `icono` VALUES ('203', 'multiply', 'halcyon-icon-multiply', '1');
INSERT INTO `icono` VALUES ('204', 'multiply-1', 'halcyon-icon-multiply-1', '1');
INSERT INTO `icono` VALUES ('205', 'music-player', 'halcyon-icon-music-player', '1');
INSERT INTO `icono` VALUES ('206', 'music-player-1', 'halcyon-icon-music-player-1', '1');
INSERT INTO `icono` VALUES ('207', 'music-player-2', 'halcyon-icon-music-player-2', '1');
INSERT INTO `icono` VALUES ('208', 'music-player-3', 'halcyon-icon-music-player-3', '1');
INSERT INTO `icono` VALUES ('209', 'mute', 'halcyon-icon-mute', '1');
INSERT INTO `icono` VALUES ('210', 'muted', 'halcyon-icon-muted', '1');
INSERT INTO `icono` VALUES ('211', 'navigation', 'halcyon-icon-navigation', '1');
INSERT INTO `icono` VALUES ('212', 'navigation-1', 'halcyon-icon-navigation-1', '1');
INSERT INTO `icono` VALUES ('213', 'network', 'halcyon-icon-network', '1');
INSERT INTO `icono` VALUES ('214', 'newspaper', 'halcyon-icon-newspaper', '1');
INSERT INTO `icono` VALUES ('215', 'next', 'halcyon-icon-next', '1');
INSERT INTO `icono` VALUES ('216', 'note', 'halcyon-icon-note', '1');
INSERT INTO `icono` VALUES ('217', 'notebook', 'halcyon-icon-notebook', '1');
INSERT INTO `icono` VALUES ('218', 'notebook-1', 'halcyon-icon-notebook-1', '1');
INSERT INTO `icono` VALUES ('219', 'notebook-2', 'halcyon-icon-notebook-2', '1');
INSERT INTO `icono` VALUES ('220', 'notebook-3', 'halcyon-icon-notebook-3', '1');
INSERT INTO `icono` VALUES ('221', 'notebook-4', 'halcyon-icon-notebook-4', '1');
INSERT INTO `icono` VALUES ('222', 'notebook-5', 'halcyon-icon-notebook-5', '1');
INSERT INTO `icono` VALUES ('223', 'notepad', 'halcyon-icon-notepad', '1');
INSERT INTO `icono` VALUES ('224', 'notepad-1', 'halcyon-icon-notepad-1', '1');
INSERT INTO `icono` VALUES ('225', 'notepad-2', 'halcyon-icon-notepad-2', '1');
INSERT INTO `icono` VALUES ('226', 'notification', 'halcyon-icon-notification', '1');
INSERT INTO `icono` VALUES ('227', 'paper-plane', 'halcyon-icon-paper-plane', '1');
INSERT INTO `icono` VALUES ('228', 'paper-plane-1', 'halcyon-icon-paper-plane-1', '1');
INSERT INTO `icono` VALUES ('229', 'pause', 'halcyon-icon-pause', '1');
INSERT INTO `icono` VALUES ('230', 'pause-1', 'halcyon-icon-pause-1', '1');
INSERT INTO `icono` VALUES ('231', 'percent', 'halcyon-icon-percent', '1');
INSERT INTO `icono` VALUES ('232', 'percent-1', 'halcyon-icon-percent-1', '1');
INSERT INTO `icono` VALUES ('233', 'perspective', 'halcyon-icon-perspective', '1');
INSERT INTO `icono` VALUES ('234', 'photo-camera', 'halcyon-icon-photo-camera', '1');
INSERT INTO `icono` VALUES ('235', 'photo-camera-1', 'halcyon-icon-photo-camera-1', '1');
INSERT INTO `icono` VALUES ('236', 'photos', 'halcyon-icon-photos', '1');
INSERT INTO `icono` VALUES ('237', 'picture', 'halcyon-icon-picture', '1');
INSERT INTO `icono` VALUES ('238', 'picture-1', 'halcyon-icon-picture-1', '1');
INSERT INTO `icono` VALUES ('239', 'picture-2', 'halcyon-icon-picture-2', '1');
INSERT INTO `icono` VALUES ('240', 'pin', 'halcyon-icon-pin', '1');
INSERT INTO `icono` VALUES ('241', 'placeholder', 'halcyon-icon-placeholder', '1');
INSERT INTO `icono` VALUES ('242', 'placeholder-1', 'halcyon-icon-placeholder-1', '1');
INSERT INTO `icono` VALUES ('243', 'placeholder-2', 'halcyon-icon-placeholder-2', '1');
INSERT INTO `icono` VALUES ('244', 'placeholder-3', 'halcyon-icon-placeholder-3', '1');
INSERT INTO `icono` VALUES ('245', 'placeholders', 'halcyon-icon-placeholders', '1');
INSERT INTO `icono` VALUES ('246', 'play-button', 'halcyon-icon-play-button', '1');
INSERT INTO `icono` VALUES ('247', 'play-button-1', 'halcyon-icon-play-button-1', '1');
INSERT INTO `icono` VALUES ('248', 'plus', 'halcyon-icon-plus', '1');
INSERT INTO `icono` VALUES ('249', 'power', 'halcyon-icon-power', '1');
INSERT INTO `icono` VALUES ('250', 'previous', 'halcyon-icon-previous', '1');
INSERT INTO `icono` VALUES ('251', 'price-tag', 'halcyon-icon-price-tag', '1');
INSERT INTO `icono` VALUES ('252', 'print', 'halcyon-icon-print', '1');
INSERT INTO `icono` VALUES ('253', 'push-pin', 'halcyon-icon-push-pin', '1');
INSERT INTO `icono` VALUES ('254', 'radar', 'halcyon-icon-radar', '1');
INSERT INTO `icono` VALUES ('255', 'reading', 'halcyon-icon-reading', '1');
INSERT INTO `icono` VALUES ('256', 'record', 'halcyon-icon-record', '1');
INSERT INTO `icono` VALUES ('257', 'repeat', 'halcyon-icon-repeat', '1');
INSERT INTO `icono` VALUES ('258', 'repeat-1', 'halcyon-icon-repeat-1', '1');
INSERT INTO `icono` VALUES ('259', 'restart', 'halcyon-icon-restart', '1');
INSERT INTO `icono` VALUES ('260', 'resume', 'halcyon-icon-resume', '1');
INSERT INTO `icono` VALUES ('261', 'rewind', 'halcyon-icon-rewind', '1');
INSERT INTO `icono` VALUES ('262', 'rewind-1', 'halcyon-icon-rewind-1', '1');
INSERT INTO `icono` VALUES ('263', 'route', 'halcyon-icon-route', '1');
INSERT INTO `icono` VALUES ('264', 'save', 'halcyon-icon-save', '1');
INSERT INTO `icono` VALUES ('265', 'search', 'halcyon-icon-search', '1');
INSERT INTO `icono` VALUES ('266', 'search-1', 'halcyon-icon-search-1', '1');
INSERT INTO `icono` VALUES ('267', 'send', 'halcyon-icon-send', '1');
INSERT INTO `icono` VALUES ('268', 'server', 'halcyon-icon-server', '1');
INSERT INTO `icono` VALUES ('269', 'server-1', 'halcyon-icon-server-1', '1');
INSERT INTO `icono` VALUES ('270', 'server-2', 'halcyon-icon-server-2', '1');
INSERT INTO `icono` VALUES ('271', 'server-3', 'halcyon-icon-server-3', '1');
INSERT INTO `icono` VALUES ('272', 'settings', 'halcyon-icon-settings', '1');
INSERT INTO `icono` VALUES ('273', 'settings-1', 'halcyon-icon-settings-1', '1');
INSERT INTO `icono` VALUES ('274', 'settings-2', 'halcyon-icon-settings-2', '1');
INSERT INTO `icono` VALUES ('275', 'settings-3', 'halcyon-icon-settings-3', '1');
INSERT INTO `icono` VALUES ('276', 'settings-4', 'halcyon-icon-settings-4', '1');
INSERT INTO `icono` VALUES ('277', 'settings-5', 'halcyon-icon-settings-5', '1');
INSERT INTO `icono` VALUES ('278', 'settings-6', 'halcyon-icon-settings-6', '1');
INSERT INTO `icono` VALUES ('279', 'settings-7', 'halcyon-icon-settings-7', '1');
INSERT INTO `icono` VALUES ('280', 'settings-8', 'halcyon-icon-settings-8', '1');
INSERT INTO `icono` VALUES ('281', 'settings-9', 'halcyon-icon-settings-9', '1');
INSERT INTO `icono` VALUES ('282', 'share', 'halcyon-icon-share', '1');
INSERT INTO `icono` VALUES ('283', 'share-1', 'halcyon-icon-share-1', '1');
INSERT INTO `icono` VALUES ('284', 'share-2', 'halcyon-icon-share-2', '1');
INSERT INTO `icono` VALUES ('285', 'shuffle', 'halcyon-icon-shuffle', '1');
INSERT INTO `icono` VALUES ('286', 'shuffle-1', 'halcyon-icon-shuffle-1', '1');
INSERT INTO `icono` VALUES ('287', 'shutdown', 'halcyon-icon-shutdown', '1');
INSERT INTO `icono` VALUES ('288', 'sign', 'halcyon-icon-sign', '1');
INSERT INTO `icono` VALUES ('289', 'sign-1', 'halcyon-icon-sign-1', '1');
INSERT INTO `icono` VALUES ('290', 'skip', 'halcyon-icon-skip', '1');
INSERT INTO `icono` VALUES ('291', 'smartphone', 'halcyon-icon-smartphone', '1');
INSERT INTO `icono` VALUES ('292', 'smartphone-1', 'halcyon-icon-smartphone-1', '1');
INSERT INTO `icono` VALUES ('293', 'smartphone-2', 'halcyon-icon-smartphone-2', '1');
INSERT INTO `icono` VALUES ('294', 'smartphone-3', 'halcyon-icon-smartphone-3', '1');
INSERT INTO `icono` VALUES ('295', 'smartphone-4', 'halcyon-icon-smartphone-4', '1');
INSERT INTO `icono` VALUES ('296', 'smartphone-5', 'halcyon-icon-smartphone-5', '1');
INSERT INTO `icono` VALUES ('297', 'smartphone-6', 'halcyon-icon-smartphone-6', '1');
INSERT INTO `icono` VALUES ('298', 'smartphone-7', 'halcyon-icon-smartphone-7', '1');
INSERT INTO `icono` VALUES ('299', 'smartphone-8', 'halcyon-icon-smartphone-8', '1');
INSERT INTO `icono` VALUES ('300', 'smartphone-9', 'halcyon-icon-smartphone-9', '1');
INSERT INTO `icono` VALUES ('301', 'smartphone-10', 'halcyon-icon-smartphone-10', '1');
INSERT INTO `icono` VALUES ('302', 'smartphone-11', 'halcyon-icon-smartphone-11', '1');
INSERT INTO `icono` VALUES ('303', 'speaker', 'halcyon-icon-speaker', '1');
INSERT INTO `icono` VALUES ('304', 'speaker-1', 'halcyon-icon-speaker-1', '1');
INSERT INTO `icono` VALUES ('305', 'speaker-2', 'halcyon-icon-speaker-2', '1');
INSERT INTO `icono` VALUES ('306', 'speaker-3', 'halcyon-icon-speaker-3', '1');
INSERT INTO `icono` VALUES ('307', 'speaker-4', 'halcyon-icon-speaker-4', '1');
INSERT INTO `icono` VALUES ('308', 'speaker-5', 'halcyon-icon-speaker-5', '1');
INSERT INTO `icono` VALUES ('309', 'speaker-6', 'halcyon-icon-speaker-6', '1');
INSERT INTO `icono` VALUES ('310', 'speaker-7', 'halcyon-icon-speaker-7', '1');
INSERT INTO `icono` VALUES ('311', 'speaker-8', 'halcyon-icon-speaker-8', '1');
INSERT INTO `icono` VALUES ('312', 'spotlight', 'halcyon-icon-spotlight', '1');
INSERT INTO `icono` VALUES ('313', 'star', 'halcyon-icon-star', '1');
INSERT INTO `icono` VALUES ('314', 'star-1', 'halcyon-icon-star-1', '1');
INSERT INTO `icono` VALUES ('315', 'stop', 'halcyon-icon-stop', '1');
INSERT INTO `icono` VALUES ('316', 'stop-1', 'halcyon-icon-stop-1', '1');
INSERT INTO `icono` VALUES ('317', 'stopwatch', 'halcyon-icon-stopwatch', '1');
INSERT INTO `icono` VALUES ('318', 'stopwatch-1', 'halcyon-icon-stopwatch-1', '1');
INSERT INTO `icono` VALUES ('319', 'stopwatch-2', 'halcyon-icon-stopwatch-2', '1');
INSERT INTO `icono` VALUES ('320', 'stopwatch-3', 'halcyon-icon-stopwatch-3', '1');
INSERT INTO `icono` VALUES ('321', 'stopwatch-4', 'halcyon-icon-stopwatch-4', '1');
INSERT INTO `icono` VALUES ('322', 'street', 'halcyon-icon-street', '1');
INSERT INTO `icono` VALUES ('323', 'street-1', 'halcyon-icon-street-1', '1');
INSERT INTO `icono` VALUES ('324', 'substract', 'halcyon-icon-substract', '1');
INSERT INTO `icono` VALUES ('325', 'substract-1', 'halcyon-icon-substract-1', '1');
INSERT INTO `icono` VALUES ('326', 'success', 'halcyon-icon-success', '1');
INSERT INTO `icono` VALUES ('327', 'switch', 'halcyon-icon-switch', '1');
INSERT INTO `icono` VALUES ('328', 'switch-1', 'halcyon-icon-switch-1', '1');
INSERT INTO `icono` VALUES ('329', 'switch-2', 'halcyon-icon-switch-2', '1');
INSERT INTO `icono` VALUES ('330', 'switch-3', 'halcyon-icon-switch-3', '1');
INSERT INTO `icono` VALUES ('331', 'switch-4', 'halcyon-icon-switch-4', '1');
INSERT INTO `icono` VALUES ('332', 'switch-5', 'halcyon-icon-switch-5', '1');
INSERT INTO `icono` VALUES ('333', 'switch-6', 'halcyon-icon-switch-6', '1');
INSERT INTO `icono` VALUES ('334', 'switch-7', 'halcyon-icon-switch-7', '1');
INSERT INTO `icono` VALUES ('335', 'tabs', 'halcyon-icon-tabs', '1');
INSERT INTO `icono` VALUES ('336', 'tabs-1', 'halcyon-icon-tabs-1', '1');
INSERT INTO `icono` VALUES ('337', 'target', 'halcyon-icon-target', '1');
INSERT INTO `icono` VALUES ('338', 'television', 'halcyon-icon-television', '1');
INSERT INTO `icono` VALUES ('339', 'television-1', 'halcyon-icon-television-1', '1');
INSERT INTO `icono` VALUES ('340', 'time', 'halcyon-icon-time', '1');
INSERT INTO `icono` VALUES ('341', 'trash', 'halcyon-icon-trash', '1');
INSERT INTO `icono` VALUES ('342', 'umbrella', 'halcyon-icon-umbrella', '1');
INSERT INTO `icono` VALUES ('343', 'unlink', 'halcyon-icon-unlink', '1');
INSERT INTO `icono` VALUES ('344', 'unlocked', 'halcyon-icon-unlocked', '1');
INSERT INTO `icono` VALUES ('345', 'unlocked-1', 'halcyon-icon-unlocked-1', '1');
INSERT INTO `icono` VALUES ('346', 'unlocked-2', 'halcyon-icon-unlocked-2', '1');
INSERT INTO `icono` VALUES ('347', 'upload', 'halcyon-icon-upload', '1');
INSERT INTO `icono` VALUES ('348', 'user', 'halcyon-icon-user', '1');
INSERT INTO `icono` VALUES ('349', 'user-1', 'halcyon-icon-user-1', '1');
INSERT INTO `icono` VALUES ('350', 'user-2', 'halcyon-icon-user-2', '1');
INSERT INTO `icono` VALUES ('351', 'user-3', 'halcyon-icon-user-3', '1');
INSERT INTO `icono` VALUES ('352', 'user-4', 'halcyon-icon-user-4', '1');
INSERT INTO `icono` VALUES ('353', 'user-5', 'halcyon-icon-user-5', '1');
INSERT INTO `icono` VALUES ('354', 'user-6', 'halcyon-icon-user-6', '1');
INSERT INTO `icono` VALUES ('355', 'user-7', 'halcyon-icon-user-7', '1');
INSERT INTO `icono` VALUES ('356', 'users', 'halcyon-icon-users', '1');
INSERT INTO `icono` VALUES ('357', 'users-1', 'halcyon-icon-users-1', '1');
INSERT INTO `icono` VALUES ('358', 'video-camera', 'halcyon-icon-video-camera', '1');
INSERT INTO `icono` VALUES ('359', 'video-camera-1', 'halcyon-icon-video-camera-1', '1');
INSERT INTO `icono` VALUES ('360', 'video-player', 'halcyon-icon-video-player', '1');
INSERT INTO `icono` VALUES ('361', 'video-player-1', 'halcyon-icon-video-player-1', '1');
INSERT INTO `icono` VALUES ('362', 'video-player-2', 'halcyon-icon-video-player-2', '1');
INSERT INTO `icono` VALUES ('363', 'view', 'halcyon-icon-view', '1');
INSERT INTO `icono` VALUES ('364', 'view-1', 'halcyon-icon-view-1', '1');
INSERT INTO `icono` VALUES ('365', 'view-2', 'halcyon-icon-view-2', '1');
INSERT INTO `icono` VALUES ('366', 'volume-control', 'halcyon-icon-volume-control', '1');
INSERT INTO `icono` VALUES ('367', 'volume-control-1', 'halcyon-icon-volume-control-1', '1');
INSERT INTO `icono` VALUES ('368', 'warning', 'halcyon-icon-warning', '1');
INSERT INTO `icono` VALUES ('369', 'wifi', 'halcyon-icon-wifi', '1');
INSERT INTO `icono` VALUES ('370', 'wifi-1', 'halcyon-icon-wifi-1', '1');
INSERT INTO `icono` VALUES ('371', 'windows', 'halcyon-icon-windows', '1');
INSERT INTO `icono` VALUES ('372', 'windows-1', 'halcyon-icon-windows-1', '1');
INSERT INTO `icono` VALUES ('373', 'windows-2', 'halcyon-icon-windows-2', '1');
INSERT INTO `icono` VALUES ('374', 'windows-3', 'halcyon-icon-windows-3', '1');
INSERT INTO `icono` VALUES ('375', 'windows-4', 'halcyon-icon-windows-4', '1');
INSERT INTO `icono` VALUES ('376', 'wireless-internet', 'halcyon-icon-wireless-internet', '1');
INSERT INTO `icono` VALUES ('377', 'worldwide', 'halcyon-icon-worldwide', '1');
INSERT INTO `icono` VALUES ('378', 'worldwide-1', 'halcyon-icon-worldwide-1', '1');
INSERT INTO `icono` VALUES ('379', 'zoom-in', 'halcyon-icon-zoom-in', '1');
INSERT INTO `icono` VALUES ('380', 'zoom-out', 'halcyon-icon-zoom-out', '1');
INSERT INTO `icono` VALUES ('381', 'arrow-down', 'halcyon-icon-arrow-down', '1');
INSERT INTO `icono` VALUES ('382', 'arrow-left', 'halcyon-icon-arrow-left', '1');
INSERT INTO `icono` VALUES ('383', 'arrow-right', 'halcyon-icon-arrow-right', '1');
INSERT INTO `icono` VALUES ('384', 'arrow-up', 'halcyon-icon-arrow-up', '1');
INSERT INTO `icono` VALUES ('385', 'menu', 'halcyon-icon-menu', '1');

-- ----------------------------
-- Table structure for idioma
-- ----------------------------
DROP TABLE IF EXISTS `idioma`;
CREATE TABLE `idioma` (
  `ididioma` char(2) NOT NULL,
  `nombre_id` varchar(255) NOT NULL,
  `descripcion_id` tinytext,
  `bandera` varchar(255) DEFAULT NULL,
  `estado_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; 1:activo; 2:deshabilitado',
  PRIMARY KEY (`ididioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of idioma
-- ----------------------------
INSERT INTO `idioma` VALUES ('aa', 'Afar', null, null, '2');
INSERT INTO `idioma` VALUES ('ab', 'Abjasio (o abjasiano)', null, null, '2');
INSERT INTO `idioma` VALUES ('ae', 'Avéstico', null, null, '2');
INSERT INTO `idioma` VALUES ('af', 'Afrikáans', null, null, '2');
INSERT INTO `idioma` VALUES ('ak', 'Akano', null, null, '2');
INSERT INTO `idioma` VALUES ('am', 'Amhárico', null, null, '2');
INSERT INTO `idioma` VALUES ('an', 'Aragonés', null, null, '2');
INSERT INTO `idioma` VALUES ('ar', 'Árabe', null, null, '2');
INSERT INTO `idioma` VALUES ('as', 'Asamés', null, null, '2');
INSERT INTO `idioma` VALUES ('av', 'Avar (o ávaro)', null, null, '2');
INSERT INTO `idioma` VALUES ('ay', 'Aimara', null, null, '2');
INSERT INTO `idioma` VALUES ('az', 'Azerí', null, null, '2');
INSERT INTO `idioma` VALUES ('ba', 'Baskir', null, null, '2');
INSERT INTO `idioma` VALUES ('be', 'Bielorruso', null, null, '2');
INSERT INTO `idioma` VALUES ('bg', 'Búlgaro', null, null, '2');
INSERT INTO `idioma` VALUES ('bh', 'Bhoyapurí', null, null, '2');
INSERT INTO `idioma` VALUES ('bi', 'Bislama', null, null, '2');
INSERT INTO `idioma` VALUES ('bm', 'Bambara', null, null, '2');
INSERT INTO `idioma` VALUES ('bn', 'Bengalí', null, null, '2');
INSERT INTO `idioma` VALUES ('bo', 'Tibetano', null, null, '2');
INSERT INTO `idioma` VALUES ('br', 'Bretón', null, null, '2');
INSERT INTO `idioma` VALUES ('bs', 'Bosnio', null, null, '2');
INSERT INTO `idioma` VALUES ('ca', 'Catalán', null, null, '2');
INSERT INTO `idioma` VALUES ('ce', 'Checheno', null, null, '2');
INSERT INTO `idioma` VALUES ('ch', 'Chamorro', null, null, '2');
INSERT INTO `idioma` VALUES ('co', 'Corso', null, null, '2');
INSERT INTO `idioma` VALUES ('cr', 'Cree', null, null, '2');
INSERT INTO `idioma` VALUES ('cs', 'Checo', null, null, '2');
INSERT INTO `idioma` VALUES ('cu', 'Eslavo eclesiástico antiguo', null, null, '2');
INSERT INTO `idioma` VALUES ('cv', 'Chuvasio', null, null, '2');
INSERT INTO `idioma` VALUES ('cy', 'Galés', null, null, '2');
INSERT INTO `idioma` VALUES ('da', 'Danés', null, null, '2');
INSERT INTO `idioma` VALUES ('de', 'Alemán', null, null, '1');
INSERT INTO `idioma` VALUES ('dv', 'Maldivo (o dhivehi)', null, null, '2');
INSERT INTO `idioma` VALUES ('dz', 'Dzongkha', null, null, '2');
INSERT INTO `idioma` VALUES ('ee', 'Ewé', null, null, '2');
INSERT INTO `idioma` VALUES ('el', 'Griego (moderno)', null, null, '2');
INSERT INTO `idioma` VALUES ('en', 'Inglés', null, null, '1');
INSERT INTO `idioma` VALUES ('eo', 'Esperanto', null, null, '2');
INSERT INTO `idioma` VALUES ('es', 'Español (o castellano)', null, null, '1');
INSERT INTO `idioma` VALUES ('et', 'Estonio', null, null, '2');
INSERT INTO `idioma` VALUES ('eu', 'Euskera', null, null, '2');
INSERT INTO `idioma` VALUES ('fa', 'Persa', null, null, '2');
INSERT INTO `idioma` VALUES ('ff', 'Fula', null, null, '2');
INSERT INTO `idioma` VALUES ('fi', 'Finés (o finlandés)', null, null, '2');
INSERT INTO `idioma` VALUES ('fj', 'Fiyiano (o fiyi)', null, null, '2');
INSERT INTO `idioma` VALUES ('fo', 'Feroés', null, null, '2');
INSERT INTO `idioma` VALUES ('fr', 'Francés', null, null, '1');
INSERT INTO `idioma` VALUES ('fy', 'Frisón (o frisio)', null, null, '2');
INSERT INTO `idioma` VALUES ('ga', 'Irlandés (o gaélico)', null, null, '2');
INSERT INTO `idioma` VALUES ('gd', 'Gaélico escocés', null, null, '2');
INSERT INTO `idioma` VALUES ('gl', 'Gallego', null, null, '2');
INSERT INTO `idioma` VALUES ('gn', 'Guaraní', null, null, '2');
INSERT INTO `idioma` VALUES ('gu', 'Guyaratí (o guyaratí)', null, null, '2');
INSERT INTO `idioma` VALUES ('gv', 'Manés (gaélico manés o de Isla de Man)', null, null, '2');
INSERT INTO `idioma` VALUES ('ha', 'Hausa', null, null, '2');
INSERT INTO `idioma` VALUES ('he', 'Hebreo', null, null, '2');
INSERT INTO `idioma` VALUES ('hi', 'Hindi (o hindú)', null, null, '2');
INSERT INTO `idioma` VALUES ('ho', 'Hiri motu', null, null, '2');
INSERT INTO `idioma` VALUES ('hr', 'Croata', null, null, '2');
INSERT INTO `idioma` VALUES ('ht', 'Haitiano', null, null, '2');
INSERT INTO `idioma` VALUES ('hu', 'Húngaro', null, null, '2');
INSERT INTO `idioma` VALUES ('hy', 'Armenio', null, null, '2');
INSERT INTO `idioma` VALUES ('hz', 'Herero', null, null, '2');
INSERT INTO `idioma` VALUES ('ia', 'Interlingua', null, null, '2');
INSERT INTO `idioma` VALUES ('id', 'Indonesio', null, null, '2');
INSERT INTO `idioma` VALUES ('ie', 'Occidental', null, null, '2');
INSERT INTO `idioma` VALUES ('ig', 'Igbo', null, null, '2');
INSERT INTO `idioma` VALUES ('ii', 'Yi de Sichuán', null, null, '2');
INSERT INTO `idioma` VALUES ('ik', 'Iñupiaq', null, null, '2');
INSERT INTO `idioma` VALUES ('io', 'Ido', null, null, '2');
INSERT INTO `idioma` VALUES ('is', 'Islandés', null, null, '2');
INSERT INTO `idioma` VALUES ('it', 'Italiano', null, null, '2');
INSERT INTO `idioma` VALUES ('iu', 'Inuktitut (o inuit)', null, null, '2');
INSERT INTO `idioma` VALUES ('ja', 'Japonés', null, null, '2');
INSERT INTO `idioma` VALUES ('jv', 'Javanés', null, null, '2');
INSERT INTO `idioma` VALUES ('ka', 'Georgiano', null, null, '2');
INSERT INTO `idioma` VALUES ('kg', 'Kongo (o kikongo)', null, null, '2');
INSERT INTO `idioma` VALUES ('ki', 'Kikuyu', null, null, '2');
INSERT INTO `idioma` VALUES ('kj', 'Kuanyama', null, null, '2');
INSERT INTO `idioma` VALUES ('kk', 'Kazajo (o kazajio)', null, null, '2');
INSERT INTO `idioma` VALUES ('kl', 'Groenlandés (o kalaallisut)', null, null, '2');
INSERT INTO `idioma` VALUES ('km', 'Camboyano (o jemer)', null, null, '2');
INSERT INTO `idioma` VALUES ('kn', 'Canarés', null, null, '2');
INSERT INTO `idioma` VALUES ('ko', 'Coreano', null, null, '2');
INSERT INTO `idioma` VALUES ('kr', 'Kanuri', null, null, '2');
INSERT INTO `idioma` VALUES ('ks', 'Cachemiro (o cachemir)', null, null, '2');
INSERT INTO `idioma` VALUES ('ku', 'Kurdo', null, null, '2');
INSERT INTO `idioma` VALUES ('kv', 'Komi', null, null, '2');
INSERT INTO `idioma` VALUES ('kw', 'Córnico', null, null, '2');
INSERT INTO `idioma` VALUES ('ky', 'Kirguís', null, null, '2');
INSERT INTO `idioma` VALUES ('la', 'Latín', null, null, '2');
INSERT INTO `idioma` VALUES ('lb', 'Luxemburgués', null, null, '2');
INSERT INTO `idioma` VALUES ('lg', 'Luganda', null, null, '2');
INSERT INTO `idioma` VALUES ('li', 'Limburgués', null, null, '2');
INSERT INTO `idioma` VALUES ('ln', 'Lingala', null, null, '2');
INSERT INTO `idioma` VALUES ('lo', 'Lao', null, null, '2');
INSERT INTO `idioma` VALUES ('lt', 'Lituano', null, null, '2');
INSERT INTO `idioma` VALUES ('lu', 'Luba-katanga (o chiluba)', null, null, '2');
INSERT INTO `idioma` VALUES ('lv', 'Letón', null, null, '2');
INSERT INTO `idioma` VALUES ('mg', 'Malgache (o malagasy)', null, null, '2');
INSERT INTO `idioma` VALUES ('mh', 'Marshalés', null, null, '2');
INSERT INTO `idioma` VALUES ('mi', 'Maorí', null, null, '2');
INSERT INTO `idioma` VALUES ('mk', 'Macedonio', null, null, '2');
INSERT INTO `idioma` VALUES ('ml', 'Malayalam', null, null, '2');
INSERT INTO `idioma` VALUES ('mn', 'Mongol', null, null, '2');
INSERT INTO `idioma` VALUES ('mr', 'Maratí', null, null, '2');
INSERT INTO `idioma` VALUES ('ms', 'Malayo', null, null, '2');
INSERT INTO `idioma` VALUES ('mt', 'Maltés', null, null, '2');
INSERT INTO `idioma` VALUES ('my', 'Birmano', null, null, '2');
INSERT INTO `idioma` VALUES ('na', 'Nauruano', null, null, '2');
INSERT INTO `idioma` VALUES ('nb', 'Noruego bokmål', null, null, '2');
INSERT INTO `idioma` VALUES ('nd', 'Ndebele del norte', null, null, '2');
INSERT INTO `idioma` VALUES ('ne', 'Nepalí', null, null, '2');
INSERT INTO `idioma` VALUES ('ng', 'Ndonga', null, null, '2');
INSERT INTO `idioma` VALUES ('nl', 'Neerlandés (u holandés)', null, null, '2');
INSERT INTO `idioma` VALUES ('nn', 'Nynorsk', null, null, '2');
INSERT INTO `idioma` VALUES ('no', 'Noruego', null, null, '2');
INSERT INTO `idioma` VALUES ('nr', 'Ndebele del sur', null, null, '2');
INSERT INTO `idioma` VALUES ('nv', 'Navajo', null, null, '2');
INSERT INTO `idioma` VALUES ('ny', 'Chichewa', null, null, '2');
INSERT INTO `idioma` VALUES ('oc', 'Occitano', null, null, '2');
INSERT INTO `idioma` VALUES ('oj', 'Ojibwa', null, null, '2');
INSERT INTO `idioma` VALUES ('om', 'Oromo', null, null, '2');
INSERT INTO `idioma` VALUES ('or', 'Oriya', null, null, '2');
INSERT INTO `idioma` VALUES ('os', 'Osético (u osetio, u oseta)', null, null, '2');
INSERT INTO `idioma` VALUES ('pa', 'Panyabí (o penyabi)', null, null, '2');
INSERT INTO `idioma` VALUES ('pi', 'Pali', null, null, '2');
INSERT INTO `idioma` VALUES ('pl', 'Polaco', null, null, '2');
INSERT INTO `idioma` VALUES ('ps', 'Pastú (o pastún, o pashto)', null, null, '2');
INSERT INTO `idioma` VALUES ('pt', 'Portugués', null, null, '2');
INSERT INTO `idioma` VALUES ('qu', 'Quechua', null, null, '2');
INSERT INTO `idioma` VALUES ('rm', 'Romanche', null, null, '2');
INSERT INTO `idioma` VALUES ('rn', 'Kirundi', null, null, '2');
INSERT INTO `idioma` VALUES ('ro', 'Rumano', null, null, '2');
INSERT INTO `idioma` VALUES ('ru', 'Ruso', null, null, '1');
INSERT INTO `idioma` VALUES ('rw', 'Ruandés (o kiñaruanda)', null, null, '2');
INSERT INTO `idioma` VALUES ('sa', 'Sánscrito', null, null, '2');
INSERT INTO `idioma` VALUES ('sc', 'Sardo', null, null, '2');
INSERT INTO `idioma` VALUES ('sd', 'Sindhi', null, null, '2');
INSERT INTO `idioma` VALUES ('se', 'Sami septentrional', null, null, '2');
INSERT INTO `idioma` VALUES ('sg', 'Sango', null, null, '2');
INSERT INTO `idioma` VALUES ('si', 'Cingalés', null, null, '2');
INSERT INTO `idioma` VALUES ('sk', 'Eslovaco', null, null, '2');
INSERT INTO `idioma` VALUES ('sl', 'Esloveno', null, null, '2');
INSERT INTO `idioma` VALUES ('sm', 'Samoano', null, null, '2');
INSERT INTO `idioma` VALUES ('sn', 'Shona', null, null, '2');
INSERT INTO `idioma` VALUES ('so', 'Somalí', null, null, '2');
INSERT INTO `idioma` VALUES ('sq', 'Albanés', null, null, '2');
INSERT INTO `idioma` VALUES ('sr', 'Serbio', null, null, '2');
INSERT INTO `idioma` VALUES ('ss', 'Suazi (o swati, o siSwati)', null, null, '2');
INSERT INTO `idioma` VALUES ('st', 'Sesotho', null, null, '2');
INSERT INTO `idioma` VALUES ('su', 'Sundanés (o sondanés)', null, null, '2');
INSERT INTO `idioma` VALUES ('sv', 'Sueco', null, null, '2');
INSERT INTO `idioma` VALUES ('sw', 'Suajili', null, null, '2');
INSERT INTO `idioma` VALUES ('ta', 'Tamil', null, null, '2');
INSERT INTO `idioma` VALUES ('te', 'Télugu', null, null, '2');
INSERT INTO `idioma` VALUES ('tg', 'Tayiko', null, null, '2');
INSERT INTO `idioma` VALUES ('th', 'Tailandés', null, null, '2');
INSERT INTO `idioma` VALUES ('ti', 'Tigriña', null, null, '2');
INSERT INTO `idioma` VALUES ('tk', 'Turcomano', null, null, '2');
INSERT INTO `idioma` VALUES ('tl', 'Tagalo', null, null, '2');
INSERT INTO `idioma` VALUES ('tn', 'Setsuana', null, null, '2');
INSERT INTO `idioma` VALUES ('to', 'Tongano', null, null, '2');
INSERT INTO `idioma` VALUES ('tr', 'Turco', null, null, '2');
INSERT INTO `idioma` VALUES ('ts', 'Tsonga', null, null, '2');
INSERT INTO `idioma` VALUES ('tt', 'Tártaro', null, null, '2');
INSERT INTO `idioma` VALUES ('tw', 'Twi', null, null, '2');
INSERT INTO `idioma` VALUES ('ty', 'Tahitiano', null, null, '2');
INSERT INTO `idioma` VALUES ('ug', 'Uigur', null, null, '2');
INSERT INTO `idioma` VALUES ('uk', 'Ucraniano', null, null, '2');
INSERT INTO `idioma` VALUES ('ur', 'Urdu', null, null, '2');
INSERT INTO `idioma` VALUES ('uz', 'Uzbeko', null, null, '2');
INSERT INTO `idioma` VALUES ('ve', 'Venda', null, null, '2');
INSERT INTO `idioma` VALUES ('vi', 'Vietnamita', null, null, '2');
INSERT INTO `idioma` VALUES ('vo', 'Volapük', null, null, '2');
INSERT INTO `idioma` VALUES ('wa', 'Valón', null, null, '2');
INSERT INTO `idioma` VALUES ('wo', 'Wolof', null, null, '2');
INSERT INTO `idioma` VALUES ('xh', 'Xhosa', null, null, '2');
INSERT INTO `idioma` VALUES ('yi', 'Yídish (o yidis, o yiddish)', null, null, '2');
INSERT INTO `idioma` VALUES ('yo', 'Yoruba', null, null, '2');
INSERT INTO `idioma` VALUES ('za', 'Chuan (o chuang, o zhuang)', null, null, '2');
INSERT INTO `idioma` VALUES ('zh', 'Chino', null, null, '2');
INSERT INTO `idioma` VALUES ('zu', 'Zulú', null, null, '2');

-- ----------------------------
-- Table structure for medida
-- ----------------------------
DROP TABLE IF EXISTS `medida`;
CREATE TABLE `medida` (
  `idmedida` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  `idtipomedida` int(8) unsigned NOT NULL,
  `estado_me` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; 1:activo',
  PRIMARY KEY (`idmedida`),
  KEY `fk_medida_tipo_medida_1` (`idtipomedida`),
  CONSTRAINT `fk_medida_tipo_medida_1` FOREIGN KEY (`idtipomedida`) REFERENCES `tipo_medida` (`idtipomedida`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of medida
-- ----------------------------
INSERT INTO `medida` VALUES ('1', 'S', '1', '1');
INSERT INTO `medida` VALUES ('2', 'M', '1', '1');
INSERT INTO `medida` VALUES ('3', 'L', '1', '1');
INSERT INTO `medida` VALUES ('4', 'XL', '1', '1');
INSERT INTO `medida` VALUES ('5', 'XXL', '1', '1');
INSERT INTO `medida` VALUES ('6', '33oz', '2', '1');
INSERT INTO `medida` VALUES ('7', '66oz', '2', '1');
INSERT INTO `medida` VALUES ('8', '99oz', '2', '1');
INSERT INTO `medida` VALUES ('9', '10X15', '3', '1');
INSERT INTO `medida` VALUES ('10', '20X15', '3', '1');
INSERT INTO `medida` VALUES ('19', '12X25', '3', '0');
INSERT INTO `medida` VALUES ('20', '30X20', '3', '1');
INSERT INTO `medida` VALUES ('21', 'PENDRIVE 2 GB', '2', '1');
INSERT INTO `medida` VALUES ('22', 'PENDRIVE 16 GB', '2', '1');

-- ----------------------------
-- Table structure for mensaje
-- ----------------------------
DROP TABLE IF EXISTS `mensaje`;
CREATE TABLE `mensaje` (
  `idmensaje` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `seccion` varchar(255) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `contenido` text,
  PRIMARY KEY (`idmensaje`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of mensaje
-- ----------------------------
INSERT INTO `mensaje` VALUES ('1', 'TIENDA', null, '<p style=\"text-align: justify;\">Welcome to your personal space. If you made a previous payment, you will have a balance for the amount delivered. If the amount of your purchase exceeds your balance you will have to pay the difference through your PayPal account or through your Credit Card.</p>');
INSERT INTO `mensaje` VALUES ('2', 'RESUMEN COMPRA', null, '<p></p><div style=\"text-align: justify;\">Check the detail of your purchase. If you have made a purchase deposit, you will have a balance. Consume the entire balance since no refunds will be made on the deposit made.</div><div style=\"text-align: justify;\">If you exceed your balance you will have to pay the difference with your PayPal account or your Credit Card.</div><div style=\"text-align: justify;\">Once reviewed the summary accept the TERMS &amp; CONDITIONS and click on the &#34;PAY&#34; button.</div><div style=\"text-align: justify;\">Then your photos will be available for download. Access from the MENU to MY GALLERY and download or share your photos in your social networks.</div><p></p>');
INSERT INTO `mensaje` VALUES ('3', 'COMPRA EXITOSA', null, '<p style=\"text-align: justify;\">Your photos are now available for download. Access from the MENU to MY GALLERY and download or share your photos in your social networks. If you wish, you can then evaluate our service. </p>');
INSERT INTO `mensaje` VALUES ('4', 'GALERIA', null, '<p>Select and download your photos. You can also share them on your Social Networks.</p>');
INSERT INTO `mensaje` VALUES ('5', 'COMPRA NO EXITOSA', null, '<p style=\"text-align: left;\">We are sorry but the payment could not be processed. Please contact us to see what solution we can give to your purchase request.</p>');
INSERT INTO `mensaje` VALUES ('6', 'EMAIL OFERTA', null, '<p>Usted recibe este email porque ha solicitado la descarga de una foto gratis.</p><p><b>Por favor, haga click en el botón de verificación. A continuación será re dirigido a su espacio personal de descarga.</b></p><p>Este regalo solo es aplicable una vez. Si desea descargar más fotos deberá abonar el precio del paquete DIGITAL FUN PAS o descargar fotos individuales mediante el paquete ONE BY ONE que encontrará en la SHOP de su espacio personal.</p>');
INSERT INTO `mensaje` VALUES ('7', 'LOGIN', 'Where\'s my Code? ', '<p>If you purchased a digital copy of your photo and video, you\'ll find your code on your receipt. If you didin\'t purchased yet, your code is on your bracelet of the excursion.<br/>Need more help? Visit our FAQs.<br/></p>');
INSERT INTO `mensaje` VALUES ('8', 'OFERTA', 'Descargue una foto GRATIS', '<p>Seleccione una foto de su excursión y complete su e-mail. En unos minutos recibirá un enlace de validación en su cuenta de correo.<br/>A continuación vuelva a entrar con su código y dispondrá de la imagen en su GALLERY donde podrá descargarla totalmente GRATIS. Recuerde que puede obtener más fotos e incluso todo el paquete de fotos + video, abonando el importe on line.</p>');
INSERT INTO `mensaje` VALUES ('9', 'AVISO LEGAL', 'Aviso Legal', '<p><br/><!--StartFragment--></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">1. EL AVISO LEGAL Y SU ACEPTACION</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El pre&#173;sente aviso legal (en ade&#173;lante, el “Aviso Legal”) reg&#173;ula el uso del ser&#173;vi&#173;cio del por&#173;tal de Inter&#173;net www.caribbeanphotocloud.com (en ade&#173;lante, el “Por&#173;tal”) que CARIBBEAN PHOTO STUDIO (en ade&#173;lante, <span style=\"font-size: 12.87px;float: none;\">CARIBBEAN PHOTO STUDIO</span>), con domi&#173;cilio social en Av. Estados Unidos, Plaza Tres Center Local B-23, Friusa, Bavaro<span style=\"font-size: 14px;text-align: left;float: none;\"></span>, Rep. Dom. , pone a dis&#173;posi&#173;ción de los usuar&#173;ios de Inter&#173;net. La uti&#173;lización del Por&#173;tal atribuye la condi&#173;ción de usuario del Por&#173;tal (en ade&#173;lante, el “Usuario”) e implica la aceptación plena y sin reser&#173;vas de todas y cada una de las dis&#173;posi&#173;ciones inclu&#173;idas en este Aviso Legal en la ver&#173;sión pub&#173;li&#173;cada por <span style=\"font-size: 12.87px;float: none;\">CARIBBEAN PHOTO STUDIO</span> en el momento mismo en que el Usuario acceda al Por&#173;tal. En con&#173;se&#173;cuen&#173;cia, el Usuario debe leer aten&#173;ta&#173;mente el pre&#173;sente Aviso Legal en cada una de las oca&#173;siones en que se pro&#173;ponga uti&#173;lizar el Por&#173;tal, ya que aquél puede sufrir modificaciones.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">2. OBJETO</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">A través del Por&#173;tal, CARIBBEAN PHOTO STUDIO facilita a los Usuar&#173;ios el acceso y la uti&#173;lización de diver&#173;sos ser&#173;vi&#173;cios y con&#173;tenidos (en ade&#173;lante, los “Ser&#173;vi&#173;cios”) puestos a dis&#173;posi&#173;ción por CARIBBEAN PHOTO STUDIO o por terceros.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3. CONDICIONES DE ACCESO Y UTILIZACION DEL PORTAL</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.1. Carác&#173;ter gra&#173;tu&#173;ito del acceso y uti&#173;lización del Portal</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">La prestación de los Ser&#173;vi&#173;cios, por parte de CARIBBEAN PHOTO STUDIO, tiene carác&#173;ter gra&#173;tu&#173;ito para los Usuar&#173;ios. No obstante lo ante&#173;rior, algunos de los Ser&#173;vi&#173;cios sum&#173;in&#173;istra&#173;dos por CARIBBEAN PHOTO STUDIO o por ter&#173;ceros a través del Por&#173;tal están suje&#173;tos al pago de un pre&#173;cio en la forma que se deter&#173;mine en las cor&#173;re&#173;spon&#173;di&#173;entes Condi&#173;ciones Particulares.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.2. Reg&#173;istro de Usuario</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Con carác&#173;ter gen&#173;eral la prestación de los Ser&#173;vi&#173;cios no exige la pre&#173;via suscrip&#173;ción o reg&#173;istro de los Usuar&#173;ios. No obstante, CARIBBEAN PHOTO STUDIO condi&#173;ciona la uti&#173;lización de algunos de los Ser&#173;vi&#173;cios a la pre&#173;via cumpli&#173;mentación del cor&#173;re&#173;spon&#173;di&#173;ente reg&#173;istro de Usuario. Asimismo, CARIBBEAN PHOTO STUDIO pone a dis&#173;posi&#173;ción de los Usuar&#173;ios algunos Ser&#173;vi&#173;cios cuya uti&#173;lización requiere la cumpli&#173;mentación de reg&#173;istros adi&#173;cionales. El citado reg&#173;istro se efec&#173;tu&#173;ará en la forma expre&#173;sa&#173;mente indi&#173;cada en el pro&#173;pio ser&#173;vi&#173;cio o en las Condi&#173;ciones Par&#173;tic&#173;u&#173;lares que lo regulen.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.3. Veraci&#173;dad de la información</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Toda la infor&#173;ma&#173;ción que facilite el Usuario a través de los Ser&#173;vi&#173;cios deberá ser veraz. A estos efec&#173;tos, el Usuario garan&#173;tiza la aut&#173;en&#173;ti&#173;ci&#173;dad de todos aque&#173;l&#173;los datos que comu&#173;nique como con&#173;se&#173;cuen&#173;cia de la cumpli&#173;mentación de los for&#173;mu&#173;la&#173;rios nece&#173;sar&#173;ios para la suscrip&#173;ción de los Ser&#173;vi&#173;cios. De igual forma, será respon&#173;s&#173;abil&#173;i&#173;dad del Usuario man&#173;tener toda la infor&#173;ma&#173;ción facil&#173;i&#173;tada a CARIBBEAN PHOTO STUDIO per&#173;ma&#173;nen&#173;te&#173;mente actu&#173;al&#173;izada de forma que responda, en cada momento, a la situación real del Usuario. En todo caso el Usuario será el único respon&#173;s&#173;able de las man&#173;i&#173;festa&#173;ciones fal&#173;sas o inex&#173;ac&#173;tas que real&#173;ice y de los per&#173;juicios que cause a CARIBBEAN PHOTO STUDIO o a ter&#173;ceros por la infor&#173;ma&#173;ción que facilite.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.4. Menores de edad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Para hacer uso de los Ser&#173;vi&#173;cios que requieran la recogida de Datos Per&#173;son&#173;ales por parte de CARIBBEAN PHOTO STUDIO los menores de trece años (en ade&#173;lante “Menores de Edad”) deben obtener pre&#173;vi&#173;a&#173;mente per&#173;miso de sus padres, tutores o rep&#173;re&#173;sen&#173;tantes legales, quienes serán con&#173;sid&#173;er&#173;a&#173;dos respon&#173;s&#173;ables de todos los actos real&#173;iza&#173;dos por los menores a su cargo.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.5. Obligación de hacer un uso cor&#173;recto del Por&#173;tal y de los Servicios</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El Usuario se com&#173;pro&#173;m&#173;ete a uti&#173;lizar el Por&#173;tal y los Ser&#173;vi&#173;cios de con&#173;formi&#173;dad con la ley, el pre&#173;sente Aviso Legal, las Condi&#173;ciones Par&#173;tic&#173;u&#173;lares de cier&#173;tos Ser&#173;vi&#173;cios y demás avi&#173;sos, reglamen&#173;tos de uso e instruc&#173;ciones puestos en su conocimiento, así como con la moral y las bue&#173;nas cos&#173;tum&#173;bres gen&#173;eral&#173;mente acep&#173;tadas y el orden público.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El Usuario deberá absten&#173;erse de obtener e incluso de inten&#173;tar obtener los Con&#173;tenidos emple&#173;ando para ello medios o pro&#173;ced&#173;imien&#173;tos dis&#173;tin&#173;tos de los que, según los casos, se hayan puesto a su dis&#173;posi&#173;ción a este efecto o se hayan indi&#173;cado a este efecto en las pági&#173;nas web donde se encuen&#173;tren los Con&#173;tenidos o, en gen&#173;eral, de los que se empleen habit&#173;ual&#173;mente en Inter&#173;net a este efecto siem&#173;pre que no entrañen un riesgo de daño o inuti&#173;lización del Por&#173;tal, de los Ser&#173;vi&#173;cios y/o de los Contenidos.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Los Usuar&#173;ios o ter&#173;ceros per&#173;ju&#173;di&#173;ca&#173;dos por la recep&#173;ción de men&#173;sajes no solic&#173;i&#173;ta&#173;dos dirigi&#173;dos a una plu&#173;ral&#173;i&#173;dad de per&#173;sonas podrán comu&#173;nicárselo a CARIBBEAN PHOTO STUDIO remi&#173;tiendo un men&#173;saje a la sigu&#173;iente direc&#173;ción de correo elec&#173;trónico: contacto@caribbeanphotocloud.com.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">4. NO LICENCIA</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Todas las mar&#173;cas, nom&#173;bres com&#173;er&#173;ciales o sig&#173;nos dis&#173;tin&#173;tivos de cualquier clase que apare&#173;cen en el Por&#173;tal son propiedad de CARIBBEAN PHOTO STUDIO o de ter&#173;ceros, sin que pueda enten&#173;derse que el uso o acceso al Por&#173;tal y/o a los Ser&#173;vi&#173;cios atribuya al Usuario dere&#173;cho alguno sobre las citadas mar&#173;cas, nom&#173;bres com&#173;er&#173;ciales y/o sig&#173;nos distintivos.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Asimismo, los Con&#173;tenidos son propiedad int&#173;elec&#173;tual de CARIBBEAN PHOTO STUDIO o de ter&#173;ceros, sin que puedan enten&#173;derse cedi&#173;dos al Usuario, en vir&#173;tud de lo estable&#173;cido en este Aviso Legal, ninguno de los dere&#173;chos de explotación que exis&#173;ten o puedan exi&#173;s&#173;tir sobre dichos Con&#173;tenidos más allá de lo estric&#173;ta&#173;mente nece&#173;sario para el cor&#173;recto uso del Por&#173;tal y de los Servicios.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5. EXCLUSION DE GARANTIAS Y DE RESPONSABILIDAD</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.1 Disponi&#173;bil&#173;i&#173;dad y con&#173;tinuidad, util&#173;i&#173;dad y falibilidad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no garan&#173;tiza la disponi&#173;bil&#173;i&#173;dad y con&#173;tinuidad del fun&#173;cionamiento del Por&#173;tal y de los Ser&#173;vi&#173;cios. Cuando ello sea razon&#173;able&#173;mente posi&#173;ble, CARIBBEAN PHOTO STUDIO adver&#173;tirá pre&#173;vi&#173;a&#173;mente de las inter&#173;rup&#173;ciones en el fun&#173;cionamiento del Por&#173;tal y de los Ser&#173;vi&#173;cios. CARIBBEAN PHOTO STUDIO tam&#173;poco garan&#173;tiza la util&#173;i&#173;dad del Por&#173;tal y de los Ser&#173;vi&#173;cios para la real&#173;ización de ninguna activi&#173;dad en con&#173;creto, ni su infal&#173;i&#173;bil&#173;i&#173;dad y, en par&#173;tic&#173;u&#173;lar, aunque no de modo exclu&#173;sivo, CARIBBEAN PHOTO STUDIO no garan&#173;tiza que los Usuar&#173;ios puedan efec&#173;ti&#173;va&#173;mente uti&#173;lizar el Por&#173;tal y los Ser&#173;vi&#173;cios, acceder a las dis&#173;tin&#173;tas pági&#173;nas web que for&#173;man el Por&#173;tal o a aquél&#173;las desde las que se prestan los Servicios.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO EXCLUYE, CON TODA LA EXTENSION PERMITIDA POR EL ORDENAMIENTO JURIDICO, CUALQUIER RESPONSABILIDAD POR LOS DANOS Y PERJUICIOS DE TODA NATURALEZA QUE PUEDAN DEBERSE A LA FALTA DE DISPONIBILIDAD O DE CONTINUIDAD DEL FUNCIONAMIENTO DEL PORTAL Y DE LOS SERVICIOS, A LA DEFRAUDACION DE LA UTILIDAD QUE LOS USUARIOS HUBIEREN PODIDO ATRIBUIR AL PORTAL Y A LOS SERVICIOS, A LA FALIBILIDAD DEL PORTAL Y DE LOS SERVICIOS, Y EN PARTICULAR, AUNQUE NO DE MODO EXCLUSIVO, A LOS FALLOS EN EL ACCESO A LAS DISTINTAS PAGINAS WEB DEL PORTAL O A AQUELLAS DESDE LAS QUE SE PRESTAN LOS SERVICIOS.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.3 Cal&#173;i&#173;dad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no con&#173;trola ni garan&#173;tiza la ausen&#173;cia de virus ni de otros ele&#173;men&#173;tos en los Con&#173;tenidos que puedan pro&#173;ducir alteraciones en su sis&#173;tema infor&#173;mático (soft&#173;ware y hard&#173;ware) o en los doc&#173;u&#173;men&#173;tos elec&#173;tróni&#173;cos y ficheros alma&#173;ce&#173;na&#173;dos en su sis&#173;tema informático.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.4 Veraci&#173;dad, exac&#173;ti&#173;tud, exhaus&#173;tivi&#173;dad y actualidad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no garan&#173;tiza la veraci&#173;dad, exac&#173;ti&#173;tud, exhaus&#173;tivi&#173;dad y actu&#173;al&#173;i&#173;dad de los Contenidos.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO EXCLUYE, CON TODA LA EXTENSION PERMITIDA POR EL ORDENAMIENTO JURIDICO, CUALQUIER RESPONSABILIDAD POR LOS DAÑOS Y PERJUICIOS DE TODA NATURALEZA QUE PUEDAN DEBERSE A LA FALTA DE VERACIDAD, EXACTITUD, EXHAUSTIVIDAD Y/O ACTUALIDAD DE LOS CONTENIDOS.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.5 Lic&#173;i&#173;tud, fia&#173;bil&#173;i&#173;dad y utilidad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no garan&#173;tiza la lic&#173;i&#173;tud, fia&#173;bil&#173;i&#173;dad y util&#173;i&#173;dad de los ser&#173;vi&#173;cios presta&#173;dos por ter&#173;ceros a través del Por&#173;tal. CARIBBEAN PHOTOSTUDIO EXCLUYE CUALQUIER RESPONSABILIDAD POR LOS DANOS Y PERJUICIOS DE TODA NATURALEZA QUE PUEDAN DEBERSE A LOS SERVICIOS PRESTADOS POR TERCEROS A TRAVES DEL PORTAL.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">6. PROCEDIMIENTO EN CASO DE REALIZACION DE ACTIVIDADES DE CARACTER ILICITO</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">En el caso de que cualquier Usuario o un ter&#173;cero con&#173;sidere que exis&#173;ten hechos o cir&#173;cun&#173;stan&#173;cias que rev&#173;e&#173;len el carác&#173;ter ilíc&#173;ito de la uti&#173;lización de cualquier Con&#173;tenido y/o de la real&#173;ización de cualquier activi&#173;dad en las pági&#173;nas web inclu&#173;idas o acce&#173;si&#173;bles a través del Por&#173;tal, y, en par&#173;tic&#173;u&#173;lar, de la vio&#173;lación de dere&#173;chos de propiedad int&#173;elec&#173;tual o indus&#173;trial (patentes, mod&#173;e&#173;los y dibu&#173;jos indus&#173;tri&#173;ales, mar&#173;cas y nom&#173;bres com&#173;er&#173;ciales, etc.) u otros dere&#173;chos, deberá enviar una noti&#173;fi&#173;cación a CARIBBEAN PHOTO STUDIO en la que se con&#173;tengan los sigu&#173;ientes extremos:</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(a) datos per&#173;son&#173;ales del recla&#173;mante: nom&#173;bre, direc&#173;ción, número de telé&#173;fono y direc&#173;ción de correo electrónico;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(b) especi&#173;fi&#173;cación de la supuesta activi&#173;dad ilícita lle&#173;vada a cabo en el Por&#173;tal y, en par&#173;tic&#173;u&#173;lar, cuando se trate de una supuesta vio&#173;lación de dere&#173;chos, indi&#173;cación pre&#173;cisa y conc&#173;reta de los con&#173;tenidos pro&#173;te&#173;gi&#173;dos así como de su local&#173;ización en las pági&#173;nas web;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(c) hechos o cir&#173;cun&#173;stan&#173;cias que rev&#173;e&#173;lan el carác&#173;ter ilíc&#173;ito de dicha actividad;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(d) en el supuesto de vio&#173;lación de dere&#173;chos, firma man&#173;u&#173;scrita o equiv&#173;a&#173;lente, con los datos per&#173;son&#173;ales del tit&#173;u&#173;lar de los dere&#173;chos supues&#173;ta&#173;mente infringi&#173;dos o de la per&#173;sona autor&#173;izada para actuar en nom&#173;bre y por cuenta de ésta;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(e) declaración expresa, clara y bajo la respon&#173;s&#173;abil&#173;i&#173;dad del recla&#173;mante de que la infor&#173;ma&#173;ción pro&#173;por&#173;cionada en la noti&#173;fi&#173;cación es exacta y del carác&#173;ter ilíc&#173;ito de la uti&#173;lización de los con&#173;tenidos o de la real&#173;ización de las activi&#173;dades descritas.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">7. NOTIFICACIONES</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Todas las noti&#173;fi&#173;ca&#173;ciones y comu&#173;ni&#173;ca&#173;ciones (en ade&#173;lante, las “Noti&#173;fi&#173;ca&#173;ciones”) por parte del Usuario a CARIBBEAN PHOTO STUDIO se con&#173;sid&#173;er&#173;arán efi&#173;caces, a todos los efec&#173;tos, cuando se nos diri&#173;jan de alguna de las sigu&#173;ientes formas:</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(a) Envío por correo postal a la sigu&#173;iente direc&#173;ción: <span style=\"font-size: 12.87px;float: none;\">Av. Estados Unidos, Plaza Tres Center Local B-23, Friusa, Bavaro</span><span style=\"font-size: 14px;text-align: left;float: none;\"></span><span style=\"font-size: 12.87px;float: none;\">, Rep. Dom</span><br/></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(b) Comu&#173;ni&#173;cación por medio de una lla&#173;mada tele&#173;fónica al número de telé&#173;fono: 8095521546.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">© Envío por correo elec&#173;trónico a la sigu&#173;iente direc&#173;ción: contacto@caribbeanphotocloud.com.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">8. LEGISLACION APLICABLE</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El pre&#173;sente Aviso Legal se rige en todos y cada uno de sus extremos por la ley de la República Dominicana.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><span style=\"font-size: 12.87px;float: none;\">CARIBBEAN PHOTO STUDIO </span>y el Usuario, con renun&#173;cia expresa a cualquier otro fuero, se some&#173;ten al de los Juz&#173;ga&#173;dos y Tri&#173;bunales de la República Domini&#173;cana. Para cualquier sug&#173;eren&#173;cia o prop&#173;uesta de colab&#173;o&#173;ración escríbanos por correo elec&#173;trónico a <span style=\"font-size: 12.87px;float: none;\">contacto@caribbeanphotocloud.com.</span>., o llá&#173;menos al sigu&#173;iente número de telé&#173;fono: <span style=\"font-size: 12.87px;float: none;\">8095521546.</span></p><p></p>');
INSERT INTO `mensaje` VALUES ('10', 'TERMINOS', 'Terminos y condiciones', '<p>1.Política<br/>Al ingresar y utilizar este portal de Internet, cuyo nombre de dominio es https://www.photodelphinus.com/, propiedad de Operadora Xuna, S.A. de C.V., que en lo sucesivo se denominará “DELPHINUS”, el usuario está aceptando los Términos y condiciones de uso contenidos en este convenio y declara expresamente su aceptación utilizando para tal efecto medios electrónicos, en términos de lo dispuesto por el artículo 1803 del Código Civil Federal. En caso de no aceptar en forma absoluta y completa los términos y condiciones de este convenio, el usuario deberá abstenerse de acceder, utilizar y observar el sitio web www.photodelphinus.com.<br/><br/>Y en caso de que el usuario acceda, utilice y observe el sitio web www.photodelphinus.com se considerará como una absoluta y expresa aceptación de los Términos y condiciones de uso aquí estipulados.<br/><br/>La sola utilización de dicha página de Internet le otorga al público en general la condición de usuario (en adelante referido como el «usuario» o los «usuarios») e implica la aceptación, plena e incondicional, de todas y cada una de las condiciones generales y particulares incluidas en estos Términos y condiciones de uso publicados por DELPHINUS en el momento mismo en que el usuario acceda al sitio web.<br/><br/>Cualquier modificación a los presentes Términos y condiciones de uso será realizada cuando el titular de la misma, en este caso DELPHINUS, lo considere apropiado, siendo exclusiva responsabilidad del usuario asegurarse de tomar conocimiento de tales modificaciones.<br/><br/>2. Convenio <br/>Convenio de adhesión para el uso de la página de Internet https:// www.photodelphinus.com / que celebran: por una parte, DELPHINUS y, por la otra, el usuario, sujetándose, ambas partes, a lo establecido en este documento.<br/><br/>3. Licencia<br/>a) Por virtud de la celebración de este convenio, “DELPHINUS” otorga y concede al usuario el derecho no exclusivo, revocable y no transferible de ver y utilizar el sitio web www.photodelphinus.com de conformidad con los Términos y condiciones de uso que aquí se estipulan. Para los efectos del presente convenio, las partes acuerdan que por «usuario» se entenderá a cualquier persona de cualquier naturaleza que ingrese al sitio web https:// www.photodelphinus.com / y/o a cualquiera de las subpáginas que despliegan su contenido y/o a la persona de cualquier naturaleza que se dé de alta y/o use cualquiera de los servicios que se ofrecen a través de dicha página.<br/><br/>b) El usuario sólo podrá imprimir y/o copiar cualquier información contenida o publicada en el sitio web www.photodelphinus.com exclusivamente para uso personal, queda terminantemente prohibido el uso comercial de dicha información. En caso de ser persona moral se sujetará a lo dispuesto por el artículo 148, fracción IV de la Ley Federal del Derecho de Autor.<br/><br/>c) La reimpresión, publicación, distribución, asignación, sublicencia, venta, reproducción electrónica o por otro medio, parcial o total, de cualquier información, documento o gráfico que aparezca en el sitio web https://www. www.photodelphinus.com., para cualquier uso distinto al personal no comercial le está expresamente prohibido al usuario, a menos de que cuente con la autorización previa y por escrito de DELPHINUS.<br/><br/> <br/>4. Reglas para el uso del sitio web photodelphinus.com.<br/>El usuario y DELPHINUS están de acuerdo en que la utilización del sitio web https://www.photodelphinus.com se sujetará a las siguientes reglas:<br/><br/>1.    Información contenida en el sitio web www.photodelphinus.com<br/>El usuario reconoce y acepta que la información publicada o contenida en dicho sitio será claramente identificada de forma tal que se reconozca que la misma proviene y ha sido generada por DELPHINUS o por sus proveedores.<br/><br/>2.    No obstante, la información, conceptos y opiniones publicadas en dicho sitio no necesariamente reflejan la posición de DELPHINUS, ni de sus empleados, oficiales, directores, accionistas, licenciatarios y concesionarios (en lo sucesivo los «afiliados»).<br/>Por esta razón, DELPHINUS no se hace responsable por ninguna de las informaciones, opiniones y conceptos que se emitan en la página web referida. En este caso, se recomienda al usuario consultar con un especialista y/o profesional en la materia. Asimismo, DELPHINUS no se hace responsable de la información contenida en la página de Internet, incluidas las subpáginas, en el entendido de que el uso y seguimiento de la misma es bajo riesgo y responsabilidad del usuario.<br/><br/>3.    DELPHINUS se reserva el derecho de bloquear el acceso o remover en forma parcial o total<br/>Toda información, comunicación o material que a su exclusivo juicio pueda resultar: i) abusivo, difamatorio u obsceno; ii) fraudulento, artificioso o engañoso; iii) violatorio de derechos de autor, marcas, confidencialidad, secretos industriales o cualquier derecho de propiedad intelectual de un tercero; iv) ofensivo o; v) que de cualquier forma contravenga lo establecido en este convenio. Si el usuario desea obtener mayor información de un tema en específico proveído por DELPHINUS o sus proveedores deberá consultarlo directamente con cada uno de ellos, según corresponda, y/o con un especialista en la materia.<br/><br/>4.    El usuario reconoce que DELPHINUS no controla o censura previamente el contenido disponible en la página de Internet.<br/>Por tal motivo, DELPHINUS no asume ninguna responsabilidad por el contenido provisto a dicha página por proveedores independientes o ajenos a DELPHINUS y no tiene el control editorial sobre el contenido, información y/o material generado y/o provisto por terceros. Todas las opiniones, consejos, declaraciones, servicios, ofertas u otras informaciones o contenidos expresados o puestos a disposición del público por terceros, pertenecen a su respectivo autor y DELPHINUS no asume responsabilidad alguna frente a ello. De la misma forma, DELPHINUS no garantiza la exactitud, veracidad, amplitud y/o utilidad de cualquier contenido provisto por tales terceros. Adicionalmente, DELPHINUS no es responsable ni garantiza la exactitud, exhaustividad, veracidad y/o confiabilidad de cualquier opinión, información, consejo o declaración expresados por DELPHINUS a través de su página de Internet y bajo ninguna circunstancia DELPHINUS será responsable de cualquier daño y/o perjuicio, directo o indirecto, causado en virtud de la confianza que el usuario deposite en información obtenida a través de su sitio web. DELPHINUS se reserva el derecho de suprimir o modificar el contenido de esta página que, a exclusivo juicio de DELPHINUS, no cumpla con sus estándares o que pudiera resultar contrario al ordenamiento jurídico vigente y, por consiguiente, no será responsable por cualquier falla o tardanza que se genere al eliminar tal material. <br/><br/>5. Formatos <br/>Los usuarios reconocen que, al proporcionar la información de carácter personal requerida en alguno de los servicios que se prestan en este sitio web, otorgan a DELPHINUS la autorización señalada en el artículo 109 de la Ley Federal del Derecho de Autor. En todos los casos, los usuarios responderán por la veracidad de la información proporcionada a DELPHINUS. Asimismo, para la prestación de servicios, el usuario se obliga además a aceptar los términos y condiciones estipulados para tal efecto.<br/><br/>6. Derechos de autor y propiedad industrial<br/>DELPHINUS, el sitio web www.photodelphinus.com. sus logotipos y todo el material que aparece en dicho sitio, son marcas, nombres de dominio, nombres comerciales y obras artísticas propiedad de sus respectivos titulares y están protegidos por los tratados internacionales y las leyes aplicables en materia de propiedad intelectual y derechos de autor.<br/><br/>Los derechos de autor sobre el contenido, organización, recopilación, compilación, información, logotipos, fotografías, imágenes, programas, aplicaciones, y en general cualquier información contenida o publicada en el sitio web www.photodelphinus.com. se encuentran debidamente protegidos a favor de DELPHINUS, sus afiliados, proveedores y/o de sus respectivos propietarios, de conformidad con la legislación aplicable en materia de propiedad intelectual e industrial.<br/><br/>Se prohíbe expresamente al usuario modificar, alterar o suprimir, ya sea en forma total o parcial, los avisos, marcas, nombres comerciales, señas, anuncios, logotipos o en general cualquier indicación que se refiera a la propiedad de la información contenida en el sitio señalado.<br/><br/>En caso de que el usuario transmita a DELPHINUS cualquier información, programas, aplicaciones, software o en general cualquier material que requiera ser licenciado a través del sitio web www.photodelphinus.com, el usuario otorga con este acto a DELPHINUS una licencia perpetua, universal, gratuita, no exclusiva, mundial y libre de regalías, que incluye los derechos de sublicenciar, vender, reproducir, distribuir, transmitir, crear trabajos derivados, exhibirlos y ejecutarlos públicamente. <br/><br/>Lo establecido en el párrafo anterior se aplicará igualmente a cualquier otra información que el usuario envíe o transmita a DELPHINUS, incluyendo, sin limitación alguna, ideas para renovar o mejorar el sitio web www.photodelphinus.com), ya sea que éstas hayan sido incluidas en cualquier espacio de la página señalada o en virtud de otros medios o modos de transmisión conocidos o que sean desarrollados en el futuro. <br/><br/>Por lo anterior, el usuario renuncia expresamente con este acto a llevar a cabo cualquier acción, demanda o reclamación en contra de DELPHINUS, sus afiliados o proveedores por cualquier actual o eventual violación de cualquier derecho de autor o propiedad intelectual derivado de la información, programas, aplicaciones, software, ideas y demás material que el propio usuario envíe al sitio web https://www.photodelphinus.com/.<br/><br/>Es nuestra política actuar contra las violaciones que en materia de propiedad intelectual se pudieran generar u originar según lo estipulado en la legislación y en otras leyes de propiedad intelectual aplicables, incluyendo la eliminación o el bloqueo del acceso a material que se encuentra sujeto a actividades que infrinjan el derecho de propiedad intelectual de terceros.<br/><br/>En caso de que algún usuario o tercero consideren que cualquiera de los contenidos que se encuentren o sean introducidos en dicho sitio https://www.photodelphinus.com/ y/o cualquiera de sus servicios, violen sus derechos de propiedad intelectual deberán enviar una notificación a la siguiente dirección (Poner dirección de correo electrónico), en la que indiquen: i) datos personales verídicos (nombre, dirección, número de teléfono y dirección de correo electrónico del reclamante); ii) firma autógrafa con los datos personales del titular de los derechos de propiedad intelectual; iii) indicación precisa y completa del (los) contenido (s) protegido (s) mediante los derechos de propiedad intelectual supuestamente infringidos, así como la localización de dichas violaciones en el sitio web referido; iv) declaración expresa y clara de que la introducción del (los) contenido (s) indicado (s) se ha realizado sin el consentimiento del titular de los derechos de propiedad intelectual supuestamente infringidos; v) declaración expresa, clara y bajo la responsabilidad del reclamante de que la información proporcionada en la notificación es exacta y de que la introducción del (los) contenido (s) constituye una violación de dichos derechos.<br/><br/>7. Material publicitario<br/>El usuario reconoce y acepta que DELPHINUS es una organización independiente de terceros patrocinadores y anunciantes cuya información, imágenes, anuncios y demás material publicitario o promocional (en lo subsecuente «material publicitario›) puede ser publicado en el sitio web www.photodelphinus.com. El usuario reconoce y acepta que el material publicitario no forma parte del contenido principal que se publica en dicho sitio. Asimismo, reconoce y acepta con este acto que este material se encuentra protegido por las leyes que en materia de propiedad intelectual e industrial resulten aplicables.<br/><br/>8. Negación de garantías<br/>El usuario está de acuerdo que la utilización del sitio web www.photodelphinus.com se realiza bajo su propio riesgo y que los servicios y productos que ahí se prestan y ofrecen se prevén sobre una base «tal cual» y «según sean disponibles». DELPHINUS no garantiza que la página señalada satisfaga los requerimientos del usuario o que los servicios que en ella se ofrecen no sufran interrupciones, sean seguros o estén exentos de errores.<br/><br/>DELPHINUS no garantiza o avala en ninguna forma la veracidad, precisión, legalidad, moralidad o ninguna otra característica del contenido del material que se publique en el sitio web www.photodelphinus.com.<br/><br/>DELPHINUS se libera de cualquier responsabilidad y condiciones, tanto expresas como implícitas, en relación con los servicios e información contenida o disponible en o a través de esta página web; incluyendo, sin limitación alguna:<br/><br/>a)    La disponibilidad de uso del sitio web www.photodelphinus.com.<br/><br/>b)    La ausencia de virus, errores, desactivadores o cualquier otro material contaminante o con funciones destructivas en la información o programas disponibles en o a través de esta página o en general cualquier falla en dicho sitio.<br/><br/>c)    No obstante lo anterior, DELPHINUS o sus proveedores podrán actualizar el contenido de la página constantemente, por lo que se solicita al usuario tomar en cuenta que algunas informaciones publicitadas o contenidas en o a través de este sitio web pueden haber quedado obsoletas y/o contener imprecisiones o errores tipográficos u ortográficos. <br/><br/>9. Limitaciones a la responsabilidad<br/>Hasta el máximo permitido por las leyes aplicables, DELPHINUS no será responsable, en ningún caso, por daños directos, especiales, incidentales, indirectos, o consecuenciales que en cualquier forma se deriven o se relacionen con:<br/><br/>a)    El uso o ejecución del sitio web www.photodelphinus.com, con el retraso o la falta de disponibilidad de uso de DELPHINUS <br/><br/>b)    La proveeduría o falta de la misma de servicios de cualquier información o gráficos contenidos o publicados en o a través del sitio señalado.<br/><br/>c)    La actualización o falta de actualización de la información. <br/><br/>d)    La alteración o modificación, total o parcial, de la información después de haber sido incluida en dicho sitio.<br/><br/>e)    Cualquier otro aspecto o característica de la información contenida o publicada en la página web o a través de las ligas que eventualmente se incluyan en este sitio.<br/><br/>f)    La proveeduría o falta de proveeduría que los demás servicios, todos los supuestos anteriores serán vigentes, aún en los casos en que se le hubiere notificado o avisado a DELPHINUS acerca de la posibilidad de que se ocasionaran dichos daños.<br/><br/> <br/>10. Modificaciones al sitio web www.photodelphinus.com<br/>DELPHINUS podrá en cualquier momento y cuando lo considere conveniente, sin necesidad de avisar al usuario, realizar correcciones, adiciones, mejoras o modificaciones al contenido, presentación, información, servicios, áreas, bases de datos y demás elementos de dicho sitio, sin que ello de lugar ni derecho a ninguna reclamación o indemnización, ni que esto implique reconocimiento de responsabilidad alguna a favor del usuario.<br/><br/>11. Modificaciones al convenio<br/>DELPHINUS se reserva el derecho de modificar los Términos y condiciones de uso de este convenio en cualquier momento, siendo efectivas dichas modificaciones de forma inmediata por medio de:<br/><br/> <br/>a)    La publicación en el sitio web www.photodelphinus.com del convenio modificado.<br/><br/>b)    La notificación al usuario sobre dichas modificaciones. De esta forma, el usuario está de acuerdo en revisar dicho convenio periódicamente con la finalidad de mantenerse al tanto de dichas modificaciones. No obstante lo anterior, cada vez que el usuario acceda al sitio señalado se considerará como una aceptación absoluta a las modificaciones del presente convenio. <br/><br/>12. Términos adicionales<br/>Ocasionalmente, DELPHINUS podrá agregar a los Términos y condiciones de uso del presente convenio provisiones adicionales relativas a áreas específicas o nuevos servicios que se proporcionen en o a través del sitio web www.photodelphinus.com (en lo subsecuente «términos adicionales»), los cuales serán publicados en las áreas específicas o nuevos servicios de dicho sitio para su lectura y aceptación. El usuario reconoce y acepta que estos términos adicionales forman parte integrante del presente convenio para todos los efectos legales a que haya lugar.<br/><br/>13. Cesión de derechos<br/>DELPHINUS podrá, en cualquier momento y cuando así lo estime conveniente, ceder total o parcialmente sus derechos y obligaciones derivados del presente convenio. En virtud de dicha cesión, DELPHINUS quedará liberada de cualquier obligación a favor del usuario, establecida en el presente convenio. <br/><br/>14. Indemnización<br/>El usuario está de acuerdo en indemnizar a DELPHINUS, sus afiliados, proveedores, vendedores y asesores por cualquier acción, demanda o reclamación (incluso de honorarios de abogados y de costas judiciales) derivadas de cualquier incumplimiento por parte del usuario al presente convenio; incluyendo, sin limitación de alguna de las derivadas de: <br/><br/>a) Cualquier aspecto relativo al uso del sitio web www.photodelphinus.com<br/><br/>b) La información contenida o disponible en o a través de dicho sitio o de injurias, difamación o cualquier otra conducta violatoria del presente convenio por parte del usuario en el uso de la página web señalada.<br/><br/>c) La violación a las leyes aplicables o tratados internacionales relativos a los derechos de autor o propiedad intelectual, contenidos o disponibles en, o a través de dicho sitio web.<br/><br/>15. Terminación<br/>DELPHINUS se reserva el derecho, a su exclusiva discreción, y sin necesidad de aviso o notificación al usuario, para:<br/><br/>a)    Terminar definitivamente el presente convenio.<br/><br/>b)    Descontinuar o dejar de publicar definitivamente el sitio web https://www.photodelphinus.com/ sin responsabilidad alguna para DELPHINUS, sus afiliados o proveedores. <br/><br/>16. Subsistencia<br/>Estos Términos y condiciones de uso, así como los términos adicionales, constituyen el acuerdo íntegro entre las partes, y sustituye cualquier otro acuerdo o convenio celebrado con anterioridad. Cualquier cláusula o provisión del presente convenio, así como de los términos adicionales, legalmente declarada inválida, será eliminada o modificada a elección de DELPHINUS, con la finalidad de corregir su vicio o defecto. Sin embargo, el resto de las cláusulas o provisiones mantendrán su fuerza, obligatoriedad y validez.<br/><br/>17. No renuncia de derechos<br/>La inactividad por parte de DELPHINUS, sus afiliados o proveedores al ejercicio de cualquier derecho o acción derivados del presente convenio, en ningún momento deberá interpretarse como renuncia a dichos derechos o acciones. <br/><br/>18. Legislación aplicable y jurisdicción<br/>Este convenio estará sujeto y será interpretado de acuerdo con las leyes y ante los tribunales del Distrito Federal, México. <br/><br/>19. Devoluciones, Cancelaciones o reembolsos.<br/>Devoluciones Totales<br/><br/>Nuestra área de Finanzas podrá ejercer la devolución siempre y cuando se haya ejecutado un cobro por un producto y que el producto por algún problema técnico no haya sido entregado al usuario (cliente), la empresa tiene 48 horas después de recibir la queja para enviar el producto al cliente como garantía de compra, en caso de no lograr la entrega del producto comprado, el departamento de Finanzas iniciará el procedimiento y tardará aproximadamente 45 dias hábiles en devolverse. Es posible que se solicite información al cliente a como soporte de la compra. En caso de devoluciones por transferencia internacional este tendrá un costo de 30USD con cargo al usuario (cliente).<br/><br/>Devoluciones parciales:<br/><br/>Si existiera algún problema técnico comprobable con el producto digital de manera parcial, digamos las fotos, el video o con el photobook, En caso de que el monto rebase los 50 USD se podrá hacer el reembolso con un cargo al cliente de 30USD por la transferencia internacional. En caso de reembolso nacional este no tendrá cargo alguno. Policita de cancelación: una vez adquirido el producto y enviado al cliente, este no podrá ser cancelado.<br/><br/>Reembolsos:<br/>Debido a la naturaleza del producto que ofrecemos, siempre se tiene la posibilidad de visualizar las fotografías previas a la compra, por lo que una vez concretada, no existe la posibilidad de otorgar reembolsos de ningún tipo.<br/><br/>Para cualquier información adicional favor de contactarnos al correo photo@delphinus.com.mx, O llamarnos alos siguientes telefonos:<br/><br/>International toll free USA/Canada: 1-888- 526-2230<br/><br/>Toll free from Mexico:  01-800- 3353-461</p>');
INSERT INTO `mensaje` VALUES ('11', 'PREGUNTAS', 'Preguntas Frecuentes', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu <b>fugiat</b> nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');

-- ----------------------------
-- Table structure for movimiento
-- ----------------------------
DROP TABLE IF EXISTS `movimiento`;
CREATE TABLE `movimiento` (
  `idmovimiento` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) unsigned NOT NULL,
  `idexcursion` int(11) NOT NULL,
  `tipo_movimiento` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:venta; 2:pedido',
  `fecha_movimiento` datetime NOT NULL,
  `total` float DEFAULT NULL,
  `tipo_pack` tinyint(1) DEFAULT '2' COMMENT '1: COMPLETO;  2 : INDIVIDUAL',
  `estado` tinyint(1) DEFAULT '1' COMMENT '0:anulado; 1:activo; 2: por confirmar',
  PRIMARY KEY (`idmovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of movimiento
-- ----------------------------
INSERT INTO `movimiento` VALUES ('93', '104', '1', '1', '2018-05-05 14:25:03', '99', '1', '1');
INSERT INTO `movimiento` VALUES ('94', '105', '2', '1', '2018-05-07 15:24:58', '15', '2', '1');

-- ----------------------------
-- Table structure for producto
-- ----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `idproducto` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `idproductomaster` int(8) unsigned NOT NULL,
  `categoria` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:basico; 2:premium',
  `idmedida` int(8) unsigned DEFAULT NULL,
  `precio_unitario` int(4) NOT NULL,
  `precio_2_5` int(4) DEFAULT NULL,
  `precio_mas_5` int(4) DEFAULT NULL,
  `cantidad_fotos` tinyint(1) unsigned DEFAULT NULL COMMENT 'cantidad de fotos para usar en el merchandising',
  `estado_p` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; 1:activo',
  PRIMARY KEY (`idproducto`),
  KEY `fk_producto_precio_producto_1` (`idproductomaster`) USING BTREE,
  KEY `fk_producto_precio_producto_size_1` (`idmedida`) USING BTREE,
  CONSTRAINT `fk_producto_medida_1` FOREIGN KEY (`idmedida`) REFERENCES `medida` (`idmedida`),
  CONSTRAINT `fk_producto_producto_master_1` FOREIGN KEY (`idproductomaster`) REFERENCES `producto_master` (`idproductomaster`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of producto
-- ----------------------------
INSERT INTO `producto` VALUES ('1', '2', '1', '6', '16', '15', '10', '1', '1');
INSERT INTO `producto` VALUES ('2', '2', '1', '7', '18', '16', '14', '1', '1');
INSERT INTO `producto` VALUES ('3', '2', '1', '8', '20', '18', '16', '1', '1');
INSERT INTO `producto` VALUES ('4', '2', '2', '6', '20', '18', '15', '1', '1');
INSERT INTO `producto` VALUES ('5', '2', '2', '7', '25', '20', '18', '1', '1');
INSERT INTO `producto` VALUES ('6', '2', '2', '8', '30', '25', '20', '1', '1');
INSERT INTO `producto` VALUES ('7', '1', '1', '1', '20', '18', '16', '1', '1');
INSERT INTO `producto` VALUES ('8', '1', '1', '2', '18', '16', '14', '1', '1');
INSERT INTO `producto` VALUES ('9', '1', '1', '3', '16', '14', '13', '1', '1');
INSERT INTO `producto` VALUES ('10', '1', '1', '4', '10', '9', '8', '1', '1');
INSERT INTO `producto` VALUES ('11', '1', '1', '5', '18', '16', '14', '1', '1');
INSERT INTO `producto` VALUES ('12', '1', '2', '1', '25', '23', '20', '1', '1');
INSERT INTO `producto` VALUES ('13', '1', '2', '2', '20', '18', '16', '1', '1');
INSERT INTO `producto` VALUES ('14', '1', '2', '3', '18', '16', '14', '1', '1');
INSERT INTO `producto` VALUES ('15', '1', '2', '4', '12', '11', '10', '1', '1');
INSERT INTO `producto` VALUES ('16', '1', '2', '5', '20', '18', '16', '1', '1');
INSERT INTO `producto` VALUES ('41', '3', '1', '9', '18', '16', '15', '10', '1');
INSERT INTO `producto` VALUES ('42', '3', '1', '9', '23', '20', '18', '15', '1');
INSERT INTO `producto` VALUES ('43', '3', '1', '9', '27', '25', '22', '20', '1');
INSERT INTO `producto` VALUES ('44', '3', '1', '10', '23', '20', '18', '10', '1');
INSERT INTO `producto` VALUES ('45', '3', '1', '10', '27', '25', '22', '15', '1');
INSERT INTO `producto` VALUES ('46', '3', '1', '10', '30', '28', '25', '20', '1');
INSERT INTO `producto` VALUES ('47', '4', '1', '9', '4', '3', '2', null, '1');
INSERT INTO `producto` VALUES ('48', '4', '1', '10', '5', '4', '3', null, '1');
INSERT INTO `producto` VALUES ('49', '4', '1', '20', '8', '6', '4', null, '1');
INSERT INTO `producto` VALUES ('50', '5', '1', '21', '10', '9', '8', '10', '1');
INSERT INTO `producto` VALUES ('51', '5', '1', '22', '20', '18', '16', '10', '1');

-- ----------------------------
-- Table structure for producto_master
-- ----------------------------
DROP TABLE IF EXISTS `producto_master`;
CREATE TABLE `producto_master` (
  `idproductomaster` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion_pm` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `imagen_bas` varchar(255) DEFAULT NULL COMMENT 'imagen de producto basico',
  `imagen_pre` varchar(255) DEFAULT NULL COMMENT 'imagen de producto premium',
  `si_genero` tinyint(1) DEFAULT NULL COMMENT '1: SI; 2:NO',
  `si_color` tinyint(1) DEFAULT NULL COMMENT '1: SI; 2:NO',
  `tipo_seleccion` tinyint(1) DEFAULT '2' COMMENT '1:seleccion unica; 2:seleccion multiple',
  `descripcion_basico` text,
  `descripcion_premium` text,
  `estado_pm` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; 1:activo',
  PRIMARY KEY (`idproductomaster`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of producto_master
-- ----------------------------
INSERT INTO `producto_master` VALUES ('1', 'CAMISETA', 'icono-camiseta-20180102011931.jpg', 'camiseta_bas-20180107233351.jpg', 'camiseta_pre-20180107233351.jpg', '1', '1', '1', '<div class=\"desc-title-con\" style=\"height: 45px;\"><span class=\"desc-title\"><span id=\"selectionBoundary_1515078966718_06254542082000047\" class=\"rangySelectionBoundary\">&#65279;</span><b>Descripción</b><font face=\"simple-line-icons\"><span style=\"font-size: 16px;\"><br/></span></font></span><span style=\"font-size: 12px;\">Estilo: </span><span style=\"font-size: 12px;\">casual</span></div><div class=\"desc-con j-desc-con active\" style=\"font-size: 12px;\"><div class=\"kv\" style=\"font-size: 12px;\"><div class=\"kv-row\"><div class=\"key\">Tipo del patrón: llanura</div></div><div class=\"kv-row\"><div class=\"key\">Color: blanco</div></div><div class=\"kv-row\"><div class=\"key\">Material: poliéster</div></div><div class=\"kv-row\"><div class=\"key\">Escote: cuello redondo</div></div><div class=\"kv-row\"><div class=\"key\">Longitud de la manga: Manga corta</div></div><div class=\"kv-row\"><div class=\"key\">Tela: La tela tiene un poco de elasticidad</div></div><div class=\"kv-row\"><div class=\"key\">Hombro(cm): M:41cm, L:42cm, XL:43cm, XXL:44cm</div></div><div class=\"kv-row\"><div class=\"key\">Tamaño Busto(cm): M:98-108cm, L:102-112cm, XL:106-116cm, XXL:110-120cm</div></div><div class=\"kv-row\"><div class=\"key\">Longitud de Manga(cm): M:15cm, L:16cm, XL:17cm, XXL:18cm</div></div><div class=\"kv-row\"><div class=\"key\">Largo(cm): M:59cm, L:60cm, XL:61cm, XXL:62cm</div></div><div class=\"kv-row\"><div class=\"key\">Talla(s): M,L,XL,XXL</div></div></div></div><!--EndFragment--><p><br/></p><p><br/></p><p><br/></p>', '<div class=\"desc-title-con\" style=\"height: 45px;font-size: 12px;\"><span class=\"desc-title\" style=\"font-size: 14px;\"><b>Descripción</b></span></div><div class=\"desc-title-con\" style=\"height: 45px;font-size: 12px;\">Estilo: <span style=\"font-size: 12px;float: none;\">casual<!--EndFragment--><br/></span>Tipo del patrón: llanura<br/>Color: blanco</div><div class=\"desc-title-con\" style=\"height: 45px;font-size: 12px;\"><p><br/></p><p>Material: poliéster</p></div><div class=\"desc-con j-desc-con active\" style=\"font-size: 12px;\"><div class=\"kv\" style=\"font-size: 12px;\"><div class=\"kv-row\"><div class=\"key\">Escote: cuello redondo</div></div><div class=\"kv-row\"><div class=\"key\">Longitud de la manga: Manga corta</div></div><div class=\"kv-row\"><div class=\"key\">Tela: La tela tiene un poco de elasticidad</div></div><div class=\"kv-row\"><div class=\"key\">Hombro (cm): M:41cm, L:42cm, XL:43cm, XXL:44cm</div></div><div class=\"kv-row\"><div class=\"key\">Tamaño Busto(cm): M:98-108cm, L:102-112cm, XL:106-116cm, XXL:110-120cm</div></div><div class=\"kv-row\"><div class=\"key\">Longitud de Manga(cm): M:15cm, L:16cm, XL:17cm, XXL:18cm</div></div><div class=\"kv-row\"><div class=\"key\">Largo (cm): M:59cm, L:60cm, XL:61cm, XXL:62cm</div></div><div class=\"kv-row\"><div class=\"key\">Talla(s): M,L,XL,XXL</div></div></div></div><!--EndFragment--><p><br/></p><p><br/></p>', '1');
INSERT INTO `producto_master` VALUES ('2', 'TAZAS', 'tazas1-20180102011907.jpg', 'medida_tazas1-300x225-20180107233842.jpg', 'taza-cambio-color-20180107233842.jpg', '2', '1', '1', '<p><b>DESCRIPCIÓN PRODUCTO:</b><br/><br/>TAZA CERÁMICA   <br/>Medidas: 80Ø x 95 mm.<br/>Taza de cerámica. Capacidad: 325 ml.<br/>Impresión nítida a todo color.<br/>Apta para lavavajillas y microondas.<br/>Interior disponible en varios colores.<br/>Impresión total hasta el borde.<br/></p>', '<p>DESCRIPCIÓN PRODUCTO:</p><p>Medidas: 80Ø x 95 mm.</p><p>Taza de cerámica. Capacidad: 325 ml.</p><p>Impresión nítida a todo color.<br/>Apta para lavavajillas y microondas.<br/>Interior disponible en varios colores.<br/>Impresión total hasta el borde.<br/></p>', '1');
INSERT INTO `producto_master` VALUES ('3', 'PHOTOBOOK', 'photpbook-icon-20180102011847.jpg', '12x12_PhotoBook_Padded_LeatherLk_CHERRY-V1-Gen_1024x1024-20180108002531.jpg', '8x11_Hard-Photo-Book-Rectangle_Wedding_V3-BW_d9e2b33f-6597-41d1-ae2b-d10203aff00f_grande-20180108002556.jpg', '2', '1', '2', '<h4 style=\"font-size: 18px;\">DESCRIPCIÓN DEL PRODUCTO</h4><p style=\"font-size: 14px;\">Un photobook es como un álbum pero con las fotos impresas directamente en sus páginas. En Caribbean Photo Estudio hacemos los photobooks con mejor acabado.<br/><br/>Características:<br/></p><ul style=\"font-size: 14px;\"><li>Photobook en tamaño 10x15 cms. y 20x15cms.</li><li>10, 15 y 20 páginas en papel premium.</li><li>Tapa dura.</li><li>Tapas y páginas interiores 100% personalizadas con el diseño y fotos que tú quieras.</li><li>Con acabado de primera y colores vivos.</li></ul><!--EndFragment--><p><br/></p><p><br/></p>', '<h4 style=\"font-size: 18px;\">DESCRIPCIÓN DEL PRODUCTO</h4><p style=\"font-size: 14px;\">Un photobook es como un álbum pero con las fotos impresas directamente en sus páginas. En Caribbean Photo Estudio hacemos los photobooks con mejor acabado.<br/><br/>Características:<br/></p><ul style=\"font-size: 14px;\"><li>Photobook en tamaño 10x15 cms. y 20x15cms.</li><li>10, 15 y 20 páginas en papel premium.</li><li>Tapa dura.</li><li>Tapas y páginas interiores 100% personalizadas con el diseño y fotos que tú quieras.</li><li>Con acabado de primera y colores vivos.</li></ul><!--EndFragment--><p><br/></p><p><br/></p>', '1');
INSERT INTO `producto_master` VALUES ('4', 'IMPRESIÓN FOTOGRÁFICA', 'print-20180108173607.png', 'printer-hammacher-schlemmer-20180108173607.jpg', 'printer-hammacher-schlemmer-20180108173607.jpg', '2', '2', '1', '<p>TAMAÑOS:</p><p>10x15</p><p>20x15</p><p>30x20</p><p><br/></p>', '<p style=\"font-size: 14px;\">TAMAÑOS:</p><p style=\"font-size: 14px;\">10x15</p><p style=\"font-size: 14px;\">20x15</p><p style=\"font-size: 14px;\">21x30</p><p style=\"font-size: 14px;\">Incluye marco</p><!--EndFragment--><p><br/></p><p><br/></p>', '1');
INSERT INTO `producto_master` VALUES ('5', 'PENDRIVE', 'usb-icon-20180121000502.png', 'whitemate-pendrive-2-20180121000502.jpg', 'whitemate-pendrive-2-20180121000502.jpg', '2', '1', '2', '<p>PENDRIVE capacidad 2 GB</p>', '<p>PENDRIVE 16 GB</p>', '1');

-- ----------------------------
-- Table structure for producto_master_color
-- ----------------------------
DROP TABLE IF EXISTS `producto_master_color`;
CREATE TABLE `producto_master_color` (
  `idproductomastercolor` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `idproductomaster` int(8) unsigned NOT NULL,
  `idcolor` int(8) unsigned DEFAULT NULL,
  `estado_pmc` tinyint(1) DEFAULT '1' COMMENT '0:anulado; 1:activo',
  PRIMARY KEY (`idproductomastercolor`),
  KEY `fk_producto_master_color_producto_master_1` (`idproductomaster`) USING BTREE,
  KEY `fk_producto_master_color_color_1` (`idcolor`) USING BTREE,
  CONSTRAINT `fk_producto_master_color_color_1` FOREIGN KEY (`idcolor`) REFERENCES `color` (`idcolor`),
  CONSTRAINT `fk_producto_master_color_producto_master_1` FOREIGN KEY (`idproductomaster`) REFERENCES `producto_master` (`idproductomaster`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of producto_master_color
-- ----------------------------
INSERT INTO `producto_master_color` VALUES ('1', '2', '4', '0');
INSERT INTO `producto_master_color` VALUES ('2', '2', '2', '0');
INSERT INTO `producto_master_color` VALUES ('3', '2', '3', '0');
INSERT INTO `producto_master_color` VALUES ('4', '1', '1', '1');
INSERT INTO `producto_master_color` VALUES ('5', '1', '2', '1');
INSERT INTO `producto_master_color` VALUES ('6', '1', '6', '1');
INSERT INTO `producto_master_color` VALUES ('7', '2', '4', '1');
INSERT INTO `producto_master_color` VALUES ('8', '2', '1', '1');
INSERT INTO `producto_master_color` VALUES ('9', '2', '2', '1');
INSERT INTO `producto_master_color` VALUES ('10', '3', '1', '1');
INSERT INTO `producto_master_color` VALUES ('11', '3', '2', '1');
INSERT INTO `producto_master_color` VALUES ('12', '5', '4', '1');
INSERT INTO `producto_master_color` VALUES ('13', '5', '1', '1');
INSERT INTO `producto_master_color` VALUES ('14', '5', '2', '1');

-- ----------------------------
-- Table structure for puntuacion
-- ----------------------------
DROP TABLE IF EXISTS `puntuacion`;
CREATE TABLE `puntuacion` (
  `idpuntuacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) unsigned NOT NULL,
  `puntos` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  PRIMARY KEY (`idpuntuacion`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of puntuacion
-- ----------------------------
INSERT INTO `puntuacion` VALUES ('1', '5', '5', '2017-10-21 05:48:48');
INSERT INTO `puntuacion` VALUES ('2', '6', '5', '2017-10-21 19:52:39');
INSERT INTO `puntuacion` VALUES ('3', '6', '5', '2017-10-21 19:53:45');
INSERT INTO `puntuacion` VALUES ('4', '8', '1', '2017-10-28 04:46:32');
INSERT INTO `puntuacion` VALUES ('5', '10', '5', '2017-12-05 02:30:01');
INSERT INTO `puntuacion` VALUES ('6', '3', '3', '2017-12-13 18:43:38');
INSERT INTO `puntuacion` VALUES ('7', '11', '4', '2017-12-14 07:23:41');
INSERT INTO `puntuacion` VALUES ('8', '12', '3', '2017-12-14 20:44:00');
INSERT INTO `puntuacion` VALUES ('9', '14', '3', '2017-12-16 00:37:57');
INSERT INTO `puntuacion` VALUES ('10', '14', '4', '2017-12-20 21:00:25');
INSERT INTO `puntuacion` VALUES ('11', '18', '3', '2017-12-21 10:33:37');
INSERT INTO `puntuacion` VALUES ('12', '20', '4', '2017-12-31 12:00:55');
INSERT INTO `puntuacion` VALUES ('13', '24', '4', '2018-01-05 23:27:21');
INSERT INTO `puntuacion` VALUES ('14', '23', '3', '2018-01-06 21:46:52');
INSERT INTO `puntuacion` VALUES ('15', '23', '4', '2018-01-06 23:14:20');
INSERT INTO `puntuacion` VALUES ('16', '21', '5', '2018-01-07 23:41:19');
INSERT INTO `puntuacion` VALUES ('17', '21', '5', '2018-01-09 06:56:34');
INSERT INTO `puntuacion` VALUES ('18', '23', '4', '2018-01-18 01:32:49');
INSERT INTO `puntuacion` VALUES ('19', '23', '4', '2018-01-20 01:34:07');
INSERT INTO `puntuacion` VALUES ('20', '23', '4', '2018-01-20 02:07:13');
INSERT INTO `puntuacion` VALUES ('21', '23', '4', '2018-01-20 22:49:15');
INSERT INTO `puntuacion` VALUES ('22', '23', '4', '2018-01-22 00:47:18');
INSERT INTO `puntuacion` VALUES ('23', '16', '4', '2018-01-23 06:32:32');
INSERT INTO `puntuacion` VALUES ('24', '16', '4', '2018-01-23 06:36:43');
INSERT INTO `puntuacion` VALUES ('25', '24', '3', '2018-01-23 11:50:01');
INSERT INTO `puntuacion` VALUES ('26', '25', '5', '2018-01-29 19:52:14');
INSERT INTO `puntuacion` VALUES ('27', '34', '5', '2018-02-21 22:29:02');
INSERT INTO `puntuacion` VALUES ('28', '42', '3', '2018-02-21 23:38:47');
INSERT INTO `puntuacion` VALUES ('29', '41', '4', '2018-02-21 23:43:42');
INSERT INTO `puntuacion` VALUES ('30', '40', '4', '2018-02-23 00:22:00');
INSERT INTO `puntuacion` VALUES ('31', '32', '4', '2018-02-25 21:00:33');
INSERT INTO `puntuacion` VALUES ('32', '32', '5', '2018-02-26 16:23:34');
INSERT INTO `puntuacion` VALUES ('33', '41', '5', '2018-02-26 23:08:40');
INSERT INTO `puntuacion` VALUES ('34', '44', '5', '2018-02-26 23:23:44');
INSERT INTO `puntuacion` VALUES ('35', '46', '4', '2018-02-28 12:29:30');
INSERT INTO `puntuacion` VALUES ('36', '43', '5', '2018-02-28 22:08:07');
INSERT INTO `puntuacion` VALUES ('37', '43', '5', '2018-02-28 22:24:12');
INSERT INTO `puntuacion` VALUES ('38', '50', '4', '2018-03-02 22:36:41');
INSERT INTO `puntuacion` VALUES ('39', '52', '4', '2018-03-02 23:06:28');
INSERT INTO `puntuacion` VALUES ('40', '54', '4', '2018-03-03 22:45:03');
INSERT INTO `puntuacion` VALUES ('41', '52', '4', '2018-03-03 23:27:16');
INSERT INTO `puntuacion` VALUES ('42', '55', '4', '2018-03-04 00:37:19');
INSERT INTO `puntuacion` VALUES ('43', '68', '4', '2018-03-04 22:43:22');
INSERT INTO `puntuacion` VALUES ('44', '69', '3', '2018-03-05 00:43:48');
INSERT INTO `puntuacion` VALUES ('45', '65', '4', '2018-03-06 22:03:52');
INSERT INTO `puntuacion` VALUES ('46', '66', '4', '2018-03-07 11:41:03');
INSERT INTO `puntuacion` VALUES ('47', '64', '5', '2018-03-07 14:18:03');
INSERT INTO `puntuacion` VALUES ('48', '63', '5', '2018-03-08 10:18:15');
INSERT INTO `puntuacion` VALUES ('49', '67', '5', '2018-03-11 02:48:28');
INSERT INTO `puntuacion` VALUES ('50', '48', '1', '2018-03-12 07:02:23');
INSERT INTO `puntuacion` VALUES ('51', '72', '5', '2018-03-12 14:50:23');
INSERT INTO `puntuacion` VALUES ('52', '62', '5', '2018-03-13 00:18:25');
INSERT INTO `puntuacion` VALUES ('53', '76', '4', '2018-03-23 23:54:54');
INSERT INTO `puntuacion` VALUES ('54', '74', '4', '2018-03-24 00:07:45');
INSERT INTO `puntuacion` VALUES ('55', '79', '5', '2018-03-29 20:50:42');
INSERT INTO `puntuacion` VALUES ('56', '85', '5', '2018-04-13 15:43:10');
INSERT INTO `puntuacion` VALUES ('57', '86', '5', '2018-04-16 16:03:56');
INSERT INTO `puntuacion` VALUES ('58', '104', '4', '2018-05-05 14:27:16');
INSERT INTO `puntuacion` VALUES ('59', '105', '5', '2018-05-07 15:25:04');

-- ----------------------------
-- Table structure for red_social
-- ----------------------------
DROP TABLE IF EXISTS `red_social`;
CREATE TABLE `red_social` (
  `idredsocial` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rs` varchar(255) DEFAULT NULL,
  `icono_rs` varchar(255) DEFAULT NULL COMMENT 'fontawesome',
  `clase` varchar(255) DEFAULT NULL COMMENT 'bootstrap',
  PRIMARY KEY (`idredsocial`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of red_social
-- ----------------------------
INSERT INTO `red_social` VALUES ('1', 'facebook', 'fa fa-facebook', 'facebook');
INSERT INTO `red_social` VALUES ('2', 'twitter', 'fa fa-twitter', 'twitter');
INSERT INTO `red_social` VALUES ('3', 'pinterest', 'fa fa-pinterest', 'pinterest');
INSERT INTO `red_social` VALUES ('4', 'linkedin', 'fa fa-linkedin', 'linkedin');
INSERT INTO `red_social` VALUES ('5', 'instagram', 'fa fa-instagram', 'instagram');
INSERT INTO `red_social` VALUES ('6', 'tumblr', 'fa fa-tumblr', 'tumblr');
INSERT INTO `red_social` VALUES ('7', 'skype', 'fa fa-skype', 'skype');
INSERT INTO `red_social` VALUES ('8', 'youtube', 'fa fa-youtube', 'youtube');
INSERT INTO `red_social` VALUES ('9', 'rss', 'fa fa-rss', 'rss');
INSERT INTO `red_social` VALUES ('10', 'vimeo', 'fa fa-vimeo', 'vimeo');
INSERT INTO `red_social` VALUES ('11', 'google', 'fa fa-google-plus', 'google');
INSERT INTO `red_social` VALUES ('12', 'flickr', 'fa fa-flickr', 'flickr');

-- ----------------------------
-- Table structure for reporte
-- ----------------------------
DROP TABLE IF EXISTS `reporte`;
CREATE TABLE `reporte` (
  `idreporte` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `abreviatura` varchar(255) NOT NULL,
  `estado_rp` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Anulado; 1: Activo',
  PRIMARY KEY (`idreporte`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of reporte
-- ----------------------------
INSERT INTO `reporte` VALUES ('1', 'LISTADO DE EMAILS POR FECHAS', 'CLI-EM', '1');

-- ----------------------------
-- Table structure for seccion
-- ----------------------------
DROP TABLE IF EXISTS `seccion`;
CREATE TABLE `seccion` (
  `idseccion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion_se` varchar(255) NOT NULL,
  `estado_se` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; 1:activo',
  PRIMARY KEY (`idseccion`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of seccion
-- ----------------------------
INSERT INTO `seccion` VALUES ('1', 'INICIO', '1');
INSERT INTO `seccion` VALUES ('2', 'SERVICIOS', '1');
INSERT INTO `seccion` VALUES ('3', 'NOTICIAS', '1');
INSERT INTO `seccion` VALUES ('4', 'TRABAJA CON NOSOTROS', '1');
INSERT INTO `seccion` VALUES ('5', 'AVISO LEGAL', '1');
INSERT INTO `seccion` VALUES ('6', 'TERMINOS Y CONDICIONES', '1');
INSERT INTO `seccion` VALUES ('7', 'PREGUNTAS FRECUENTES', '1');
INSERT INTO `seccion` VALUES ('8', 'AVISO CODIGO', '1');
INSERT INTO `seccion` VALUES ('9', 'OFERTA', '1');

-- ----------------------------
-- Table structure for seccion_contenido
-- ----------------------------
DROP TABLE IF EXISTS `seccion_contenido`;
CREATE TABLE `seccion_contenido` (
  `idseccioncontenido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idseccion` int(10) unsigned NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `contenido` text NOT NULL,
  `tiene_boton` char(2) NOT NULL DEFAULT 'NO',
  `nombre_boton` varchar(255) DEFAULT NULL,
  `enlace_boton` varchar(255) DEFAULT NULL,
  `acepta_imagen` char(2) NOT NULL DEFAULT 'NO',
  `imagen` varchar(255) DEFAULT NULL,
  `acepta_background` char(2) NOT NULL DEFAULT 'NO',
  `imagen_bg` varchar(255) DEFAULT NULL,
  `tipo_contenido` char(255) DEFAULT 'SI' COMMENT 'SI: sin imagen; \r\nLD: con imagen Lateral derecha; \r\nLI: con imagen Lateral izquierda;\r\nPD: con imagen paralax derecha;\r\nPI: con imagen paralax izquierda;\r\nPS: con paralax y slider de contenido\r\nBG: solo imagen de fondo ',
  `acepta_ficha` char(2) DEFAULT 'NO',
  `ficha_galeria` char(255) DEFAULT 'NO' COMMENT 'SI: las fichas tendran galeria de fotos. NO: no tendran',
  PRIMARY KEY (`idseccioncontenido`),
  KEY `fk_seccion_contenido_seccion_1` (`idseccion`),
  CONSTRAINT `fk_seccion_contenido_seccion_1` FOREIGN KEY (`idseccion`) REFERENCES `seccion` (`idseccion`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of seccion_contenido
-- ----------------------------
INSERT INTO `seccion_contenido` VALUES ('1', '1', 'Nuestro compromiso', null, '<p><span style=\"font-size: 16px;text-align: justify;float: none;\"></span></p><h4><b><span style=\"font-size: 14.0pt;\">Misión</span></b></h4><h4></h4><p>Continuar desarrollando nuevas y excitantes soluciones audiovisuales en la cobertura de excursiones y eventos de todo tipo, brindando siempre un Servicio de la mejor calidad y Atención al Cliente de primera.</p><h4></h4><h4></h4><h4><b><span style=\"font-size: 14.0pt;\">Visión</span></b></h4><h4></h4><p>Ser el principal proveedor de servicios fílmicos y fotográficos en toda el área del este, abarcando La Romana y Bayahibe, estableciéndonos en el mercado local y turístico como la primera opción en la cobertura de las actividades recreativas, sociales y corporativas de nuestros clientes y allegados, siempre excediendo todos los estándares de calidad con nuestros productos y equipo de trabajo. <span> </span></p><h4></h4><h4></h4><h4><strong><b>Valores</b></strong></h4><p>Calidad, Compromiso, Disciplina, Integridad.</p><!--EndFragment--><p><br/></p><p><br/></p><p></p><!--EndFragment--><p><br/></p><p></p>', 'NO', null, null, 'SI', 'image-21.jpg', 'NO', null, 'LD', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('2', '1', 'Goey Studio', 'Punta Cana, Dominican Republic', '<p></p><p><span>Somos un conjunto de artistas audiovisuales que hemos hecho nuestra meta, crear las mejores imágenes y diseños para nuestros clientes, sus recuerdos y actividades mas importantes.</span></p><p><span><br/> Establecidos hace mas de 10 años en el área de Punta Cana, hemos emprendido una metodología de trabajo moderna y altamente creativa, lo que nos permite realizar trabajos innovadores y la entrega de un material con calidad de primera y en tiempo record..</span></p><p><span></span></p><p><b><span>Una compañía en constante crecimiento</span></b></p><p><span>Nuestra rama principal es producción audiovisual de actividades turísticas (excursiones), así como también la cobertura de, Bodas de Destino, Actividades Sociales y Corporativas, Comerciales y Creación de Contenido para Community Management. Día tras día ponemos todo nuestro esfuerzo en ser una excelente fuente de servicios de calidad, siendo así la satisfacción de nuestros clientes y compañías aliadas, nuestra mejor recompensa.</span></p><p></p>', 'SI', null, null, 'NO', null, 'SI', 'bg-1-20171229152744.jpg', 'PI', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('3', '2', 'Oferta de Servicios', 'La experiencia de un personal altamente calificado y comprometido con el mejor servicio.', '<p><b><span style=\"color: #343434;\"></span></b></p><p><b><span style=\"font-size: 14.0pt;color: #343434;\">Fotograf</span></b><b><span style=\"font-size: 14.0pt;color: #343434;\">í</span></b><b><span style=\"font-size: 14.0pt;color: #343434;\">a </span></b><b></b></p><ul><li><span style=\"color: #343434;\">Social y Comercial</span><span style=\"font-size: 11.0pt;\"></span></li><li>Sesiones Bodas, Pre-Boda y Novios</li><li><span style=\"color: #343434;\">Contenido publicitario para Community Management y Social Media (foto y video)</span><span style=\"font-size: 11.0pt;\"></span></li></ul><p><b><span style=\"font-size: 14.0pt;color: #343434;\">Videos </span></b><b><span style=\"font-size: 14.0pt;\"></span></b></p><ul><li><span style=\"color: #343434;\">Comerciales</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Musicales</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Documentales e Infomerciales Corporativos</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Video Social</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Video para Bodas</span><span style=\"font-size: 11.0pt;\"></span></li></ul><p><span style=\"color: #343434;\"></span></p><p><b><span style=\"font-size: 14.0pt;color: #343434;\">Otros Servicios </span></b><b></b></p><ul><li>Photobooths &amp; VideoBooths</li><li>Video tipo 8mm </li><li>Time Lapses &amp; StopMotions</li><li>Diseño e impresión de álbumes y photobooks (Varios Tamaños)</li><li>Impresiones de Fotografías (Varios Tamaños)</li><li><span style=\"color: #343434;\">Fotograf</span><span style=\"color: #343434;\">í</span><span style=\"color: #343434;\">a y Video para Constructoras e Inmobiliarias</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Fotograf</span><span style=\"color: #343434;\">í</span><span style=\"color: #343434;\">a y Video A</span><span style=\"color: #343434;\">é</span><span style=\"color: #343434;\">reo (Drone)</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Fotograf</span><span style=\"color: #343434;\">í</span><span style=\"color: #343434;\">a y Video en 360</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Circuito Cerrado</span><span style=\"font-size: 11.0pt;\"></span></li><li><span style=\"color: #343434;\">Serigraf</span><span style=\"color: #343434;\">í</span><span style=\"color: #343434;\">a y sublimaci</span><span style=\"color: #343434;\">ó</span><span style=\"color: #343434;\">n de Tshirts y tazas </span><span style=\"color: #343434;\"> </span><span style=\"font-size: 11.0pt;\"></span></li></ul><p><br/></p>', 'NO', null, null, 'NO', null, 'SI', 'bg-2-20171229153021.jpg', 'PD', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('4', '2', 'En imágenes', null, '', 'NO', null, null, 'NO', null, 'NO', null, 'SI', 'SI', 'SI');
INSERT INTO `seccion_contenido` VALUES ('5', '4', '¿Quieres trabajar con nosotros?', null, '<div style=\"text-align: center;\">We looking for people like you!</div><div style=\"text-align: center;\"><br/></div><div style=\"text-align: center;\"><a href=\"http://www.caribbeanphotocloud.com/solicitudempleo.pdf\" target=\"_blank\">Click Here </a>to leave your Curriculum Vitae.</div><div style=\"text-align: center;\">¡We hope to see you soon!</div><p></p>', 'NO', null, null, 'NO', null, 'NO', null, 'SI', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('6', '2', 'Adquiera sus fotos de excursión On Line', 'Desde su móvil, Tablet o computadora. Seleccione las fotos que mas le gusten, descárgalas y compártelas en sus redes sociales. Moderno y simple.', '<p><span style=\"font-size: 14px;\">Usted puede contratar nuestros servicios contactando telefónicamente o desde nuestra web mediante el chat puesto a su disposición, disponible las 24 horas, los 7 días de la semana. </span><br/></p><p></p><p><br/></p><p><span style=\"font-size: 9.0pt;\">*Notas:</span></p><p><span style=\"font-size: 9.0pt;\">Los trabajos contratados permanecerán en la nube durante un plazo de 30 días, con la finalidad de que usted pueda mantener una copia de sus fotografías.</span></p><p></p>', 'NO', '', '', 'NO', '', 'SI', 'bg-2-20171229154044.jpg', 'PS', 'SI', 'NO');
INSERT INTO `seccion_contenido` VALUES ('7', '5', 'Legal Notice', null, '<p><br/><!--StartFragment--></p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>1. EL AVISO LEGAL Y SU ACEPTACION</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El pre&#173;sente aviso legal (en ade&#173;lante, el “Aviso Legal”) reg&#173;ula el uso del ser&#173;vi&#173;cio del por&#173;tal de Inter&#173;net www.caribbeanphotocloud.com (en ade&#173;lante, el “Por&#173;tal”) que CARIBBEAN PHOTO STUDIO (en ade&#173;lante, <span style=\"font-size: 12.87px;float: none;\">CARIBBEAN PHOTO STUDIO</span>), con domi&#173;cilio social en Av. Estados Unidos, Plaza Tres Center Local B-23, Friusa, Bavaro<span style=\"font-size: 14px;text-align: left;float: none;\"></span>, Rep. Dom. , pone a dis&#173;posi&#173;ción de los usuar&#173;ios de Inter&#173;net. La uti&#173;lización del Por&#173;tal atribuye la condi&#173;ción de usuario del Por&#173;tal (en ade&#173;lante, el “Usuario”) e implica la aceptación plena y sin reser&#173;vas de todas y cada una de las dis&#173;posi&#173;ciones inclu&#173;idas en este Aviso Legal en la ver&#173;sión pub&#173;li&#173;cada por <span style=\"font-size: 12.87px;float: none;\">CARIBBEAN PHOTO STUDIO</span> en el momento mismo en que el Usuario acceda al Por&#173;tal. En con&#173;se&#173;cuen&#173;cia, el Usuario debe leer aten&#173;ta&#173;mente el pre&#173;sente Aviso Legal en cada una de las oca&#173;siones en que se pro&#173;ponga uti&#173;lizar el Por&#173;tal, ya que aquél puede sufrir modificaciones.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>2. OBJETO</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">A través del Por&#173;tal, CARIBBEAN PHOTO STUDIO facilita a los Usuar&#173;ios el acceso y la uti&#173;lización de diver&#173;sos ser&#173;vi&#173;cios y con&#173;tenidos (en ade&#173;lante, los “Ser&#173;vi&#173;cios”) puestos a dis&#173;posi&#173;ción por CARIBBEAN PHOTO STUDIO o por terceros.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>3. CONDICIONES DE ACCESO Y UTILIZACION DEL PORTAL</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.1. Carác&#173;ter gra&#173;tu&#173;ito del acceso y uti&#173;lización del Portal</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">La prestación de los Ser&#173;vi&#173;cios, por parte de CARIBBEAN PHOTO STUDIO, tiene carác&#173;ter gra&#173;tu&#173;ito para los Usuar&#173;ios. No obstante lo ante&#173;rior, algunos de los Ser&#173;vi&#173;cios sum&#173;in&#173;istra&#173;dos por CARIBBEAN PHOTO STUDIO o por ter&#173;ceros a través del Por&#173;tal están suje&#173;tos al pago de un pre&#173;cio en la forma que se deter&#173;mine en las cor&#173;re&#173;spon&#173;di&#173;entes Condi&#173;ciones Particulares.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.2. Reg&#173;istro de Usuario</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Con carác&#173;ter gen&#173;eral la prestación de los Ser&#173;vi&#173;cios no exige la pre&#173;via suscrip&#173;ción o reg&#173;istro de los Usuar&#173;ios. No obstante, CARIBBEAN PHOTO STUDIO condi&#173;ciona la uti&#173;lización de algunos de los Ser&#173;vi&#173;cios a la pre&#173;via cumpli&#173;mentación del cor&#173;re&#173;spon&#173;di&#173;ente reg&#173;istro de Usuario. Asimismo, CARIBBEAN PHOTO STUDIO pone a dis&#173;posi&#173;ción de los Usuar&#173;ios algunos Ser&#173;vi&#173;cios cuya uti&#173;lización requiere la cumpli&#173;mentación de reg&#173;istros adi&#173;cionales. El citado reg&#173;istro se efec&#173;tu&#173;ará en la forma expre&#173;sa&#173;mente indi&#173;cada en el pro&#173;pio ser&#173;vi&#173;cio o en las Condi&#173;ciones Par&#173;tic&#173;u&#173;lares que lo regulen.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.3. Veraci&#173;dad de la información</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Toda la infor&#173;ma&#173;ción que facilite el Usuario a través de los Ser&#173;vi&#173;cios deberá ser veraz. A estos efec&#173;tos, el Usuario garan&#173;tiza la aut&#173;en&#173;ti&#173;ci&#173;dad de todos aque&#173;l&#173;los datos que comu&#173;nique como con&#173;se&#173;cuen&#173;cia de la cumpli&#173;mentación de los for&#173;mu&#173;la&#173;rios nece&#173;sar&#173;ios para la suscrip&#173;ción de los Ser&#173;vi&#173;cios. De igual forma, será respon&#173;s&#173;abil&#173;i&#173;dad del Usuario man&#173;tener toda la infor&#173;ma&#173;ción facil&#173;i&#173;tada a CARIBBEAN PHOTO STUDIO per&#173;ma&#173;nen&#173;te&#173;mente actu&#173;al&#173;izada de forma que responda, en cada momento, a la situación real del Usuario. En todo caso el Usuario será el único respon&#173;s&#173;able de las man&#173;i&#173;festa&#173;ciones fal&#173;sas o inex&#173;ac&#173;tas que real&#173;ice y de los per&#173;juicios que cause a CARIBBEAN PHOTO STUDIO o a ter&#173;ceros por la infor&#173;ma&#173;ción que facilite.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.4. Menores de edad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Para hacer uso de los Ser&#173;vi&#173;cios que requieran la recogida de Datos Per&#173;son&#173;ales por parte de CARIBBEAN PHOTO STUDIO los menores de trece años (en ade&#173;lante “Menores de Edad”) deben obtener pre&#173;vi&#173;a&#173;mente per&#173;miso de sus padres, tutores o rep&#173;re&#173;sen&#173;tantes legales, quienes serán con&#173;sid&#173;er&#173;a&#173;dos respon&#173;s&#173;ables de todos los actos real&#173;iza&#173;dos por los menores a su cargo.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">3.5. Obligación de hacer un uso cor&#173;recto del Por&#173;tal y de los Servicios</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El Usuario se com&#173;pro&#173;m&#173;ete a uti&#173;lizar el Por&#173;tal y los Ser&#173;vi&#173;cios de con&#173;formi&#173;dad con la ley, el pre&#173;sente Aviso Legal, las Condi&#173;ciones Par&#173;tic&#173;u&#173;lares de cier&#173;tos Ser&#173;vi&#173;cios y demás avi&#173;sos, reglamen&#173;tos de uso e instruc&#173;ciones puestos en su conocimiento, así como con la moral y las bue&#173;nas cos&#173;tum&#173;bres gen&#173;eral&#173;mente acep&#173;tadas y el orden público.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El Usuario deberá absten&#173;erse de obtener e incluso de inten&#173;tar obtener los Con&#173;tenidos emple&#173;ando para ello medios o pro&#173;ced&#173;imien&#173;tos dis&#173;tin&#173;tos de los que, según los casos, se hayan puesto a su dis&#173;posi&#173;ción a este efecto o se hayan indi&#173;cado a este efecto en las pági&#173;nas web donde se encuen&#173;tren los Con&#173;tenidos o, en gen&#173;eral, de los que se empleen habit&#173;ual&#173;mente en Inter&#173;net a este efecto siem&#173;pre que no entrañen un riesgo de daño o inuti&#173;lización del Por&#173;tal, de los Ser&#173;vi&#173;cios y/o de los Contenidos.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Los Usuar&#173;ios o ter&#173;ceros per&#173;ju&#173;di&#173;ca&#173;dos por la recep&#173;ción de men&#173;sajes no solic&#173;i&#173;ta&#173;dos dirigi&#173;dos a una plu&#173;ral&#173;i&#173;dad de per&#173;sonas podrán comu&#173;nicárselo a CARIBBEAN PHOTO STUDIO remi&#173;tiendo un men&#173;saje a la sigu&#173;iente direc&#173;ción de correo elec&#173;trónico: contacto@caribbeanphotocloud.com.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>4. NO LICENCIA</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Todas las mar&#173;cas, nom&#173;bres com&#173;er&#173;ciales o sig&#173;nos dis&#173;tin&#173;tivos de cualquier clase que apare&#173;cen en el Por&#173;tal son propiedad de CARIBBEAN PHOTO STUDIO o de ter&#173;ceros, sin que pueda enten&#173;derse que el uso o acceso al Por&#173;tal y/o a los Ser&#173;vi&#173;cios atribuya al Usuario dere&#173;cho alguno sobre las citadas mar&#173;cas, nom&#173;bres com&#173;er&#173;ciales y/o sig&#173;nos distintivos.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Asimismo, los Con&#173;tenidos son propiedad int&#173;elec&#173;tual de CARIBBEAN PHOTO STUDIO o de ter&#173;ceros, sin que puedan enten&#173;derse cedi&#173;dos al Usuario, en vir&#173;tud de lo estable&#173;cido en este Aviso Legal, ninguno de los dere&#173;chos de explotación que exis&#173;ten o puedan exi&#173;s&#173;tir sobre dichos Con&#173;tenidos más allá de lo estric&#173;ta&#173;mente nece&#173;sario para el cor&#173;recto uso del Por&#173;tal y de los Servicios.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>5. EXCLUSION DE GARANTIAS Y DE RESPONSABILIDAD</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.1 Disponi&#173;bil&#173;i&#173;dad y con&#173;tinuidad, util&#173;i&#173;dad y falibilidad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no garan&#173;tiza la disponi&#173;bil&#173;i&#173;dad y con&#173;tinuidad del fun&#173;cionamiento del Por&#173;tal y de los Ser&#173;vi&#173;cios. Cuando ello sea razon&#173;able&#173;mente posi&#173;ble, CARIBBEAN PHOTO STUDIO adver&#173;tirá pre&#173;vi&#173;a&#173;mente de las inter&#173;rup&#173;ciones en el fun&#173;cionamiento del Por&#173;tal y de los Ser&#173;vi&#173;cios. CARIBBEAN PHOTO STUDIO tam&#173;poco garan&#173;tiza la util&#173;i&#173;dad del Por&#173;tal y de los Ser&#173;vi&#173;cios para la real&#173;ización de ninguna activi&#173;dad en con&#173;creto, ni su infal&#173;i&#173;bil&#173;i&#173;dad y, en par&#173;tic&#173;u&#173;lar, aunque no de modo exclu&#173;sivo, CARIBBEAN PHOTO STUDIO no garan&#173;tiza que los Usuar&#173;ios puedan efec&#173;ti&#173;va&#173;mente uti&#173;lizar el Por&#173;tal y los Ser&#173;vi&#173;cios, acceder a las dis&#173;tin&#173;tas pági&#173;nas web que for&#173;man el Por&#173;tal o a aquél&#173;las desde las que se prestan los Servicios.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO EXCLUYE, CON TODA LA EXTENSION PERMITIDA POR EL ORDENAMIENTO JURIDICO, CUALQUIER RESPONSABILIDAD POR LOS DANOS Y PERJUICIOS DE TODA NATURALEZA QUE PUEDAN DEBERSE A LA FALTA DE DISPONIBILIDAD O DE CONTINUIDAD DEL FUNCIONAMIENTO DEL PORTAL Y DE LOS SERVICIOS, A LA DEFRAUDACION DE LA UTILIDAD QUE LOS USUARIOS HUBIEREN PODIDO ATRIBUIR AL PORTAL Y A LOS SERVICIOS, A LA FALIBILIDAD DEL PORTAL Y DE LOS SERVICIOS, Y EN PARTICULAR, AUNQUE NO DE MODO EXCLUSIVO, A LOS FALLOS EN EL ACCESO A LAS DISTINTAS PAGINAS WEB DEL PORTAL O A AQUELLAS DESDE LAS QUE SE PRESTAN LOS SERVICIOS.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.3 Cal&#173;i&#173;dad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no con&#173;trola ni garan&#173;tiza la ausen&#173;cia de virus ni de otros ele&#173;men&#173;tos en los Con&#173;tenidos que puedan pro&#173;ducir alteraciones en su sis&#173;tema infor&#173;mático (soft&#173;ware y hard&#173;ware) o en los doc&#173;u&#173;men&#173;tos elec&#173;tróni&#173;cos y ficheros alma&#173;ce&#173;na&#173;dos en su sis&#173;tema informático.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.4 Veraci&#173;dad, exac&#173;ti&#173;tud, exhaus&#173;tivi&#173;dad y actualidad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no garan&#173;tiza la veraci&#173;dad, exac&#173;ti&#173;tud, exhaus&#173;tivi&#173;dad y actu&#173;al&#173;i&#173;dad de los Contenidos.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO EXCLUYE, CON TODA LA EXTENSION PERMITIDA POR EL ORDENAMIENTO JURIDICO, CUALQUIER RESPONSABILIDAD POR LOS DAÑOS Y PERJUICIOS DE TODA NATURALEZA QUE PUEDAN DEBERSE A LA FALTA DE VERACIDAD, EXACTITUD, EXHAUSTIVIDAD Y/O ACTUALIDAD DE LOS CONTENIDOS.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">5.5 Lic&#173;i&#173;tud, fia&#173;bil&#173;i&#173;dad y utilidad</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">CARIBBEAN PHOTO STUDIO no garan&#173;tiza la lic&#173;i&#173;tud, fia&#173;bil&#173;i&#173;dad y util&#173;i&#173;dad de los ser&#173;vi&#173;cios presta&#173;dos por ter&#173;ceros a través del Por&#173;tal. CARIBBEAN PHOTOSTUDIO EXCLUYE CUALQUIER RESPONSABILIDAD POR LOS DANOS Y PERJUICIOS DE TODA NATURALEZA QUE PUEDAN DEBERSE A LOS SERVICIOS PRESTADOS POR TERCEROS A TRAVES DEL PORTAL.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>6. PROCEDIMIENTO EN CASO DE REALIZACION DE ACTIVIDADES DE CARACTER ILICITO</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">En el caso de que cualquier Usuario o un ter&#173;cero con&#173;sidere que exis&#173;ten hechos o cir&#173;cun&#173;stan&#173;cias que rev&#173;e&#173;len el carác&#173;ter ilíc&#173;ito de la uti&#173;lización de cualquier Con&#173;tenido y/o de la real&#173;ización de cualquier activi&#173;dad en las pági&#173;nas web inclu&#173;idas o acce&#173;si&#173;bles a través del Por&#173;tal, y, en par&#173;tic&#173;u&#173;lar, de la vio&#173;lación de dere&#173;chos de propiedad int&#173;elec&#173;tual o indus&#173;trial (patentes, mod&#173;e&#173;los y dibu&#173;jos indus&#173;tri&#173;ales, mar&#173;cas y nom&#173;bres com&#173;er&#173;ciales, etc.) u otros dere&#173;chos, deberá enviar una noti&#173;fi&#173;cación a CARIBBEAN PHOTO STUDIO en la que se con&#173;tengan los sigu&#173;ientes extremos:</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(a) datos per&#173;son&#173;ales del recla&#173;mante: nom&#173;bre, direc&#173;ción, número de telé&#173;fono y direc&#173;ción de correo electrónico;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(b) especi&#173;fi&#173;cación de la supuesta activi&#173;dad ilícita lle&#173;vada a cabo en el Por&#173;tal y, en par&#173;tic&#173;u&#173;lar, cuando se trate de una supuesta vio&#173;lación de dere&#173;chos, indi&#173;cación pre&#173;cisa y conc&#173;reta de los con&#173;tenidos pro&#173;te&#173;gi&#173;dos así como de su local&#173;ización en las pági&#173;nas web;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(c) hechos o cir&#173;cun&#173;stan&#173;cias que rev&#173;e&#173;lan el carác&#173;ter ilíc&#173;ito de dicha actividad;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(d) en el supuesto de vio&#173;lación de dere&#173;chos, firma man&#173;u&#173;scrita o equiv&#173;a&#173;lente, con los datos per&#173;son&#173;ales del tit&#173;u&#173;lar de los dere&#173;chos supues&#173;ta&#173;mente infringi&#173;dos o de la per&#173;sona autor&#173;izada para actuar en nom&#173;bre y por cuenta de ésta;</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(e) declaración expresa, clara y bajo la respon&#173;s&#173;abil&#173;i&#173;dad del recla&#173;mante de que la infor&#173;ma&#173;ción pro&#173;por&#173;cionada en la noti&#173;fi&#173;cación es exacta y del carác&#173;ter ilíc&#173;ito de la uti&#173;lización de los con&#173;tenidos o de la real&#173;ización de las activi&#173;dades descritas.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>7. NOTIFICACIONES</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">Todas las noti&#173;fi&#173;ca&#173;ciones y comu&#173;ni&#173;ca&#173;ciones (en ade&#173;lante, las “Noti&#173;fi&#173;ca&#173;ciones”) por parte del Usuario a CARIBBEAN PHOTO STUDIO se con&#173;sid&#173;er&#173;arán efi&#173;caces, a todos los efec&#173;tos, cuando se nos diri&#173;jan de alguna de las sigu&#173;ientes formas:</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(a) Envío por correo postal a la sigu&#173;iente direc&#173;ción: <span style=\"font-size: 12.87px;float: none;\">Av. Estados Unidos, Plaza Tres Center Local B-23, Friusa, Bavaro</span><span style=\"font-size: 14px;text-align: left;float: none;\"></span><span style=\"font-size: 12.87px;float: none;\">, Rep. Dom</span><br/></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">(b) Comu&#173;ni&#173;cación por medio de una lla&#173;mada tele&#173;fónica al número de telé&#173;fono: 8095521546.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\">© Envío por correo elec&#173;trónico a la sigu&#173;iente direc&#173;ción: contacto@caribbeanphotocloud.com.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><b>8. LEGISLACION APLICABLE</b></p><p style=\"font-size: 12.87px;vertical-align: baseline;\">El pre&#173;sente Aviso Legal se rige en todos y cada uno de sus extremos por la ley de la República Dominicana.</p><p style=\"font-size: 12.87px;vertical-align: baseline;\"><span style=\"font-size: 12.87px;float: none;\">CARIBBEAN PHOTO STUDIO </span>y el Usuario, con renun&#173;cia expresa a cualquier otro fuero, se some&#173;ten al de los Juz&#173;ga&#173;dos y Tri&#173;bunales de la República Domini&#173;cana. Para cualquier sug&#173;eren&#173;cia o prop&#173;uesta de colab&#173;o&#173;ración escríbanos por correo elec&#173;trónico a <span style=\"font-size: 12.87px;float: none;\">contacto@caribbeanphotocloud.com.</span>., o llá&#173;menos al sigu&#173;iente número de telé&#173;fono: <span style=\"font-size: 12.87px;float: none;\">8095521546.</span></p><p></p>', 'NO', '', '', 'NO', '', 'NO', '', 'SI', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('8', '6', 'Terms & Conditions', null, '<p><span style=\"font-size: 10.5pt;\">1.Política</span><br/> <span style=\"font-size: 10.5pt;\">Al ingresar y utilizar este portal de Internet, cuyo nombre de dominio es https://www.caribbeanphotocloud.com que en lo sucesivo se denominará “CARIBBEAN PHOTO STUDIO”, el usuario está aceptando los Términos y condiciones de uso contenidos en este convenio y declara expresamente su aceptación utilizando para tal efecto medios electrónicos, en términos de lo dispuesto por el artículo 1803 del Código Civil Federal. En caso de no aceptar en forma absoluta y completa los términos y condiciones de este convenio, el usuario deberá abstenerse de acceder, utilizar y observar el sitio web www.caribbeanphotocloud.com.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Y en caso de que el usuario acceda, utilice y observe el sitio web www.caribbeanphotocloud.com se considerará como una absoluta y expresa aceptación de los Términos y condiciones de uso aquí estipulados.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">La sola utilización de dicha página de Internet le otorga al público en general la condición de usuario (en adelante referido como el «usuario» o los «usuarios») e implica la aceptación, plena e incondicional, de todas y cada una de las condiciones generales y particulares incluidas en estos Términos y condiciones de uso publicados por CARIBBEAN PHOTO STUDIO en el momento mismo en que el usuario acceda al sitio web.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Cualquier modificación a los presentes Términos y condiciones de uso será realizada cuando el titular de la misma, en este caso CARIBBEAN PHOTO STUDIO, lo considere apropiado, siendo exclusiva responsabilidad del usuario asegurarse de tomar conocimiento de tales modificaciones.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">2. Convenio </span><br/> <span style=\"font-size: 10.5pt;\">Convenio de adhesión para el uso de la página de Internet https:// www.caribbeanphotocloud.com / que celebran: por una parte, CARIBBEAN PHOTO STUDIO y, por la otra, el usuario, sujetándose, ambas partes, a lo establecido en este documento.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">3. Licencia</span><br/> <span style=\"font-size: 10.5pt;\">a) Por virtud de la celebración de este convenio, “CARIBBEAN PHOTO STUDIO” otorga y concede al usuario el derecho no exclusivo, revocable y no transferible de ver y utilizar el sitio web www.caribbeanphotocloud.com de conformidad con los Términos y condiciones de uso que aquí se estipulan. Para los efectos del presente convenio, las partes acuerdan que por «usuario» se entenderá a cualquier persona de cualquier naturaleza que ingrese al sitio web https:// www.caribbeanphotocloud.com / y/o a cualquiera de las subpáginas que despliegan su contenido y/o a la persona de cualquier naturaleza que se dé de alta y/o use cualquiera de los servicios que se ofrecen a través de dicha página.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">b) El usuario sólo podrá imprimir y/o copiar cualquier información contenida o publicada en el sitio web www.caribbeanphotocloud.com exclusivamente para uso personal, queda terminantemente prohibido el uso comercial de dicha información. En caso de ser persona moral se sujetará a lo dispuesto por el artículo 148, fracción IV de la Ley Federal del Derecho de Autor.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">c) La reimpresión, publicación, distribución, asignación, sublicencia, venta, reproducción electrónica o por otro medio, parcial o total, de cualquier información, documento o gráfico que aparezca en el sitio web https://www.caribbeanphotocloud.com, para cualquier uso distinto al personal no comercial le está expresamente prohibido al usuario, a menos de que cuente con la autorización previa y por escrito de CARIBBEAN PHOTO STUDIO.</span><br/> <br/> <span style=\"font-size: 10.5pt;\"> </span><br/> <span style=\"font-size: 10.5pt;\">4. Reglas para el uso del sitio web www.caribbeanphotocloud.com .</span><br/> <span style=\"font-size: 10.5pt;\">El usuario y CARIBBEAN PHOTO STUDIO están de acuerdo en que la utilización del sitio web https://www.caribbeanphotocloud.com se sujetará a las siguientes reglas:</span><br/> <br/> <span style=\"font-size: 10.5pt;\">1. Información contenida en el sitio web www.www.caribbeanphotocloud.com </span><br/> <span style=\"font-size: 10.5pt;\">El usuario reconoce y acepta que la información publicada o contenida en dicho sitio será claramente identificada de forma tal que se reconozca que la misma proviene y ha sido generada por CARIBBEAN PHOTO STUDIO o por sus proveedores.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">2. No obstante, la información, conceptos y opiniones publicadas en dicho sitio no necesariamente reflejan la posición de CARIBBEAN PHOTO STUDIO, ni de sus empleados, oficiales, directores, accionistas, licenciatarios y concesionarios (en lo sucesivo los «afiliados»).</span><br/> <span style=\"font-size: 10.5pt;\">Por esta razón, CARIBBEAN PHOTO STUDIO no se hace responsable por ninguna de las informaciones, opiniones y conceptos que se emitan en la página web referida. En este caso, se recomienda al usuario consultar con un especialista y/o profesional en la materia. Asimismo, CARIBBEAN PHOTO STUDIO no se hace responsable de la información contenida en la página de Internet, incluidas las subpáginas, en el entendido de que el uso y seguimiento de la misma es bajo riesgo y responsabilidad del usuario.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">3. CARIBBEAN PHOTO STUDIO se reserva el derecho de bloquear el acceso o remover en forma parcial o total</span><br/> <span style=\"font-size: 10.5pt;\">Toda información, comunicación o material que a su exclusivo juicio pueda resultar: i) abusivo, difamatorio u obsceno; ii) fraudulento, artificioso o engañoso; iii) violatorio de derechos de autor, marcas, confidencialidad, secretos industriales o cualquier derecho de propiedad intelectual de un tercero; iv) ofensivo o; v) que de cualquier forma contravenga lo establecido en este convenio. Si el usuario desea obtener mayor información de un tema en específico proveído por CARIBBEAN PHOTO STUDIO o sus proveedores deberá consultarlo directamente con cada uno de ellos, según corresponda, y/o con un especialista en la materia.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">4. El usuario reconoce que CARIBBEAN PHOTO STUDIO no controla o censura previamente el contenido disponible en la página de Internet.</span><br/> <span style=\"font-size: 10.5pt;\">Por tal motivo, CARIBBEAN PHOTO STUDIO no asume ninguna responsabilidad por el contenido provisto a dicha página por proveedores independientes o ajenos a CARIBBEAN PHOTO STUDIO y no tiene el control editorial sobre el contenido, información y/o material generado y/o provisto por terceros. Todas las opiniones, consejos, declaraciones, servicios, ofertas u otras informaciones o contenidos expresados o puestos a disposición del público por terceros, pertenecen a su respectivo autor y CARIBBEAN PHOTO STUDIO no asume responsabilidad alguna frente a ello. De la misma forma, CARIBBEAN PHOTO STUDIO no garantiza la exactitud, veracidad, amplitud y/o utilidad de cualquier contenido provisto por tales terceros. Adicionalmente, CARIBBEAN PHOTO STUDIO no es responsable ni garantiza la exactitud, exhaustividad, veracidad y/o confiabilidad de cualquier opinión, información, consejo o declaración expresados por CARIBBEAN PHOTO STUDIO a través de su página de Internet y bajo ninguna circunstancia CARIBBEAN PHOTO STUDIO será responsable de cualquier daño y/o perjuicio, directo o indirecto, causado en virtud de la confianza que el usuario deposite en información obtenida a través de su sitio web. CARIBBEAN PHOTO STUDIO se reserva el derecho de suprimir o modificar el contenido de esta página que, a exclusivo juicio de CARIBBEAN PHOTO STUDIO, no cumpla con sus estándares o que pudiera resultar contrario al ordenamiento jurídico vigente y, por consiguiente, no será responsable por cualquier falla o tardanza que se genere al eliminar tal material. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">5. Formatos </span><br/> <span style=\"font-size: 10.5pt;\">Los usuarios reconocen que, al proporcionar la información de carácter personal requerida en alguno de los servicios que se prestan en este sitio web, otorgan a CARIBBEAN PHOTO STUDIO la autorización señalada en el artículo 109 de la Ley Federal del Derecho de Autor. En todos los casos, los usuarios responderán por la veracidad de la información proporcionada a CARIBBEAN PHOTO STUDIO. Asimismo, para la prestación de servicios, el usuario se obliga además a aceptar los términos y condiciones estipulados para tal efecto.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">6. Derechos de autor y propiedad industrial</span><br/> <span style=\"font-size: 10.5pt;\">CARIBBEAN PHOTO STUDIO, el sitio web www.www.caribbeanphotocloud.com . sus logotipos y todo el material que aparece en dicho sitio, son marcas, nombres de dominio, nombres comerciales y obras artísticas propiedad de sus respectivos titulares y están protegidos por los tratados internacionales y las leyes aplicables en materia de propiedad intelectual y derechos de autor.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Los derechos de autor sobre el contenido, organización, recopilación, compilación, información, logotipos, fotografías, imágenes, programas, aplicaciones, y en general cualquier información contenida o publicada en el sitio web www.www.caribbeanphotocloud.com . se encuentran debidamente protegidos a favor de CARIBBEAN PHOTO STUDIO, sus afiliados, proveedores y/o de sus respectivos propietarios, de conformidad con la legislación aplicable en materia de propiedad intelectual e industrial.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Se prohíbe expresamente al usuario modificar, alterar o suprimir, ya sea en forma total o parcial, los avisos, marcas, nombres comerciales, señas, anuncios, logotipos o en general cualquier indicación que se refiera a la propiedad de la información contenida en el sitio señalado.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">En caso de que el usuario transmita a CARIBBEAN PHOTO STUDIO cualquier información, programas, aplicaciones, software o en general cualquier material que requiera ser licenciado a través del sitio web www.www.caribbeanphotocloud.com , el usuario otorga con este acto a CARIBBEAN PHOTO STUDIO una licencia perpetua, universal, gratuita, no exclusiva, mundial y libre de regalías, que incluye los derechos de sublicenciar, vender, reproducir, distribuir, transmitir, crear trabajos derivados, exhibirlos y ejecutarlos públicamente. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">Lo establecido en el párrafo anterior se aplicará igualmente a cualquier otra información que el usuario envíe o transmita a CARIBBEAN PHOTO STUDIO, incluyendo, sin limitación alguna, ideas para renovar o mejorar el sitio web www.www.caribbeanphotocloud.com ), ya sea que éstas hayan sido incluidas en cualquier espacio de la página señalada o en virtud de otros medios o modos de transmisión conocidos o que sean desarrollados en el futuro. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">Por lo anterior, el usuario renuncia expresamente con este acto a llevar a cabo cualquier acción, demanda o reclamación en contra de CARIBBEAN PHOTO STUDIO, sus afiliados o proveedores por cualquier actual o eventual violación de cualquier derecho de autor o propiedad intelectual derivado de la información, programas, aplicaciones, software, ideas y demás material que el propio usuario envíe al sitio web https://www.caribbeanphotocloud.com/.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Es nuestra política actuar contra las violaciones que en materia de propiedad intelectual se pudieran generar u originar según lo estipulado en la legislación y en otras leyes de propiedad intelectual aplicables, incluyendo la eliminación o el bloqueo del acceso a material que se encuentra sujeto a actividades que infrinjan el derecho de propiedad intelectual de terceros.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">En caso de que algún usuario o tercero consideren que cualquiera de los contenidos que se encuentren o sean introducidos en dicho sitio https://www.caribbeanphotocloud.com/ y/o cualquiera de sus servicios, violen sus derechos de propiedad intelectual deberán enviar una notificación a la siguiente dirección (Poner dirección de correo electrónico), en la que indiquen: i) datos personales verídicos (nombre, dirección, número de teléfono y dirección de correo electrónico del reclamante); ii) firma autógrafa con los datos personales del titular de los derechos de propiedad intelectual; iii) indicación precisa y completa del (los) contenido (s) protegido (s) mediante los derechos de propiedad intelectual supuestamente infringidos, así como la localización de dichas violaciones en el sitio web referido; iv) declaración expresa y clara de que la introducción del (los) contenido (s) indicado (s) se ha realizado sin el consentimiento del titular de los derechos de propiedad intelectual supuestamente infringidos; v) declaración expresa, clara y bajo la responsabilidad del reclamante de que la información proporcionada en la notificación es exacta y de que la introducción del (los) contenido (s) constituye una violación de dichos derechos.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">7. Material publicitario</span><br/> <span style=\"font-size: 10.5pt;\">El usuario reconoce y acepta que CARIBBEAN PHOTO STUDIO es una organización independiente de terceros patrocinadores y anunciantes cuya información, imágenes, anuncios y demás material publicitario o promocional (en lo subsecuente «material publicitario›) puede ser publicado en el sitio web www.www.caribbeanphotocloud.com . El usuario reconoce y acepta que el material publicitario no forma parte del contenido principal que se publica en dicho sitio. Asimismo, reconoce y acepta con este acto que este material se encuentra protegido por las leyes que en materia de propiedad intelectual e industrial resulten aplicables.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">8. Negación de garantías</span><br/> <span style=\"font-size: 10.5pt;\">El usuario está de acuerdo que la utilización del sitio web www.caribbeanphotocloud.com se realiza bajo su propio riesgo y que los servicios y productos que ahí se prestan y ofrecen se prevén sobre una base «tal cual» y «según sean disponibles». CARIBBEAN PHOTO STUDIO no garantiza que la página señalada satisfaga los requerimientos del usuario o que los servicios que en ella se ofrecen no sufran interrupciones, sean seguros o estén exentos de errores.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">CARIBBEAN PHOTO STUDIO no garantiza o avala en ninguna forma la veracidad, precisión, legalidad, moralidad o ninguna otra característica del contenido del material que se publique en el sitio web www.www.caribbeanphotocloud.com .</span><br/> <br/> <span style=\"font-size: 10.5pt;\">CARIBBEAN PHOTO STUDIO se libera de cualquier responsabilidad y condiciones, tanto expresas como implícitas, en relación con los servicios e información contenida o disponible en o a través de esta página web; incluyendo, sin limitación alguna:</span><br/> <br/> <span style=\"font-size: 10.5pt;\">a) La disponibilidad de uso del sitio web www.www.caribbeanphotocloud.com .</span><br/> <br/> <span style=\"font-size: 10.5pt;\">b) La ausencia de virus, errores, desactivadores o cualquier otro material contaminante o con funciones destructivas en la información o programas disponibles en o a través de esta página o en general cualquier falla en dicho sitio.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">c) No obstante lo anterior, CARIBBEAN PHOTO STUDIO o sus proveedores podrán actualizar el contenido de la página constantemente, por lo que se solicita al usuario tomar en cuenta que algunas informaciones publicitadas o contenidas en o a través de este sitio web pueden haber quedado obsoletas y/o contener imprecisiones o errores tipográficos u ortográficos. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">9. Limitaciones a la responsabilidad</span><br/> <span style=\"font-size: 10.5pt;\">Hasta el máximo permitido por las leyes aplicables, CARIBBEAN PHOTO STUDIO no será responsable, en ningún caso, por daños directos, especiales, incidentales, indirectos, o consecuenciales que en cualquier forma se deriven o se relacionen con:</span><br/> <br/> <span style=\"font-size: 10.5pt;\">a) El uso o ejecución del sitio web www.www.caribbeanphotocloud.com , con el retraso o la falta de disponibilidad de uso de CARIBBEAN PHOTO STUDIO </span><br/> <br/> <span style=\"font-size: 10.5pt;\">b) La proveeduría o falta de la misma de servicios de cualquier información o gráficos contenidos o publicados en o a través del sitio señalado.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">c) La actualización o falta de actualización de la información. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">d) La alteración o modificación, total o parcial, de la información después de haber sido incluida en dicho sitio.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">e) Cualquier otro aspecto o característica de la información contenida o publicada en la página web o a través de las ligas que eventualmente se incluyan en este sitio.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">f) La proveeduría o falta de proveeduría que los demás servicios, todos los supuestos anteriores serán vigentes, aún en los casos en que se le hubiere notificado o avisado a CARIBBEAN PHOTO STUDIO acerca de la posibilidad de que se ocasionaran dichos daños.</span><br/> <br/> <span style=\"font-size: 10.5pt;\"> </span><br/> <span style=\"font-size: 10.5pt;\">10. Modificaciones al sitio web www.www.caribbeanphotocloud.com </span><br/> <span style=\"font-size: 10.5pt;\">CARIBBEAN PHOTO STUDIO podrá en cualquier momento y cuando lo considere conveniente, sin necesidad de avisar al usuario, realizar correcciones, adiciones, mejoras o modificaciones al contenido, presentación, información, servicios, áreas, bases de datos y demás elementos de dicho sitio, sin que ello de lugar ni derecho a ninguna reclamación o indemnización, ni que esto implique reconocimiento de responsabilidad alguna a favor del usuario.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">11. Modificaciones al convenio</span><br/> <span style=\"font-size: 10.5pt;\">CARIBBEAN PHOTO STUDIO se reserva el derecho de modificar los Términos y condiciones de uso de este convenio en cualquier momento, siendo efectivas dichas modificaciones de forma inmediata por medio de:</span><br/> <br/> <span style=\"font-size: 10.5pt;\"> </span><br/> <span style=\"font-size: 10.5pt;\">a) La publicación en el sitio web www.caribbeanphotocloud.com del convenio modificado.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">b) La notificación al usuario sobre dichas modificaciones. De esta forma, el usuario está de acuerdo en revisar dicho convenio periódicamente con la finalidad de mantenerse al tanto de dichas modificaciones. No obstante lo anterior, cada vez que el usuario acceda al sitio señalado se considerará como una aceptación absoluta a las modificaciones del presente convenio. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">12. Términos adicionales</span><br/> <span style=\"font-size: 10.5pt;\">Ocasionalmente, CARIBBEAN PHOTO STUDIO podrá agregar a los Términos y condiciones de uso del presente convenio provisiones adicionales relativas a áreas específicas o nuevos servicios que se proporcionen en o a través del sitio web www.caribbeanphotocloud.com (en lo subsecuente «términos adicionales»), los cuales serán publicados en las áreas específicas o nuevos servicios de dicho sitio para su lectura y aceptación. El usuario reconoce y acepta que estos términos adicionales forman parte integrante del presente convenio para todos los efectos legales a que haya lugar.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">13. Cesión de derechos</span><br/> <span style=\"font-size: 10.5pt;\">CARIBBEAN PHOTO STUDIO podrá, en cualquier momento y cuando así lo estime conveniente, ceder total o parcialmente sus derechos y obligaciones derivados del presente convenio. En virtud de dicha cesión, CARIBBEAN PHOTO STUDIO quedará liberada de cualquier obligación a favor del usuario, establecida en el presente convenio. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">14. Indemnización</span><br/> <span style=\"font-size: 10.5pt;\">El usuario está de acuerdo en indemnizar a CARIBBEAN PHOTO STUDIO, sus afiliados, proveedores, vendedores y asesores por cualquier acción, demanda o reclamación (incluso de honorarios de abogados y de costas judiciales) derivadas de cualquier incumplimiento por parte del usuario al presente convenio; incluyendo, sin limitación de alguna de las derivadas de: </span><br/> <br/> <span style=\"font-size: 10.5pt;\">a) Cualquier aspecto relativo al uso del sitio web www.www.caribbeanphotocloud.com </span><br/> <br/> <span style=\"font-size: 10.5pt;\">b) La información contenida o disponible en o a través de dicho sitio o de injurias, difamación o cualquier otra conducta violatoria del presente convenio por parte del usuario en el uso de la página web señalada.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">c) La violación a las leyes aplicables o tratados internacionales relativos a los derechos de autor o propiedad intelectual, contenidos o disponibles en, o a través de dicho sitio web.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">15. Terminación</span><br/> <span style=\"font-size: 10.5pt;\">CARIBBEAN PHOTO STUDIO se reserva el derecho, a su exclusiva discreción, y sin necesidad de aviso o notificación al usuario, para:</span><br/> <br/> <span style=\"font-size: 10.5pt;\">a) Terminar definitivamente el presente convenio.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">b) Descontinuar o dejar de publicar definitivamente el sitio web https://www.caribbeanphotocloud.com/ sin responsabilidad alguna para CARIBBEAN PHOTO STUDIO, sus afiliados o proveedores. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">16. Subsistencia</span><br/> <span style=\"font-size: 10.5pt;\">Estos Términos y condiciones de uso, así como los términos adicionales, constituyen el acuerdo íntegro entre las partes, y sustituye cualquier otro acuerdo o convenio celebrado con anterioridad. Cualquier cláusula o provisión del presente convenio, así como de los términos adicionales, legalmente declarada inválida, será eliminada o modificada a elección de CARIBBEAN PHOTO STUDIO, con la finalidad de corregir su vicio o defecto. Sin embargo, el resto de las cláusulas o provisiones mantendrán su fuerza, obligatoriedad y validez.</span><br/> <br/> <span style=\"font-size: 10.5pt;\">17. No renuncia de derechos</span><br/> <span style=\"font-size: 10.5pt;\">La inactividad por parte de CARIBBEAN PHOTO STUDIO, sus afiliados o proveedores al ejercicio de cualquier derecho o acción derivados del presente convenio, en ningún momento deberá interpretarse como renuncia a dichos derechos o acciones. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">18. Legislación aplicable y jurisdicción</span><br/> <span style=\"font-size: 10.5pt;\">Este convenio estará sujeto y será interpretado de acuerdo con las leyes y ante los tribunales del Distrito Federal, México. </span><br/> <br/> <span style=\"font-size: 10.5pt;\">19. Devoluciones, Cancelaciones o reembolsos.</span><br/> <span style=\"font-size: 10.5pt;\">Devoluciones Totales</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Nuestra área de Finanzas podrá ejercer la devolución siempre y cuando se haya ejecutado un cobro por un producto y que el producto por algún problema técnico no haya sido entregado al usuario (cliente), la empresa tiene 48 horas después de recibir la queja para enviar el producto al cliente como garantía de compra, en caso de no lograr la entrega del producto comprado, el departamento de Finanzas iniciará el procedimiento y tardará aproximadamente 45 dias hábiles en devolverse. Es posible que se solicite información al cliente a como soporte de la compra. En caso de devoluciones por transferencia internacional este tendrá un costo de 30USD con cargo al usuario (cliente).</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Devoluciones parciales:</span><br/> <br/> <span style=\"font-size: 10.5pt;\">Si existiera algún problema técnico comprobable con el producto digital de manera parcial, digamos las fotos, el video o con el photobook, En caso de que el monto rebase los 50 USD se podrá hacer el reembolso con un cargo al cliente de 30USD por la transferencia internacional. En caso de reembolso nacional este no tendrá cargo alguno. Policita de cancelación: una vez adquirido el producto y enviado al cliente, este no podrá ser cancelado.</span><br/> <br/> Reembolsos:<br/> Debido a la naturaleza del producto que ofrecemos, siempre se tiene la posibilidad de visualizar las fotografías previas a la compra, por lo que una vez concretada, no existe la posibilidad de otorgar reembolsos de ningún tipo.<br/> <br/> Para cualquier información adicional favor de contactarnos al correo services@caribbeanphotocloud.com, O llamarnos a los siguientes telefonos:<br/> <!--[if !supportLineBreakNewLine]--><br/> <!--[endif]--></p><p>CPS - Customer Service </p><p>+1 (849) 912-4759​&#8288;​ - Oficina 809-552-1546</p><p> <br/> <!--[if !supportLineBreakNewLine]--><br/> <!--[endif]--><font size=\"2\"><span style=\"font-size: 10.0pt;\"></span></font></p><p>​</p>', 'NO', '', '', 'NO', '', 'NO', '', 'SI', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('9', '7', 'FAQs', null, '<p><b>1. Si no encuentro mis fotos, ¿Qué puedo hacer?</b><br/>Las fotos están clasificadas por fecha, hábitat, horario de nado y tipo de nado. Una vez seleccionados correctamente todos los filtros de búsqueda, podrás seleccionar tu grupo de fotos.<br/>En caso de que no encuentres tu foto, escríbenos a: photo@delphinus.com.mx o llámanos sin costo en México al 01-800-3353-461.<br/><br/><b>2. ¿Qué métodos de pago aceptan?</b><br/>Puedes pagar con tu tarjeta de crédito VISA, MASTERCARD, American Express, tarjeta de débito y a través de PayPal (no es necesario tener una cuenta con ellos). No aceptamos efectivo o depósitos bancarios.<br/><br/><b>3. ¿Mi pago en línea es seguro?</b><br/>Sí, tus pagos se realizan a través de Conekta y PayPal, reconocidos y seguros sistemas de pago. Tus datos están protegidos por un excelente sistema electrónico. PhotoDelphinus no recibe ni guarda ningún tipo de información sobre tu tarjeta de crédito o datos bancarios.<br/><br/><b>4. ¿En qué formato entregan las fotos?</b><br/>Todas las fotos son entregadas en formato digital (JPG) con un peso aproximado de 1 a 2 MB cada una; actualmente no enviamos fotos impresas. Solo si seleccionaste la opción de Photobook recibirás el formato impreso.<br/><br/><b>5. ¿Cuánto tiempo tardan en estar disponibles las fotos y el video en la plataforma?</b><br/>Desde que realizas tu nado con delfines, almacenamos todas las fotos y video por un período de 3 meses. Si realizas la compra de tus fotos o video, garantizamos que estarán disponibles en tu cuenta durante otro mese para que puedas descargarlas.<br/><br/><b>6. ¿Cómo compro mi Photobook?</b><br/>El Photobook forma parte del Paquete 3, junto con la compra de tus fotos digitales y video.<br/>Tú mismo harás una selección de tus 20 fotografías favoritas.<br/><br/><b>7. ¿Cómo enviamos tu Photobook?</b><br/>Tu Photobook se entrega por medio de la empresa de mensajería UPS dentro de los 5 días hábiles siguientes después de la compra (USA, Can, Mex) y de 6 a 10 días hábiles en otros países.<br/>Utilizamos la dirección que registres al crear tu cuenta.<br/><b><br/></b></p><p><b>8. ¿Puedo ver un preview de mi video?</b><br/>Actualmente la previsualización del video de tu interacción no está disponible. Solo podrás ver y descargar tu video una vez que compres el paquete 2 o 3.<br/><b><br/></b></p><p><b>9. ¿En qué formato se entrega mi video?</b><br/>Tu video HD está en formato MP4 y tiene una duración de entre 8 y 10 minutos, donde podrás ver tus momentos de mayor acción con los delfines en cualquier dispositivo como PC, tabletas, Imacs, IPad y celulares Android.<br/>Los archivos de Video pueden ser abiertos con Windows Media Player, VLC o QuickTime. Es importante mencionar que algunos dispositivos no cuentan con softwares actualizados y no podrán leer los archivos de foto y video. En el caso de que su reproductor de video favorito no pueda abrir el archivo MP4, posiblemente necesitará instalar (descargar) un códec para MPEG4.<br/>Llame sin costo al 01-800-3353-461 o envíenos un correo a photo@delphinus.com.mx<br/><br/><b>10. ¿Para qué sirve el acceso a mi cuenta?</b><br/>Este acceso es para usuarios que han realizado su compra en línea y quieren acceder a ver su panel de fotografías.<br/>Si tu usario y contraseña son marcados como inccorrectos, revise que no está confundiendo alguno de los caracteres, ya que el usuario y contraseña son sensibles a mayúsculas y minúsculas.<br/><b><br/></b></p><p><b>11. La página o mis fotos no se despliegan correctamente, ¿qué puedo hacer?</b><br/>Asegúrate de tener una versión actualizada de Mozilla, Chrome, Internet Explorer o Safari. Si el problema persiste, escríbenos a: photo@delphinus.com.mx o llámanos sin costo en México al 01-800-3353-461<br/><br/><b>12. ¿Cuánto tardan en estar disponibles mis fotos una vez que las he comprado?</b><br/>Una vez que realizas la compra, las fotos tardan entre 2 y 48 horas máximo para ser cargadas en su formato original a tu cuenta. Te avisaremos con un email cuando tus fotos estén disponibles.<br/><br/><b>13. Nunca recibí mi correo de confirmación de compra.</b><br/>Revisa tu &#34;correo basura&#34; o Spam para verificar que no haya llegado ahí. Si ya verificaste que el cargo fue realizado a tu tarjeta de crédito, y no puedes localizar el correo de confirmación, escríbenos a: photo@delphinus.com.mx o llámanos sin costo en Mexico al 01-800-3353-461.<br/></p>', 'NO', '', '', 'NO', '', 'NO', '', 'SI', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('10', '3', '', null, '', 'NO', null, null, 'NO', null, 'SI', 'bg-3-20171123082217.jpg', 'BG', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('11', '8', 'Where\'s my code?', null, '<p>If you purchased a digital copy of your photo and video, you\'ll find your code on your receipt. If you didin\'t purchased yet, your code is on your bracelet of the excursion.</p><p><strong>Need more help?</strong> Visit our FAQs.<!--EndFragment--><br/><br/><br/></p>', 'NO', null, null, 'NO', null, 'NO', null, 'SI', 'NO', 'NO');
INSERT INTO `seccion_contenido` VALUES ('12', '9', 'Descargue una foto GRATIS', null, '<p>Seleccione una foto de su excursión y complete su e-mail. En unos minutos recibirá un enlace de validación en su cuenta de correo.<br/>A continuación vuelva a entrar con su código y dispondrá de la imagen en su GALLERY donde podrá descargarla totalmente GRATIS. Recuerde que puede obtener más fotos e incluso todo el paquete de fotos + video, abonando el importe on line.</p>', 'NO', '', '', 'NO', '', 'NO', '', 'SI', 'NO', 'NO');

-- ----------------------------
-- Table structure for social_web
-- ----------------------------
DROP TABLE IF EXISTS `social_web`;
CREATE TABLE `social_web` (
  `idsocialweb` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idweb` int(8) unsigned NOT NULL,
  `idredsocial` int(11) unsigned NOT NULL,
  `enlace` varchar(255) NOT NULL,
  `estado_sw` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:activo; 2:inactivo; 0: anulado',
  PRIMARY KEY (`idsocialweb`),
  KEY `fk_social_web_web_1` (`idweb`) USING BTREE,
  KEY `fk_social_web_red_social_1` (`idredsocial`) USING BTREE,
  CONSTRAINT `fk_social_web_red_social_1` FOREIGN KEY (`idredsocial`) REFERENCES `red_social` (`idredsocial`),
  CONSTRAINT `fk_social_web_web_1` FOREIGN KEY (`idweb`) REFERENCES `web` (`idweb`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of social_web
-- ----------------------------
INSERT INTO `social_web` VALUES ('1', '1', '1', 'http://www.facebook.com/goeystudio', '1');
INSERT INTO `social_web` VALUES ('2', '1', '5', 'http://www.instagram.com/goeystudio', '1');

-- ----------------------------
-- Table structure for tipo_banner
-- ----------------------------
DROP TABLE IF EXISTS `tipo_banner`;
CREATE TABLE `tipo_banner` (
  `idtipobanner` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion_tb` varchar(255) DEFAULT NULL,
  `ancho_defecto` float DEFAULT NULL,
  `alto_defecto` float DEFAULT NULL,
  PRIMARY KEY (`idtipobanner`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tipo_banner
-- ----------------------------
INSERT INTO `tipo_banner` VALUES ('1', 'SLIDER', '1920', '902');
INSERT INTO `tipo_banner` VALUES ('2', 'FONDO', '1920', '1080');
INSERT INTO `tipo_banner` VALUES ('3', 'LATERAL', '480', '725');

-- ----------------------------
-- Table structure for tipo_email
-- ----------------------------
DROP TABLE IF EXISTS `tipo_email`;
CREATE TABLE `tipo_email` (
  `idtipoemail` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo_te` varchar(255) NOT NULL,
  `estado_te` tinyint(2) unsigned DEFAULT '1',
  PRIMARY KEY (`idtipoemail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tipo_email
-- ----------------------------
INSERT INTO `tipo_email` VALUES ('1', 'CORREO BIENVENIDA', '1');
INSERT INTO `tipo_email` VALUES ('2', 'CORREO ACCESO', '1');
INSERT INTO `tipo_email` VALUES ('3', 'CORREO RECORDATORIO', '1');
INSERT INTO `tipo_email` VALUES ('4', 'CORREO 1ER DESCUENTO', '1');
INSERT INTO `tipo_email` VALUES ('5', 'CORREO 2DO DESCUENTO', '1');
INSERT INTO `tipo_email` VALUES ('6', 'CORREO DE CONFIRMACION', '1');

-- ----------------------------
-- Table structure for tipo_icono
-- ----------------------------
DROP TABLE IF EXISTS `tipo_icono`;
CREATE TABLE `tipo_icono` (
  `idtipoicono` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`idtipoicono`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tipo_icono
-- ----------------------------
INSERT INTO `tipo_icono` VALUES ('1', 'halcyon');
INSERT INTO `tipo_icono` VALUES ('2', 'fontawesome');
INSERT INTO `tipo_icono` VALUES ('3', 'simpleline');

-- ----------------------------
-- Table structure for tipo_medida
-- ----------------------------
DROP TABLE IF EXISTS `tipo_medida`;
CREATE TABLE `tipo_medida` (
  `idtipomedida` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion_tm` varchar(255) NOT NULL,
  PRIMARY KEY (`idtipomedida`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tipo_medida
-- ----------------------------
INSERT INTO `tipo_medida` VALUES ('1', 'TALLA');
INSERT INTO `tipo_medida` VALUES ('2', 'VOLUMEN');
INSERT INTO `tipo_medida` VALUES ('3', 'AREA (cm x cm)');

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `idusuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) unsigned NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `ididioma` char(2) DEFAULT 'es',
  `createdat` datetime NOT NULL,
  `updatedat` datetime NOT NULL,
  `solicita_bonificacion` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1: Si; 2: No',
  `estado_us` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:anulado; \r\n1:habilitado; \r\n2: deshabilitado',
  `codigo` varchar(255) NOT NULL,
  `nombre_foto` varchar(255) DEFAULT NULL COMMENT 'para imagen avatar',
  PRIMARY KEY (`idusuario`),
  KEY `fk_usuario_grupo_1` (`idgrupo`),
  KEY `fk_usuario_idioma_1` (`ididioma`),
  CONSTRAINT `fk_usuario_grupo_1` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`),
  CONSTRAINT `fk_usuario_idioma_1` FOREIGN KEY (`ididioma`) REFERENCES `idioma` (`ididioma`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('1', '1', 'benx', '202cb962ac59075b964b07152d234b70', 'es', '2017-07-28 12:35:59', '2017-07-28 12:35:59', '2', '1', '', '');
INSERT INTO `usuario` VALUES ('2', '2', 'admin', '202cb962ac59075b964b07152d234b70', 'es', '2017-07-28 12:35:59', '2017-07-28 12:35:59', '2', '1', '', '');
INSERT INTO `usuario` VALUES ('34', '3', null, '835ebd1153f72cd71f7b8ac64c1a68fc', null, '2018-02-15 11:11:55', '2018-02-25 14:17:21', '2', '1', 'A1111', null);
INSERT INTO `usuario` VALUES ('35', '3', null, 'b0ca4eff978167e0f1953fcea8832d3f', null, '2018-02-15 11:11:55', '2018-02-15 11:11:55', '2', '1', 'A222', null);
INSERT INTO `usuario` VALUES ('36', '3', null, '787123093d8f8542db8bd1eefb9201b6', null, '2018-02-15 11:11:55', '2018-02-21 22:17:05', '2', '1', 'A3333', null);
INSERT INTO `usuario` VALUES ('37', '3', null, '25f9e794323b453885f5181f1b624d0b', null, '2018-02-21 17:14:46', '2018-02-21 17:14:46', '2', '1', '123456789', null);
INSERT INTO `usuario` VALUES ('38', '3', null, '8dac6c7efc0c6175df8f4784a9913a2f', null, '2018-02-21 22:35:54', '2018-02-21 22:35:54', '2', '1', 'A4444', null);
INSERT INTO `usuario` VALUES ('39', '3', null, '01253aeedafa49bd9384887dfaa48b25', null, '2018-02-21 22:36:11', '2018-02-21 22:36:11', '2', '1', 'A5555', null);
INSERT INTO `usuario` VALUES ('40', '3', null, '44f97f8e46a64839e2f7473b2448b4a8', null, '2018-02-21 22:36:26', '2018-02-21 22:36:26', '2', '1', 'A6666', null);
INSERT INTO `usuario` VALUES ('41', '3', null, '827ccb0eea8a706c4c34a16891f84e7b', null, '2018-02-21 23:13:32', '2018-02-21 23:21:41', '2', '0', '12345', null);
INSERT INTO `usuario` VALUES ('42', '3', null, '96e79218965eb72c92a549dd5a330112', null, '2018-02-21 23:23:28', '2018-02-23 00:16:18', '2', '1', '111111', null);
INSERT INTO `usuario` VALUES ('43', '3', null, 'e3ceb5881a0a1fdaad01296d7554868d', null, '2018-02-21 23:23:33', '2018-02-21 23:40:31', '2', '1', '222222', null);
INSERT INTO `usuario` VALUES ('44', '3', null, '074fd28eff0f5adea071694061739e55', null, '2018-02-21 23:23:56', '2018-02-21 23:36:49', '2', '1', '3333333', null);
INSERT INTO `usuario` VALUES ('45', '4', 'operador1', 'a65daa2d77588f2fb99257b639871940', null, '2018-02-23 10:25:03', '2018-05-05 03:56:13', '2', '1', '', null);
INSERT INTO `usuario` VALUES ('46', '3', null, '66337dd564c5891cda03e6f53c7bfa09', null, '2018-02-26 23:17:19', '2018-02-26 23:17:19', '2', '1', '', null);
INSERT INTO `usuario` VALUES ('47', '3', null, 'ade8005ce5e53136d0f034e1d2166587', null, '2018-02-26 23:17:34', '2018-02-26 23:17:34', '2', '1', '', null);
INSERT INTO `usuario` VALUES ('48', '3', null, 'ce3693b4199a72c9e588dc8ad3a32578', null, '2018-02-26 23:17:46', '2018-02-26 23:17:46', '2', '1', '', null);
INSERT INTO `usuario` VALUES ('49', '3', null, '835ebd1153f72cd71f7b8ac64c1a68fc', null, '2018-02-28 12:13:08', '2018-02-28 12:13:08', '2', '1', '', null);
INSERT INTO `usuario` VALUES ('50', '5', 'super', 'a65daa2d77588f2fb99257b639871940', 'es', '2018-05-05 03:42:55', '2018-05-05 03:42:55', '2', '1', '', null);

-- ----------------------------
-- Table structure for web
-- ----------------------------
DROP TABLE IF EXISTS `web`;
CREATE TABLE `web` (
  `idweb` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `titulo_we` varchar(255) NOT NULL,
  `descripcion_we` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `autor_we` varchar(255) DEFAULT NULL,
  `logo` varchar(255) NOT NULL,
  `footer_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) NOT NULL,
  `apple_icon` varchar(255) NOT NULL,
  `marca_agua` varchar(255) NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `latitud_gm` varchar(255) DEFAULT NULL COMMENT 'latitud de google maps',
  `longitud_gm` varchar(255) DEFAULT NULL COMMENT 'longitud de google maps',
  `estado_we` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:activo: 2:inactivo',
  `updatedat` datetime DEFAULT NULL,
  PRIMARY KEY (`idweb`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of web
-- ----------------------------
INSERT INTO `web` VALUES ('1', 'GOEY PICTURES', 'Welcome to Goey Pictures, Claim the photos and video of your excursion at Punta Cana!', 'photo, photos, photography, video, vacation, holidays, tourism, excursion, beach, paradise, caribbean, saona, catalina, bavaro, punta cana, dominican republic, DR, foto, fotos, fotografia, vacaciones, turismo, playa, paraiso, caribe, republica dominicana,', 'Carlos Morel', 'logo-dark.png', 'footer-logo.png', 'favicon.png', 'apple-touch-180x180.png', 'watermark.png', 'info@goeystudio.com', '1 (809) 552 1546', '1 (849) 912 4759​⁠​', 'goeypictures', 'Prolongacion Estados Unidos #83 Bavaro Friusa', null, null, '1', '2018-03-28 03:11:48');
