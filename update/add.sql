DROP TABLE IF EXISTS `p_customer_info`;
CREATE TABLE `p_customer_info` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '客户名称',
  `user_name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `mobile` int(11) DEFAULT NULL COMMENT '手机号',
  `address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `create_time` int(12) DEFAULT NULL,
  `update_time` int(12) DEFAULT NULL,
  `status` int(1) DEFAULT '1' COMMENT '1有效  2无效',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户信息';

DROP TABLE IF EXISTS `p_finance_info`;
CREATE TABLE `p_finance_info` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) DEFAULT NULL COMMENT '客户信息 id',
  `invoice_header` varchar(255) DEFAULT NULL COMMENT '发票抬头',
  `taxpayer_number` varchar(250) DEFAULT NULL COMMENT '纳税人识别号',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `mobile` int(11) DEFAULT NULL COMMENT '电话',
  `account_open_bank` varchar(255) DEFAULT NULL COMMENT '开户银行',
  `bank_account` varchar(255) DEFAULT NULL COMMENT '银行账号',
  `customer_manager` int(10) DEFAULT NULL COMMENT '客户经理   user表中的id   user_id',
  `customer_type` int(1) NOT NULL DEFAULT '1' COMMENT '客户类型   1 普通用户   2 VIP客户',
  `intergral_num` int(10) DEFAULT NULL COMMENT '兑换积分元',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(12) DEFAULT NULL,
  `update_time` int(12) DEFAULT NULL,
  `status` int(1) DEFAULT '1' COMMENT '1有效  2无效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='财务信息';

DROP TABLE IF EXISTS `p_goods`;
CREATE TABLE `p_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` varchar(255) NOT NULL COMMENT '商品编号',
  `goods_name` varchar(255) NOT NULL COMMENT '商品名称',
  `goods_cas` varchar(255) NOT NULL COMMENT 'CAS',
  `spec` varchar(255) NOT NULL COMMENT '商品规格',
  `standards` varchar(255) NOT NULL COMMENT '标准',
  `purpose` varchar(255) NOT NULL COMMENT '用途',
  `p_price` decimal(10,2) NOT NULL COMMENT '进价',
  `s_price` decimal(10,2) NOT NULL COMMENT '售价',
  `unit` varchar(255) NOT NULL COMMENT '单位',
  `create_time` int(12) NOT NULL,
  `update_time` int(12) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

