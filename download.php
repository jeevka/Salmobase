<?php

// MySQL Login Details
$myServer = "192.168.168.205";
$myUser = "jeevka";
$myPass = "gbrowse01ok";
$myDB = "salmon_test";


// Connection MySQL server
$con=mysqli_connect($myServer,$myUser,$myPass,$myDB) or
     die("Couldn´t connect MySQL server");

#$seq_type = mysqli_real_escape_string($con, $_POST['seq_type']);
#$ref = mysqli_real_escape_string($con, $_POST['ref']);
#$start = mysqli_real_escape_string($con, $_GET['r1']);
#$end = mysqli_real_escape_string($con, $_GET['r2']);
#$us = mysqli_real_escape_string($con, $_GET['upstream']);
#$ds = mysqli_real_escape_string($con, $_GET['downstream']);

$type = $_GET['seq_type'];
$ref = $_GET["ref"];
$start = $_GET["r1"];
$end = $_GET["r2"];
$us = $_GET["upstream"];
$ds = $_GET["downstream"];
$gname = $_GET["gname"];

$range_1 = $start - $us;
$range_2 = $end + $ds;

$query_1 = sprintf("SELECT id FROM locationlist WHERE seqname='%s'",$ref);

$seqid_1 = mysqli_query($con,$query_1);

while($row = mysqli_fetch_array($seqid_1)) {
  $seqid = $row['id'];
}

$query_2 = sprintf("select offset,sequence from sequence where id='%s' and offset>='%s' and offset<='%s'",$seqid,$range_1,$range_2);

$seq = mysqli_query($con,$query_2);


# Executing Perl script to download sequences from database
# exec("perl -w Seq_Download.pl $ref $range_1 $range_2 $type");

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Sequence.fasta");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!-- html>
<head>
<title>Download Seq</title>
</head>
<body -->

<?php
   $file = "/var/www/cgi-bin/Seq_Download.pl $ref $range_1 $range_2 $type $gname";
   ob_start();
   passthru($file);
   $perlreturn = ob_get_contents();
   ob_end_clean();
   echo $perlreturn; 
  
   # Executing Perl script to download sequences from database
   # exec("perl -w Seq_Download.pl $ref $range_1 $range_2 $type");
	
   #while($row = mysqli_fetch_array($seq)) {

  	#echo $row['sequence'];
	#if (intval($range_1) >= intval($row['offset'])){
	#  	echo  $row['offset']." ".$range_1;
        #        echo "<br>";
	#  }

	#if ($range_2 <= $row['offset']) {
        #  echo $row['offset']." ".$range_2; 
  	#  echo "<br>";
	# } 
    #  }
?>

<!-- /body>
</html -->	
