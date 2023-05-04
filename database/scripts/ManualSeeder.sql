INSERT INTO `aeromodel`.`propellers` (`size`, `type`, `blade_number`) VALUES
('27x10', 'bois', '2'),
('26x12', 'bois', '2'),
('26x13', 'bois', '2');
INSERT INTO `aeromodel`.`engines` (`name`, `power`, `type`, `weight`, `frequency`, `user_id`) VALUES
('Fiala B2', '120cc', '95 SP 3.3%', '3450', '4stroke', '1'),
('Roto 85 FSI', '85cc', '95 SP 3.3%', '3250', '4stroke', '1');
INSERT INTO `aeromodel`.`transmitters` (`id`, `name`, `manufacturer`) VALUES
('1', 't16 sz', 'Futaba'),
('2', 't16 iz', 'Futaba');
INSERT INTO `aeromodel`.`rc_models` (`name`, `description`, `manufacturer`, `length`, `wingSpan`, `height`, `weight`, `user_id`, `transmitter_id`, `acquired_on`, `finished_on`, `first_flown_on`) VALUES 
('Mitsubishi A6m zero', 'Un avion construit par alain fontana', 'Meister Scale', 2580 , 3008, 800, 16800, 1, 1, "2016-02-19", "2017-02-23", "2017-03-09"),
('Hawker Hurricane', 'Un avion construit par alain fontana', NULL, NULL , 2870, NULL, 16300, 1, 1, NULL, NULL, NULL),
('Sopwith Triplane', 'Un avion construit par alain fontana', NULL, NULL, 2800, NULL, 15900, 1, 1, NULL, NULL, NULL),
('Consolidated B-24 Liberator', 'Un avion construit par alain fontana', NULL, NULL , 3200, NULL, 25000, 1, 1, NULL, NULL, NULL),
('de Havilland DH.98 Mosquito', 'Un avion construit par alain fontana', NULL, NULL , 2950, NULL, 18580, 1, 1, NULL, NULL, NULL);
INSERT INTO `aeromodel`.`rc_models_has_engines` (`rc_model_id`, `engine_id`, `quantity`) VALUES 
('1', '1', '1'),
('2', '2', '1'),
('3', '1', '1'),
('4', '1', '2'),
('4', '2', '2'),
('5', '1', '2');
INSERT INTO `aeromodel`.`rc_models_has_propellers` (`rc_model_id`, `propeller_id`, `quantity`) VALUES 
('1', '1', '1'),
('2', '2', '1'),
('3', '3', '1'),
('4', '1', '2'),
('4', '2', '2'),
('5', '1', '2');
INSERT INTO `aeromodel`.`batteries` (`capacity`, `cells`, `type`, `cRate`) VALUES 
('1800', '3', 'LiPo', '35'),
('2400', '2', 'LiPo', '25'),
('2200', '2', 'LiPo', '25'),
('2800', '2', 'LiPo', '25');
INSERT INTO `aeromodel`.`rc_models_has_batteries` (`rc_model_id`, `battery_id`, `quantity`) VALUES 
('1', '1', '1'),
('1', '2', '2'),
('2', '3', '3'),
('3', '4', '2'),
('4','1','2'),
('4','2','2'),
('5','1','2');
INSERT INTO `aeromodel`.`flights` (`location`, `date`, `time`, `weather`, `duration`, `description`, `rc_model_id`) VALUES
('Vullierens', '2023-03-16', '14:32:00', 'sunny', '00:07:00', 'Vol d\'entrainement au show aérien', '1');
