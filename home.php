<?php
    session_start();
    if (!isset($_SESSION['loggedin']))
        header("location: login.php");

    //check expiry of session (1hr per session)
    $current_time = time();
    if (isset($_SESSION['destroy_after']) && $current_time > $_SESSION['destroy_after']) {
            session_destroy();
            header("location: login.php");
    }
    else
        $_SESSION['destroy_after'] = $current_time + 3600;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>VSU-Infirmary RIS</title>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href='resources/home.css'>
    
    
  </head>
  <body>

    <nav class="navbar navbar-expand-md navbar-dark sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <a id="navlink1" class="navbar-brand" data-toggle="collapse" data-target=".navbar-collapse.show" href="#">RISystem</a>
        <div class="collapse navbar-collapse" data-toggle="collapse" data-target=".navbar-collapse.show" id="collapsibleNavId">
            <div class="navbar-nav">
                <div class="nav-item <?php if ($_SESSION['role'] != 'admin') echo 'd-none'?>">
                    <a class="nav-link" href="#">Patients</a>
                </div>
                <div class="nav-item dropdown <?php if ($_SESSION['role'] == 'admin') echo 'd-none'?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Examination
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a id="navlink2" class="dropdown-item" href="#"><i class="fas fa-plus-square mr-1"></i> Add patient</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-list-ol mr-1"></i> Show list</a>
                    </div>
                </div>
                <div class="nav-item dropdown <?php if ($_SESSION['role'] == 'admin') echo 'd-none'?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Teleradiology
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"><i class="fas fa-file-upload mr-1"></i> Send X-Ray Image</a>
                        <a class="dropdown-item" href="#"><i class="far fa-eye-slash mr-1"></i> Pending interpretation</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-print mr-1"></i> Results</a>
                    </div>
                </div>
                <div class="nav-item <?php if ($_SESSION['role'] != 'admin') echo 'd-none'?>">
                    <a class="nav-link" id="navlink3" href="#">Administration</a>
                </div>
            </div>
        </div>
        <div id="settings-container">
            <?php
                $img_url = "resources/images/".$_SESSION['img_file'];
                echo '<a id="settings" class="d-flex text-center bg-warning text-dark align-middle rounded-pill mr-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="'.$img_url.'?t='.time().'" class="rounded-circle" width="28px" height="28px">
                        <i id="settings-u-name">'.$_SESSION['u_name'].'</i>
                        <i class="fas fa-caret-down"></i>
                    </a>';
            ?>
            <div id="settings-dropdown-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a id="edit-account" class="dropdown-item" href="#"><i class="fas fa-user-edit mr-1"></i> Edit account</a>
                <a id="logout" class="dropdown-item" href="#"><i class="fas fa-sign-out-alt mr-1"></i> Logout</a>
            </div>  
        </div>
    </nav>
    <noscript>
      <style>
        #enable-js {
          margin: 0;
          padding: 12px 15px;
          background-color: #FFC107;
          color: #000;
          text-align: center;
          font-family: "Arial";
          font-size: 1rem;
        }
      </style>
      <p id="enable-js">Unfortunately, this page doesn't work properly without JavaScript enabled. Please enable JavaScript in your browser and reload the page.</a></p>
    </noscript>
    
    <?php
        $current_time = time();
        if ($current_time < $_SESSION['loggedin'] + 15) {
            echo '<div id="welcome-message" class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Welcome <strong>'.$_SESSION['u_name'].'</strong>!</h4>
                    <p>The system is still in beta test. Some features may not be available and bugs are most evident during beta testing..</p>
                </div>';
        }
    ?>

    <!-- Dashboard - nav_link_content #1 -->
    <section id="dashboard" class="nav_link_content">
            <h3 class="heading">Dashboard</h3>
        <div class="card">
            <div class="card-header">
                Patient census
            </div>
            <div class="card-body d-flex justify-content-center">
                No info
            </div>
        </div>
    </section>
    <!-- Add patient - nav_link_content #2 -->
    <section id="add-patient" class="nav_link_content">
            <h3 class="heading">Examination</h3>
        <div class="card">
            <div class="card-header">
                Add patient
            </div>
            <div class="card-body">
                <form id="add-patient-form">
                    <div class="progress mb-2 d-none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="form-row mb-2">
                        <div id="add-patient-alert" class="alert alert-danger w-100 text-center" role="alert">
                            <!-- response goes here -->
                        </div>
                    </div>
                    <div class="form-row row-cols-2 row-cols-sm-2 row-cols-md-4">
                        <div class="col mb-3">
                            <label for="x_ray_no">X-ray No.</label>
                            <input type="text" class="form-control" name="x_ray_no" id="x_ray_no" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col mb-3">
                            <label for="inf_no">Infirmary No.</label>
                            <input type="text" class="form-control" name="inf_no" id="inf_no" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col mb-3">
                            <label for="or_no">OR No.</label>
                            <input type="text" class="form-control" name="or_no" id="or_no" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col mb-3">
                            <label for="exam_date">Examination date</label>
                            <input type="date" class="form-control" name="exam_date" id="exam_date" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6 mb-3">
                            <label for="patient_fname">First name</label>
                            <input type="text" class="form-control name" name="patient_fname" id="patient_fname" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="patient_lname">Last name</label>
                            <input type="text" class="form-control name" name="patient_lname" id="patient_lname" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                    </div>
                    <div class="form-row row-cols-2 row-cols-sm-2 row-cols-md-3">
                        <div class="col mb-3">
                            <label for="b_date">Birth date</label>
                            <input type="date" class="form-control" name="b_date" id="b_date" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col mb-3 d-none">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" name="age" id="age">
                        </div>
                        <div class="col mb-3">
                            <label for="patient_gender">Gender</label>
                            <select class="custom-select" name="patient_gender" id="patient_gender" required>
                                <option selected disabled value="">Choose...</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="patient_cnumber">Mobile no.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span style="font-size:.9rem" class="input-group-text rounded-left">+63</span>
                                </div>
                                <input type="text" class="form-control rounded-right number" name="patient_cnumber" id="patient_cnumber" required>
                                <small class="form-text">
                                </small>
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label for="standing_or_status">Standing/Status</label>
                            <select class="custom-select" name="standing_or_status" id="standing_or_status">
                                <option selected disabled value="">Choose...</option>
                                <option>Eependent</option>
                                <option>Employee</option>
                                <option>Student</option>
                                <option>Outsider</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="history_or_purpose">History/Purpose</label>
                            <input type="text" class="form-control" name="history_or_purpose" id="history_or_purpose" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col mb-3">
                            <label for="physician">Physician</label>
                            <select class="custom-select" name="physician" id="physician" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Elwin Jay, Yu, Internal Medicine</option>
                                <option value="2">Merry Christ'l, Supnet-guinocor, Pediatrician</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row row-cols-2 row-cols-sm-2 row-cols-md-2">
                        <div class="col mb-3">
                            <label for="procedure">Procedure</label>
                            <select id="procedure" name="procedure" class="form-control">
                                <option id="procedure-placeholder" selected disabled value="">Choose...</option>
                                <optgroup label="Chest">
                                    <option value="Chest AP">AP</option>
                                    <option value="Chest PA">PA</option>
                                    <option value="Chest APL">APL</option>
                                    <option value="Chest PAL">PAL</option>
                                    <option value="Chest APOL">APOL</option>
                                    <option value="Chest PALO">PALO</option>
                                </optgroup>
                                <optgroup label="Bucky">
                                    <option value="Bucky AP">AP</option>
                                    <option value="Bucky PA">PA</option>
                                </optgroup>
                                <optgroup label="Extremities">
                                    <option value="Extremities APL">APL</option>
                                    <option value="Extremities PAL">PAL</option>
                                    <option value="Extremities APOL">APOL</option>
                                    <option value="Extremities PALO">PALO</option>
                                </optgroup>
                                <optgroup label="Skull">
                                    <option value="Skull APL">APL</option>
                                    <option value="Skull PAL">PAL</option>
                                    <option value="Skull Waters view">Waters view</option>
                                </optgroup>
                                <optgroup label="Vertebrae">
                                    <option value="Vertebrae APL">APL</option>
                                    <option value="Vertebrae RAO">RAO</option>
                                    <option value="Vertebrae LAO">LAO</option>
                                </optgroup>
                                <optgroup label="Pelvis">
                                    <option value="Pelvis LAO">AP</option>
                                </optgroup>
                                <optgroup label="Shoulder">
                                    <option value="Shoulder AP">AP</option>
                                    <option value="Shoulder Internal Rotation">Internal Rotation</option>
                                    <option value="Shoulder External Rotation">External Rotation</option>
                                    <option value="Shoulder Scapular Y">Scapular Y</option>
                                </optgroup>
                                <optgroup label="Abdomin">
                                    <option value="Abdomin FPU">FPU</option>
                                </optgroup>
                            </select>
                            <small class="form-text text-muted">
                                Select 1 (click) or more (ctr+click)
                            </small>
                        </div>
                        <div class="col mb-3">
                            <label for="film_size">Film size</label>
                            <select class="form-control" name="film_size" id="film_size">
                                <option id="film_size-placeholder" selected disabled value="">Choose...</option>
                                <option>8x10</option>
                                <option>10x12</option>
                                <option>11x14</option>
                                <option>14x14</option>
                                <option>14x17</option>
                            </select>
                            <small class="form-text text-muted">
                                Select 1 (click) or more (ctr+click)
                            </small>
                        </div>
                        <div class="col mb-3">
                            <label for="spoils">No. of film spoilage</label>
                            <input type="number" class="form-control" name="spoils" id="spoils" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col mb-3">
                            <label for="error">Reason for spoilage</label>
                            <input type="text" class="form-control" name="error" id="error" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <button class="btn btn-primary ml-auto" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="administration" class="nav_link_content d-none">
        <h3 class="heading">Administration</h3>
        <div id="send-registration-email" class="card">
            <div class="card-header">
                Send registration email to the user
            </div>
            <div class="card-body">
                <form id="send-registration-email-form">
                    <div class="alert alert-secondary mb-2 d-flex" role="alert">
                        <strong>Note: </strong>
                        <i class="ml-2">A link to the registration page will be sent to the user and will use the code to unlock the page.</i>
                    </div>
                    <div class="progress mb-2 d-none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="form-row mb-2">
                        <div id="send-registration-email-alert" class="alert w-100 text-center" role="alert">
                            <!-- response goes here -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control email" name="email" id="email" required>
                            <small class="form-text text-muted">
                                Must be a valid e-mail address containing 3-32 characters long.
                            </small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="reg_code">Code</label>
                            <input type="text" class="form-control" name="reg_code" id="reg_code" required>
                            <small class="form-text text-muted">
                                Must be 5-20 characters long, containing letters and numbers only.
                            </small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="role">Role</label>
                            <select class="custom-select" name="role" id="role" required>
                                <option selected disabled value="">Choose...</option>
                                <option>Radiologic technologist</option>
                                <option>Radiologist</option>
                            </select>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <button class="btn btn-primary ml-auto" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="user-list-container" class="card">
            <div class="card-header">
                User list
            </div>
            <div class="card-body text-center d-flex justify-content-around">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-secondary">
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>ROLE</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="user-list-body">
                            <!-- list goes here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <section id="user-info-container">
        <div id="view-user-modal" class="modal fade" data-keyboard="false" tabindex="-1" aria-labelledby="unlock-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <div class="mb-2">
                            <img src="" class="rounded-circle" width="200px" height="200px">
                        </div>
                        <div class="mb-4">
                            <!-- fname and lname -->
                        </div>
                        <div class="mb-1">
                            <!-- role -->
                        </div>
                        <div class="mb-1">
                            <!-- email -->
                        </div>
                        <div class="mb-1">
                            <!-- cnumber -->
                        </div>
                        <div class="mb-1">
                            <!-- gender -->
                        </div>
                        <div class="mb-1 badge">
                            <!-- status -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="edit-account" class="nav_link_content d-none">
        <h3 class="heading">Edit account</h3>
        <div id="edit-profile" class="card">
            <div class="card-header">
                Profile
            </div>
            <div class="card-body">
                <form id="edit-profile-form">
                    <div class="text-center">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="mb-2 text-center">
                        <img id="profile-picture" src="resources/images/blank.jpg" width="200px" height="200px" class="rounded-circle">
                        <input type="file" class="custom-file-input d-none" name="customFile" id="customFile">
                    </div>
                    <div class="progress mb-2 d-none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="form-row mb-2">
                        <div id="edit-profile-alert" class="alert w-100 text-center" role="alert">
                            <!-- response goes here -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="fname">First name</label>
                            <input type="text" class="form-control names" name="fname" id="fname">
                            <small class="form-text text-muted">
                                Must be a valid name, containing 2-32 characters long.
                            </small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lname">Last name</label>
                            <input type="text" class="form-control names" name="lname" id="lname">
                            <small class="form-text text-muted">
                                Must be a valid name, containing 2-32 characters long.
                            </small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="edit-profile-email">Email address</label>
                            <input type="email" class="form-control email" name="edit-profile-email" id="edit-profile-email">
                            <small class="form-text text-muted">
                                Must be a valid e-mail address containing 3-32 characters long.
                            </small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cnumber">Mobile no.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span style="font-size:.9rem" class="input-group-text rounded-left">+63</span>
                                </div>
                                <input type="text" class="form-control rounded-right" name="cnumber" id="cnumber">
                                <small class="form-text">
                                </small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="gender">Gender</label>
                            <select class="custom-select" name="gender" id="gender">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <button class="btn btn-primary ml-auto" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="change-password" class="card">
            <div class="card-header">
                Change password
            </div>
            <div class="card-body">
                <form id="change-password-form">
                    <div  class="progress mb-2 d-none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="form-row mb-2">
                        <div id="change-password-alert" class="alert w-100 text-center" role="alert">
                            <!-- response goes here -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="old_u_pass">Old Password</label>
                            <input type="password" class="form-control" name="old_u_pass" id="old_u_pass" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="new_u_pass">New password</label>
                            <input type="password" class="form-control" name="new_u_pass" id="new_u_pass" required>
                            <small class="form-text">
                                Must be 8-20 characters long, containing letters and numbers only.
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="new_u_pass2">Verify new Password</label>
                            <input type="password" class="form-control" name="new_u_pass2" id="new_u_pass2" required>
                            <small class="form-text text-muted">
                            </small>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <button class="btn btn-primary ml-auto" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="resources/home.js"></script>
</body>
</html>
