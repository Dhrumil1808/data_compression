<?php
require_once ('Huffman.php');
$huffman = new Huffman();
$exampleString = 'the raininthespainfallsmainlyontheplain.';
//echo strlen($exampleString);
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
/*echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original lenght :	'.strlen($exampleString).'<br />'.
		'Encoded lenght :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';*/

//$huffman->generateDictionnary('0123456789abcdefghijklmnopqrstuvwxyz');
//$dictionnary = $huffman->getDictionnary();
$myfile=fopen("test.txt", "r") or die("unable to open the file");
$i=0;
while(!feof($myfile))
{
	echo fgetc($myfile)."<br>";
	$i++;

}
//echo $i;

fclose($myfile);
$myfile1=fopen("test.txt", "r") or die("unable to open the file");

while(!feof($myfile1))
{
	$encode=fgets($myfile1);
	echo $encode;
	$encode_string=$huffman->encode($encode);
	echo $encode_string;
	
}
/*$huffman = new Huffman();
$huffman->generateDictionnary('0123456789abcdef');
$dictionnary = $huffman->getDictionnary();
$exampleString = '4009814546017120030654ab480184190804298b01980908bb098981f989182804082040498249d840298e42984984290842984298042d980d49824928e402984f0984298429849082498498a98429802c498b42098';
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
/*echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original lenght :	'.strlen($exampleString).'<br />'.
		'Encoded lenght :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';
$huffman = new Huffman();
$huffman->setDictionnary($dictionnary);
$exampleString = md5(rand());
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original lenght :	'.strlen($exampleString).'<br />'.
		'Encoded lenght :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';
$huffman = new Huffman();
$exampleString = sha1(rand());
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original lenght :	'.strlen($exampleString).'<br />'.
		'Encoded lenght :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';*/
?>