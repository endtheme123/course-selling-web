<?php
  // Get the current page name
  $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="collapse navbar_collapse" id="navbarNav">
<!-- search bar -->
          <form class="form_inline">
            <input class="form_control" type="search" placeholder="Search" aria-label="Search" >
          </form>
  <ul>
    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'home.php') echo 'active'; ?>" href="home.php">Home</a>
    </li>
    
    <?php if ($_SESSION['utype']=="Student") { ?>
    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'course.php') echo 'active'; ?>" href="course.php">Course</a>
    </li>
    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'test.php') echo 'active'; ?>" href="test.php">Test</a>
    </li>
      <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'find_job.php') echo 'active'; ?>" href="find_job.php">Find job</a>
    </li>
    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'profile.php') echo 'active'; ?>" href="profile.php">Profile</a>
    </li> 
    <?php } else { ?>
<li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'company.php') echo 'active'; ?>" href="company.php">Company</a>
    </li>
    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'CVCheck.php') echo 'active'; ?>" href="CVCheck.php">CV Box</a>
    </li> 

    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'interview.php') echo 'active'; ?>" href="interview.php">Interview</a>
    </li> 

      <?php
    }
    
    
    ?> 
    
  </ul>
</div>