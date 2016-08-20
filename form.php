<?php
spl_autoload_register(function ($class_name) {
    require_once 'Class/' . $class_name . '.php';
});

$array_in_form = defender_site($_POST);


$new_identification = new Identification();
$person = new Person($array_in_form['family'], $array_in_form['name'], $array_in_form['patronymic'],
    $array_in_form['input_tel'], $array_in_form['input_RFNSPDocid'],
    $array_in_form['input_docseria'], $array_in_form['input_docnum']);


$input_operation = $array_in_form['operation'];
switch ($input_operation) {
    case 'emission':
        try {
            $emission_user = $new_identification->emission_new_card($person, $array_in_form['input_sex'],
                $array_in_form['input_birthday'],
                $array_in_form['input_birthplace'],
                $array_in_form['input_mail'],
                $array_in_form['input_docissuingdate'],
                $array_in_form['input_docissuer'],
                $array_in_form['input_docissuercode'],
                $array_in_form['input_adress'],
                $array_in_form['input_card_num'],
                $array_in_form['input_secret']);
        } catch (Exception $e) {
            echo "<b>Ошибка в данных:</b>" . $e->getMessage(), "\n";
            exit(1);
        }
        echo "<pre>";
        echo "Успешно!";
        break;


    case 'identification_user':
        ////START identification
        try {
            $identification_user = $new_identification->identification_user($person, $array_in_form['input_snils']);
        } catch (Exception $e) {
            echo 'Ошибка в данных: ', $e->getMessage(), "\n";
            exit(1);

        }
        echo "<pre>";
        print_r($identification_user);
        /////GET A PIN-CODE

        echo "<form action =" . ($_SERVER["PHP_SELF"]) . " METHOD=\"POST\">";
        echo "<input type=\"hidden\" name=\"operation\" value=\"end_identification\">";
        echo "<input type=\"hidden\" name=\"request_id\" value={$identification_user}>";
        echo "<input type=\"text\" name=\"pin_code\" placeholder=\"123456\" pattern=\"[0-9]{6}\">";
        echo "<button type=\"submit\" value=\"Отправить\">Отправить</button>";
        echo "</form>";

        break;

    case 'end_identification' :
        ///////END identification
        if (!empty($_POST['pin_code'])) {
            try {
                $end_identification_user = $new_identification->end_identification_user($_POST['pin_code'], $_POST['request_id']);
            } catch (Exception $e) {
                echo 'Ошибка в данных: ', $e->getMessage(), "\n";
                exit(1);
            }
        }
        echo "<pre>";
        print_r($end_identification_user);
        echo "Успешно!";

}


function defender_site($array_post)
{
    $array = [];
    foreach ($array_post as $key => $value) {
        $array[$key] = htmlspecialchars($value);
    }
    return $array;

}