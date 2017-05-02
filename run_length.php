<?php
//$message = 'aaaaaaaaaabbbaxxxxyyyzyx';
 
function run_length_encode($msg)
{
	$i = $j = 0;
	$prev = '';
	$output = '';
 
	for($i=0;$i<strlen($msg);$i++) {
		if ($msg[$i] != $prev) {
 
			if ($i && $j > 1) 
				$output .= $j;
 
			$output .= $msg[$i];
 
			$prev = $msg[$i];
 
			$j = 0;
		}
		$j++;
		
	}
 
	if ($j > 1)
		$output .= $j;
 
	return $output;
}
 
// a10b3ax4y3zyx
$myfile=fopen("test_run.txt","r") or die("unable to open the file");
$myfile2=fopen("test_run_compress.txt","w") or die("unable to open the file");
while(!feof($myfile))
{
	$message=fgets($myfile);
	$encode=run_length_encode($message);
	echo $encode;
	fwrite($myfile2,$encode);
}

$myfile1=fopen("test_run.txt","r") or die("unable to open the file");
$k=0;
while(!feof($myfile1))
{
	fgetc($myfile1);
	$k++;

}
//echo $k;
$myfile3=fopen("test_run_compress.txt","r") or die("unable to open the file");
$l=0;
while(!feof($myfile3))
{
	fgetc($myfile3);
	$l++;
}
//echo $l;

echo "Original Length:". $k;

echo "Encoded Length:" . $l;


?>