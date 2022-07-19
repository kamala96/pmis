<!DOCTYPE html>
<html lang="en-US">
<head>
  <link href="<?php echo base_url('assets/css/screen.css')?>" rel="stylesheet" type="text/css" />
  <link type="image/x-icon" href="<?php echo base_url('assets/images/pmisfavicon.ico'); ?>" rel="shortcut icon" />
  <title>Posta Management Information System:: Log in</title>
</head>

<body class="modal-form">
  <html lang="en-GB"><head>
    <title>PMIS</title>
  </head>

  <style>
    span.reverse {
      unicode-bidi: bidi-override;
      direction: rtl;
    }
  </style>
  
  <div class="tr_logo">
    <p id="tr_head">TANZANIA POSTS CORPORATION</p>
    <p id="tr_tail">Posta Management Information System</p>
  </div>

  <div class="modal-form">
    <div class="login-height">
      <div class="login_left">
        <div id="sliderFrame">
          <div id="slider">

            <a href="https://www.maliasili.go.tz/" target="_blank">
              <img src="<?php echo base_url()?>assets/images/Tourist.png" alt="https://www.maliasili.go.tz/" />
            </a>

            <a href="https://www.tantrade.go.tz/" target="_blank">
              <img src="https://admin.eganet.go.tz/iredadmin/static/default/images/sliders/TANTRED WEB 1.jpg" alt="https://www.tantrade.go.tz/" />
            </a>
            <a href="https://nbs.go.tz/" target="_blank">
              <img src="https://admin.eganet.go.tz/iredadmin/static/default/images/sliders/MAKINDA.png" alt="https://nbs.go.tz/" />
            </a>
          </div>
        </div>
      </div>
      <div class="login_right">

        <div class="tr_logp">
          <p>Please login to PMIS</p>
          <?php if($this->session->flashdata('feedback')) { ?>
            <h6 style="color:red;"><?php echo $this->session->flashdata('feedback');?></h6>
          <?php } ?>

        </div>
        <form name="horde_login" id="horde_login" method="post" action="<?php echo base_url('login/Login_Auth'); ?>">
          <div id="tr_usr">
            <label for="horde_user">Username</label>
          </div>
          <div id="tr_input">
           <input type="email" class="tr_uname"  id="horde_user" name="email" value="" style="direction:ltr" required />
         </div>

         <div id="tr_usr">
          <label for="horde_pass">Password</label>
        </div>
         <div id="tr_input">
          <input type="password" class="tr_upass"  name="password" value="" style="direction:ltr" required />
        </div>

        <div id="horde-login-pass-capslock" style="display:none">
        Warning: Your Caps Lock key is on!                                    </div>

          <!-- <div id="horde_select_view_div" style="display:none" class="tr_hsel">
             <div id="tr_slabel"><label for="horde_select_view">Mode</label></div>
             <div>
              <select id="horde_select_view" name="horde_select_view" class="tr_sview">
               <option value="auto">Automatic</option>
               <option value="" disabled="disabled">- - - - - - - - - -</option>
               <!option value="basic" selected="selected">Basic</option -->
               <!-- <option value="dynamic">Computer (PC/Laptop)</option>
               <option value="smartmobile">Mobile (Smartphone/Tablet)</option>
               <option value="mobile">Mobile (Minimal)</option>
               <option value="mobile_nojs" selected="selected">Mobile (No JavaScript)</option>
             </select> -->
             <!-- </div>
             </div> --> 
             <div class="login-submit">
               <input id="login-button" name="login_button" class="horde-default submit-button" value="Log in" type="submit" />
             </div>
           </form>
         </div>
         <br>
       </div>
       <div class="footer">
        <p>For any Technical inquiry, Please contact  ICT Support Team at :  <span class="reverse">@troppustci</span>posta.co.tz.</p> 
        <ul class="footer-login-copy">
         <li>
          Copyright &copy;2022 , tpc. All rights reserved.  
        </li>
        <li>

        </li>
      </ul> 
    </div>

  </div>
  <br>
  <br />
  <table width="100%">
    <tr>
      <td align="center">
        <img src="/themes/default/graphics/horde-power1.png" alt="Powered by Horde" />
      </td>
    </tr>
  </table>

  <script type="text/javascript" src="<?php echo base_url()?>assets/js/prototype.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/js/horde.js"></script>
  <!-- <script type="text/javascript" src="/js/login.js?v=596ca0a81b7fe741719c6df2f8b52a22"></script> -->
  <script type="text/javascript" src="<?php echo base_url()?>assets/js/loginjs.js"></script>
  <script type="text/javascript" src="/js/accesskeys.js?v=596ca0a81b7fe741719c6df2f8b52a22"></script>
</body>
</html>

