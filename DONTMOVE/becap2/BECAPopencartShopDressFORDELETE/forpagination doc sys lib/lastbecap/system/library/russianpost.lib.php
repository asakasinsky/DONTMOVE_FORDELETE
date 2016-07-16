<?php
/**
 * Russian Post tracking API PHP library
 * @author InJapan Corp. <max@injapan.ru>
 * @author Alexander Toporkov <toporchillo@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$russianpostRequiredExtensions = array('SimpleXML', 'curl', 'pcre');
foreach($russianpostRequiredExtensions as $russianpostExt) {
	if (!extension_loaded($russianpostExt)) {
		throw new RussianPostSystemException('Для отслеживания отправлений Почты России надо установить PHP-расширение ' . $russianpostExt);
	}
}

class RussianPostAPI {
  /**
   * SOAP service URL
   */
  const SOAPEndpoint = 'https://tracking.russianpost.ru/rtm34';

  protected $login;
  protected $password;
  
  protected $proxyHost;
  protected $proxyPort;
  protected $proxyAuthUser;
  protected $proxyAuthPassword;

  /**
   * Constructor. Pass proxy config here.
   * @param string $login
   * @param string $password
   * @param string $proxyHost
   * @param string $proxyPort
   * @param string $proxyAuthUser
   * @param string $proxyAuthPassword
   */
  public function __construct($login = '', $password = '', $proxyHost = "", $proxyPort = "", $proxyAuthUser = "", $proxyAuthPassword = "") {
	$this->login = $login;
	$this->password = $password;
	
    $this->proxyHost         = $proxyHost;
    $this->proxyPort         = $proxyPort;
    $this->proxyAuthUser     = $proxyAuthUser;
    $this->proxyAuthPassword = $proxyAuthPassword;
  }

  /**
   * Returns tracking data
   * @param string $trackingNumber tracking number
   * @return array of RussianPostTrackingRecord
   */
  public function getOperationHistory($trackingNumber) {
    $trackingNumber = trim($trackingNumber);
    if (!preg_match('/^[0-9]{14}|[A-Z]{2}[0-9]{9}[A-Z]{2}$/', $trackingNumber)) {
		throw new RussianPostArgumentException('Неверный формат трек-номера: ' . $trackingNumber);
    }
	
    $data = $this->makeRequest($trackingNumber);
    $data = $this->parseResponse($data);

    return $data;
  }

  protected function parseResponse($raw) {
    $xml = @simplexml_load_string($raw);
    
    if (!is_object($xml)) {
		throw new RussianPostDataException("SOAP-сервис вернул невалидный XML");
	}

    $ns = $xml->getNamespaces(true);

	$nsKeys = array();
	$i=0;
    foreach($ns as $key => $dummy) {
		if (strpos($key, 'ns') === 0) {
			$nsKeys[$i] = $key;
			$i++;
		}
	}

    if (!count($nsKeys)) {
		throw new RussianPostDataException("Некорректное пространство имен в XML-ответе");
    }

    if ($xml->children($ns['S'])->Body && $xml->children($ns['S'])->Body->children($ns['S'])->Fault) {
		$err_header = $xml->children($ns['S'])->Body->children($ns['S'])->Fault->children($ns['S'])->Reason->children($ns['S'])->Text;
		$err_body = (string) $xml->children($ns['S'])->Body->children($ns['S'])->Fault->children($ns['S'])->Detail->children($ns[$nsKeys[0]])->AuthorizationFaultReason;
		throw new RussianPostDataException($err_header.': '.$err_body);
	}

    if (!($xml->children($ns['S'])->Body &&
			$records = $xml->children($ns['S'])->Body->children($ns[$nsKeys[0]])->getOperationHistoryResponse->children($ns[$nsKeys[1]])->OperationHistoryData->children($ns[$nsKeys[1]])->historyRecord)) {
		throw new RussianPostDataException("XML-ответ не содержит данных со статусами почтового отправления");
	}

    $out = array();
    foreach($records as $rec) {
		$outRecord = new RussianPostTrackingRecord();
		$outRecord->operationType            = (string) $rec->OperationParameters->OperType->Name;
		$outRecord->operationTypeId          = (int) $rec->OperationParameters->OperType->Id;

		$outRecord->operationAttribute       = (string) $rec->OperationParameters->OperAttr->Name;
		$outRecord->operationAttributeId     = (int) $rec->OperationParameters->OperAttr->Id;

		$outRecord->operationPlacePostalCode = (string) $rec->AddressParameters->OperationAddress->Index;
		$outRecord->operationPlaceName       = (string) $rec->AddressParameters->OperationAddress->Description;

		$outRecord->destinationPostalCode    = (string) $rec->AddressParameters->DestinationAddress->Index;
		$outRecord->destinationAddress       = (string) $rec->AddressParameters->DestinationAddress->Description;

		$outRecord->operationDate            = (string) $rec->OperationParameters->OperDate;

		$outRecord->itemWeight               = round(floatval($rec->ItemParameters->Mass) / 1000, 3);
		$outRecord->declaredValue            = round(floatval($rec->FinanceParameters->Value) / 100, 2);
		$outRecord->collectOnDeliveryPrice   = round(floatval($rec->FinanceParameters->Payment) / 100, 2);

		$out[] = $outRecord;
    }

    return $out;
  }

  protected function makeRequest($trackingNumber) {
    $channel = curl_init(self::SOAPEndpoint);

    $data = <<<EOD
<?xml version='1.0' encoding='UTF-8'?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:oper="http://russianpost.org/operationhistory" xmlns:data="http://russianpost.org/operationhistory/data" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soap:Header/>
   <soap:Body>
      <oper:getOperationHistory>
         <data:OperationHistoryRequest>
            <data:Barcode>$trackingNumber</data:Barcode>
            <data:MessageType>0</data:MessageType>
            <data:Language>RUS</data:Language>
         </data:OperationHistoryRequest>
         <data:AuthorizationHeader soapenv:mustUnderstand="1">
            <data:login>$this->login</data:login>
            <data:password>$this->password</data:password>
         </data:AuthorizationHeader>
      </oper:getOperationHistory>
   </soap:Body>
</soap:Envelope>
EOD;

    curl_setopt_array($channel, array(
      CURLOPT_POST           => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CONNECTTIMEOUT => 10,
      CURLOPT_TIMEOUT        => 10,
      CURLOPT_POSTFIELDS     => $data,
      CURLOPT_HTTPHEADER     => array(
        'Content-Type: application/soap+xml; charset=utf-8',
        'Content-Length: '.strlen($data)
      ),
    ));

    if (!empty($this->proxyHost) && !empty($this->proxyPort)) {
      curl_setopt($channel, CURLOPT_PROXY, $this->proxyHost . ':' . $this->proxyPort);
    }

    if (!empty($this->proxyAuthUser)) {
      curl_setopt($channel, CURLOPT_PROXYUSERPWD, $this->proxyAuthUser . ':' . $this->proxyAuthPassword);
    }

    $result = curl_exec($channel);
	//header('Content-Type: text/xml; charset=utf-8');
	//echo $result."\n\n";
    if ($errorCode = curl_errno($channel)) {
      throw new RussianPostChannelException(curl_error($channel), $errorCode);
    }
    return $result;    
  }
}

