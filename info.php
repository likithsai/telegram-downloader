<?php
    session_start();
    require_once 'config/config.php';
    require_once 'class/TelegramBot.php';

    //  session management
    if (!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit();
    }

    $bot_id = $_GET['id'];
    $chat_id = $_GET['chat_id'];
    $uid = $_SESSION['session_user_id'];

    if (isset($_GET['task']))  {
        $task = $_GET['task'];

        if(isset($_GET['msgid'])) {
            $msg_id = $_GET['msgid'];
        }

        switch (strtolower($task)) {
            case 'delete':
                $delete_msg = (new telegramBot($bot_id))->deleteMessage($chat_id, $msg_id);
                if ($delete_msg["result"]) {
                    $db->query("DELETE FROM t_messages WHERE telegram_msg_id=$msg_id");
                }
                break;

            case 'export':
                if(isset($_GET['format'])) {
                    if(strtolower($_GET['format']) == 'excel') {
                        exportToExcel($db);
                    }
                }
                break;    

            case 'schedulestart':
                $db->query("UPDATE t_messages SET msg_schedule='1' WHERE telegram_msg_id='$msg_id'");
                break;

            case 'scheduleend':
                $db->query("UPDATE t_messages SET msg_schedule='0' WHERE telegram_msg_id='$msg_id'");
                break;

            case 'default':
                break;
        }
    }

    $sql = "SELECT * FROM t_user WHERE u_id='$uid'";
    $sqlData = $db->query($sql)->fetchArray();
    $tmsgsql = "SELECT * FROM t_messages WHERE msg_uid=$uid AND msg_botid='$bot_id'";
    $sqlDataMsg = $db->query($tmsgsql)->fetchAll();
    $tmgrsql = "SELECT * FROM t_manager WHERE m_uid='$bot_id' AND m_userid=$uid";
    $sqlDataMgr = $db->query($tmgrsql)->fetchAll();

    //  send message
    if (isset($_POST['send-message-btn']) && isset($_POST['send-message-text'])) {
        $msg_content = html_entity_decode($_POST['send-message-text']);
        $send_msg_status = (new telegramBot($bot_id))->sendMessage($chat_id, $msg_content, 'html', true);
        if (!empty($send_msg_status)) {
            $tel_msg_id = $send_msg_status["result"]["message_id"];
            $db->query("INSERT INTO t_messages (msg_content, telegram_msg_id, msg_uid, msg_botid) VALUES('$msg_content', $tel_msg_id, $uid, '$bot_id')");
        }
    }

    //  schedule message
    if (isset($_POST['schedule-message-btn']) && isset($_POST['send-message-text'])) {
        $msg_content = html_entity_decode($_POST['send-message-text']);
        $db->query("INSERT INTO t_messages (msg_content, msg_uid, msg_botid, msg_schedule) VALUES('$msg_content', $uid, '$bot_id', 1)");
    }

    //  enable scheduler
    if (isset($_POST['enable_scheduler'])) {
        $db->query("UPDATE t_manager SET m_schedule='1' WHERE m_uid='$bot_id'");
    }

    //  disable scheduler
    if (isset($_POST['disable_scheduler'])) {
        $db->query("UPDATE t_manager SET m_schedule='0' WHERE m_uid='$bot_id'");
    }

    function getURL() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    //  function to check for valid JSON
    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo $bot_id; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body class="bg-light">
    <header>
         <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
            <div class="container">
                <a href="dashboard.php" class="navbar-brand d-flex align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
                  </svg>
                  <span>&nbsp;</span>
                  <strong>Telegram Manager</strong>
                </a>
               <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="navbar-collapse collapse" id="navbarCollapse">
                  <div class="navbar-nav ml-auto">
                     <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-person"></i>
                           <?php echo $sqlData['u_username']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown03">
                           <a class="dropdown-item" href="settings">
                                <i class="bi bi-gear"></i>
                                <span>&nbsp;</span>
                                <span>Settings</span>
                           </a>
                           <a class="dropdown-item" href="dashboard.php?task=logout">
                                <i class="bi bi-box-arrow-left"></i>
                                <span>&nbsp;</span>
                                <span>Logout</span>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </nav>
         <section class="jumbotron bg-dark text-white mb-0 p-0 rounded-0">
            <div class="container py-5 justify-content-start d-md-flex d-sm-block text-center text-md-left">
                <div class="d-block mr-md-4 mr-sm-0 mb-4 mb-md-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-collection" viewBox="0 0 16 16">
                        <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"></path>
                    </svg>
                </div>
                <div class="d-block">
                    <h3><?php echo (new telegramBot($bot_id))->getMe() ["result"]["first_name"]; ?></h3>
                    <p class="lead">@<?php echo (new telegramBot($bot_id))->getMe() ["result"]["username"]; ?></p>
                </div>
            </div>
        </section>
    </header>
    <main>
        <nav class="sticky-top navbar navbar-expand-md navbar-light bg-light border shadow-sm">
            <div class="container">
                <div class="nav nav-pills flex-nowrap text-center d-flex justify-content-between overflow-auto" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-contact-tab" data-toggle="tab" href="#bot-info" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <i class="bi bi-info-circle-fill"></i>
                        <span class="ml-1">Info</span>
                    </a>
                    <a class="nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                        <i class="bi bi-chat-left-dots-fill"></i>
                        <span class="ml-1">Messages</span>
                    </a>
                    <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <i class="bi bi-clock-fill"></i>
                        <span class="ml-1">Schedule</span>
                    </a>
                    <a class="nav-link" data-toggle="tab" href="#bot-settings" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <i class="bi bi-gear-fill"></i>
                        <span class="ml-1">Settings</span>
                    </a>
                </div>
            </div>
        </nav>

        <section class="container my-md-4">
            <div class="tab-content" id="nav-tabContent">
                <div class="row tab-pane fade min-vh-100 active show" id="bot-info">
                    <div class="container row m-0 p-0">  
                    <?php
                        $json = (new telegramBot($bot_id))->getMe() ["result"];
                        foreach ($json as $key => $value) {
                            echo '<div class="card col-md-12 shadow border">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">' . $key . '</h5>
                                        <p class="card-text text-muted">' . $value . '</p>
                                        </form>
                                    </div>
                                </div>';
                        }

                        $description = (new telegramBot($bot_id))->getChat($chat_id) ["result"]["description"];
                        $invite_link = (new telegramBot($bot_id))->getChat($chat_id) ["result"]["invite_link"];
                        echo '<div class="card col-md-12 shadow border">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Description</h5>
                                        <p class="card-text text-muted">' . $description . '</p>
                                        </form>
                                    </div>
                                </div>
                                <div class="card col-md-12 shadow border">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Invite Link</h5>
                                        <p class="card-text text-muted"><a href="' . $invite_link . '">' . $invite_link . '</a></p>
                                        </form>
                                    </div>
                                </div>';
                    ?>
                    </div>
                </div>
                <div class="row tab-pane fade min-vh-100" id="nav-home">
                <?php
                    if (!empty($sqlDataMsg)) {
                        echo '<div class="list-group rounded-lg overflow-hidden shadow">';
                        foreach ($sqlDataMsg as $msg) {
                            $content = $msg['msg_content'];
                            $date = $msg['msg_date'];
                            $t_message_id = $msg['telegram_msg_id'];
                            $username = $db->query("SELECT u_username FROM t_user WHERE u_id='" . $msg['msg_uid'] . "'")->fetchAll() [0]["u_username"];

                            echo '<div class="container row m-0 p-0">
                                            <div class="card col-md-12 shadow border">
                                                <div class="card-body">
                                                    <div class="d-md-flex d-sm-block justify-content-between">
                                                        <div class="d-block">
                                                            <h5 class="card-title font-weight-bold">
                                                                <i class="bi bi-people"></i>
                                                                <span>' . $username . '</span>
                                                            </h5>
                                                            <p class="card-text text-muted text-truncate">' . $content . '</p>
                                                        </div>
                                                        <div class="d-block mt-3 mt-md-0">                                                
                                                            <p class="d-flex justify-content-between align-middle">
                                                                <i class="bi bi-clock"></i>
                                                                <span class="card-text text-muted w-100 m-0">' . date('F d, Y', strtotime($date)) . '</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-md-12 shadow border bg-light mb-2 d-md-flex justify-content-between">
                                                <div class="d-block">
                                                    <div class="card-body d-flex justify-content-between align-middle">
                                                        <form method="post" action="<?php echo htmlspecialchars(getURL()); ?>">
                                                            <a href="' . getURL() . '&task=delete&msgid=' . $t_message_id . '" class="btn btn-primary mt-1 col-sm-12 col-md-auto mr-0 mr-md-2">
                                                                <i class="bi bi-trash-fill"></i>
                                                                <span class="ml-1">Delete Message</span>
                                                            </a>';

                                                            if ($msg['msg_schedule']) {
                                                                echo '<a href="' . getURL() . '&task=scheduleend&msgid=' . $t_message_id . '" class="btn btn-danger mt-1 col-sm-12 col-md-auto">
                                                                        <i class="bi bi-x-circle"></i
                                                                        <span class="ml-1">Remove From Scheduler</span>
                                                                    </a>';
                                                            } else {
                                                                echo '<a href="' . getURL() . '&task=schedulestart&msgid=' . $t_message_id . '" class="btn btn-primary mt-1 col-sm-12 col-md-auto">
                                                                        <i class="bi bi-clock"></i>
                                                                        <span class="ml-1">Add to Scheduler</span>
                                                                    </a>';
                                                            }
                                                        echo '</form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                        }
                    } else {
                        echo '<div class="container">
                                    <div class="jumbotron text-center bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-chat-left-quote-fill my-3" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm7.194 2.766a1.688 1.688 0 0 0-.227-.272 1.467 1.467 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 5.734 4C4.776 4 4 4.746 4 5.667c0 .92.776 1.666 1.734 1.666.343 0 .662-.095.931-.26-.137.389-.39.804-.81 1.22a.405.405 0 0 0 .011.59c.173.16.447.155.614-.01 1.334-1.329 1.37-2.758.941-3.706a2.461 2.461 0 0 0-.227-.4zM11 7.073c-.136.389-.39.804-.81 1.22a.405.405 0 0 0 .012.59c.172.16.446.155.613-.01 1.334-1.329 1.37-2.758.942-3.706a2.466 2.466 0 0 0-.228-.4 1.686 1.686 0 0 0-.227-.273 1.466 1.466 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 10.07 4c-.957 0-1.734.746-1.734 1.667 0 .92.777 1.666 1.734 1.666.343 0 .662-.095.931-.26z"/>
                                        </svg>
                                        <h1>No Message Found!</h1>
                                    </div>
                                </div>';
                    }
                ?>
                </div>
                <div class="row tab-pane fade min-vh-100" id="nav-contact">
                    <div class="container row m-0 p-0">
                        
                        <div class="card col-md-12 shadow border">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">Schedule Messages</h5>
                                <p class="card-text text-muted">Scheduled messages allows the admin to send message in list after certain interval.</p>
                                <form method="post" action="<?php echo htmlspecialchars(getURL()); ?>">
                                    <?php
                                        if ($sqlDataMgr[0]["m_schedule"] == 0) {
                                            echo '<button type="submit" name="enable_scheduler" class="btn btn-primary mt-1 col-sm-12 col-md-auto">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                                                        <span class="ml-1">Schedule Message</span>
                                                                                        </button>';
                                        } else {
                                            echo '<button type="submit" name="disable_scheduler" class="btn btn-danger mt-1 col-sm-12 col-md-auto">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                                                        <span class="ml-1">Disable Scheduler</span>
                                                                                        </button>';
                                        }
                                    ?>
                                </form>
                            </div>
                        </div>

                        <?php
                            if ($sqlDataMgr[0]["m_schedule"] != 0) {
                                echo '<div class="card col-md-12 shadow border bg-light">
                                                                    <div class="card-body d-flex justify-content-between">
                                                                        <p class="card-text text-muted w-100 m-0 pt-1">Send Message after</p>
                                                                        <form class="form-inline">
                                                                            <label class="sr-only" for="inlineFormInputName2">Name</label>
                                                                            <select class="custom-select">
                                                                                <option selected>Select Option</option>
                                                                                <option value="1">1 Minute</option>
                                                                                <option value="5">5 Minute</option>
                                                                                <option value="10">10 Minute</option>
                                                                                <option value="15">15 Minute</option>
                                                                                <option value="30">30 Minute</option>
                                                                                <option value="60">1 hr</option>
                                                                            </select>
                                                                        </form>
                                                                    </div>
                                                                </div>';
                            }
                        ?>
                    </div>
                </div>
                <div class="row tab-pane fade min-vh-100" id="bot-settings">
                <div class="container row m-0 p-0">
                        <div class="card col-md-12 shadow border">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">Export Database</h5>
                                <p class="card-text text-muted">Export Database to various format</p>
                                <a href="export.php?type=excel" target="_blank" class="btn btn-primary mt-1 col-sm-12 col-md-auto">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span class="ml-1">Export to Excel</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
    </main>

    
    <footer class="sticky-top bg-dark card rounded-0 shadow-sm fixed-bottom p-3">
        <div class="container">
            <div class="container-xxl">
                <form method="post" action="<?php echo htmlspecialchars(getURL()); ?>">
                    <div class="form-row align-items-center">
                        <div class="col">
                            <div class="input-group">
                                <textarea name="send-message-text" class="form-control bg-transparent border-0 text-white" placeholder="Type your message..." rows="1" style="overflow: hidden; overflow-wrap: break-word; resize: none;" required></textarea>
                                <div class="input-group-append">
                                    <label class="custom-file container" id="customFile">
                                        <input type="file" class="custom-file-input d-none" multiple>
                                        <span class="custom-file-control form-control-file text-primary btn">Select File</span>
                                    </label>
                                    <button type="submit" name="schedule-message-btn" class="btn btn-ico btn-secondary btn-minimal bg-transparent border-0 dropzone-button-js dz-clickable">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    </button>
                                    <button type="submit" name="send-message-btn" class="btn btn-ico btn-secondary btn-minimal bg-transparent border-0 dropzone-button-js dz-clickable">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div id="files-selected"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>
    <script src="js/script.min.js"></script>
</body>
</html>
