-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2025 a las 19:51:11
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comedor_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bandejas`
--

CREATE TABLE `bandejas` (
  `Id_Bandeja` int(11) NOT NULL,
  `Id_Menu` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `CosteUnitario` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bandejas`
--

INSERT INTO `bandejas` (`Id_Bandeja`, `Id_Menu`, `Cantidad`, `CosteUnitario`) VALUES
(1, 1, 100, 0.8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_productos`
--

CREATE TABLE `categorias_productos` (
  `Id_Categoria` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_productos`
--

INSERT INTO `categorias_productos` (`Id_Categoria`, `Nombre`, `Estado`) VALUES
(1, 'Lácteos', 1),
(2, 'Carnes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comensales`
--

CREATE TABLE `comensales` (
  `Cedula_Comensal` varchar(15) NOT NULL,
  `PrimerNombre` varchar(50) DEFAULT NULL,
  `SegundoNombre` varchar(50) DEFAULT NULL,
  `PrimerApellido` varchar(50) DEFAULT NULL,
  `SegundoApellido` varchar(50) DEFAULT NULL,
  `Genero` varchar(10) DEFAULT NULL,
  `Codigo_Tipocomensal` varchar(10) DEFAULT NULL,
  `Codigo_Nucleo` varchar(10) DEFAULT NULL,
  `Codigo_Departamento` varchar(10) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comensales`
--

INSERT INTO `comensales` (`Cedula_Comensal`, `PrimerNombre`, `SegundoNombre`, `PrimerApellido`, `SegundoApellido`, `Genero`, `Codigo_Tipocomensal`, `Codigo_Nucleo`, `Codigo_Departamento`, `Estado`) VALUES
('12345678', 'Maria', 'Lucia', 'Mendez', 'Ortega', 'Femenino', 'TC001', 'N003', 'D014', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `Id_Compra` int(11) NOT NULL,
  `Rif_Proveedor` varchar(15) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Numero_Factura` int(11) DEFAULT NULL,
  `Cedula_Usuario` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `Codigo_Departamento` varchar(10) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`Codigo_Departamento`, `Nombre`, `Estado`) VALUES
('D001', 'Ingeniería Química', 1),
('D002', 'Ingeniería Metalúrgica', 1),
('D003', 'Ingeniería Mecánica', 1),
('D004', 'Ingeniería Industrial', 1),
('D005', 'Ingeniería Electrónica', 1),
('D006', 'Ingeniería Eléctrica', 1),
('D007', 'TSU Construcción Civil', 1),
('D008', 'TSU Industrial', 1),
('D009', 'TSU Mecánica', 1),
('D010', 'TSU Electricidad', 1),
('D011', 'Administración', 1),
('D012', 'Contaduría Pública', 1),
('D013', 'Gerencia de Recursos Humanos', 1),
('D014', 'Tecnología de la Construcción Civil', 1),
('D015', 'Tecnología en Administración Industrial', 1),
('D016', 'Tecnología en Estadística', 1),
('D017', 'Tecnología en Sistemas Industriales', 1),
('D018', 'Turismo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompras`
--

CREATE TABLE `detallecompras` (
  `Id_Detalle` int(11) NOT NULL,
  `Id_Compra` int(11) DEFAULT NULL,
  `Codigo_Producto` varchar(20) DEFAULT NULL,
  `Precio_Producto` float DEFAULT NULL,
  `Id_Empaquetado` int(11) DEFAULT NULL,
  `PesoUnitario` float DEFAULT NULL,
  `Cantidad_Producto` int(11) DEFAULT NULL,
  `Id_Marca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empaquetado`
--

CREATE TABLE `empaquetado` (
  `Id_Empaquetado` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empaquetado`
--

INSERT INTO `empaquetado` (`Id_Empaquetado`, `Nombre`, `Estado`) VALUES
(1, 'Caja', 1),
(2, 'Bolsa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `Id_Ingredientes` int(11) NOT NULL,
  `Codigo_Producto` varchar(20) DEFAULT NULL,
  `PesoDetallado_Producto` float DEFAULT NULL,
  `UnidadMasa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`Id_Ingredientes`, `Codigo_Producto`, `PesoDetallado_Producto`, `UnidadMasa`) VALUES
(1, 'P001', 200, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca_productos`
--

CREATE TABLE `marca_productos` (
  `Id_Marca` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca_productos`
--

INSERT INTO `marca_productos` (`Id_Marca`, `Nombre`, `Estado`) VALUES
(1, 'Nestlé', 1),
(2, 'Polar', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `Id_Menu` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Id_Receta` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`Id_Menu`, `Nombre`, `Id_Receta`, `Fecha`) VALUES
(1, 'Desayuno Lunes', 1, '2025-07-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nucleos`
--

CREATE TABLE `nucleos` (
  `Codigo_Nucleo` varchar(10) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nucleos`
--

INSERT INTO `nucleos` (`Codigo_Nucleo`, `Nombre`, `Estado`) VALUES
('N001', 'Barquisimeto', 1),
('N002', 'Carora', 1),
('N003', 'Guarenas', 1),
('N004', 'Charallave', 1),
('N005', 'Puerto Ordaz', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Codigo_Producto` varchar(20) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Id_Unidad` int(11) DEFAULT NULL,
  `Id_Categoria` int(11) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Codigo_Producto`, `Nombre`, `Id_Unidad`, `Id_Categoria`, `Estado`) VALUES
('P001', 'Leche', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `Rif_Proveedor` varchar(15) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `Id_Receta` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Id_Ingredientes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`Id_Receta`, `Nombre`, `Id_Ingredientes`) VALUES
(1, 'Cereal con Leche', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `Id_Ticket` int(11) NOT NULL,
  `Codigo_Tipocomensal` varchar(10) DEFAULT NULL,
  `Id_Menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposcomensales`
--

CREATE TABLE `tiposcomensales` (
  `Codigo_Tipocomensal` varchar(10) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Exento` tinyint(1) NOT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposcomensales`
--

INSERT INTO `tiposcomensales` (`Codigo_Tipocomensal`, `Nombre`, `Exento`, `Estado`) VALUES
('TC001', 'Administrativo', 0, 1),
('TC002', 'Profesor', 0, 1),
('TC003', 'Obrero', 0, 1),
('TC004', 'Estudiante', 0, 1),
('TC005', 'Exonerado', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposusuarios`
--

CREATE TABLE `tiposusuarios` (
  `Codigo_TipoUsuario` varchar(10) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposusuarios`
--

INSERT INTO `tiposusuarios` (`Codigo_TipoUsuario`, `Nombre`, `Estado`) VALUES
('TU001', 'SuperUsuario', 1),
('TU002', 'Supervisor', 1),
('TU003', 'Operador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadmasa`
--

CREATE TABLE `unidadmasa` (
  `Id_Unidad` int(11) NOT NULL,
  `UnidadMasa` varchar(50) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidadmasa`
--

INSERT INTO `unidadmasa` (`Id_Unidad`, `UnidadMasa`, `Estado`) VALUES
(1, 'Gramos', 1),
(2, 'Mililitros', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Cedula_Usuario` varchar(15) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Codigo_TipoUsuario` varchar(10) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Cedula_Usuario`, `Nombre`, `Contrasena`, `Codigo_TipoUsuario`, `Estado`) VALUES
('11111111', 'maria', '$2y$10$VCg0Tog3wVPSknXL3AF.kObAhrgAwrdlbrZsAlFAJcgVOH.7ECPA.', 'TU002', 0),
('12345678', 'Luisa Pere', '$2y$10$Yl5dmNn3ShpB2QqU/oSGPOZi8Ih0Baubr1oB5gfyBNwoID7A/3bk.', 'TU003', 0),
('29841249', 'Marygle Marin', 'Marygle.04', 'TU001', 1),
('30019093', 'Rosmary Rodríguez', 'Rosmary.08', 'TU001', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bandejas`
--
ALTER TABLE `bandejas`
  ADD PRIMARY KEY (`Id_Bandeja`),
  ADD KEY `Id_Menu` (`Id_Menu`);

--
-- Indices de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`Id_Categoria`);

--
-- Indices de la tabla `comensales`
--
ALTER TABLE `comensales`
  ADD PRIMARY KEY (`Cedula_Comensal`),
  ADD KEY `Codigo_Tipocomensal` (`Codigo_Tipocomensal`),
  ADD KEY `Codigo_Nucleo` (`Codigo_Nucleo`),
  ADD KEY `Codigo_Departamento` (`Codigo_Departamento`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`Id_Compra`),
  ADD KEY `Rif_Proveedor` (`Rif_Proveedor`),
  ADD KEY `Cedula_Usuario` (`Cedula_Usuario`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`Codigo_Departamento`);

--
-- Indices de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  ADD PRIMARY KEY (`Id_Detalle`),
  ADD KEY `Id_Compra` (`Id_Compra`),
  ADD KEY `Codigo_Producto` (`Codigo_Producto`),
  ADD KEY `Id_Empaquetado` (`Id_Empaquetado`),
  ADD KEY `Id_Marca` (`Id_Marca`);

--
-- Indices de la tabla `empaquetado`
--
ALTER TABLE `empaquetado`
  ADD PRIMARY KEY (`Id_Empaquetado`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`Id_Ingredientes`),
  ADD KEY `Codigo_Producto` (`Codigo_Producto`),
  ADD KEY `UnidadMasa` (`UnidadMasa`);

--
-- Indices de la tabla `marca_productos`
--
ALTER TABLE `marca_productos`
  ADD PRIMARY KEY (`Id_Marca`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`Id_Menu`),
  ADD KEY `Id_Receta` (`Id_Receta`);

--
-- Indices de la tabla `nucleos`
--
ALTER TABLE `nucleos`
  ADD PRIMARY KEY (`Codigo_Nucleo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Codigo_Producto`),
  ADD KEY `Id_Unidad` (`Id_Unidad`),
  ADD KEY `Id_Categoria` (`Id_Categoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`Rif_Proveedor`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`Id_Receta`),
  ADD KEY `Id_Ingredientes` (`Id_Ingredientes`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`Id_Ticket`),
  ADD KEY `Codigo_Tipocomensal` (`Codigo_Tipocomensal`);

--
-- Indices de la tabla `tiposcomensales`
--
ALTER TABLE `tiposcomensales`
  ADD PRIMARY KEY (`Codigo_Tipocomensal`);

--
-- Indices de la tabla `tiposusuarios`
--
ALTER TABLE `tiposusuarios`
  ADD PRIMARY KEY (`Codigo_TipoUsuario`);

--
-- Indices de la tabla `unidadmasa`
--
ALTER TABLE `unidadmasa`
  ADD PRIMARY KEY (`Id_Unidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Cedula_Usuario`),
  ADD KEY `Codigo_TipoUsuario` (`Codigo_TipoUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bandejas`
--
ALTER TABLE `bandejas`
  MODIFY `Id_Bandeja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  MODIFY `Id_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `Id_Compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  MODIFY `Id_Detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empaquetado`
--
ALTER TABLE `empaquetado`
  MODIFY `Id_Empaquetado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `Id_Ingredientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marca_productos`
--
ALTER TABLE `marca_productos`
  MODIFY `Id_Marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `Id_Menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `Id_Receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `Id_Ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `unidadmasa`
--
ALTER TABLE `unidadmasa`
  MODIFY `Id_Unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bandejas`
--
ALTER TABLE `bandejas`
  ADD CONSTRAINT `bandejas_ibfk_1` FOREIGN KEY (`Id_Menu`) REFERENCES `menus` (`Id_Menu`);

--
-- Filtros para la tabla `comensales`
--
ALTER TABLE `comensales`
  ADD CONSTRAINT `comensales_ibfk_1` FOREIGN KEY (`Codigo_Tipocomensal`) REFERENCES `tiposcomensales` (`Codigo_Tipocomensal`),
  ADD CONSTRAINT `comensales_ibfk_2` FOREIGN KEY (`Codigo_Nucleo`) REFERENCES `nucleos` (`Codigo_Nucleo`),
  ADD CONSTRAINT `comensales_ibfk_3` FOREIGN KEY (`Codigo_Departamento`) REFERENCES `departamentos` (`Codigo_Departamento`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`Rif_Proveedor`) REFERENCES `proveedores` (`Rif_Proveedor`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`Cedula_Usuario`) REFERENCES `usuarios` (`Cedula_Usuario`);

--
-- Filtros para la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  ADD CONSTRAINT `detallecompras_ibfk_1` FOREIGN KEY (`Id_Compra`) REFERENCES `compras` (`Id_Compra`),
  ADD CONSTRAINT `detallecompras_ibfk_2` FOREIGN KEY (`Codigo_Producto`) REFERENCES `productos` (`Codigo_Producto`),
  ADD CONSTRAINT `detallecompras_ibfk_3` FOREIGN KEY (`Id_Empaquetado`) REFERENCES `empaquetado` (`Id_Empaquetado`),
  ADD CONSTRAINT `detallecompras_ibfk_4` FOREIGN KEY (`Id_Marca`) REFERENCES `marca_productos` (`Id_Marca`);

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `ingredientes_ibfk_1` FOREIGN KEY (`Codigo_Producto`) REFERENCES `productos` (`Codigo_Producto`),
  ADD CONSTRAINT `ingredientes_ibfk_2` FOREIGN KEY (`UnidadMasa`) REFERENCES `unidadmasa` (`Id_Unidad`);

--
-- Filtros para la tabla `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`Id_Receta`) REFERENCES `recetas` (`Id_Receta`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Id_Unidad`) REFERENCES `unidadmasa` (`Id_Unidad`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`Id_Categoria`) REFERENCES `categorias_productos` (`Id_Categoria`);

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`Id_Ingredientes`) REFERENCES `ingredientes` (`Id_Ingredientes`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`Codigo_Tipocomensal`) REFERENCES `tiposcomensales` (`Codigo_Tipocomensal`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Codigo_TipoUsuario`) REFERENCES `tiposusuarios` (`Codigo_TipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
