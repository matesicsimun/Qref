<?php

$userData = [
  'name'=>"Šimun",
  'surname'=>"Matešić",
  'email'=>"smatesic@gmail.com",
  'password' => 'prva12349',
  'password2'=>'drugalozinka321',
  'birthday'=>'1997-08-01'
];

$valid = true;

// Validate name
$namePattern = "/^[ŠšĐđĆćČčŽžA-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+([\ A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+)*/u";
$valid = $valid && preg_match($namePattern, $userData['name']);
var_dump($valid);
// Validate surname
$valid = $valid && preg_match($namePattern, $userData['surname']);
var_dump($valid);

// Validate password
$passwordPattern = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/";
$valid = $valid && preg_match($passwordPattern, $userData['password']);
var_dump($valid);
$valid = $valid && preg_match($passwordPattern, $userData['password2']);
var_dump($valid);
// Validate email
$valid = $valid && filter_var($userData['email'], FILTER_VALIDATE_EMAIL);


var_dump($valid);
$valid = $valid && validateDate($userData['birthday']);

var_dump($valid);

function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);

    return $d && $d->format($format) == $date;
}