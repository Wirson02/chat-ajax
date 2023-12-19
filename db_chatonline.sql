-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-12-2023 a las 16:00:04
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_chatonline`
--
CREATE DATABASE IF NOT EXISTS `db_chatonline` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_chatonline`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE `amigos` (
  `id_amigo` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_user_amigo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id_amigo`, `id_user`, `id_user_amigo`, `fecha`, `estado`) VALUES
(2, 6, 7, '2023-11-13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `user_origen` int(11) NOT NULL,
  `user_destino` int(11) NOT NULL,
  `chat_msg` longtext NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `chat`
--

INSERT INTO `chat` (`id_chat`, `user_origen`, `user_destino`, `chat_msg`, `fecha`) VALUES
(7, 6, 7, 'Hola', '2023-11-13 15:33:35'),
(8, 7, 6, 'si', '2023-11-13 15:33:59'),
(9, 6, 7, 'asdasd', '2023-11-13 15:34:11'),
(10, 6, 7, 'hola', '2023-11-13 15:58:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `user_username` varchar(15) NOT NULL,
  `user_nom` varchar(50) NOT NULL,
  `user_ape` varchar(20) NOT NULL,
  `user_pwd` varchar(60) NOT NULL,
  `user_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `user_username`, `user_nom`, `user_ape`, `user_pwd`, `user_admin`) VALUES
(6, 'jorge', 'Jorge', 'Alcalde', '$2y$10$HVrNn6sh1G67qTnpMfXPo.aIbL83bmd0ZHCqwrJhgyQSCJ5zDQYwO', 1),
(7, 'wilson', 'Wilson', 'Alfredo', '$2y$10$mdqCbDmBqNcsOrNWa2peHOiVfIC.v/CpPmp9mjyV1aCLMAQgEQ2cK', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`id_amigo`),
  ADD KEY `usuario_usuario_FK` (`id_user`),
  ADD KEY `usuario_amigo_FK` (`id_user_amigo`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `chatorigen_user_fk` (`user_origen`),
  ADD KEY `chatdestino_user_fk` (`user_destino`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigos`
--
ALTER TABLE `amigos`
  MODIFY `id_amigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD CONSTRAINT `usuario_amigo_FK` FOREIGN KEY (`id_user_amigo`) REFERENCES `usuarios` (`id_user`),
  ADD CONSTRAINT `usuario_usuario_FK` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`);

--
-- Filtros para la tabla `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chatdestino_user_fk` FOREIGN KEY (`user_destino`) REFERENCES `usuarios` (`id_user`),
  ADD CONSTRAINT `chatorigen_user_fk` FOREIGN KEY (`user_origen`) REFERENCES `usuarios` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
