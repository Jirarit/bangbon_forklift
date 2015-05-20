<?php
/*
	Class COLOR Changes Logs
	=======================
{{{
	Use to service constant for text/background color in textmode

	Date Time		Descriptions
	-----------		-----------------------------------------------------------
	150207.1742		First create this class
	150320.1134		Revise code for easy reading and folding

	-----------		-----------------------------------------------------------
}}}*/
class color {

	const Reset = "\x1B[0m";
	const ClearScreen = "\x1B[2J\x1B[0;0H";

	//---- Text Foreground --------------------
	const fgBlack = "\x1B[30m";
	const fgRed = "\x1B[31m";
	const fgGreen = "\x1B[32m";
	const fgYellow = "\x1B[33m";
	const fgBlue = "\x1B[34m";
	const fgMagenta = "\x1B[35m";
	const fgCyan = "\x1B[36m";
	const fgWhite = "\x1B[37m";

	const fgBlackB = "\x1B[30;1m";
	const fgRedB = "\x1B[31;1m";
	const fgGreenB = "\x1B[32;1m";
	const fgYellowB = "\x1B[33;1m";
	const fgBlueB = "\x1B[34;1m";
	const fgMagentaB = "\x1B[35;1m";
	const fgCyanB = "\x1B[36;1m";
	const fgWhiteB = "\x1B[37;1m";

	const fgNormal = "\x1B[39m";

	//---- Text Background -------------------
	const bgBlack = "\x1B[40m";
	const bgRed = "\x1B[41m";
	const bgGreen = "\x1B[42m";
	const bgYellow = "\x1B[43m";
	const bgBlue = "\x1B[44m";
	const bgMagenta = "\x1B[45m";
	const bgCyan = "\x1B[46m";
	const bgWhite = "\x1B[47m";

	const bgBlackB = "\x1B[40;1m";
	const bgRedB = "\x1B[41;1m";
	const bgGreenB = "\x1B[42;1m";
	const bgYellowB = "\x1B[43;1m";
	const bgBlueB = "\x1B[44;1m";
	const bgMagentaB = "\x1B[45;1m";
	const bgCyanB = "\x1B[46;1m";
	const bgWhiteB = "\x1B[47;1m";

	const bgNormal = "\x1B[49m";

	public static function CodeTable() {	/*{{{
		*/
		$fgName = array('fgBlack','fgRed','fgGreen','fgYellow','fgBlue','fgMagenta','fgCyan','fgWhite');
		$fgNameB = array('fgBlackB','fgRedB','fgGreenB','fgYellowB','fgBlueB','fgMagentaB','fgCyanB','fgWhiteB');
		$bgName = array('bgBlack','bgRed','bgGreen','bgYellow','bgBlue','bgMagenta','bgCyan','bgWhite');
		$bgNameB = array('bgBlackB','bgRedB','bgGreenB','bgYellowB','bgBlueB','bgMagentaB','bgCyanB','bgWhiteB');
		$maxW=0;
		foreach($fgName as $s) if (strlen($s)>$maxW) $maxW=strlen($s);
		foreach($fgNameB as $s) if (strlen($s)>$maxW) $maxW=strlen($s);
		foreach($bgName as $s) if (strlen($s)>$maxW) $maxW=strlen($s);
		foreach($bgNameB as $s) if (strlen($s)>$maxW) $maxW=strlen($s);
		$buff = self::Reset.PHP_EOL;
		foreach($fgName as $i=>$s) $buff.='['."\x1B[3{$i}m".str_pad($s,$maxW,' ',STR_PAD_BOTH)."\x1B[39m".']';	$buff.=self::Reset.PHP_EOL;
		foreach($fgNameB as $i=>$s) $buff.='['."\x1B[3{$i};1m".str_pad($s,$maxW,' ',STR_PAD_BOTH)."\x1B[39m".']';	$buff.=self::Reset.PHP_EOL;
		$buff .= PHP_EOL;
		foreach($bgName as $i=>$s) $buff.='['."\x1B[4{$i}m".str_pad($s,$maxW,' ',STR_PAD_BOTH)."\x1B[49m".']';	$buff.=self::Reset.PHP_EOL;
		foreach($bgNameB as $i=>$s) $buff.='['."\x1B[4{$i};1m".str_pad($s,$maxW,' ',STR_PAD_BOTH)."\x1B[49m".']';	$buff.=self::Reset.PHP_EOL;
		$buff .= self::Reset.PHP_EOL;
		return($buff);

	}	/*}}}*/
}
?>
