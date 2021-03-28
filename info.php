<?PHP
    session_start();
    require_once 'config/config.php';
    require_once 'class/TelegramBot.php';

    //  session management
    if (!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit();
    }


    $bot_id = $_GET['id'];
    $uid = $_SESSION['session_user_id'];

    $sql = "SELECT * FROM t_user WHERE u_id='$uid'";
    $sqlData = $db->query($sql)->fetchArray();
    $tmsgsql = "SELECT * FROM t_messages WHERE msg_uid=$uid AND msg_botid='$bot_id'";
    $sqlDataMsg = $db->query($tmsgsql)->fetchAll();
    $tmgrsql = "SELECT * FROM t_manager WHERE m_uid='$bot_id' AND m_userid=$uid";
    $sqlDataMgr = $db->query($tmgrsql)->fetchAll();

    //  send message
    if(isset($_POST['send-message-btn']) && isset($_POST['send-message-text'])) { 
        $msg_content = html_entity_decode($_POST['send-message-text']);
        $db->query("INSERT INTO t_messages (msg_content, msg_uid, msg_botid) VALUES('$msg_content', $uid, '$bot_id')");
        (new telegramBot($bot_id))->sendMessage ('-1001436094290', $msg_content, 'html', true);
    }

    //  schedule message
    if(isset($_POST['schedule-message-btn']) && isset($_POST['send-message-text'])) { 
        $msg_content = html_entity_decode($_POST['send-message-text']);
        $db->query("INSERT INTO t_messages (msg_content, msg_uid, msg_botid, msg_schedule) VALUES('$msg_content', $uid, '$bot_id', 1)");
    }
    

    //  enable scheduler
    if(isset($_POST['enable_scheduler'])) {
        $db->query("UPDATE t_manager SET m_schedule='1' WHERE m_uid='$bot_id'");
    }

    //  disable scheduler
    if(isset($_POST['disable_scheduler'])) {
        $db->query("UPDATE t_manager SET m_schedule='0' WHERE m_uid='$bot_id'");
    }

    function getURL() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                           <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                           </svg>
                           <?php echo $sqlData['u_username']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown03">
                           <a class="dropdown-item" href="settings">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                 <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                                 <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                              </svg>
                              <span>&nbsp;</span>
                              <span>Settings</span>
                           </a>
                           <a class="dropdown-item" href="dashboard.php?task=logout">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                 <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                 <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                              </svg>
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
                    <h3><?php echo (new telegramBot($bot_id))->getMe()["result"]["first_name"]; ?></h3>
                    <p class="lead">@<?php echo (new telegramBot($bot_id))->getMe()["result"]["username"]; ?></p>
                </div>
            </div>
        </section>
    </header>
    <main>
        <nav class="sticky-top navbar navbar-expand-md navbar-light bg-light border shadow-sm">
            <div class="container">
                <div class="nav nav-pills flex-nowrap text-center" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-contact-tab" data-toggle="tab" href="#bot-info" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                        <span class="ml-1">Info</span>
                    </a>
                    <a class="nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots-fill" viewBox="0 0 16 16">
                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>
                        <span class="ml-1">Messages</span>
                    </a>
                    <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                        </svg>
                        <span class="ml-1">Schedule</span>
                    </a>
                </div>
            </div>
        </nav>

        <section class="container my-md-4">
            <div class="tab-content" id="nav-tabContent">
                <div class="row tab-pane fade min-vh-100 active show" id="bot-info">
                    <div class="container row m-0 p-0">  
                        <?php
                            $json = (new telegramBot($bot_id))->getMe()["result"];
                            foreach ($json as $key => $value) {
                                echo '<div class="card col-md-12 shadow border">
                                        <div class="card-body">
                                            <h5 class="card-title font-weight-bold">' . $key . '</h5>
                                            <p class="card-text text-muted">' . $value . '</p>
                                            </form>
                                        </div>
                                    </div>';
                            }
                        ?>
                    </div>
                </div>
                <div class="row tab-pane fade min-vh-100" id="nav-home">
                    <div class="list-group rounded-lg overflow-hidden shadow">
                    <?php 
                        foreach ($sqlDataMsg as $msg) {
                            $content = $msg['msg_content'];
                            $date = $msg['msg_date'];
                            $username =  $db->query("SELECT u_username FROM t_user WHERE u_id='" . $msg['msg_uid'] ."'")->fetchAll()[0]["u_username"];

                            echo '<div class="container row m-0 p-0">
                        
                                    <div class="card col-md-12 shadow border">
                                        <div class="card-body">
                                            <div class="d-md-flex d-sm-block justify-content-between">
                                                <div class="d-block">
                                                    <h5 class="card-title font-weight-bold">
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                                            </svg>
                                                        </span>
                                                        <span>' . $username . '</span>
                                                    </h5>
                                                    <p class="card-text text-muted text-truncate">' . $content . '</p>
                                                </div>
                                                <div class="d-block mt-3 mt-md-0">                                                
                                                    <p class="d-flex justify-content-between align-middle">
                                                        <span class="text-muted mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                            </svg>
                                                        </span>
                                                        <span class="card-text text-muted w-100 m-0">'. date('F d, Y', strtotime($date)) .'</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card col-md-12 shadow border bg-light mb-2 d-md-flex justify-content-between">
                                        <div class="d-block">
                                            <div class="card-body d-flex justify-content-between align-middle">
                                                <form method="post" action="<?php echo htmlspecialchars(getURL()); ?>">
                                                    <button type="submit" name="enable_scheduler" class="btn btn-primary mt-1 col-sm-12 col-md-auto mr-0 mr-md-2">
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                            </svg>
                                                        </span>
                                                        <span class="ml-1">Delete Message</span>
                                                    </button>';

                                                    if($msg['msg_schedule']) {
                                                        echo '<button type="submit" name="enable_scheduler" class="btn btn-danger mt-1 col-sm-12 col-md-auto">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                </svg>
                                                            </span>
                                                            <span class="ml-1">Remove From Scheduler</span>
                                                        </button>';
                                                    } else {
                                                        echo '<button type="submit" name="enable_scheduler" class="btn btn-primary mt-1 col-sm-12 col-md-auto">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                                </svg>
                                                            </span>
                                                            <span class="ml-1">Add to Scheduler</span>
                                                        </button>';
                                                    }
                                                echo '</form>
                                            </div>
                                        </div>
                                    </div>
                            </div>';
                            
                            // echo '<a href="#" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                            //         <div class="media">';
                                        
                            // if($msg['msg_schedule']) {
                            //     echo '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bg-warning text-dark p-2 rounded"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                            // } else {
                            //     echo '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bg-info text-white p-2 rounded"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
                            // }
                                        
                            // echo '<div class="media-body ml-3 w-25">
                            //                 <div class="d-flex align-items-center justify-content-between mb-1">
                            //                     <h6 class="mb-0 font-weight-bold">' . $username . '</h6>
                            //                     <small class="small font-weight-bold">'. date('F d, Y', strtotime($date)) .'</small>
                            //                 </div>
                            //                 <p class="font-italic text-muted mb-0 text-small text-truncate">' . $content . '</p>
                            //             </div>
                            //         </div>
                            //     </a>';
                        }
                    ?>
                    </div>
                </div>
                <div class="row tab-pane fade min-vh-100" id="nav-contact">
                    <div class="container row m-0 p-0">
                        
                        <div class="card col-md-12 shadow border">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">Schedule Messages</h5>
                                <p class="card-text text-muted">Scheduled messages allows the admin to send message in list after certain interval.</p>
                                <form method="post" action="<?php echo htmlspecialchars(getURL()); ?>">
                                    <?php 
                                        if($sqlDataMgr[0]["m_schedule"] == 0) { 
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
                            if($sqlDataMgr[0]["m_schedule"] != 0) { 
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
                                    <button class="btn btn-ico btn-secondary btn-minimal bg-transparent border-0 dropzone-button-js dz-clickable" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip injected-svg"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                    </button>
                                    <button type="submit" name="schedule-message-btn" class="btn btn-ico btn-secondary btn-minimal bg-transparent border-0 dropzone-button-js dz-clickable">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    </button>
                                    <button type="submit" name="send-message-btn" class="btn btn-ico btn-secondary btn-minimal bg-transparent border-0 dropzone-button-js dz-clickable">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                    </button>
                                </div>
                            </div>
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

</body>
</html>