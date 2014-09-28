/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : yii2doc

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-09-21 15:47:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for guidelist
-- ----------------------------
DROP TABLE IF EXISTS `guidelist`;
CREATE TABLE `guidelist` (
  `id` varchar(4) NOT NULL,
  `enname` varchar(255) DEFAULT NULL,
  `cnname` varchar(255) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guidelist
-- ----------------------------
INSERT INTO `guidelist` VALUES ('0001', 'index', '索引', '1');
INSERT INTO `guidelist` VALUES ('0101', 'overview', 'Yii 概述', '1');
INSERT INTO `guidelist` VALUES ('0102', 'upgrade-from-v1', '从Yii1.1.x升级', '1');
INSERT INTO `guidelist` VALUES ('0201', 'installation', '安装 Yii框架', '1');
INSERT INTO `guidelist` VALUES ('0202', 'start-workflow', '运行应用', '1');
INSERT INTO `guidelist` VALUES ('0203', 'start-hello', '说声 Hello', '1');
INSERT INTO `guidelist` VALUES ('0204', 'start-forms', '使用表单', '1');
INSERT INTO `guidelist` VALUES ('0205', 'start-databases', '使用数据库', '1');
INSERT INTO `guidelist` VALUES ('0206', 'start-gii', '用Gii生成代码', '1');
INSERT INTO `guidelist` VALUES ('0207', 'looking-ahead', '进阶资料', '1');
INSERT INTO `guidelist` VALUES ('0301', 'app-overview', '结构概述', '1');
INSERT INTO `guidelist` VALUES ('0302', 'entry-scripts', '入口脚本', '1');
INSERT INTO `guidelist` VALUES ('0303', 'applications', '应用', '1');
INSERT INTO `guidelist` VALUES ('0304', 'app-component', '应用组件', '1');
INSERT INTO `guidelist` VALUES ('0305', 'controller', '控制器（Controller）', '1');
INSERT INTO `guidelist` VALUES ('0306', 'view', '视图（View）', '1');
INSERT INTO `guidelist` VALUES ('0307', 'model', '模型（Model）', '1');
INSERT INTO `guidelist` VALUES ('0308', 'modules', '模块', '1');
INSERT INTO `guidelist` VALUES ('0309', 'filters', '过滤器', '1');
INSERT INTO `guidelist` VALUES ('0310', 'widgets', '小部件', '1');
INSERT INTO `guidelist` VALUES ('0311', 'assets', '资源管理（Assets）', '1');
INSERT INTO `guidelist` VALUES ('0312', 'extensions', '扩展', '1');
INSERT INTO `guidelist` VALUES ('0406', 'url', 'URL管理', '1');
INSERT INTO `guidelist` VALUES ('0407', 'error', '错误处理', '1');
INSERT INTO `guidelist` VALUES ('0408', 'logging', '日志（Logging）', '1');
INSERT INTO `guidelist` VALUES ('0501', 'components', '组件（Component）', '1');
INSERT INTO `guidelist` VALUES ('0502', 'properties', '属性（Property）', '1');
INSERT INTO `guidelist` VALUES ('0503', 'events', '事件（Event）', '1');
INSERT INTO `guidelist` VALUES ('0504', 'behaviors', '行为（Behavior）', '1');
INSERT INTO `guidelist` VALUES ('0505', 'configuration', '配置（Configuration ）', '1');
INSERT INTO `guidelist` VALUES ('0506', 'autoloading', '类自动加载', '1');
INSERT INTO `guidelist` VALUES ('0507', 'alias', '别名（Alias）', '1');
INSERT INTO `guidelist` VALUES ('0508', 'service-locator', '服务定位器', '1');
INSERT INTO `guidelist` VALUES ('0509', 'di', '依赖注入容器', '1');
INSERT INTO `guidelist` VALUES ('0601', 'database-basics', '数据访问对象', '1');
INSERT INTO `guidelist` VALUES ('0602', 'query-builder', 'SQL查询生成器', '1');
INSERT INTO `guidelist` VALUES ('0603', 'active-record', 'Active Record', '1');
INSERT INTO `guidelist` VALUES ('0604', 'console-migrate', '数据库迁移', '1');
INSERT INTO `guidelist` VALUES ('0701', 'form', '表单（Forms）', '1');
INSERT INTO `guidelist` VALUES ('0702', 'validating-input', '输入验证', '1');
INSERT INTO `guidelist` VALUES ('0703', 'uploading-files', '文件上传', '1');
INSERT INTO `guidelist` VALUES ('0804', 'data-providers', '数据提供器', '1');
INSERT INTO `guidelist` VALUES ('0805', 'data-widgets', '数据小部件', '1');
INSERT INTO `guidelist` VALUES ('0806', 'client-scripts', '使用客户端脚本', '1');
INSERT INTO `guidelist` VALUES ('0807', 'theming', '主题（Theming）', '1');
INSERT INTO `guidelist` VALUES ('0901', 'authentication', '验证（Authentication）', '1');
INSERT INTO `guidelist` VALUES ('0902', 'authorization', '授权（Authorization）', '1');
INSERT INTO `guidelist` VALUES ('0903', 'security', '安全（Security)', '2');
INSERT INTO `guidelist` VALUES ('1001', 'caching-overview', '缓存（Caching）', '1');
INSERT INTO `guidelist` VALUES ('1002', 'caching-data', '数据缓存', '1');
INSERT INTO `guidelist` VALUES ('1003', 'caching-fragment', '片段缓存', '1');
INSERT INTO `guidelist` VALUES ('1004', 'caching-page', '页面缓存', '1');
INSERT INTO `guidelist` VALUES ('1005', 'caching-http', 'HTTP 缓存', '1');
INSERT INTO `guidelist` VALUES ('1101', 'rest-quick-start', '快速入门', '1');
INSERT INTO `guidelist` VALUES ('1102', 'rest-resources', '资源', '1');
INSERT INTO `guidelist` VALUES ('1103', 'rest-controllers', '控制器', '1');
INSERT INTO `guidelist` VALUES ('1104', 'rest-routing', '路由', '1');
INSERT INTO `guidelist` VALUES ('1105', 'rest-response-formatting', '格式化响应', '1');
INSERT INTO `guidelist` VALUES ('1106', 'rest-authentication', '授权验证', '1');
INSERT INTO `guidelist` VALUES ('1107', 'rest-rate-limiting', '速率限制', '1');
INSERT INTO `guidelist` VALUES ('1108', 'rest-versioning', '版本化', '1');
INSERT INTO `guidelist` VALUES ('1109', 'rest-error', '错误处理', '1');
INSERT INTO `guidelist` VALUES ('1201', 'module-debug', '调试工具栏和调试器', '1');
INSERT INTO `guidelist` VALUES ('1202', 'gii', '代码生成器（Gii）', '1');
INSERT INTO `guidelist` VALUES ('1301', 'testing', '测试（Testing）', '1');
INSERT INTO `guidelist` VALUES ('1306', 'test-fixture', '测试固件', '1');
INSERT INTO `guidelist` VALUES ('1401', 'apps-advanced', '高级应用模板', '1');
INSERT INTO `guidelist` VALUES ('1402', 'start-from-scratch', '从头构建应用', '1');
INSERT INTO `guidelist` VALUES ('1403', 'console', '控制台应用', '1');
INSERT INTO `guidelist` VALUES ('1404', 'core-validators', '核心验证器', '1');
INSERT INTO `guidelist` VALUES ('1405', 'i18n', '国际化（i18n）', '1');
INSERT INTO `guidelist` VALUES ('1406', 'mailing', '收发邮件', '1');
INSERT INTO `guidelist` VALUES ('1407', 'performance', '性能优化', '1');
INSERT INTO `guidelist` VALUES ('1409', 'template-engines', '使用模板引擎', '1');
INSERT INTO `guidelist` VALUES ('1410', 'integration', '使用第三方库', '1');
INSERT INTO `guidelist` VALUES ('1509', 'widget-bootstrap', 'Bootstrap 小部件', '1');
INSERT INTO `guidelist` VALUES ('1510', 'widget-jquery-ui', 'Jquery UI 小部件', '1');
INSERT INTO `guidelist` VALUES ('2001', 'apps-basic', '基础应用模板', '1');
INSERT INTO `guidelist` VALUES ('2002', 'basics', '基本概念', '1');
INSERT INTO `guidelist` VALUES ('2003', 'data-grid', '数据表格', '1');
INSERT INTO `guidelist` VALUES ('2004', 'composer', 'Composer', '1');
INSERT INTO `guidelist` VALUES ('2011', 'validation', '模型验证', '2');
INSERT INTO `guidelist` VALUES ('2014', 'title', 'Yii2.0权威指南', '2');
INSERT INTO `guidelist` VALUES ('2090', 'apps-own', '自建应用程序结构', '2');
INSERT INTO `guidelist` VALUES ('2091', 'data-overview', '数据提供器和小部件', '2');
INSERT INTO `guidelist` VALUES ('2092', 'helpers', '帮助类', '2');
INSERT INTO `guidelist` VALUES ('2093', 'rest', 'RESTful WEB服务', '2');
