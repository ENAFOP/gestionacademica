<?php
/**
 * Implementation of Calendar view
 *
 * @category   DMS
 * @package    SeedDMS
 * @license    GPL 2
 * @version    @version@
 * @author     Herson Cruz <herson@multisistemas.com.sv>
 * @author     Luis Medrano <lmedrano@multisistemas.com.sv>
 * @copyright  Copyright (C) 2011-2017 Multisistemas
 * @version    Release: @package_version@
 */

/**
 * Include parent class
 */
require_once("../../../views/$theme/class.Bootstrap.php");

/**
 * Class which outputs the html page for Calendar view
 *
 * @category   DMS
 * @package    SeedDMS
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal,
 *             2006-2008 Malcolm Cowe, 2010 Matteo Lucarelli,
 *             2010-2012 Uwe Steinmann
 * @version    Release: @package_version@
 */
class SeedDMS_View_Process extends SeedDMS_Bootstrap_Style {

	function js() { /* {{{ */
		header('Content-Type: application/javascript');
	} /* }}} */

	function show() { /* {{{ */
		$dms = $this->params['dms'];
		$user = $this->params['user'];
		$mode = $this->params['mode'];

		$this->htmlStartPage(getMLText("process"));
		$this->globalNavigation();
		$this->contentStart();
		$this->pageNavigation("", "process");

		if ($mode=="y"){

			$this->contentHeading(getMLText("year_view").": ".$year);
			
			echo "<div class=\"pagination pagination-small\">";
			echo "<ul>";
			print "<li><a href=\"../out/out.Calendar.php?mode=y&year=".($year-1)."\"><i style=\"color: black;\" class=\"icon-arrow-left\"></i></a></li>";
			print "<li><a href=\"../out/out.Calendar.php?mode=y\"><i style=\"color: black;\" class=\"icon-circle-blank\"></i></a></li>";
			print "<li><a href=\"../out/out.Calendar.php?mode=y&year=".($year+1)."\"><i style=\"color: black;\" class=\"icon-arrow-right\"></i></a></li>";
			echo "</ul>";
			echo "</div>";

			$this->contentContainerStart();
			$this->printYearTable($year);
			$this->contentContainerEnd();

		}else if ($mode=="m"){

			if (!isset($this->dayNamesLong)) $this->generateCalendarArrays();
			if (!isset($this->monthNames)) $this->generateCalendarArrays();
			
			$this->contentHeading(getMLText("month_view").": ".$this->monthNames[$month-1]. " ".$year);
			
			echo "<div class=\"pagination pagination-small\">";
			echo "<ul>";
			print "<li><a href=\"../out/out.Calendar.php?mode=m&year=".($year)."&month=".($month-1)."\"><i style=\"color: black;\" class=\"icon-arrow-left\"></i></a></li>";
			print "<li><a href=\"../out/out.Calendar.php?mode=m\"><i style=\"color: black;\" class=\"icon-circle-blank\"></i></li>";
			print "<li><a href=\"../out/out.Calendar.php?mode=m&year=".($year)."&month=".($month+1)."\"><i style=\"color: black;\" class=\"icon-arrow-right\"></i></a></li>";
			echo "</ul>";
			echo "</div>";
//			$this->contentContainerStart();
			
			$days=$this->getDaysInMonth($month, $year);
			$today = getdate(time());
			
			$events = getEventsInInterval(mktime(0,0,0, $month, 1, $year), mktime(23,59,59, $month, $days, $year));

			echo "<div class=\"row-fluid\">";
			echo "<div class=\"span2\">";
			echo "<h4><a href=\"../out/out.Calendar.php?mode=w&year=".($year)."&month=".($month)."&day=1\">".date('W', mktime(12, 0, 0, $month, 1, $year)).". ".getMLText('calendar_week')."</a></h4>";
			echo "<div class=\"well\">";
			$fd = getdate(mktime(12, 0, 0, $month, 1, $year));
			for($i=0; $i<$fd['wday']-1; $i++)
				echo "<tr><td colspan=\"2\">&nbsp;</td></tr>";
			
			for ($i=1; $i<=$days; $i++){
			
				// separate weeks
				$date = getdate(mktime(12, 0, 0, $month, $i, $year));
				if (($date["wday"]==$this->firstdayofweek) && ($i!=1)) {
					echo "</div>";
					echo "</div>";
					echo "<div class=\"span2\">";
					echo "<h4><a href=\"../out/out.Calendar.php?mode=w&year=".($year)."&month=".($month)."&day=".($i)."\">".date('W', mktime(12, 0, 0, $month, $i, $year)).". ".getMLText('calendar_week')."</a></h4>";
					echo "<div class=\"well\">";
				}
				
				// highlight today
				$class = ($year == $today["year"] && $month == $today["mon"] && $i == $today["mday"]) ? "todayHeader" : "header";
				
				echo "<h5>".$i.". - ".$this->dayNamesLong[$date["wday"]]."</h5>";
				
				if ($class=="todayHeader") $class="today";
				else $class="";
				
				$xdate=mktime(0, 0, 0, $month, $i, $year);
				foreach ($events as $event){
					echo "<div>";
					if (($event["start"]<=$xdate)&&($event["stop"]>=$xdate)){
					
						if (strlen($event['name']) > 25) $event['name'] = substr($event['name'], 0, 22) . "...";
						print "<i class=\"icon-lightbulb\"></i> <a href=\"../out/out.ViewEvent.php?id=".$event['id']."\">".htmlspecialchars($event['name'])."</a>";
					}
					echo "</div>";
				}
				
			}
			echo "</div>";
			echo "</div>\n";
			echo "</div>\n";

//			$this->contentContainerEnd();
			
		}else{

			
			// get the week interval - TODO: $GET
//			$datestart=getdate(mktime(0,0,0,$month,$day,$year));
/*
			while($datestart["wday"]!=$this->firstdayofweek){
				$datestart=getdate(mktime(0,0,0,$datestart["mon"],$datestart["mday"]-1,$datestart["year"]));
			}
*/
				
//			$datestop=getdate(mktime(23,59,59,$month,$day,$year));
/*
			if ($datestop["wday"]==$this->firstdayofweek){
				$datestop=getdate(mktime(23,59,59,$datestop["mon"],$datestop["mday"]+1,$datestop["year"]));
			}
*/
/*
			while($datestop["wday"]!=$this->firstdayofweek){
				$datestop=getdate(mktime(23,59,59,$datestop["mon"],$datestop["mday"]+1,$datestop["year"]));
			}
			$datestop=getdate(mktime(23,59,59,$datestop["mon"],$datestop["mday"]-1,$datestop["year"]));
*/
			
/*
			$starttime=mktime(0,0,0,$datestart["mon"],$datestart["mday"],$datestart["year"]);
			$stoptime=mktime(23,59,59,$datestop["mon"],$datestop["mday"],$datestop["year"]);
			
			$today = getdate(time());
			$events = getEventsInInterval($starttime,$stoptime);
*/
			
/*
			$this->contentHeading(getMLText("week_view").": ".getReadableDate(mktime(12, 0, 0, $month, $day, $year)));
			
			echo "<div class=\"pagination pagination-small\">";
			echo "<ul>";
			print "<li><a href=\"../out/out.Calendar.php?mode=w&year=".($year)."&month=".($month)."&day=".($day-7)."\"><i style=\"color: black;\" class=\"icon-arrow-left\"></i></a></li>";
			print "<li><a href=\"../out/out.Calendar.php?mode=w\"><i style=\"color: black;\" class=\"icon-circle-blank\"></i></a></li>";
			print "<li><a href=\"../out/out.Calendar.php?mode=w&year=".($year)."&month=".($month)."&day=".($day+7)."\"><i style=\"color: black;\" class=\"icon-arrow-right\"></i></a></li>";
			echo "</ul>";
			echo "</div>";
*/
			$this->contentContainerStart();
			
			echo "<table class='table table-condensed'>\n";
			
/*
			for ($i=$starttime; $i<$stoptime; $i += 86400){
			
				$date = getdate($i);
				
				// for daylight saving time TODO: could be better
				if ( ($i!=$starttime) && ($prev_day==$date["mday"]) ){
					$i += 3600;
					$date = getdate($i);
				}
				
				// highlight today
				$class = ($date["year"] == $today["year"] && $date["mon"] == $today["mon"] && $date["mday"]  == $today["mday"]) ? "info" : "";
				
				echo "<tr class=\"".$class."\">";
				echo "<td colspan=\"3\"><strong>".$this->dayNamesLong[$date["wday"]].", ";
				echo getReadableDate($i)."</strong></td>";
				echo "</tr>";
				
				foreach ($events as $event){
					if (($event["start"]<=$i)&&($event["stop"]>=$i)){
						echo "<tr>";
						print "<td><a href=\"../out/out.ViewEvent.php?id=".$event['id']."\">".htmlspecialchars($event['name'])."</a>";
						if($event['comment'])
							echo "<br /><em>".htmlspecialchars($event['comment'])."</em>";
						print "</td>";
						echo "<td><a class=\"btn btn-mini\" href=\"../out/out.RemoveEvent.php?id=".$event['id']."\"><i class=\"icon-remove\"></i> ".getMLText('delete')."</a></td>";
						echo "<td><a class=\"btn btn-mini\" href=\"../out/out.EditEvent.php?id=".$event['id']."\">".getMLText('update')."</a></td>";
						echo "</tr>\n";	
					}
				}
				
				$prev_day=$date["mday"];
			}
*/
			echo "</table>\n";

			$this->contentContainerEnd();
		}

		$this->contentEnd();
		$this->htmlEndPage();
	} /* }}} */
}
?>
