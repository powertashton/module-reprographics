<?php
// USE ;end TO SEPARATE SQL STATEMENTS. DON'T USE ;end IN ANY OTHER PLACES!

$sql = [];
$count = 0;

// v0.0.00
$sql[$count][0] = "0.0.00";
$sql[$count][1] = "-- First version, nothing to update";


// v0.0.0x
$count++;
$sql[$count][0] = "0.0.02";
$sql[$count][1] = "CREATE TABLE `Printing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `department` varchar(45) DEFAULT NULL,
  `BWA3Duplex` double DEFAULT NULL,
  `BWA3DuplexPrice` double DEFAULT NULL,
  `BWA3Simplex` double DEFAULT NULL,
  `BWA3SimplexPrice` double DEFAULT NULL,
  `BWA4Duplex` int(11) DEFAULT NULL,
  `BWA4DuplexPrice` double DEFAULT NULL,
  `BWA4Simplex` int(11) DEFAULT NULL,
  `BWA4SimplexPrice` double DEFAULT NULL,
  `FCA3Duplex` varchar(45) DEFAULT NULL,
  `FCA3DuplexPrice` varchar(45) DEFAULT NULL,
  `FCA3Simplex` varchar(45) DEFAULT NULL,
  `FCA3SimplexPrice` varchar(45) DEFAULT NULL,
  `FCA4Duplex` int(11) DEFAULT NULL,
  `FCA4DuplexPrice` double DEFAULT NULL,
  `FCA4Simplex` int(11) DEFAULT NULL,
  `FCA4SimplexPrice` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idPrinting_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;end";
