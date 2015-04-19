<?php
// Set the div details for lights
// F. Bardin 2015/02/15
// ------------------------------------
// Anti-hack
if (! defined('ANTI_HACK')){exit;}

// Elements selected and name update if 1 element or color switch if 2 lights selected
echo "\n<DIV ID=dispname><SPAN ID=sellist></SPAN>";
echo "<SPAN ID=selname><INPUT TYPE=text ID=elemname CLASS=ui-corner-all> <BUTTON ID=updname>Rename</BUTTON>";
echo "</SPAN>"; // selname
echo "</DIV>"; // dispname

// Table for slider
echo "\n<TABLE>";
echo "\n<TR>";
echo "<TD rowspan=4><INPUT TYPE=text ID=colorpicker>";
echo "\n<TR ID=trbri>";
echo "<TD CLASS=\"slider slilib\">Brightness";
echo "\n<TR ID=trbri>";
echo "<TD CLASS=slider><DIV ID=brislider></DIV></TD>";
echo "<TD><DIV ID=brival CLASS=bsval></DIV>";
echo "\n<TR><TD>&nbsp;";
echo "\n</TABLE>";

// Action buttons
echo "\n<DIV ID=actions>";
echo "<FIELDSET CLASS=\"ui-widget ui-widget-content ui-corner-all\"><LEGEND>Effects</LEGEND>\n";
echo "<BUTTON ID=blink1>1 Blink</BUTTON>";
echo "<BUTTON ID=blink30s>Blink 30 s</BUTTON>";
echo "<BUTTON ID=blinkoff>Blink Off</BUTTON>";
echo "&nbsp;&nbsp;";
echo "<BUTTON ID=colorloop>Color Loop</BUTTON>";
echo "<BUTTON ID=colorloopoff>Loop Off</BUTTON>";
echo "</FIELDSET>";
echo "\n</DIV>"; // actions

// Transfert color settings
echo "\n<DIV ID=transset>";
echo "<FIELDSET CLASS=\"ui-widget ui-widget-content ui-corner-all\"><LEGEND ID=transsetlegend>Copy color settings</LEGEND>\n";

echo "<DIV ID=tsradio>";
echo "<INPUT TYPE=radio NAME=tsradio ID=cpto VALUE=cpto CHECKED=checked><LABEL FOR=cpto>Copy to</LABEL>";
echo "<INPUT TYPE=radio NAME=tsradio ID=cpfrom VALUE=cpfrom><LABEL FOR=cpfrom>Copy from</LABEL>";
echo "<INPUT TYPE=radio NAME=tsradio ID=swwith VALUE=swwith><LABEL FOR=swwith>Switch with</LABEL>";
echo "</DIV>"; // tsradio
echo "&nbsp;<SELECT ID=tssell>\n";
echo "<OPTION VALUE=none>Select light</OPTION>\n";
foreach ($HueAPI->info['lights'] as $lnum => $lval){
	echo "<OPTION VALUE=$lnum>".$lval['name']."</OPTION>\n";
}
echo "</SELECT>\n";

echo "<DIV ID=dtsexec>";
echo "<BUTTON ID=tsexec>Execute</BUTTON>";
echo "</DIV>"; // dtsexec
echo "\n</FIELDSET>";
echo "\n</DIV>"; // transset

// Group management
echo "\n<DIV ID=grpmgmt>";
echo "<FIELDSET CLASS=\"ui-widget ui-widget-content ui-corner-all\"><LEGEND ID=grplegend>Manage group</LEGEND>\n";

echo "<SPAN ID=grplightopt>\n";

echo "<SELECT ID=assigngrp>\n";
echo "<OPTION VALUE=other>Select</OPTION>\n";
foreach ($HueAPI->info['groups'] as $gnum => $gval){
	echo "<OPTION VALUE=$gnum LIGHTS=\"[";
	$lightslist = "";
	foreach ($gval['lights'] as $internal => $lnum){$lightslist .= ",$lnum";}
	echo substr($lightslist,1);	
	echo "]\">".$gval['name']."</OPTION>\n";
}
echo "</SELECT>\n";

echo "<SPAN ID=creategrp> or create <INPUT TYPE=text ID=newgrp CLASS=ui-corner-all></SPAN>\n";
echo "<BUTTON ID=grpassign>Fill Group</BUTTON>\n";
echo "</SPAN>\n"; // grplightopt

echo "<SPAN ID=grpopt>\n";
echo "<BUTTON ID=delgrp>Delete group(s)</BUTTON>\n";
echo "</SPAN>\n"; // grpopt

echo "\n</FIELDSET>";
echo "\n</DIV>"; // grpmgmt

// Element description (if 1 element only)
echo "\n<BR><DIV ID=descri><H3>Informations</H3><DIV ID=detdescri></DIV></DIV>";
?>
<SCRIPT>
// Initialize controls
$('#updname').button({
 icons: {primary: "ui-icon-arrowthick-1-e"}
});

$("#tsradio").buttonset({width : 'auto'});
$("#tssell").selectmenu({width : 'auto'});
$("#tsexec").button({
 icons: {primary: "ui-icon-arrowthick-1-e"}
});

$("#brislider").noUiSlider({
	start: 0,
	step: 1,
	connect: 'upper',
	range: {
			'min': 0,
			'max': 254
	},
	format: wNumb({decimals: 0})
});
$("#brislider").noUiSlider_pips({
	mode: 'values',
	values : [0, 50, 100, 150, 200, 254],
	density: 4
});
$("#brislider").Link('lower').to($('#brival'));

$("#blink1, #blink30s, #blinkoff").button();
$("#colorloop, #colorloopoff").button();

$('#colorpicker').minicolors({
	change: function(rgb){changeColorPicker(rgb);},
	changeDelay: 500,
	control: 'wheel',
	inline : true
});

$("#assigngrp").selectmenu({width : 'auto'});
$("#grpassign").button({
 icons: {primary: "ui-icon-arrowthick-1-e"}
});
$("#delgrp").button();

$('#descri').accordion({
	collapsible: true,
	heightStyle: "content",
	active: false
});

lightsDetail();
</SCRIPT>