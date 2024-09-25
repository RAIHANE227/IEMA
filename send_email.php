<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جمع البيانات من النموذج
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $nationalite = $_POST['nationalite'];
    $paysResidence = $_POST['paysResidence'];
    $formationSouhaitee = $_POST['formationSouhaitee'];
    $rentreeEnvisagee = $_POST['rentréeEnvisagée'];

    // إنشاء محتوى الملف النصي
    $content = "Prénom: $prenom\nNom: $nom\nEmail: $email\nNationalité: $nationalite\nPays de résidence: $paysResidence\nFormation souhaitée: $formationSouhaitee\nRentrée envisagée: $rentreeEnvisagee";

    // حفظ المحتوى في ملف نصي
    $fileName = 'inscription.txt';
    file_put_contents($fileName, $content);

    // إعداد البريد الإلكتروني باستخدام PHPMailer
    $mail = new PHPMailer(true);

    try {
        // إعدادات السيرفر
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // استخدم مضيف SMTP الخاص بك
        $mail->SMTPAuth = true;
        $mail->Username = 'ouldacheraihane@gmail.com'; // بريدك الإلكتروني
        $mail->Password = 'raihane2001'; // كلمة مرور البريد الإلكتروني
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // إعدادات المرسل والمتلقي
        $mail->setFrom('ouldacheraihane@gmail.com', 'Nom de votre site');
        $mail->addAddress('recipient_email@example.com', 'Nom du destinataire');

        // المرفق
        $mail->addAttachment($fileName);

        // المحتوى
        $mail->isHTML(true);
        $mail->Subject = 'Nouvelle inscription';
        $mail->Body    = 'Vous avez reçu une nouvelle inscription. Veuillez trouver les détails en pièce jointe.';

        // إرسال البريد الإلكتروني
        $mail->send();
        echo 'Le message a été envoyé avec succès';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur de messagerie: {$mail->ErrorInfo}";
    }

    // حذف الملف بعد الإرسال
    unlink($fileName);
}
?>

