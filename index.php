<?php
require "alice.php";
require "data.php";
$smarty = new Smarty;
$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';
$smarty->template_dir = PATH."inc/templates/";
$smarty->compile_dir  = PATH."inc/templates_c/";

$w = $dWeather;

/* Masthead */
if ($dEmailCount)
	if ($dEmailCount == 1) $masthead = "$dEmailCount new message";
	else $masthead = "$dEmailCount new messages";
elseif (alice_xbmc_check('playing'))
{
	$nowPlaying = alice_xbmc_check('playing');
	if ($nowPlaying[0])
	$masthead = "{$nowPlaying[0]} - &ldquo;{$nowPlaying[1]}&rdquo;";
	else $masthead = $nowPlaying[1];
}
else
{
	$w = $dWeather;
	$masthead = "{$w['currTemp']}&deg;F - {$w['currCond']}";
}

/* Subhead */
if (alice_xbmc_check('playing'))
{
	$subhead = <<<SHEAD
<a class="btn btn-large" onclick='$.post("api.php", { control: "rewind" } );'><i class=icon-backward></i></a> <a class="btn btn-large btn-primary" onclick='$.post("api.php", { control: "pause" } );'><i class="icon-play icon-white"></i><i class="icon-pause icon-white"></i></a> <a class="btn btn-large" onclick='$.post("api.php", { control: "forward" } );'><i class=icon-forward></i></a> <a class="btn btn-large" onclick='$.post("api.php", { control: "volume up" } );'><i class=icon-volume-up></i></a> <a class="btn btn-large" onclick='$.post("api.php", { control: "volume down" } );'><i class=icon-volume-down></i></a> <a class="btn btn-large" onclick='$.post("api.php", { control: "volume mute" } );'><i class=icon-volume-off></i></a>
SHEAD;
}
elseif (date('H') == 23)
{
	$now = new DateTime();
	$ref = new DateTime("tomorrow 6:30am");
	$diff = $now->diff($ref);
	if ($diff->h) $time = "{$diff->h} hours and {$diff->i} minutes";
	else $time = "{$diff->i} minutes"; 
	$subhead = "You will be waking up in $time.";
}
else
{
$subhead = "It is ".date('g:i a');
}

/* XBMC */
/* Get three most recent films */
if (alice_xbmc_on())
{
	$jsonThreeFilms = json_decode(alice_xbmc_talk(array("jsonrpc" => "2.0", "method" => "VideoLibrary.GetRecentlyAddedMovies", "params" => array("limits" => array("end" => 3), "properties" => array("mpaa", "runtime")), "id" => 1)));
	$arrayThreeFilms = $jsonThreeFilms->result->movies;
	$films = "";
	foreach ($arrayThreeFilms as $movie)
	{
		$films .= "<a href=xbmc.php?movie={$movie->movieid}><strong>{$movie->label}</strong></a> - {$movie->mpaa} - {$movie->runtime} mins<br />\n";
	}
}
$smarty->assign("masthead", $masthead);
$smarty->assign("subhead", $subhead);
$smarty->assign("weather", $w);
if (alice_xbmc_on()) $smarty->assign("xbmcBody", $films);
$smarty->assign("updateTime", $dUpdated);
$smarty->assign("updateCity", $dLocation['city'].', '.$dLocation['state']);
$smarty->display("index.tpl");
?>
