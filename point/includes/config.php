<?php
// ============================================================
//  includes/config.php: datos para conectarse a MySQL.
//  Configuración de la base de datos (XAMPP por defecto)
//  Si tu MySQL tiene contraseña o usa otro puerto, cámbialo aquí.
// ============================================================
const DB_HOST  = 'localhost';
const DB_PORT  = '3306';          // XAMPP: 3306 (MAMP suele usar 8889)
const DB_NAME  = 'point_db';
const DB_USER  = 'root';
const DB_PASS  = '';              // XAMPP: vacío por defecto (MAMP: 'root')
const MOSTRAR_ERRORES = true;     // ponlo en false cuando lo publiques