/**
 * One record in tracking history
 */
class RussianPostTrackingRecord {
	/**
	* Operation type, e.g. Импорт, Экспорт and so on
	* @var string
	*/
	public $operationType;

	/**
	* Operation type ID
	* @var int
	*/
	public $operationTypeId;

	/**
	* Operation attribute, e.g. Выпущено таможней
	* @var string
	*/
	public $operationAttribute;

	/**
	* Operation attribute ID
	* @var int
	*/
	public $operationAttributeId;

	/**
	* ZIP code of the postal office where operation took place
	* @var string
	*/
	public $operationPlacePostalCode;

	/**
	* Name of the postal office where operation took place
	* @var [type]
	*/
	public $operationPlaceName;

	/**
	* Operation date in ISO 8601 format
	* @var string
	*/
	public $operationDate;

	/**
	* Item wight (kg)
	* @var float
	*/
	public $itemWeight;

	/**
	* Declared value of the item in rubles
	* @var float
	*/
	public $declaredValue;

	/**
	* COD price of the item in rubles
	* @var float
	*/
	public $collectOnDeliveryPrice;

	/**
	* Postal code of the place item addressed to
	* @var string
	*/
	public $destinationPostalCode;

	/**
	* Destination address of the place item addressed to
	* @var string
	*/
	public $destinationAddress;
}

class RussianPostException         extends Exception { }
class RussianPostArgumentException extends RussianPostException { }
class RussianPostSystemException   extends RussianPostException { }
class RussianPostChannelException  extends RussianPostException { }
class RussianPostDataException     extends RussianPostException { }
