-- MySQL dump 10.16  Distrib 10.3.8-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: licenses
-- ------------------------------------------------------
-- Server version	10.3.8-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `servers`
--

DROP TABLE IF EXISTS `servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hostname` (`hostname`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servers`
--

LOCK TABLES `servers` WRITE;
/*!40000 ALTER TABLE `servers` DISABLE KEYS */;
INSERT INTO `servers` VALUES (1,'Server2003'),(2,'server2008'),(3,'server2014'),(4,'cadsf1'),(5,'demo'),(6,'az71nt050.honeywell.com'),(7,'tsunami'),(8,'YourHostname'),(9,'N/A'),(10,'TESTSERVER1'),(11,'hws5'),(12,'192.168.1.200'),(13,'FS-16471_970400_or_Correct_Server_Name'),(14,'banshee'),(15,'192.168.1.110'),(16,'192.168.1.116'),(17,'192.168.1.106');
/*!40000 ALTER TABLE `servers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `code` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
INSERT INTO `sites` VALUES (1,'matlab_demo',''),(2,'NX_demo',''),(3,'accurev_demo2',''),(4,'matlab_demo2',''),(5,'matlab_demo3',''),(6,'NX-demo2',''),(7,'A1_2014',''),(27,'Doors_Boston',''),(48,'accurev_demo',''),(50,'adina_Sentinal',''),(51,'adina_Sentinel',''),(52,'alterad_',''),(53,'Additional_Tag',''),(54,'Diab_',''),(55,'DSLSTESTER',''),(56,'updatetester_',''),(57,'TESTTAG',''),(58,'Cadence_NA',''),(59,'PTC',''),(60,'Altium',''),(61,'accurev__demo',''),(62,'Atuocad_add',''),(63,'autodesk_boston',''),(64,'Siemens_PTI',''),(65,'SW_Albany',''),(66,'Cadence_WAN',''),(67,'ABC1',''),(68,'accurev__test',''),(69,'GenericDem',NULL),(70,'AltiumTag',NULL);
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'FlexLM'),(2,'RLM'),(3,'Sentinel(RMS)'),(4,'LUM'),(5,'DSLS'),(6,'Altium'),(7,'LM-X(Altair)'),(8,'LM-X(Other)'),(9,'Windchill'),(10,'MathLM'),(11,'Generic');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alerts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(255) NOT NULL,
  `featurename` varchar(255) NOT NULL,
  `days` int(5) NOT NULL,
  `hours` int(5) NOT NULL,
  `emailrecip` varchar(255) NOT NULL,
  `warning` tinyint(4) NOT NULL DEFAULT 0,
  `type` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_feature_email` (`sitename`,`featurename`,`emailrecip`,`type`),
  KEY `featurename` (`featurename`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
INSERT INTO `alerts` VALUES (2,'TESTTAG','expi',30,0,'kinnari@teameda.com',0,'expi'),(3,'matlab_demo','expi',26,0,'kinnari@teameda.com',0,'expi'),(5,'GenericDem','expi',30,0,'kinsac_2000@yahoo.com',0,'expi'),(7,'TESTTAG','expi',30,0,'kinsac_2000@yahoo.com',0,'expi'),(8,'AltiumTag','expi',22,0,'chetana_patel@yahoo.com',0,'expi'),(9,'TESTTAG','expi',22,0,'chetana_patel@yahoo.com',0,'expi');
/*!40000 ALTER TABLE `alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ports`
--

DROP TABLE IF EXISTS `ports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `port` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `port` (`port`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ports`
--

LOCK TABLES `ports` WRITE;
/*!40000 ALTER TABLE `ports` DISABLE KEYS */;
INSERT INTO `ports` VALUES (1,27000),(2,28000),(3,2375),(4,27001),(5,27002),(6,28001),(7,4300),(8,5280),(9,6306),(10,7400),(11,7654),(12,7178),(13,7571),(14,2153),(15,7102),(17,0),(18,80),(19,25000),(20,5000),(21,1233),(22,12345),(23,50),(24,33),(25,44);
/*!40000 ALTER TABLE `ports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'MATLAB'),(2,'NX'),(3,'accurev'),(4,'A1'),(5,'DCExpert'),(6,'DxDesigner'),(7,'AbaqusStandard'),(8,'IncisiveEnterpriseFamily'),(9,'AllegroDesignEditor'),(10,'NC-VHDL'),(11,'Doors'),(12,'AbaqusBundle'),(13,'LSF'),(14,'Teamcenter'),(15,'Cirrus1000'),(16,'Adams'),(17,'0-In'),(18,'Chameleon'),(19,'NC-Sim'),(20,'Xtreme'),(21,'VirtuosoNeoCell'),(22,'AllegroPCBRouter'),(23,'Dracula'),(24,'FireIceQX'),(25,'NC-Verilog'),(26,'Bundle'),(27,'VirtuosoAnalog'),(28,'AllegroDesignEditorXL'),(29,'Cadence_WAN'),(30,'VirtuosoDigital'),(31,'3DDesignViewer'),(32,'AllegroPCBLibraries'),(33,'EncounterRTLCompiler'),(34,'Abaqus_1'),(35,'AutoDesk_Bundle'),(36,'AutoDeskBundle'),(37,'Incisive Enterprise Family'),(38,'Virtuoso NeoCell'),(39,'Allegro PCB Router'),(40,'Fire & Ice QX'),(41,'Virtuoso Analog'),(42,'Allegro Design Editor XL'),(43,'Virtuoso Digital'),(44,'3D Design Viewer'),(45,'Allegro PCB Libraries'),(46,'Encounter RTL Compiler'),(47,'AutoDesk Bundle'),(48,'DC Expert'),(49,'Cirrus 1000'),(50,'Abaqus Bundle'),(52,'adina'),(53,'Allegro Design Editor'),(54,'HyperCrash'),(55,'fe-safe'),(56,'DSLSTest'),(57,'TESTTOOL'),(58,'Windchill Archive'),(59,'AltiumTool'),(60,'21414'),(61,'autodesk_b'),(62,'autodesk_tool'),(63,'PTI'),(64,'SOLIDWORKS 3D CAD'),(65,'SOLIDWORKS'),(66,'ABC1'),(67,'Abaqus/Standard'),(68,'Generic Tool'),(69,'TEST');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licenses` (
  `serverid` int(10) unsigned NOT NULL,
  `portid` int(10) unsigned NOT NULL,
  `productid` int(10) unsigned NOT NULL,
  `siteid` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL,
  `lamid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lamid` (`lamid`),
  KEY `serverid` (`serverid`),
  KEY `portid` (`portid`),
  KEY `productid` (`productid`),
  KEY `siteid` (`siteid`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licenses`
