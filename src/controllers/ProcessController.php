<?php

namespace App\Controllers;

use App\Database;

header('Content-Type: application/json');

$db = Database::getConnection();

$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');

$errors = [];

if (empty($first_name)) {
    $errors[] = 'A keresztnév megadása kötelező.';
}

if (empty($last_name)) {
    $errors[] = 'A vezetéknév megadása kötelező.';
}

if (!empty($phone)) {
    // Szlovák mobilszám validáció (+4219xxxxxxxx vagy 09xxxxxxxx)
    if (!preg_match('/^(\\+4219\\d{8}|09\\d{8})$/', $phone)) {
        $errors[] = 'Érvénytelen szlovák mobilszám (formátum: +4219xxxxxxxx vagy 09xxxxxxxx).';
    } else {
        // Telefonszám normalizálása '+4219' formátumra
        if (strpos($phone, '09') === 0) {
            $phone = '+421' . substr($phone, 1);
        }

        $stmt = $db->prepare("SELECT id FROM contacts WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = 'A megadott telefonszám már létezik.';
        }

        $stmt->close();
    }
}

if (!empty($email)) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Érvénytelen e-mail cím.';
    } else {
        $stmt = $db->prepare("SELECT id FROM contacts WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = 'A megadott e-mail cím már létezik.';
        }

        $stmt->close();
    }
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'error' => implode(' ', $errors)]);
    exit;
}

$phone = $phone ?: null;
$email = $email ?: null;

$stmt = $db->prepare("INSERT INTO contacts (first_name, last_name, phone, email) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $first_name, $last_name, $phone, $email);

if ($stmt->execute()) {
    $output_phone = $phone !== null ? htmlspecialchars($phone) : '';
    $output_email = $email !== null ? htmlspecialchars($email) : '';

    echo json_encode([
        'success' => true,
        'data' => [
            'first_name' => htmlspecialchars($first_name),
            'last_name' => htmlspecialchars($last_name),
            'phone' => $output_phone,
            'email' => $output_email
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Hiba történt az adatbázis művelet során.']);
}

$stmt->close();
$db->close();
