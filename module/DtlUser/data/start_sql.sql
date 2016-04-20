INSERT INTO `user_role` (`id`, `name`) VALUES (1, 'guest');
INSERT INTO `user_role` (`id`, `name`) VALUES (2, 'user');
INSERT INTO `user_role` (`id`, `name`) VALUES (3, 'dtladmin');
INSERT INTO `user_role` (`id`, `name`) VALUES (4, 'boss');

INSERT INTO `userrole_userrole` (`userrole_source`, `userrole_target`) VALUES (3, 2);
INSERT INTO `userrole_userrole` (`userrole_source`, `userrole_target`) VALUES (4, 3);


