<?php

// CAPTCHA her sayfa yüklendiğinde veya form gönderiminden sonra yeniden oluşturulsun
$num1 = rand(1, 10);
$num2 = rand(1, 10);
$operators = ['+', '-', '*']; // Bölme işlemi kaldırıldı
$operator = $operators[array_rand($operators)]; // Rastgele işlem seç

// İşlemi gerçekleştir ve doğru cevabı hesapla
switch ($operator) {
    case '+':
        $answer = $num1 + $num2;
        break;
    case '-':
        if ($num1 < $num2) {
            list($num1, $num2) = [$num2, $num1];
        }
        $answer = $num1 - $num2;
        break;
    case '*':
        $answer = $num1 * $num2;
        break;
}

$_SESSION['captcha_answer'] = $answer; // Doğru cevabı sakla
$_SESSION['captcha_question'] = "$num1 $operator $num2"; // Soruyu sakla
