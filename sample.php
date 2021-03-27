
<?PHP

    require_once 'class/telegramBot.php';

    $result = (new telegramBot("1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI"))->pollUpdates()["result"];

    foreach ($result as $key) {
        # code...
        var_dump($key["channel_post"]["text"]);
        echo "<br /><br />";
    }
    // var_dump((new telegramBot("1642261514:AAGXoVxR9ciTFYbyPG9QYukdOhk5Fo_4aPI"))->pollUpdates()["result"]);

?>