--

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
INSERT INTO `licenses` VALUES (1,1,1,1,1,1,129),(1,2,2,2,2,1,130),(1,3,3,68,3,2,148),(2,4,1,4,4,1,151),(1,6,2,6,6,1,153),(11,8,58,59,10,9,162),(3,5,1,5,33,1,152),(3,5,1,5,31,1,172),(17,23,68,69,32,11,173),(17,24,59,70,34,6,174),(17,23,69,69,35,1,158),(17,25,37,57,36,1,5);
/*!40000 ALTER TABLE `licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `display` (`display`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'TestAccu','accurev-ent'),(2,'replica','replica'),(3,'MATLAB','MATLAB'),(4,'NX13100N','NX13100N'),(5,'ideas_integration','ideas_integration'),(6,'nx_integration','nx_integration'),(7,'nx_nas_bn_basic_dsk','nx_nas_bn_basic_dsk'),(8,'teamcenter_admin','teamcenter_admin'),(9,'teamcenter_designer','teamcenter_designer'),(10,'visview_base','visview_base'),(11,'server_id','server_id'),(12,'NX13100N_3d_to_2d_flattener','NX13100N_3d_to_2d_flattener'),(13,'NX13100N_adv_assemblies','NX13100N_adv_assemblies'),(14,'NX13100N_assemblies','NX13100N_assemblies'),(15,'NX13100N_design_studio','NX13100N_design_studio'),(16,'NX13100N_drafting','NX13100N_drafting'),(17,'NX13100N_dxf_to_ug','NX13100N_dxf_to_ug'),(18,'NX13100N_dxfdwg','NX13100N_dxfdwg'),(19,'NX13100N_features_modeling','NX13100N_features_modeling'),(20,'NX13100N_free_form_modeling','NX13100N_free_form_modeling'),(21,'NX13100N_gateway','NX13100N_gateway'),(22,'NX13100N_geometric_tol','NX13100N_geometric_tol'),(23,'NX13100N_grip_execute','NX13100N_grip_execute'),(24,'NX13100N_iges','NX13100N_iges'),(25,'NX13100N_nc_external_program','NX13100N_nc_external_program'),(26,'NX13100N_nx_flexible_pcb','NX13100N_nx_flexible_pcb'),(27,'NX13100N_nx_freeform_1','NX13100N_nx_freeform_1'),(28,'NX13100N_nx_freeform_2','NX13100N_nx_freeform_2'),(29,'NX13100N_nx_nastran_export','NX13100N_nx_nastran_export'),(30,'NX13100N_nx_sheet_metal','NX13100N_nx_sheet_metal'),(31,'NX13100N_nx_spsd_stress','NX13100N_nx_spsd_stress'),(32,'NX13100N_nx_spsd_vibration','NX13100N_nx_spsd_vibration'),(33,'NX13100N_pcf_package_file','NX13100N_pcf_package_file'),(34,'NX13100N_pstudio_cons','NX13100N_pstudio_cons'),(35,'NX13100N_pv_ugdatagenerator','NX13100N_pv_ugdatagenerator'),(36,'NX13100N_routing_base','NX13100N_routing_base'),(37,'NX13100N_sla_3d_systems','NX13100N_sla_3d_systems'),(38,'NX13100N_solid_modeling','NX13100N_solid_modeling'),(39,'NX13100N_step_ap203','NX13100N_step_ap203'),(40,'NX13100N_step_ap214','NX13100N_step_ap214'),(41,'NX13100N_studio_analyze','NX13100N_studio_analyze'),(42,'NX13100N_studio_free_form','NX13100N_studio_free_form'),(43,'NX13100N_studio_render','NX13100N_studio_render'),(44,'NX13100N_studio_visualize','NX13100N_studio_visualize'),(45,'NX13100N_ug_checkmate','NX13100N_ug_checkmate'),(46,'NX13100N_ug_collaborate','NX13100N_ug_collaborate'),(47,'NX13100N_ug_kf_checker','NX13100N_ug_kf_checker'),(48,'NX13100N_ug_kf_execute','NX13100N_ug_kf_execute'),(49,'NX13100N_ug_nas_des','NX13100N_ug_nas_des'),(50,'NX13100N_ug_opt_wizard','NX13100N_ug_opt_wizard'),(51,'NX13100N_ug_prod_des_advisor','NX13100N_ug_prod_des_advisor'),(52,'NX13100N_ug_smart_models','NX13100N_ug_smart_models'),(53,'NX13100N_ug_to_dxf','NX13100N_ug_to_dxf'),(54,'NX13100N_ug_web_express','NX13100N_ug_web_express'),(55,'NX13100N_ugopen_menuscript','NX13100N_ugopen_menuscript'),(56,'NX13100N_usr_defined_features','NX13100N_usr_defined_features'),(60,'Altium Designer','Altium Designer '),(61,'windchill','windchill'),(62,'ARM Compiler','ARM.EW.COMPILER_STD_v1.06'),(63,'ARM.EW.LINKER_STD_v1.06','ARM.EW.LINKER_STD_v1.06'),(64,'ARM.EW.MISRAC_STD_v1.06','ARM.EW.MISRAC_STD_v1.06'),(65,'ARM.EW.DEBUGGER_STD_v1.06','ARM.EW.DEBUGGER_STD_v1.06'),(66,'RX.EW.LIBSRC_STD_v1.06','RX.EW.LIBSRC_STD_v1.06'),(67,'RX.EW.COMPILER_STD_v1.06','RX.EW.COMPILER_STD_v1.06'),(68,'RX.EW.LINKER_STD_v1.06','RX.EW.LINKER_STD_v1.06'),(69,'RX_PCB Designer','RX.EW.MISRAC_STD_v1.06'),(70,'ARM.EW.LIBSRC_STD_v1.06','ARM.EW.LIBSRC_STD_v1.06'),(71,'RX.EW.DEBUGGER_STD_v1.06','RX.EW.DEBUGGER_STD_v1.06'),(72,'M16C.EW.LIBSRC_STD_v1.01','M16C.EW.LIBSRC_STD_v1.01'),(73,'M16C.EW.COMPILER_STD_v1.01','M16C.EW.COMPILER_STD_v1.01'),(74,'M16C.EW.LINKER_STD_v1.01','M16C.EW.LINKER_STD_v1.01'),(75,'M16C.EW.MISRAC_STD_v1.01','M16C.EW.MISRAC_STD_v1.01'),(76,'M16C.EW.DEBUGGER_STD_v1.01','M16C.EW.DEBUGGER_STD_v1.01'),(77,'Altium ','Altium ');
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-19 10:55:31
