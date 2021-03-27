<?PHP
    session_start();
    require_once 'config/config.php';
    require_once 'class/TelegramBot.php';

    //  session management
    if (!isset($_SESSION['session_user_id'])) {
        header('Location: index.php');
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
    if(isset($_PSOT['enable_scheduler'])) {
        $db->query("UPDATE t_manager SET m_schedule='1' WHERE m_uid='$bot_id'");
    }

    //  disable scheduler
    if(isset($_PSOT['disable_scheduler'])) {
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
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16">
                      <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785l-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004l.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495L8 13.366l2.532-7.876-5.062.005zm-1.371-.999l-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817l5.123-6.83-2.928.002-2.195 6.828z"/>
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
            <div class="container py-5">
                <h3><?php echo (new telegramBot($bot_id))->getMe()["result"]["first_name"]; ?></h3>
                <p class="lead"><?php echo '@' . (new telegramBot($bot_id))->getMe()["result"]["username"]; ?></p>
            </div>
        </section>
    </header>
    <main>
        <nav class="sticky-top navbar navbar-expand-md navbar-light bg-light border shadow-sm">
            <div class="container">
                <div class="nav nav-pills flex-nowrap text-center" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
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
                <div class="row tab-pane fade show active min-vh-100" id="nav-home">
                    <div class="list-group rounded-lg overflow-hidden shadow">
                    <?php 
                        foreach ($sqlDataMsg as $msg) {
                            $content = $msg['msg_content'];
                            $date = $msg['msg_date'];
                            $username =  $db->query("SELECT u_username FROM t_user WHERE u_id='" . $msg['msg_uid'] ."'")->fetchAll()[0]["u_username"];

                            echo '<div class="container row m-0 p-0">
                        
                                    <div class="card col-md-12 shadow border">
                                        <div class="card-body">
                                            <h5 class="card-title font-weight-bold">Schedule Messages</h5>
                                            <p class="card-text text-muted">Scheduled messages allows the admin to send message in list after certain interval.</p>
                                            <form method="post" action="<?php echo htmlspecialchars(getURL()); ?>">
                                                <button type="submit" name="enable_scheduler" class="btn btn-primary mt-1 col-sm-12 col-md-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                    <span class="ml-1">Delete Message</span>
                                                </button>
                                            </form>
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