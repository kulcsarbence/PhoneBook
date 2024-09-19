<?php

namespace App\Controllers;

use App\Database;
use App\View;

$db = Database::getConnection();

$sql = "SELECT * FROM contacts ORDER BY id DESC";
$result = $db->query($sql);

$contacts = $result->fetch_all(MYSQLI_ASSOC);

View::render('home.twig', ['contacts' => $contacts]);
