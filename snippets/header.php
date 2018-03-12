<?php 
echo "<nav class='navbar navbar-expand-md navbar-dark' style='background-color: #2A80B2;'>
  <a class='navbar-brand' href='index.php'><span style='font-size:15px;' class='d-none d-lg-block'>General Retention and Disposal Schedule</span><span class='d-lg-none'>GRDS</span></a>";


switch ($header_type) {
    case 1:
        echo "</nav>";
        break;
    case 2:
        echo "<button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarToggler' aria-controls='navbarToggler' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarToggler'>
            <ul class='navbar-nav ml-auto mt-2 mt-md-0'>
                <li id='navhome' class='nav-item'>
                    <a class='nav-link' href='index.php'><i class='fa fa-home' aria-hidden='true'></i> Home</a>
                </li>
                <li id='navlogin' class='nav-item'>
                    <a class='nav-link' href='login.php'><i class='fa fa-sign-in' aria-hidden='true'></i> Log In</a>
                </li>
                <li id='navsignup' class='nav-item'>
                    <a class='nav-link' href='signup.php'><i class='fa fa-user-plus' aria-hidden='true'></i> Sign Up</a>
                </li>
            </ul>
        </div>
        </nav>";
        break;
    case 3:
        echo "<button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarToggler' aria-controls='navbarToggler' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarToggler'>
            <ul class='navbar-nav ml-auto mt-2 mt-md-0'>
                <li id='navhome' class='nav-item'>
                    <a class='nav-link' href='index.php'><i class='fa fa-home' aria-hidden='true'></i> Home</a>
                </li>
                <li id='navbookmark' class='nav-item'>
                    <a class='nav-link' href='bookmarks.php'><i class='fa fa-bookmark' aria-hidden='true'></i> Bookmarks</a>
                </li>
                <li id='navaccount' class='nav-item'>
                    <a class='nav-link' href='account.php'><i class='fa fa-user' aria-hidden='true'></i> Account</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='logout.php'><i class='fa fa-sign-out' aria-hidden='true'></i> Log Out</a>
                </li>
            </ul>
        </div>
        </nav>";
        break;
    case 4:
        echo "<button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarToggler' aria-controls='navbarToggler' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarToggler'>
            <ul class='navbar-nav ml-auto mt-2 mt-md-0'>
                <li id='navhome' class='nav-item'>
                    <a class='nav-link' href='index.php'><i class='fa fa-home' aria-hidden='true'></i> Home</a>
                </li>
                <li id='navbookmark' class='nav-item'>
                    <a class='nav-link' href='bookmarks.php'><i class='fa fa-bookmark' aria-hidden='true'></i> Bookmarks</a>
                </li>
                <li class='nav-item dropdown d-none d-md-block d-lg-none'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-cogs' aria-hidden='true'></i> Settings
                    </a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
                        <a class='dropdown-item' href='account.php'><i class='fa fa-user' aria-hidden='true'></i> Account</a>
                        <a class='dropdown-item' href='approveadmin.php'><i class='fa fa-lock' aria-hidden='true'></i> Add/Remove Admin</a>
                        <a class='dropdown-item' href='newauth.php'><i class='fa fa-plus' aria-hidden='true'></i> New Authorisation</a>
                    </div>
                </li>
                <li id='navaccount' class='nav-item d-md-none d-lg-block'>
                    <a class='nav-link' href='account.php'><i class='fa fa-user' aria-hidden='true'></i> Account</a>
                </li>
                <li id='addadmin' class='nav-item d-md-none d-lg-block'>
                    <a class='nav-link' href='approveadmin.php'><i class='fa fa-lock' aria-hidden='true'></i> Add/Remove Admin</a>
                </li>
                <li id='navnewrecord' class='nav-item d-md-none d-lg-block'>
                    <a class='nav-link' href='newauth.php'><i class='fa fa-plus' aria-hidden='true'></i> New Authorisation</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='logout.php'><i class='fa fa-sign-out' aria-hidden='true'></i> Log Out</a>
                </li>
            </ul>
        </div>
        </nav>";
        break;
}
?>