<?php
include 'class.db.php';

$db = Db::getInstance();
$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$user_street = $_POST['user_street'];
$user_house = $_POST['user_house'];
$user_building = $_POST['user_building'];
$user_apartment = $_POST['user_apartment'];
$user_flor = $_POST['user_flor'];
$user_comment = $_POST['user_comment'];


$q = "SELECT * FROM users WHERE email = :user_email";// первый запрос - проверяем сходство email
$ret = $db->fetchOne($q, ['user_email' => $user_email], __FILE__);
$n_order = $ret['n_order'];
$id_user = $ret['id'];

if($ret)
{
    $n_order++;
    $q = "UPDATE users SET n_order=:n_order WHERE id = :id_user";// обновление поля id_order
    $db->exec($q,['n_order' => $n_order, 'id_user' =>$id_user],__FILE__);
}else
{
    $q = "INSERT INTO users (name, email, street, house, building, apartment, flor, comment, n_order)
            VALUES(:user_name,:user_email,:user_street,:user_house,:user_building,:user_apartment,:user_flor,:user_comment,1)";
    $db->exec($q, ['user_name' => $user_name,'user_email' => $user_email, 'user_street' => $user_street, 'user_house' => $user_house,
        'user_building' => $user_building, 'user_apartment' => $user_apartment, 'user_flor' => $user_flor,'user_comment' => $user_comment],  __FILE__);
}
$db = Db::getInstance();
$q = "SELECT * FROM users WHERE email = :user_email";
$ret = $db->fetchOne($q, ['user_email' =>$user_email], __FILE__);// повторный запрос, чтобы вывести правильные данные

$id_order = substr((string)$ret['email'],0,5) . (string)$ret['n_order'];// формируем строку - id заказа
$ret['id_order'] = $id_order;

echo "Спасибо, ваш заказ будет доставлен по адресу: улица " . $ret['street'] . ' дом ' . $ret['house'] . ' корпус ' . $ret['building'] .
' квартира ' . $ret['apartment'] . '<br>' . 'Номер вашего заказа: #ID' . $ret['id_order']. '<br>' . 'Это ваш ' . $ret['n_order'] . '-й заказ!';

