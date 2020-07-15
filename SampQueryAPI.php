<?php


class SampQueryAPI
{

private $rSocket = false;
private $aServer = array();

public function __construct($sServer, $iPort = 7777)
{

$this->aServer[0] = $sServer;
$this->aServer[1] = $iPort;

$this->rSocket = fsockopen('udp://'.$this->aServer[0], $this->aServer[1], $iError, $sError, 2);

$sPacket = 'SAMP';
$sPacket .= chr(strtok($this->aServer[0], '.'));
$sPacket .= chr(strtok('.'));
$sPacket .= chr(strtok('.'));
$sPacket .= chr(strtok('.'));
$sPacket .= chr($this->aServer[1] & 0xFF);
$sPacket .= chr($this->aServer[1] >> 8 & 0xFF);
$sPacket .= 'p4150';
		
fwrite($this->rSocket, $sPacket);
		
if(fread($this->rSocket, 15))
{
$this->aServer[4] = true;
}
else
{
$this->aServer[4] = false;
}
}
	
public function isOnline()
{
return isset($this->aServer[4]) ? $this->aServer[4] : false;
}

public function getInfo() {
@fwrite($this->rSocket, $this->createPacket('i'));

fread($this->rSocket, 11);
	
$aDetails['password'] = (integer) ord(fread($this->rSocket, 1));
$aDetails['players'] = (integer) $this->toInteger(fread($this->rSocket, 2));
$aDetails['maxplayers'] = (integer) $this->toInteger(fread($this->rSocket, 2));
$iStrlen = ord(fread($this->rSocket, 4));

if(!$iStrlen) return -1;
		
$aDetails['hostname'] = (string) fread($this->rSocket, $iStrlen);
$iStrlen = ord(fread($this->rSocket, 4));
$aDetails['gamemode'] = (string) fread($this->rSocket, $iStrlen);
$iStrlen = ord(fread($this->rSocket, 4));
$aDetails['mapname'] = (string) fread($this->rSocket, $iStrlen);	

return $aDetails;

}

public function getDetailedPlayers()
{
@fwrite($this->rSocket, $this->createPacket('d'));
fread($this->rSocket, 11);
	
$iPlayerCount = ord(fread($this->rSocket, 2));
$aDetails = array();
		
for($iIndex = 0; $iIndex < $iPlayerCount; ++$iIndex)
{
$aPlayer['playerid'] = (integer) ord(fread($this->rSocket, 1));
			
$iStrlen = ord(fread($this->rSocket, 1));
$aPlayer['nickname'] = (string) fread($this->rSocket, $iStrlen);
$aPlayer['score'] = (integer) $this->toInteger(fread($this->rSocket, 4));
$aPlayer['ping'] = (integer) $this->toInteger(fread($this->rSocket, 4));
			
$aDetails[] = $aPlayer;
unset($aPlayer);
}
return $aDetails;
}

private function toInteger($sData)
{
$iInteger = 0;
$iInteger += (ord($sData[0]));
 
 		if(isset($sData[1]))
 		{
$iInteger += (ord($sData[1]) << 8);
 		}
 		
 		if(isset($sData[2]))
 		{
$iInteger += (ord($sData[2]) << 16);
 		}
 		
 		if(isset($sData[3]))
 		{
$iInteger += (ord($sData[3]) << 24);
 		}
 		
if($iInteger >= 4294967294)
{
$iInteger -= 4294967296;
}
 		
return $iInteger;
}
	
	
private function createPacket($sPayload)
{
$sPacket = 'SAMP';
$sPacket .= chr(strtok($this->aServer[0], '.'));
$sPacket .= chr(strtok('.'));
$sPacket .= chr(strtok('.'));
$sPacket .= chr(strtok('.'));
$sPacket .= chr($this->aServer[1] & 0xFF);
$sPacket .= chr($this->aServer[1] >> 8 & 0xFF);
$sPacket .= $sPayload;

return $sPacket;
}
}

?>