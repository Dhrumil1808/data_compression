<?php

function lzw_compress($string) {
	// compression
	$dictionary = array_flip(range("\0", "\xFF"));
	//print_r($dictionary);
	//print_r($dictionary['t']);
	$word = "";
	$codes = array();
	for ($i=0; $i <strlen($string); $i++) {
		$x = $string[$i];
		//echo $x."<br>";
		if (strlen($x) && isset($dictionary[$word . $x])) {

			$word .= $x;
			//echo $word."<br>";
		} elseif ($i) {
			$codes[] = $dictionary[$word];
			//print_r($codes)."<br>";
			$dictionary[$word . $x] = count($dictionary);
			$word = $x;
			//echo $word."<br>";
			//print_r($dictionary[$word.$x]);
			//echo count($dictionary);
		}
	}
	print_r($codes);
	
	// convert codes to binary string
	$dictionary_count = 256;
	$bits = 8; // ceil(log($dictionary_count, 2))
	$return = "";
	$rest = 0;
	$rest_length = 0;
	foreach ($codes as $code) {
		$rest = ($rest << $bits) + $code;
		//echo $rest;
		$rest_length += $bits;
		$dictionary_count++;
		if ($dictionary_count > (1 << $bits)) {
			$bits++;
		}
		while ($rest_length > 7) {
			$rest_length -= 8;
			$return .= chr($rest >> $rest_length);
			$rest &= (1 << $rest_length) - 1;
		}
	}
	return $return . ($rest_length ? chr($rest << (8 - $rest_length)) : "");
}

/** LZW decompression
* @param string compressed binary data
* @return string original data
*/
function lzw_decompress($binary) {
	// convert binary string to codes
	$dictionary_count = 256;
	$bits = 8; // ceil(log($dictionary_count, 2))
	$codes = array();
	$rest = 0;
	$rest_length = 0;
	for ($i=0; $i < strlen($binary); $i++) {
		$rest = ($rest << 8) + ord($binary[$i]);
		$rest_length += 8;
		if ($rest_length >= $bits) {
			$rest_length -= $bits;
			$codes[] = $rest >> $rest_length;
			$rest &= (1 << $rest_length) - 1;
			$dictionary_count++;
			if ($dictionary_count > (1 << $bits)) {
				$bits++;
			}
		}
	}
	
	// decompression
	$dictionary = range("\0", "\xFF");
	$return = "";
	foreach ($codes as $i => $code) {
		$element = $dictionary[$code];
		if (!isset($element)) {
			$element = $word . $word[0];
		}
		$return .= $element;
		if ($i) {
			$dictionary[] = $word . $element[0];
		}
		$word = $element;
	}
	return $return;
}

$myfile=fopen("test.txt","r") or die("unable to open the file");
$myfile2=fopen("test_lzw.txt","w") or die("unable to open file");

while(!feof($myfile))
{
	$encode=fgets($myfile);
	$compress_file=lzw_compress($encode);
	//echo $compress_file."<br>";
	fwrite($myfile2,$compress_file);
}

$myfile1=fopen("test.txt","r") or die("unable to open the file");
$i=0;
while(!feof($myfile1))
{
	fgetc($myfile1);	
	$i++;

}
echo "Original Length:".$i."<br>";

$myfile3=fopen("test_lzw.txt","r") or die("unable to open the file");
$j=0;
while(!feof($myfile3))
{
	fgetc($myfile3);	
	$j++;

}
echo "Encoded Length:".$j."<br>";

$myfile4=fopen("test_lzw.txt","r") or die("unable to open the file");
while(!feof($myfile4))
{
	$encode=fgets($myfile4);
	$decode=lzw_decompress($encode);
	echo $decode."<br>";

}