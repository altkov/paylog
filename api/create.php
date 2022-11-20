<?php
require '../app/DB.php';

$db = DB::get();

$db->insert('INSERT INTO payment (`value`, `subject`, `reason`, `type`, `mood`, `category_id`, `date`) VALUES (
  ?, ?, ?, ?, ?, ?, ?                                                                                 
)', [$_POST['value'], $_POST['subject'], $_POST['reason'], $_POST['type'], $_POST['mood'], $_POST['category'], $_POST['date']]);

if (!empty($_POST['tags'])) {
    $id = $db->lastInsertID();
    $query = 'INSERT INTO payment_tags (`payment_id`, `tag_id`) VALUES ';

    $len = count($_POST['tags']);
    $query .= implode(', ', array_fill(0, $len, '(?, ?)'));

    $params = [];
    foreach ($_POST['tags'] as $tag) {
        $params[] = $id;
        $params[] = $tag;
    }

    $db->insert($query, $params);
}

header('Location: /new.php', true, 301);
exit;
