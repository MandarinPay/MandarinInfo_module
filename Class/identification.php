<?php
require_once 'XML\Serializer.php';
require_once 'Person.php';

class Identification
{
    public $secret;
    public $id_product;
    public $url_api;

    public function __construct($seret = 'NbtjifAADi', $id_product = '000008-0001-0001', $url_api = 'testing')
    {

        $this->secret = $seret;
        $this->id_product = $id_product;
        $upl_api_array = ['testing' => 'http://id01.mandarinpay.com:18081/infoapi_test',
            'work' => 'http://id01.mandarinpay.com:18081/infoapi'];
        $this->url_api = $upl_api_array[$url_api];
    }

    private function gen_hash($opcode)
    {
        $hash = md5($this->secret . '-' . $opcode . '-' . $this->id_product);
        return $hash;
    }

    private function gen_array_started($array, $opcode, $source = '205')
    {
        $array['Opcode'] = $opcode;
        $array['Product'] = $this->id_product;
        $array['hash'] = $this->gen_hash($opcode);
        $array['source'] = $source;
        return $array;
    }


    private function gen_xml_emission($array)
    {
        $array = $this->gen_array_started($array, '752', '503');
        $result = $this->serialize_xml($array);
        return ($result);
    }

    /**
     * @param $person = new Person('param)
     * @param $sex = param in form your site
     * @param $birthday = param in form your site
     * @param $birthplace = param in form your site
     * @param $mail = param in form your site
     * @param $docissuingdate = param in form your site
     * @param $docissuer = param in form your site
     * @param $docissuercode = param in form your site
     * @param $rawaddress = param in form your site
     * @param $numcard = param in form your site
     * @param $passphrase = param in form your site
     * @return mixed xml array
     * @throws Exception
     */
    public function emission_new_card(Person $person, $sex, $birthday, $birthplace, $mail, $docissuingdate, $docissuer, $docissuercode, $rawaddress, $numcard, $passphrase)
    {
        $array = $person->prepare_user_emission($sex, $birthday,
            $birthplace, $mail,
            $docissuingdate, $docissuer,
            $docissuercode, $rawaddress,
            $numcard, $passphrase);
        $url_transaction = $this->url_api;
        $ch = curl_init($url_transaction);
        $xml = $this->gen_xml_emission($array);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        $result = curl_exec($ch);
        if (curl_errno($ch))
            throw new Exception(curl_error($ch));
        $result = $this->xml_to_array($result);
        if (!empty($result['entities']['provider_desc']) and $result['entities']['provider_desc'] === 'Проведен') {
        } else {
            if (!empty($result['entities']['provider_desc'])) {
                throw new Exception($result['entities']['provider_desc']);
            } else {
                throw new Exception($result['message']);
            }

        }
        return $result;


    }

    private function gen_xml_identification_user($array)
    {


        $array = $this->gen_array_started($array, '761');
        $result = $this->serialize_xml($array);
        return ($result);

    }

    /**
     * @param $person = new Person(param)
     * @param $snils = $snils
     * @return mixed xml result
     * @throws Exception
     */

    public function identification_user(Person $person, $snils)
    {


        $array = $person->prepare_identification_user($snils);
        $url_transaction = $this->url_api;
        $ch = curl_init($url_transaction);
        $xml = $this->gen_xml_identification_user($array);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        $result = curl_exec($ch);
        if (curl_errno($ch))
            throw new Exception(curl_error($ch));
        $result = $this->xml_to_array($result);
        if ($result['message'] === "OK") {
            $result = $result['request_id'];
        } else {
            throw new Exception($result['message']);
        }

        return $result;

    }

    private function gen_xml_end_identification_user($request_id, $pin_code)
    {
        $array = [];
        $array = $this->gen_array_started($array, '762');
        $array['request_id'] = $pin_code;
        $array['pincode'] = $request_id;
        $result = $this->serialize_xml($array);
        return ($result);

    }

    public function end_identification_user($request_id, $pin_code)
    {
        $url_transaction = $this->url_api;
        $ch = curl_init($url_transaction);
        $xml = $this->gen_xml_end_identification_user($request_id, $pin_code);
        echo "<pre>";
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        $result = curl_exec($ch);
        if (curl_errno($ch))
            throw new Exception(curl_error($ch));
        $result = $this->xml_to_array($result);
//        if (!empty($result['reply']) AND $result['reply']['passport_valid'] === true
//            AND $result['reply']['person_valid'] === true
//            AND $result['reply']['snils_valid'] === true
//        ) {
//
//        } else {
//            throw new Exception("<br>passport_valid - " . $result['reply']['passport_valid']
//                . "<br>person_valid - " . $result['reply']['person_valid']
//                . "<br>snils_valid -  " . $result['reply']['snils_valid']);
//        }
        return $result;

    }

    private function serialize_xml($array)
    {

        $options = array(
            XML_SERIALIZER_OPTION_INDENT => '    ',
            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
            "rootName" => "request",
            "linebreak" => "\n",
            "typeHints" => false,
            "addDecl" => true,
            "encoding" => "UTF-8",
            "defaultTagName" => "item",
            "attributesArray" => "_attributes");
        $serializer = &new XML_Serializer($options);
        $result = $serializer->serialize($array);
        return $result;

    }

    private function xml_to_array($array)
    {
        $array = simplexml_load_string($array, "SimpleXMLElement", LIBXML_NOCDATA);
        $array = json_encode($array);
        $array = json_decode($array, TRUE);
        return $array;
    }


}