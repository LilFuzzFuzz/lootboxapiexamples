<?php
$platform = "pc"; //pc, psn, xbl
$country = "eu"; //eu, us, jp, cn, kr
$battletag = "Splash-22557"; //Replace # with -

$profile = curl_init();
curl_setopt($profile, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($profile, CURLOPT_RETURNTRANSFER, true);
curl_setopt($profile, CURLOPT_FAILONERROR, true);
curl_setopt($profile, CURLOPT_URL,"https://api.lootbox.eu/{$platform}/{$country}/{$battletag}/profile");
$result = curl_exec($profile); //grab API data
curl_close($profile);

$stats = json_decode($result, true); //decode JSON data

if(isset($stats['error'])) //Check for error
{
  echo $stats['error'];
} 
else 
{
  $results = $stats['data'];
  $level = $results['level'];
  $username = $results['username'];
  $quickwin = $results['games']['quick']['wins'];
  $quickloss = $results['games']['quick']['lost'];
  $quickplayed = $results['games']['quick']['played'];
  $avatar = $results['avatar'];
  $fulltag = str_replace("-", "#", $battletag);
  $compwin = $results['games']['competitive']['wins'];
  $comploss = $results['games']['competitive']['lost'];
  $compplayed = $results['games']['competitive']['played'];
  $quicktime = $results['playtime']['quick'];
  $comptime = $results['playtime']['competitive'];
  $mmr = $results['competitive']['rank'];
  $mode = "quick";
  $winpercentage = round((float)$quickwin / $quickplayed * 100) . '%'; //work out win percentage
  if(isset($mmr))
  {
    $mmr = $results['competitive']['rank'];
  }
  if(!isset($mmr)) //If they don't have MMR then return 0
  {
    $mmr = "0";
  }
  echo "{$username} is level {$level} and has won {$quickwin} matches but lost {$quickloss} matches. ({$winpercentage} win percentage)"; //echo data out
}
?>
