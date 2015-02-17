<?php
/*
 Reportico - PHP Reporting Tool
 Copyright (C) 2010-2012 Peter Deed

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

 * File:        run.php
 *
 * Reportico runner script
 * !!! Note this script will run reports in FULL design mode
 * !!! This means that users of the reports will be able to 
 * !!! modify reports and save those modifications
 *
 * @link http://www.reportico.org/
 * @copyright 2010-2012 Peter Deed
 * @author Peter Deed <info@reportico.org>
 * @package Reportico
 * @version $Id: run.php,v 1.8 2012-04-11 21:35:04 root Exp $
 */

    // set error reporting level
	error_reporting(E_ALL);

    // Set the timezone according to system defaults
    date_default_timezone_set(@date_default_timezone_get());

    // Reserver 100Mb for running
	ini_set("memory_limit","100M");
	ini_set("max_execution_time","90");

            //header("Content-Type: text/html; charset=utf-8");

	//ob_start();
	require_once('reportico.php');
	$q = new reportico();
	$q->allow_debug = true;
	$q->forward_url_get_parameters = "";


    $_SESSION["template"] = "dropmenu";
    $q->dropdown_menu = array(
                    array ( 
                        "project" => "tutorials",
                        "title" => "Listings",
                        "items" => array (
                            array ( "reportfile" => "tut1_films.xml" ),
                            array ( "reportfile" => "tut2_loanhistory.xml" )
                            )
                        ),
                    array ( 
                        "project" => "tutorials",
                        "title" => "Analysis Reports",
                        "items" => array (
                            array ( "reportfile" => "tut2_1_loanhistory.xml") ,
                            array ( "reportfile" => "tut4_1_lateness.xml")
                            )
                        ),
                );

	$q->execute($q->get_execute_mode(), true);
	//ob_end_flush();
?>
