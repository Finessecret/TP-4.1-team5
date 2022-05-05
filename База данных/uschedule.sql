-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 05 2022 г., 14:00
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `uschedule`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auditorium`
--

CREATE TABLE `auditorium` (
  `number_auditorium` int NOT NULL,
  `capacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `auditorium`
--

INSERT INTO `auditorium` (`number_auditorium`, `capacity`) VALUES
(101, 50),
(102, 125),
(103, 50),
(104, 50);

-- --------------------------------------------------------

--
-- Структура таблицы `discipline`
--

CREATE TABLE `discipline` (
  `id_discipline` int NOT NULL,
  `name_discipline` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `discipline`
--

INSERT INTO `discipline` (`id_discipline`, `name_discipline`) VALUES
(1, 'Java Programming'),
(2, 'C++ Programming'),
(3, '1C Programming');

-- --------------------------------------------------------

--
-- Структура таблицы `faculty`
--

CREATE TABLE `faculty` (
  `id_faculty` int NOT NULL,
  `name_faculty` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `faculty`
--

INSERT INTO `faculty` (`id_faculty`, `name_faculty`) VALUES
(0, 'University employees'),
(1, 'FCS'),
(2, 'AMM'),
(3, 'MBF');

-- --------------------------------------------------------

--
-- Структура таблицы `groupp`
--

CREATE TABLE `groupp` (
  `id_group` int NOT NULL,
  `number_of_students` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `groupp`
--

INSERT INTO `groupp` (`id_group`, `number_of_students`) VALUES
(0, 50),
(101, 25),
(102, 17),
(103, 25);

-- --------------------------------------------------------

--
-- Структура таблицы `lesson`
--

CREATE TABLE `lesson` (
  `day_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `week_value` enum('numerator','denominator') NOT NULL,
  `id_user` int NOT NULL,
  `id_discipline` int NOT NULL,
  `id_time` int NOT NULL,
  `number_auditorium` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `lesson`
--

INSERT INTO `lesson` (`day_week`, `week_value`, `id_user`, `id_discipline`, `id_time`, `number_auditorium`) VALUES
('Monday', 'numerator', 2, 1, 1, 101),
('Monday', 'denominator', 2, 3, 2, 102);

-- --------------------------------------------------------

--
-- Структура таблицы `lesson_group`
--

CREATE TABLE `lesson_group` (
  `id_group` int NOT NULL,
  `day_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `week_value` enum('numerator','denominator') NOT NULL,
  `id_discipline` int NOT NULL,
  `id_user` int NOT NULL,
  `id_time` int NOT NULL,
  `number_auditorium` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `lesson_group`
--

INSERT INTO `lesson_group` (`id_group`, `day_week`, `week_value`, `id_discipline`, `id_user`, `id_time`, `number_auditorium`) VALUES
(101, 'Monday', 'numerator', 1, 2, 1, 101);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `role_value` enum('student','teacher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`role_value`) VALUES
('student'),
('teacher');

-- --------------------------------------------------------

--
-- Структура таблицы `timeslot`
--

CREATE TABLE `timeslot` (
  `id_time` int NOT NULL,
  `time_value` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `timeslot`
--

INSERT INTO `timeslot` (`id_time`, `time_value`) VALUES
(1, '08:00:00'),
(2, '09:45:00');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `login` varchar(24) NOT NULL,
  `password` varchar(24) NOT NULL,
  `name` varchar(20) NOT NULL,
  `patronymic` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `id_group` int NOT NULL,
  `id_faculty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `login`, `password`, `name`, `patronymic`, `surname`, `id_group`, `id_faculty`) VALUES
(0, 'admin', 'admin', '', '', '', 0, 0),
(1, 'ivanov_i_i', '12345', 'Ivan', 'Ivanovich', 'Ivanov', 101, 1),
(2, 'smirnov_i_v', '123456', 'Ivan', 'Vladimirovich', 'Smirnov', 0, 1),
(3, 'hripunov_v_a', '1234321', 'Владислав', 'Александрович', 'Хрипунов', 101, 1),
(4, 'sokerina_p_i', '12345', 'Полина', 'Игоревна', 'Сокерина', 101, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_discipline`
--

CREATE TABLE `user_discipline` (
  `id_user` int NOT NULL,
  `id_discipline` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_discipline`
--

INSERT INTO `user_discipline` (`id_user`, `id_discipline`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

CREATE TABLE `user_role` (
  `role_value` enum('student','teacher') NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_role`
--

INSERT INTO `user_role` (`role_value`, `id_user`) VALUES
('student', 1),
('teacher', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auditorium`
--
ALTER TABLE `auditorium`
  ADD PRIMARY KEY (`number_auditorium`);

--
-- Индексы таблицы `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`id_discipline`);

--
-- Индексы таблицы `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id_faculty`);

--
-- Индексы таблицы `groupp`
--
ALTER TABLE `groupp`
  ADD PRIMARY KEY (`id_group`);

--
-- Индексы таблицы `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`day_week`,`week_value`,`id_user`,`id_discipline`,`id_time`,`number_auditorium`),
  ADD KEY `id_user_les` (`id_user`),
  ADD KEY `id_discipline_les` (`id_discipline`),
  ADD KEY `number_auditorium_les` (`number_auditorium`),
  ADD KEY `id_time_les` (`id_time`);

--
-- Индексы таблицы `lesson_group`
--
ALTER TABLE `lesson_group`
  ADD PRIMARY KEY (`id_group`,`day_week`,`week_value`,`id_discipline`,`id_user`,`id_time`,`number_auditorium`),
  ADD KEY `id_lesson` (`day_week`,`week_value`,`id_user`,`id_discipline`,`id_time`,`number_auditorium`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_value`);

--
-- Индексы таблицы `timeslot`
--
ALTER TABLE `timeslot`
  ADD PRIMARY KEY (`id_time`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_group_us` (`id_group`),
  ADD KEY `id_faculty_us` (`id_faculty`);

--
-- Индексы таблицы `user_discipline`
--
ALTER TABLE `user_discipline`
  ADD PRIMARY KEY (`id_user`,`id_discipline`),
  ADD KEY `id_discipline_ud` (`id_discipline`);

--
-- Индексы таблицы `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_value`,`id_user`),
  ADD KEY `id_user_ur` (`id_user`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `id_discipline_les` FOREIGN KEY (`id_discipline`) REFERENCES `discipline` (`id_discipline`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_time_les` FOREIGN KEY (`id_time`) REFERENCES `timeslot` (`id_time`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_user_les` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `number_auditorium_les` FOREIGN KEY (`number_auditorium`) REFERENCES `auditorium` (`number_auditorium`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `lesson_group`
--
ALTER TABLE `lesson_group`
  ADD CONSTRAINT `id_group_` FOREIGN KEY (`id_group`) REFERENCES `groupp` (`id_group`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_lesson` FOREIGN KEY (`day_week`,`week_value`,`id_user`,`id_discipline`,`id_time`,`number_auditorium`) REFERENCES `lesson` (`day_week`, `week_value`, `id_user`, `id_discipline`, `id_time`, `number_auditorium`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `id_faculty_us` FOREIGN KEY (`id_faculty`) REFERENCES `faculty` (`id_faculty`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_group_us` FOREIGN KEY (`id_group`) REFERENCES `groupp` (`id_group`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_discipline`
--
ALTER TABLE `user_discipline`
  ADD CONSTRAINT `id_discipline_ud` FOREIGN KEY (`id_discipline`) REFERENCES `discipline` (`id_discipline`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_user_ud` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `id_user_ur` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `role_value_ur` FOREIGN KEY (`role_value`) REFERENCES `role` (`role_value`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
