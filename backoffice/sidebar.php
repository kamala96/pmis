       
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                        <?php 
                        //$id = $this->session->userdata('user_login_id');
                        //$basicinfo = $this->employee_model->GetBasic($id);
						// $dep_id = $basicinfo->dep_id;
						// $dep = $this->employee_model->getdepartment1($dep_id);
						
      //                   if (!empty($dep)) {
      //                       $dep_name = $dep->dep_name;
      //                   }else{}
                        ?>
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="" style="text-align: center;border-radius:"> <img src="../assets/images/users/<?php echo $_SESSION['em_image'] ?> " alt="user" style="border-radius: 25px;height: 100px;width: 100px;" />
                        <!-- this is blinking heartbit-->
                        <!-- <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div> -->
                    </div>

                    <!-- User profile text-->
                    <div class="profile-text">
                        <h5><?php echo  $_SESSION['first_name'].'  '.$_SESSION['middle_name']. ' '.$_SESSION['last_name']; ?></h5>
                       <!--  <a href="../settings/Settings" class="dropdown-toggle u-dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a> -->
                        <a href="../login/logout" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a href="../dashboard/Dashboard" ><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a></li>
                            <li> <a class="" href="received_item_from_counter.php?em_id=<?php echo base64_encode($_SESSION['em_id'])?>" aria-expanded="false"><img src="../assets/images/receiving.png " height="25" width="25">&nbsp;&nbsp;<span class="hide-menu">Received Item From Counter </span></a>
                        </li>
                        <li> <a class="" href="pending_item_from_counter.php?em_id=<?php echo base64_encode($_SESSION['em_id'])?>" aria-expanded="false"><img src="../assets/images/pending.png " height="25" width="25">&nbsp;&nbsp;<span class="hide-menu">Pending Item From Counter </span></a>
                        </li>
                        <!-- <li> <a class="" href="#" aria-expanded="false"><img src="../assets/images/sent.png " height="25" width="25">&nbsp;&nbsp;<span class="hide-menu">Despatched Item </span></a>
                        </li>
                        <li> <a class="" href="#" aria-expanded="false"><img src="../assets/images/pending.png " height="25" width="25">&nbsp;&nbsp;<span class="hide-menu">Pending Despatched </span></a>
                        </li> -->
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
