
<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
         <a href="home.php"><div>Behman</div></a>
    </div>
    <ul class="list-unstyled components">
        <p>WE CARE ABOUT YOU</p>
        <li class="active">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Top</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li><a href="./top_videos.php">Top Videos</a></li>
                <li><a href="./topDoctors.php">Top Doctors</a></li>
            </ul>
        </li>
        <li>
            <a href="../Behman-V2.1/index.php#Articals">Articals</a>
        </li>
        <li>
            <a href="../Behman-V2.1/index.php#contact">Contact Us</a>
            <a href="../Behman-V2.1/index.php#about">About Behman</a>
        </li>
    </ul>
    <ul class="list-unstyled CTAs">
        <li><a href="ChatRoom" class="download">Chat Room</a></li>
        <li><a href="../Behman-V2.1/index.php" class="article">Back to Offical Page</a></li>
    </ul>
    <a href="home.php"><img src="includes/images/logo.jpg" width="220px" height="170px" style="margin-left: 15px"></a>
</nav>

<script type="text/javascript">
     $(document).ready(function () {
         $('#sidebarCollapse').on('click', function () {
             $('#sidebar').toggleClass('active');
         });
     });
 </script>
