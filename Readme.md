# Документация 

## Menu
1. [Подключение классов](#connection-classes)
2. [Базовая защита передаваемых данных](#protect-value)
3. [Класс Person](#class-person)
    * [Пример создания экземпляра класса](#an-example-of-a-call-and-the-creation-of-an-instance)
    * [Передаваемые параметры](#class-instance-creation-person)
    * [Метод prepare_identification_user](#method-prepare_identification_user)
    * [Метод prepare_user_emission](#method-prepare_user_emission)
4. [Класс Identification](#class-identification)
    * [Пример создания экземпляра класса](#an-example-of-a-call-and-the-creation-of-an-instance-identification)
    * [Передаваемые параметры](#class-instance-creation-identification)
    * [Метод emission_new_card](#method-emission_new_card)
    * [Метод identification_user](#method-identification_user)
    * [Метод end_identification_user](#method-end_identification_user)
5. [Демо](#demo)    
    
    
Класс предназначен для работы с инфошлюзом банка [mandarin](http://mandarinpay.com/) и способен выполнять следующие функции:

    - Эмиссия карты;
    - Упрощенная идентификация старт;
    - Упрощенная идентификация конец.

Подробнее о структуре и необходимых файлах:

    - папка Class содержит основные классы непосредственно для работы с инфошлюзом;
    - папка css содержит файлы, отвечающие за форматирование внешнего вида файла index.php;
    - папка fonts содержит шрифты для index.php;
    - папка js содержит js скрипты и библиотеки для index.php;
    
    - файл index.php содержит 2 простые формы для отправки данных в form.php;
    - файл form.php содержит основную логику работы с классом и возвращением ответа от инфошлюза.

Теперь подробнее о логике файла и доступных методах. Рассмотрим в качестве примера файл вызова form.php.

#### Connection classes

Для начала мы подключаем наши классы из папки Class:
```
spl_autoload_register(function ($class_name) {
    require_once 'Class/' . $class_name . '.php';
});

```
#### Protect value
Первым делом мы проверяем входные данные на спецсимволы функцией:
```
$array_in_form = defender_site($_POST);

function defender_site($array_post)
{
    $array = [];
    foreach ($array_post as $key => $value) {
        $array[$key] = htmlspecialchars($value);
    }
    return $array;

}
```
Это не столь важно, но в качестве примера наглядно показывает, что все ваши данные должны быть защищены.

Далее поговорим о классах и доступных методах.

## Class Person

Класс, отвечающий за данные, передаваемые пользователем: 


#### **An example of a call and the creation of an instance**

```
$person = new Person($array_in_form['family'], $array_in_form['name'], $array_in_form['patronymic'],
    $array_in_form['input_tel'], $array_in_form['input_RFNSPDocid'],
    $array_in_form['input_docseria'], $array_in_form['input_docnum']);
```

#### class instance creation person

Теперь о передаваемых параметрах. Учтите, что все поля являются **ОБЯЗАТЕЛЬНЫМИ**. Если не передать то или иное значение, класс просто сломается.

Подробнее о каждом параметре.


* 1-й параметр — ФАМИЛИЯ
* 2-й параметр — ИМЯ
* 3-й параметр — ОТЧЕСТВО
* 4-й параметр — НОМЕР ТЕЛЕФОНА (обязательно в формате +7ХХХХХХХХХХ, иначе  инфошлюз не примет номер)
* 5-й параметр — RFNSPDocid 
* 6-й параметр — НОМЕР СЕРИИ ДОКУМЕНТА
* 7-й параметр — НОМЕР ДОКУМЕНТА 

Может показаться, что входных параметров очень много, но это сделано для вашего же удобства. Прошу внимательно относиться к тому, что вы передаете, иначе вы можете получить невалидный ответ от инфошлюза. Я постарался реализовать обработку ошибок по максимуму, но не стоит полагаться на неё всецело.

**Методы, нужные для отладки в этом классе (Не рекомендуется использовать их в рабочем проекте как самостоятельные)**

#### method **prepare_identification_user**

```
$person->prepare_identification_user($snils)
```
Принимает единственный параметр snils Пользователя и генерирует массив для упрощенной идентификации типа 

```
Array
(
    [Person] => Array
        (
            [Family] => Василий
            [Name] => Пупкин
            [Patronim] => Иванович
            [Phone] => +7000000000
            [SNILS] => 15497129800
            [Document] => Array
                (
                    [RFNSPDocid] => 21
                    [Docseria] => 7709
                    [Docnum] => 543987
                )

        )

)
```
Используйте данный метод лишь для того, чтобы посмотреть сформированный массив и данные, которые вы передали.

#### method **prepare_user_emission** 

```
$person->prepare_user_emission($sex, $birthday, $birthplace, $mail, $docissuingdate, $docissuer, $docissuercode, $rawaddress, $numcard, $passphrase)
```
За что отвечает каждое поле, будет пояснено позже. Данный метод генерирует массив, необходимый для эммисии карты:

```
Array
(
    [Person] => Array
        (
            [Name] => Пупкин
            [Family] => Василий
            [Patronim] => Иванович
            [Sex] => муж
            [BirthDay] => 2016-07-06
            [BirthPlace] => Москва
            [Email] => mail@example.com
            [Phone] => +7000000000
            [Document] => Array
                (
                    [RFNSPDocid] => 21
                    [Docseria] => 7709
                    [Docnum] => 543987
                    [Docissuingdate] => 2016-07-14
                    [Docissuer] => УПРАВЛЕНИЕ ФЕДЕРАЛЬНОЙ МИГРАЦИОННОЙ СЛУЖБЫ РОССИИ ПО Г. МОСКВЕ
                    [Docissuercode] => 770-661
                )

            [Address] => Array
                (
                    [rawaddress] => Москва, Большая Садовая, д. 10, кв. 50
                )

            [Card] => Array
                (
                    [num] => 43543534
                    [passphrase] => Шарик
                )

        )

)
```

Больше доступных методов у данного класса нету.

## Class Identification

Основной класс по работе с инфошлюзом:

####  **An example of a call and the creation of an instance Identification**

```
$new_identification = new Identification();
```
Можно вызвать без параметров, но **не рекомендуется** делать оптимальный вызов:

```
$new_identification = new Identification('NbtjifAADi','000008-0001-0001','testing');
```
#### class instance creation Identification

Подробнее о каждом из параметров:

* 1-й параметр — это secret, который знаете только вы и который выдается системой;
* 2-й параметр — это номер продукта, который выдается системой;
* 3-й параметр — это выбор базового URL, на данном этапе существует 2 режима:
     * 1-й режим — это testing — подключение к тестовому серверу для отладки;
     * 2-й режим — это work — подключение к рабочему проекту для реальных запросов, а не отладочных.

При вызове  такого метода 

```
$new_identification = new Identification();
```
**Параметрами по умолчанию являются приведенные в примере выше.** Это является  оптимальным быстрым стартом для быстрой отладки вашего проекта.
 
#### method **emission_new_card**

Пример вызова:
```
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
```
Блок оборачивается в Try Cath, т.к. используются исключения внутри класса.

 
 Рассмотрим подробно каждый параметр, который мы передаем:
 
 * 1-й параметр — экземпляр класса [Person](#class-person);
 * 2-й параметр — пол пользователя в формате: муж или жен;
 * 3-й параметр — день рождения в формате: 1928-05-20
 * 4-й параметр — место рождения в формате: Москва.
 * 5-й параметр — адрес электронной почты в формате: mail@example.com;
 * 6-й параметр — дата получения документа в формате: 2016-07-14;
 * 7-й параметр — место получения документа в формате: "УПРАВЛЕНИЕ ФЕДЕРАЛЬНОЙ МИГРАЦИОННОЙ СЛУЖБЫ РОССИИ ПО Г. МОСКВЕ";
 * 8-й параметр — код подразделения, в котором вы получили документ, в формате: 770-661;
 * 9-й параметр — адрес прописки (проживания) в формате: "Москва, Большая Садовая, д. 10, кв. 50";
 * 10-й параметр — номер карточки в формате: 4595153453412;
 * 11-й параметр — кодовое слово, например: Шарик.
 
 Результатом операции будет массив следующего вида: 
```
Array
 (
     [code] => 1100
     [hash] => 14b8f22946e24405b8d352e3850ff845
     [entities] => Array
         (
             [provider_desc] => Проведен
             [actionName] => FINDPAY
             [billNumber] => 1234567890123456789
             [provider_code] => Array
                 (
                 )
 
             [result_desc] => Проведен
             [result_finish] => true
             [result_code] => 1
         )
 
     [request_id] => 13567
     [date] => 2016-07-28T11:53:49+00:00
     [message] => OK
 )
```
При возникновении ошибок сообщения об их наличии выведутся на экран.

 
#### method **identification_user** 

Пример вызова.

```
    try {
            $identification_user = $new_identification->identification_user($person, $array_in_form['input_snils']);
        } catch (Exception $e) {
            echo 'Ошибка в данных: ', $e->getMessage(), "\n";
            exit(1);

        }
```
Блок оборачивается в Try Cath, т.к. используются исключения внутри класса.

Передаваемые параметры:

 * 1-й параметр — экземпляр класса [Person](#class-person);
 * 2-й параметр — SNILS пользователя.
 
 Результатом данной операции будет число:
```
13579
```
при успешной операции.

В противном случае приложение выведет данные, в которых была допущена ошибка.

#### method **end_identification_user**

Пример вызова:
```
  try {
                $end_identification_user = $new_identification->end_identification_user($_POST['pin_code'], $_POST['request_id']);
            } catch (Exception $e) {
                echo 'Ошибка в данных: ', $e->getMessage(), "\n";
                exit(1);
            }
```
Блок оборачивается в Try Cath, т.к. используются исключения внутри класса.

Передаваемые параметры:
 
  * 1-й параметр — 6-значный пин-код, который был отослан пользователю на телефон и введен в вашем приложении;
  * 2-й параметр — request_id, полученый в начале идентификации.

Результат операции — массив:
```
Array
(
    [date] => 2016-07-28T12:15:28+00:00
    [reply] => Array
        (
            [passport_valid] => false/true
            [person_valid] => false/true
            [snils_valid] => false/true
        )

    [message] => OK
    [code] => 1100
    [request_id] => 13580
)
```
В противном случае приложение выведет данные. в которых была допущена ошибка.

### Demo
Демо пример рабочего приложения, полностью настроенного для ознакомления:
* в index.php — формы для отправки данных;
* в form.php  — логика по взаимодействию с классом.
 