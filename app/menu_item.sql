/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : pos

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2017-09-20 12:01:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for menu_item
-- ----------------------------
DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL,
  `title` varchar(75) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_item
-- ----------------------------
INSERT INTO `menu_item` VALUES ('1', 'master', '0', '0', '0');
INSERT INTO `menu_item` VALUES ('2', 'barang', 'barang', '1', 'c_barang/index');
INSERT INTO `menu_item` VALUES ('3', 'customer', 'link', '1', 'c_customer/index');
INSERT INTO `menu_item` VALUES ('4', 'transaksi', 'transaksi', '0', '0');
INSERT INTO `menu_item` VALUES ('5', 'penjualan', 'penjualan', '4', 'c_penjualan/index');
INSERT INTO `menu_item` VALUES ('6', 'edit-dua', 'edit-dua', '4', '0');
INSERT INTO `menu_item` VALUES ('7', 'type-satu', 'type-satu', '4', 'typee');
INSERT INTO `menu_item` VALUES ('8', 'Admin Menu', 'admin menu', '0', '0');
INSERT INTO `menu_item` VALUES ('9', 'menu', 'c_menu/index', '8', 'c_menu/index');
INSERT INTO `menu_item` VALUES ('10', 'role', 'role', '8', 'c_role/index');
INSERT INTO `menu_item` VALUES ('11', 'Hak akses Menu', 'hak akses menu', '8', 'c_akses_menu/index');
INSERT INTO `menu_item` VALUES ('12', 'satuan', 'satuan', '1', 'c_satuan/index');
INSERT INTO `menu_item` VALUES ('13', 'supplier', 'supplier', '1', 'c_supplier/index');
INSERT INTO `menu_item` VALUES ('14', 'type', 'type', '1', 'c_type/index');
