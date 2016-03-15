<?php

class Affiliate_Merchants_Bl_RateGantt 
{

    function drawGantt($name, $rates) 
    {
    	
    	$data = array();
    	
    	$i = 0;
    	
    	$min = date('Y-m-d', mktime(0, 0, 0, date("m") - 9 ,  date("d"),  date("Y") ));
    	$max = date('Y-m-d', mktime(0, 0, 0, date("m") + 9 ,  date("d"),  date("Y") ));
    	
    	foreach($rates as $rate){
    		$endArray = explode('-', $rate['enddate']);
    		if(mktime(0, 0, 0, date("m") + 9 ,  date("d"),  date("Y")) <=  mktime(0, 0, 0, $endArray[1] , $endArray[2]  ,  $endArray[0])){
    			$rate['enddate'] = $max;
    		}else if ($rate['enddate'] == '0000-00-00'){
    			$rate['ongoing'] = true;
    			$rate['enddate'] = $max;
    		}
    		
    		
    		$data[] = array($i, $rate['rate'], $rate['startdate'], $rate['enddate'], $rate['ongoing']);	
    		++$i;
    	}
		
		$graph = new GanttGraph();
		$graph->SetDateRange($min,$max);
		
		$graph->title->Set($name);
		if(count($data) < 1)
			$graph->subtitle->Set("(No Rates Assigned)");
		$graph->setMarginColor('white');
		
		$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH );
		$graph->scale->month->grid->SetColor('gray');
		$graph->scale->month->grid->Show(true);
		$graph->scale->year->grid->SetColor('gray');
		$graph->scale->year->grid->Show(true);			
		
		$graph->hgrid->Show();
		$graph->hgrid->SetRowFillColor('darkblue@0.9');
		
		for($i=0; $i<count($data); ++$i) {
		    $bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],"",8);
		    $bar->SetPattern(BAND_RDIAG,"yellow");
		    if($data[$i][4])
		    	$color = "yellow";
		    else
		    	$color = "blue";
		    $bar->SetFillColor($color);
		    $graph->Add($bar);
		}
		
		$graph->Stroke();    	
    }
}
?>