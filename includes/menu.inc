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
   
    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'course.php') echo 'active'; ?>" href="course.php">Course</a>
    </li>
      <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'find_job.php') echo 'active'; ?>" href="find_job.php">Find job</a>
    </li>
    <li class="nav_item">
      <a class="nav-link <?php if ($currentPage == 'profile.php') echo 'active'; ?>" href="profile.php">Profile</a>
    </li> 


  </ul>
</div>