<?php 
 $year = Session::get('year');

$jsonYear = json_decode($year);
echo $jsonYear;
