<?php

/**
 * Created by PhpStorm.
 * User: Kage-Chan
 * Date: 25.07.2016
 * Time: 20:54
 */
class Person
{
    public $name;
    public $family;
    public $patronim;
    public $phone;
    public $rfnspdocid;
    public $docseria;
    public $docnum;

    public function __construct($name, $family, $patronim, $phone, $rfnspdocid, $docseria, $docnum)
    {
        $this->name = $name;
        $this->family = $family;
        $this->patronim = $patronim;
        $this->phone = $phone;
        $this->rfnspdocid = $rfnspdocid;
        $this->docseria = $docseria;
        $this->docnum = $docnum;
    }

    public function prepare_identification_user($snils)
    {
        $person['Family'] = $this->family;
        $person['Name'] = $this->name;
        $person['Patronim'] = $this->patronim;
        $person['Phone'] = $this->phone;
        $person['SNILS'] = $snils;
        $document['RFNSPDocid'] = $this->rfnspdocid;
        $document['Docseria'] = $this->docseria;
        $document['Docnum'] = $this->docnum;
        $array['Person'] = $person;
        $array['Person']['Document'] = $document;
        return $array;

    }

    private function gen_array_emission_persone($sex, $birthday, $birthplace, $mail)
    {
        $person['Name'] = $this->name;
        $person['Family'] = $this->family;;
        $person['Patronim'] = $this->patronim;
        $person['Sex'] = $sex;
        $person['BirthDay'] = $birthday;
        $person['BirthPlace'] = $birthplace;
        $person['Email'] = $mail;
        $person['Phone'] = $this->phone;
        return $person;
    }

    private function gen_array_emission_document($docissuingdate, $docissuer, $docissuercode)
    {
        $documents['RFNSPDocid'] = $this->rfnspdocid;
        $documents['Docseria'] = $this->docseria;
        $documents['Docnum'] = $this->docnum;
        $documents['Docissuingdate'] = $docissuingdate;
        $documents['Docissuer'] = $docissuer;
        $documents['Docissuercode'] = $docissuercode;
        return $documents;
    }

    private function gen_array_emission_adress($rawaddress)
    {
        $adress['rawaddress'] = $rawaddress;
        return $adress;


    }

    private function gen_array_emission_card($numcard, $passphrase)
    {
        $card['num'] = $numcard;
        $card['passphrase'] = $passphrase;
        return $card;
    }

    public function prepare_user_emission($sex, $birthday, $birthplace, $mail, $docissuingdate, $docissuer, $docissuercode, $rawaddress, $numcard, $passphrase)
    {

        $person=$this->gen_array_emission_persone($sex, $birthday, $birthplace,$mail);
        $documents=$this->gen_array_emission_document($docissuingdate, $docissuer, $docissuercode);
        $adress=$this->gen_array_emission_adress($rawaddress);
        $card=$this->gen_array_emission_card($numcard, $passphrase);
        $new_araay['Person'] = $person;
        $new_araay['Person']['Document'] = $documents;
        $new_araay['Person']['Address'] = $adress;
        $new_araay['Person']['Card'] = $card;
        return $new_araay;
    }

}