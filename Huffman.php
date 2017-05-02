<?php 
require_once ('HuffmanDictionnary.php');

class Huffman
{
	private	$dictionnary = null;
	/**
	 * Specifies the dictionnary to use for encoding/decoding.
	 * @param HuffmanDictionnary $dictionnary An instance of HuffmanDictionnary that you will use for encoding/decoding.
	 */
	public function	setDictionnary(HuffmanDictionnary $dictionnary)
	{
		$this->dictionnary = $dictionnary;
	}
	/**
	 * Gets the currently used dictionnary
	 * @return HuffmanDictionnary The instance of HuffmanDictionnary that is currently used by the Huffman object.
	 */
	public function	getDictionnary()
	{
		return $this->dictionnary;
	}
	/**
	 * Deletes the currently used dictionnary.
	 */
	public function	unsetDictionnary()
	{
		$this->dictionnary = null;
	}
	/**
	 * Encodes some data with the Huffman algorithm. If the dictionnary has not been set yet, it is created with the $data.
	 * @param mixed $data The data to encode. If $data is not a string, it will be serialized.s
	 * @return string A string containing the encoded message.
	 */
	public function	encode($data)
	{
		if (!is_string($data))
			$data = serialize($data);
		if (empty($data))
			return '';
		if ($this->dictionnary === null)
			$this->generateDictionnary($data);
		$binaryString = '';
		for ($i = 0; isset($data[$i]); ++$i)

			$binaryString .= $this->dictionnary->get($data[$i]);
			//echo $binaryString."<br/>";
		$splittedBinaryString = str_split($binaryString,8);
		//print_r($splittedBinaryString);

		$binaryString = '';
		foreach ($splittedBinaryString as $i => $c)
		{
				//echo $c."<br/>";
			while (strlen($c) < 8)
				$c .= '0';
			$binaryString .= chr(bindec($c));
		//echo $binaryString;
		}
		return $binaryString;
	}
	/**
	 * Decodes some data with the Huffman algorithm. If the dictionnary has not been set yet, an exception is thrown.
	 * @param mixed $data The data to decode. If $data is not a string, an exception is thrown.
	 * @return string A string containing the decoded message.
	 */
	public function	decode($data)
	{
		if (!is_string($data))
			throw new Exception('The data must be a string.');
		if (empty($data))
			return '';
		if ($this->dictionnary === null)
			throw new Exception('The dictionnary has not been set.');
		$binaryString = '';
		$dataLenght = strlen($data);
		$uncompressedData = '';
		for ($i = 0; $i < $dataLenght; ++$i)
		{
			$decbin = decbin(ord($data[$i]));
			while (strlen($decbin) < 8)
				$decbin = '0'.$decbin;
			if (!$i)
				$decbin = substr($decbin, strpos($decbin, '1') + 1);
			if ($i + 1 == $dataLenght)
				$decbin = substr($decbin, 0, strrpos($decbin, '1'));
			$binaryString .= $decbin;
			while (($c = $this->dictionnary->getEntry($binaryString)) !== null)
				$uncompressedData .= $c;
		}
		return $uncompressedData;
	}
	/**
	 * Creates a dictionnary from $data.
	 * @param mixed $data The data used to create the dictionnary. If $data is not a string, it will be serialized.
	 */
	public function	generateDictionnary($data)
	{
		if (!is_string($data))
			$data = serialize($data);
		//echo $data;
		$occurences = array();

		while (isset($data[0]))
		{
			$occurences[] = array(substr_count($data, $data[0]), $data[0]);
			//print_r($occurences);
			$data = str_replace($data[0], '', $data);

		}
		sort($occurences);
		//print_r($occurences);
		while (count($occurences) > 1)
		{
			$row1 = array_shift($occurences);
			//print_r($row1);
			$row2 = array_shift($occurences);
			//print_r($row2);
			$occurences[] = array($row1[0] + $row2[0], array($row1, $row2));
			sort($occurences);

			//print_r($occurences);
		}

		$this->dictionnary = new HuffmanDictionnary();
		 $this->fillDictionnary(is_array($occurences[0][1]) ? $occurences[0][1] : $occurences);
		 //print_r($occurences);
	}
	//print_r($data);
	private function fillDictionnary($data, $value = '')
	{
			//print_r($data);
		if (!is_array($data[0][1]))

			($this->dictionnary->set($data[0][1], $value.'0'));
		else
			//print_r($data[0][1]);
			$this->fillDictionnary($data[0][1], $value.'0');
		if (isset($data[1]))
		{
			if (!is_array($data[1][1]))
				($this->dictionnary->set($data[1][1], $value.'1'));
			else
				($this->fillDictionnary($data[1][1], $value.'1'));
		}
	}
}
?>