/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : mychat

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-02 18:01:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for chat_communication
-- ----------------------------
DROP TABLE IF EXISTS `chat_communication`;
CREATE TABLE `chat_communication` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `fromid` int(5) NOT NULL,
  `fromname` varchar(50) NOT NULL,
  `toid` int(5) NOT NULL,
  `toname` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) NOT NULL,
  `shopid` int(5) DEFAULT NULL,
  `isread` tinyint(2) DEFAULT '0',
  `type` tinyint(2) DEFAULT '1' COMMENT '1是普通文本，2是图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chat_communication
-- ----------------------------
INSERT INTO `chat_communication` VALUES ('102', '2', '测试机', '1', 'lulu', '都是', '1564641757', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('103', '2', '测试机', '1', 'lulu', '撒的发', '1564641759', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('104', '1', 'lulu', '2', '测试机', '按时', '1564641763', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('108', '1', 'lulu', '2', '测试机', '电饭锅', '1564641776', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('109', '2', '测试机', '1', 'lulu', '任天野', '1564641780', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('114', '1', 'lulu', '2', '测试机', 'mychat_img5d42b2aeb50f7.jpg', '1564652206', null, '1', '2');
INSERT INTO `chat_communication` VALUES ('115', '2', '测试机', '1', 'lulu', 'mychat_img5d43968adda2e.jpg', '1564710538', null, '1', '2');
INSERT INTO `chat_communication` VALUES ('116', '1', 'lulu', '2', '测试机', 'mychat_img5d4396a261b26.jpg', '1564710562', null, '1', '2');
INSERT INTO `chat_communication` VALUES ('117', '2', '测试机', '1', 'lulu', 'mychat_img5d439723dcd7d.jpg', '1564710691', null, '1', '2');
INSERT INTO `chat_communication` VALUES ('118', '1', 'lulu', '2', '测试机', 'mychat_img5d43982db49c2.jpg', '1564710957', null, '1', '2');
INSERT INTO `chat_communication` VALUES ('119', '2', '测试机', '1', 'lulu', '[em_6]', '1564723913', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('120', '1', 'lulu', '2', '测试机', '[em_27]', '1564723930', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('121', '2', '测试机', '1', 'lulu', '[em_29]啊哈哈', '1564723956', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('135', '3', '用户3', '1', 'lulu', '赶回家', '1564730096', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('147', '1', 'lulu', '2', '测试机', '上的', '1564739162', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('148', '1', 'lulu', '2', '测试机', '安分', '1564739210', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('149', '1', 'lulu', '2', '测试机', '上的', '1564739237', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('150', '2', '测试机', '1', 'lulu', '上的', '1564739249', null, '1', '1');
INSERT INTO `chat_communication` VALUES ('151', '2', '测试机', '1', 'lulu', '按时', '1564739267', null, '1', '1');

-- ----------------------------
-- Table structure for chat_user
-- ----------------------------
DROP TABLE IF EXISTS `chat_user`;
CREATE TABLE `chat_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `mpid` int(10) NOT NULL COMMENT '公众号标识',
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `nickname` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '头像',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别',
  `subscribe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关注',
  `subscribe_time` int(10) DEFAULT NULL COMMENT '关注时间',
  `unsubscribe_time` int(10) DEFAULT NULL COMMENT '取消关注时间',
  `relname` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `signature` text COMMENT '个性签名',
  `mobile` varchar(15) DEFAULT NULL COMMENT '手机号',
  `is_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否绑定',
  `language` varchar(50) DEFAULT NULL COMMENT '使用语言',
  `country` varchar(50) DEFAULT NULL COMMENT '国家',
  `province` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注',
  `group_id` int(10) DEFAULT '0' COMMENT '分组ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '公众号分组标识',
  `tagid_list` varchar(255) DEFAULT NULL COMMENT '标签',
  `score` int(10) DEFAULT '0' COMMENT '积分',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '金钱',
  `latitude` varchar(50) DEFAULT NULL COMMENT '纬度',
  `longitude` varchar(50) DEFAULT NULL COMMENT '经度',
  `location_precision` varchar(50) DEFAULT NULL COMMENT '精度',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:公众号粉丝1：注册会员',
  `unionid` varchar(160) DEFAULT NULL COMMENT 'unionid字段',
  `password` varchar(64) DEFAULT NULL COMMENT '密码',
  `last_time` int(10) DEFAULT '586969200' COMMENT '最后交互时间',
  `parentid` int(10) DEFAULT '1' COMMENT '非扫码用户默认都是1',
  `isfenxiao` int(8) DEFAULT '0' COMMENT '是否为分销，默认为0，1,2,3，分别为1,2,3级分销',
  `totle_earn` decimal(8,2) DEFAULT '0.00' COMMENT '挣钱总额',
  `balance` decimal(8,2) DEFAULT '0.00' COMMENT '分销挣的剩余未提现额',
  `fenxiao_leavel` int(8) DEFAULT '2' COMMENT '分销等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公众号粉丝表';

-- ----------------------------
-- Records of chat_user
-- ----------------------------
INSERT INTO `chat_user` VALUES ('1', '1', 'oYxpK0bPptICGQd3YP_1s7jfDTmE', 'lulu', 'https://avatars2.githubusercontent.com/u/30819241?s=460&v=4', '1', '1', '1517280919', '1517280912', null, null, null, '0', 'zh_CN', '中国', '广东', '广州', '', '0', '0', '[]', '0', '0.00', null, null, null, '0', null, null, '1517478028', '1', '0', '26.00', '26.00', '2');
INSERT INTO `chat_user` VALUES ('2', '1', 'oYxpK0W2u3Sbbp-wevdQtCuviDVM', '测试机', 'https://avatars2.githubusercontent.com/u/30818949?s=460&v=4', '2', '1', '1507261446', null, null, null, null, '0', 'zh_CN', '中国', '河南', '焦作', '', '0', '0', '[]', '0', '0.00', null, null, null, '0', null, null, '586969200', '1', '0', '0.00', '0.00', '2');
INSERT INTO `chat_user` VALUES ('3', '1', 'oYxpK0W2u3Sbbp-wevdQtCuviDV1', '用户3', 'https://avatars0.githubusercontent.com/u/30425217?s=400&v=4', '2', '1', '1507261446', null, '', '', '', '0', 'zh_CN', '中国', '河南', '焦作', '', '0', '0', '[]', '0', '0.00', '', '', '', '0', '', '', '586969200', '1', '0', '0.00', '0.00', '2');
