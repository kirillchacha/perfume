<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);

// Получаем данные POST в формате JSON
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
   

    // Настройка SMTP (раскомментируйте и настройте, если нужно)
    
   //  $mail->isSMTP();                                            // Send using SMTP
   //  $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
   //  $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
   //  $mail->Username   = 'kirillchacha2000@gmail.com';                     // SMTP username
   //  $mail->Password   = 'cjlg onzu yumx vylt';                               // SMTP password
   //  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
   //  $mail->Port       = 465;                                    // TCP port to connect to
    

    // От кого письмо
    $mail->setFrom('kirillchacha2000@gmail.com', 'OPIAT'); // Замените на ваш E-mail

    // Кому отправить
    $mail->addAddress('kirillchacha2000@gmail.com'); // Замените на ваш E-mail

	 if($data["form"]=="Quez") {
		$name = $data['name'];
		$phone = $data['phone'];
		$answers = $data['answers'];
 		// Тема письма
 		$mail->Subject = 'Нові Відповіді із форми опитування';

 		// Тело письма
 		$body = '<h1>Нові Відповіді із форми опитування</h1>';
 		$body .= '<p><strong>Імя:</strong> ' . htmlspecialchars($name) . '</p>';
 		$body .= '<p><strong>Телефон:</strong> ' . htmlspecialchars($phone) . '</p>';
 		$body .= '<h2>Відповіді на питання:</h2>';

 		// Добавляем ответы в письмо
 		foreach ($answers as $question => $answer) {
			  $body .= '<p><strong>' . htmlspecialchars($question) . ':</strong> ' . htmlspecialchars($answer) . '</p>';
 		}
	} elseif($data["form"]=="Payments") {
		$name = $data['name'];
		$surname = $data['surname'];
		$phone = $data['phone'];
		$city = $data['city'];
		$address = $data['address'];
		$paymentMethod = $data['paymentMethod'];
		$comments = $data['comments'];
		$doNotCall = $data['doNotCall'];

		// Тема листа
		$mail->Subject = 'Нові Дані для Оплати';

		// Тіло листа
		$body = '<h1>Деталі нового замовлення</h1>';
		$body .= '<p><strong>Ім\'я:</strong> ' . htmlspecialchars($name) . '</p>';
		$body .= '<p><strong>Прізвище:</strong> ' . htmlspecialchars($surname) . '</p>';
		$body .= '<p><strong>Телефон:</strong> ' . htmlspecialchars($phone) . '</p>';
		$body .= '<p><strong>Місто:</strong> ' . htmlspecialchars($city) . '</p>';
		$body .= '<p><strong>Адреса відділення:</strong> ' . htmlspecialchars($address) . '</p>';
		$body .= '<p><strong>Спосіб оплати:</strong> ' . htmlspecialchars($paymentMethod) . '</p>';
		$body .= '<p><strong>Коментар:</strong> ' . htmlspecialchars($comments) . '</p>';
		$body .= '<p><strong>Передзвонювати:</strong> ' . htmlspecialchars($doNotCall) . '</p>';
	}

    $mail->Body = $body;

    // Отправляем
    try {
        if (!$mail->send()) {
            $message = 'Ошибка при отправке письма';
        } else {
            $message = 'Данные успешно отправлены!';
        }
    } catch (Exception $e) {
        $message = 'Ошибка при отправке письма: ' . $mail->ErrorInfo;
    }
} else {
    $message = 'Нет данных для отправки';
}

$response = ['message' => $message];

// Возвращаем ответ в формате JSON
header('Content-type: application/json');
echo json_encode($response);
?>
