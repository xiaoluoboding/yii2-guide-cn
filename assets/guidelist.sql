/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yii2doc

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-08-06 17:25:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for guidelist
-- ----------------------------
DROP TABLE IF EXISTS `guidelist`;
CREATE TABLE `guidelist` (
  `id` int(11) NOT NULL,
  `enname` varchar(255) DEFAULT NULL,
  `cnname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guidelist
-- ----------------------------
INSERT INTO `guidelist` VALUES ('1', 'index', '首页');
INSERT INTO `guidelist` VALUES ('2', 'active-record', '活动记录Active Record');
INSERT INTO `guidelist` VALUES ('3', 'apps-advanced', '高级应用模板');
INSERT INTO `guidelist` VALUES ('4', 'authentication', '认证');
INSERT INTO `guidelist` VALUES ('5', 'authorization', '鉴权');
INSERT INTO `guidelist` VALUES ('6', 'apps-basic', '基础应用模板');
INSERT INTO `guidelist` VALUES ('7', 'basics', '基本概念');
INSERT INTO `guidelist` VALUES ('8', 'behaviors', '行为Behaviors');
INSERT INTO `guidelist` VALUES ('9', 'bootstrap-widgets', 'Bootstrap组件');
INSERT INTO `guidelist` VALUES ('10', 'caching', '缓存');
INSERT INTO `guidelist` VALUES ('11', 'composer', '合成器Composer');
INSERT INTO `guidelist` VALUES ('12', 'configuration', '配置');
INSERT INTO `guidelist` VALUES ('13', 'console', '命令行应用');
INSERT INTO `guidelist` VALUES ('14', 'controller', '控制器Controller');
INSERT INTO `guidelist` VALUES ('15', 'apps-own', '自建应用程序结构');
INSERT INTO `guidelist` VALUES ('16', 'data-overview', '数据源和界面组件Widgets');
INSERT INTO `guidelist` VALUES ('17', 'data-grid', '数据表格');
INSERT INTO `guidelist` VALUES ('18', 'data-providers', '数据提供器');
INSERT INTO `guidelist` VALUES ('19', 'data-widgets', '数据界面组件');
INSERT INTO `guidelist` VALUES ('20', 'console-migrate', '数据库迁移');
INSERT INTO `guidelist` VALUES ('21', 'database-basics', '数据库基础');
INSERT INTO `guidelist` VALUES ('22', 'module-debug', '调试工具栏和调试器');
INSERT INTO `guidelist` VALUES ('23', 'error', '错误处理');
INSERT INTO `guidelist` VALUES ('24', 'events', '事件');
INSERT INTO `guidelist` VALUES ('25', 'extensions', '扩展Yii');
INSERT INTO `guidelist` VALUES ('26', 'test-fixture', '测试装置');
INSERT INTO `guidelist` VALUES ('27', 'helpers', '帮助类');
INSERT INTO `guidelist` VALUES ('28', 'rest', 'RESTful WEB服务');
INSERT INTO `guidelist` VALUES ('29', 'installation', '安装');
INSERT INTO `guidelist` VALUES ('30', 'i18n', '国际化');
INSERT INTO `guidelist` VALUES ('31', 'logging', '日志');
INSERT INTO `guidelist` VALUES ('32', 'mvc', 'MVC概述');
INSERT INTO `guidelist` VALUES ('33', 'console-fixture', '命令行装置');
INSERT INTO `guidelist` VALUES ('34', 'assets', '资源管理');
INSERT INTO `guidelist` VALUES ('35', 'model', '模型Model');
INSERT INTO `guidelist` VALUES ('36', 'validation', '模型验证');
INSERT INTO `guidelist` VALUES ('37', 'performance', '性能调优');
INSERT INTO `guidelist` VALUES ('38', 'query-builder', '查询构造器及查询');
INSERT INTO `guidelist` VALUES ('39', 'security', '安全');
INSERT INTO `guidelist` VALUES ('40', 'di', '服务定位及依赖注入');
INSERT INTO `guidelist` VALUES ('41', 'testing', '测试');
INSERT INTO `guidelist` VALUES ('42', 'title', 'Yii2.0权威指南');
INSERT INTO `guidelist` VALUES ('43', 'gii', '代码生成器');
INSERT INTO `guidelist` VALUES ('44', 'theming', '界面主题Theming');
INSERT INTO `guidelist` VALUES ('45', 'url', 'URL管理');
INSERT INTO `guidelist` VALUES ('46', 'upgrade-from-v1', '从Yii1升级');
INSERT INTO `guidelist` VALUES ('47', 'using-3rd-party-libraries', '使用第三方库');
INSERT INTO `guidelist` VALUES ('48', 'template', '使用模板引擎');
INSERT INTO `guidelist` VALUES ('49', 'view', '视图View');
INSERT INTO `guidelist` VALUES ('50', 'overview', 'Yii是什么');
INSERT INTO `guidelist` VALUES ('51', 'form', '表单Forms');
