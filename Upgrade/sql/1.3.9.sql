ALTER TABLE `pes_ticket_content` ADD `ticket_form_option_name` VARCHAR(255) NOT NULL COMMENT '工单字段记录的选项名称' AFTER `ticket_form_content`;
INSERT INTO `pes_option` (`id`, `option_name`, `name`, `value`, `option_range`) VALUES (NULL, 'ticket_contact', '全局工单联系方式', '[{\"title\":\"\\u7535\\u5b50\\u90ae\\u4ef6\",\"key\":\"1\",\"field\":\"member_email\"},{\"title\":\"\\u624b\\u673a\\u53f7\\u7801\",\"key\":\"2\",\"field\":\"member_phone\"},{\"title\":\"\\u5fae\\u4fe1\",\"key\":\"3\",\"field\":\"member_weixin\"},{\"title\":\"\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f\",\"key\":\"6\",\"field\":\"member_wxapp\"}]', '');