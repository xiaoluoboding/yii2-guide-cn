/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yii2doc

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-08-11 00:35:10
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
INSERT INTO `guidelist` VALUES ('1', 'index', '索引');
INSERT INTO `guidelist` VALUES ('2', 'active-record', 'Active Record');
INSERT INTO `guidelist` VALUES ('3', 'apps-advanced', '高级应用模板');
INSERT INTO `guidelist` VALUES ('4', 'authentication', '验证（Authentication）');
INSERT INTO `guidelist` VALUES ('5', 'authorization', '授权（Authorization）');
INSERT INTO `guidelist` VALUES ('6', 'apps-basic', '基础应用模板');
INSERT INTO `guidelist` VALUES ('7', 'basics', '基本概念');
INSERT INTO `guidelist` VALUES ('8', 'behaviors', '行为（Behavior）');
INSERT INTO `guidelist` VALUES ('9', 'bootstrap-widgets', 'Bootstrap小部件');
INSERT INTO `guidelist` VALUES ('10', 'caching', '缓存（Caching）');
INSERT INTO `guidelist` VALUES ('11', 'composer', 'Composer');
INSERT INTO `guidelist` VALUES ('12', 'configuration', '配置（Configuration ）');
INSERT INTO `guidelist` VALUES ('13', 'console', '命令行应用');
INSERT INTO `guidelist` VALUES ('14', 'controller', '控制器（Controller）');
INSERT INTO `guidelist` VALUES ('15', 'apps-own', '自建应用程序结构');
INSERT INTO `guidelist` VALUES ('16', 'data-overview', '数据源和小部件');
INSERT INTO `guidelist` VALUES ('17', 'data-grid', '数据表格');
INSERT INTO `guidelist` VALUES ('18', 'data-providers', '数据提供器');
INSERT INTO `guidelist` VALUES ('19', 'data-widgets', '数据小部件');
INSERT INTO `guidelist` VALUES ('20', 'console-migrate', '数据库迁移');
INSERT INTO `guidelist` VALUES ('21', 'database-basics', '数据库基础');
INSERT INTO `guidelist` VALUES ('22', 'module-debug', '调试工具栏和调试器');
INSERT INTO `guidelist` VALUES ('23', 'error', '错误处理');
INSERT INTO `guidelist` VALUES ('24', 'events', '事件（Event）');
INSERT INTO `guidelist` VALUES ('25', 'extensions', '扩展（Extends）');
INSERT INTO `guidelist` VALUES ('26', 'test-fixture', '测试装置');
INSERT INTO `guidelist` VALUES ('27', 'helpers', '帮助类');
INSERT INTO `guidelist` VALUES ('28', 'rest', 'RESTful WEB服务');
INSERT INTO `guidelist` VALUES ('29', 'installation', '安装');
INSERT INTO `guidelist` VALUES ('30', 'i18n', '国际化（i18n）');
INSERT INTO `guidelist` VALUES ('31', 'logging', '日志');
INSERT INTO `guidelist` VALUES ('32', 'mvc', 'MVC 概述');
INSERT INTO `guidelist` VALUES ('33', 'console-fixture', '命令行装置');
INSERT INTO `guidelist` VALUES ('34', 'assets', '资源管理（Assets）');
INSERT INTO `guidelist` VALUES ('35', 'model', '模型（Model）');
INSERT INTO `guidelist` VALUES ('36', 'validation', '模型验证');
INSERT INTO `guidelist` VALUES ('37', 'performance', '性能调优');
INSERT INTO `guidelist` VALUES ('38', 'query-builder', 'SQL查询生成器');
INSERT INTO `guidelist` VALUES ('39', 'security', '安全（Security)');
INSERT INTO `guidelist` VALUES ('40', 'di', '服务定位及依赖注入');
INSERT INTO `guidelist` VALUES ('41', 'testing', '测试');
INSERT INTO `guidelist` VALUES ('42', 'title', 'Yii2.0权威指南');
INSERT INTO `guidelist` VALUES ('43', 'gii', '代码生成器（Gii）');
INSERT INTO `guidelist` VALUES ('44', 'theming', '主题（Theming）');
INSERT INTO `guidelist` VALUES ('45', 'url', 'URL管理');
INSERT INTO `guidelist` VALUES ('46', 'upgrade-from-v1', '从Yii1升级');
INSERT INTO `guidelist` VALUES ('47', 'using-3rd-party-libraries', '使用第三方库');
INSERT INTO `guidelist` VALUES ('48', 'template', '使用模板引擎');
INSERT INTO `guidelist` VALUES ('49', 'view', '视图（View）');
INSERT INTO `guidelist` VALUES ('50', 'overview', 'Yii 概述');
INSERT INTO `guidelist` VALUES ('51', 'form', '表单（Forms）');
INSERT INTO `guidelist` VALUES ('52', 'components', '组件（Component）');
INSERT INTO `guidelist` VALUES ('53', 'properties', '属性（Property）');
INSERT INTO `guidelist` VALUES ('54', 'Alias', '别名（Alias）');
