<?php
    require_once 'config/config.php';

    //  redirect to login page if already installed
    if(file_exists("config/site-config.inc.php")) {
        header('Location: login.php');
    }
    
    function checkPHPVersion() {
        $php_version = phpversion();
        return ($php_version > 5) ? true : false;
    }

    function checkMySQLVersion() {
        preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', mysqli_get_client_info(), $version);
        $mysql_version = @$version[0]?$version[0]:-1;
        return ($mysql_version > 5) ? true : false;
    }

    function checkSessionWorks() {
        $_SESSION['myscriptname_sessions_work']=1;
        return (empty($_SESSION['myscriptname_sessions_work'])) ? true : false;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo APP_NAME . " - Install"; ?></title>
	<link href="css/bs-stepper.min.css" rel="stylesheet"></link>
	<link href="css/bootstrap.min.css" rel="stylesheet"></link>
	<script src="js/bs-stepper.min.js"></script>
</head>

<body class="bg-light">
	<div class="container my-5">
    <h1 class="my-5 text-center">
      <span class="mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
        </svg>
      </span>
      <span><?php echo APP_NAME; ?></span>
    </h1>
		<div id="stepper1" class="card shadow p-3 bs-stepper linear">
			<div class="bs-stepper-header" role="tablist">
				<div class="step" data-target="#test-l-1">
					<button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1" aria-selected="false" disabled="disabled"> 
            <span class="bs-stepper-circle">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
            </span>
						<span class="bs-stepper-label">User Agreement</span>
					</button>
				</div>
				<div class="bs-stepper-line"></div>
				<div class="step active" data-target="#test-l-2">
					<button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2" aria-selected="true"> 
            <span class="bs-stepper-circle">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hdd-rack-fill" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h1v2H2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2h-1V7h1a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm.5 3a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm2 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm-2 7a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm2 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zM12 7v2H4V7h8z"/>
              </svg>
            </span>
						<span class="bs-stepper-label">System Requirement</span>
					</button>
				</div>
				<div class="bs-stepper-line"></div>
				<div class="step" data-target="#test-l-3">
					<button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3" aria-selected="false" disabled="disabled"> 
            <span class="bs-stepper-circle">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-server" viewBox="0 0 16 16">
                <path d="M1.333 2.667C1.333 1.194 4.318 0 8 0s6.667 1.194 6.667 2.667V4c0 1.473-2.985 2.667-6.667 2.667S1.333 5.473 1.333 4V2.667z"/>
                <path d="M1.333 6.334v3C1.333 10.805 4.318 12 8 12s6.667-1.194 6.667-2.667V6.334c-.43.32-.931.58-1.458.79C11.81 7.684 9.967 8 8 8c-1.967 0-3.81-.317-5.21-.876a6.508 6.508 0 0 1-1.457-.79z"/>
                <path d="M14.667 11.668c-.43.319-.931.578-1.458.789-1.4.56-3.242.876-5.209.876-1.967 0-3.81-.316-5.21-.876a6.51 6.51 0 0 1-1.457-.79v1.666C1.333 14.806 4.318 16 8 16s6.667-1.194 6.667-2.667v-1.665z"/>
              </svg>
            </span>
						<span class="bs-stepper-label">Database</span>
					</button>
				</div>
        <div class="bs-stepper-line"></div>
				<div class="step" data-target="#test-l-4">
					<button type="button" class="step-trigger" role="tab" id="stepper1trigger4" aria-controls="test-l-4" aria-selected="false" disabled="disabled"> 
            <span class="bs-stepper-circle">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
              </svg>
            </span>
						<span class="bs-stepper-label">Admin</span>
					</button>
				</div>
        <div class="bs-stepper-line"></div>
				<div class="step" data-target="#test-l-5">
					<button type="button" class="step-trigger" role="tab" id="stepper1trigger5" aria-controls="test-l-5" aria-selected="false" disabled="disabled"> <span class="bs-stepper-circle">3</span>
						<span class="bs-stepper-label">Install</span>
					</button>
				</div>
			</div>

      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="bs-stepper-content">
            <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">
              <div class="py-3 form-group">
                <p>
                Copyright <YEAR> <COPYRIGHT HOLDER>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
                The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
                THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
                </p>
              </div>
              <button type="button" class="btn btn-primary" onclick="stepper1.next()">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                  </svg>
                </span>
                <span>&nbsp;</span>
                <span><b>Next:</b> &nbsp; System Requirement</span>
              </button>
            </div>
            <div id="test-l-2" role="tabpanel" class="bs-stepper-pane active dstepper-block" aria-labelledby="stepper1trigger2">
              <div class="py-3 form-group">
                  <table class="table table-striped table-hover">
                      <tbody>
                        <tr>
                          <td><span class="font-weight-bold">PHP Version (Must be 5 or better)</span></td>
                          <td><?php if(checkPHPVersion()) { echo 'OK'; } else { echo 'Error: PHP Version less than ' . phpversion() ; }?></td>
                        </tr>
                        <tr>
                          <td><span class="font-weight-bold">MySQL Version (Must be 5 or better)</span></td>
                          <td><?php if(checkMySQLVersion()) { echo 'OK'; } else { echo 'MySQL less than 5' ; }?></td>
                        </tr>
                        <tr>
                          <td><span class="font-weight-bold">PHP Session must work</span></td>
                          <td><?php if(checkSessionWorks()) { echo "Error"; } else { echo 'OK' ; }?></td>
                        </tr>
                      </tbody>
                    </table>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="stepper1.previous()" <?php echo (checkPHPVersion() and checkMySQLVersion() and checkSessionWorks())? 'disabled' : ''; ?>>
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span><b>Previous:</b> &nbsp; User Agreement</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="stepper1.next()">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span><b>Next:</b> &nbsp;  Database</span>
                </button>
              </div>
            </div>
            <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3">
              <div class="py-3">
                <div class="form-group row py-1">
                  <label for="staticEmail" class="col-sm-2 col-form-label font-weight-bold">Database Host:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="staticEmail" placeholder="Enter Database Host">
                  </div>
                </div>
                <div class="form-group row py-1">
                  <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Username:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword" placeholder="Enter Username">
                  </div>
                </div>
                <div class="form-group row py-1">
                  <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Password:</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password">
                  </div>
                </div>
                <div class="form-group row py-1">
                  <label for="staticEmail" class="col-sm-2 col-form-label font-weight-bold">Database Name:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="staticEmail" placeholder="Enter Database Name">
                    <p class="text-muted py-2">Database name will be prefixed with tm_</p>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="stepper1.previous()">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span><b>Previous:</b> &nbsp; System Requirement</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="stepper1.next()">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span><b>Next:</b> &nbsp; Admin</span>
                </button>
              </div>
            </div>
            <div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4">
            <div class="py-3">
                <div class="form-group row py-1">
                  <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Username:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword" placeholder="Enter Username">
                  </div>
                </div>
                <div class="form-group row py-1">
                  <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Password:</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password">
                  </div>
                </div>
                <div class="form-group row py-1">
                  <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Confirm Password:</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password">
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="stepper1.previous()">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span><b>Previous:</b> &nbsp; Database</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="stepper1.next()">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span><b>Next:</b> &nbsp; Install</span>
                </button>
              </div>
            </div>
            <div id="test-l-5" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger5">
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="stepper1.previous()">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span><b>Previous:</b> &nbsp; Admin</span>
                </button>
                <button type="submit" class="btn btn-primary">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"/>
                    </svg>
                  </span>
                  <span>&nbsp;</span>
                  <span>Install</span>
                </button>
              </div>
            </div>
        </div>
      </form>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>
	<script>
		var stepper1
    document.addEventListener('DOMContentLoaded', function () {
        stepper1 = new Stepper(document.querySelector('#stepper1'), {
          linear: false
        })
    });
	</script>
</body>
</html>