<html lang="en-US">
<head>
  <link type="image/x-icon" href="<?php echo base_url('assets/images/pmisfavicon.ico'); ?>" rel="shortcut icon" />
  <link href="<?php echo base_url('assets/css/screen.css')?>" rel="stylesheet" type="text/css" />
  <title>Posta Management Information System:: Log in</title>
</head>

<body class="modal-form">
  <title>Government Mailing System :: Log in</title>

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

            <div class="sliderInner" style="background: url(&quot;https://admin.eganet.go.tz/iredadmin/static/default/images/sliders/BlueArea.jpg&quot;) no-repeat; border-radius: 3px;">
            </div>
          </div>
        </div>
      </div>
      <div class="login_right">

        <div class="tr_logp">
          <p>Please, login to PMIS</p>
          <?php   
          if(validation_errors())
          {
            echo '<h6 style="color:red;">'.validation_errors().'</h6>';
          }

          if($this->session->flashdata('feedback'))
          {
            echo '<h6 style="color:red;">'.$this->session->flashdata('feedback').'</h6>';
          } ?>
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
        <div class="login-submit">
         <input id="login-button" name="login_button" class="horde-default submit-button" value="Log in" type="submit" />
       </div>
     </form>
   </div>

   <br>
 </div>
 <div class="footer">
  <p>For any Technical inquiry, Please contact  your ICT Support Team at :  <span class="reverse">@troppustci</span>posta.co.tz.</p> 
  <ul class="footer-login-copy">
   <li>
    Copyright ©2022 , TPC. All rights reserved.  
  </li>
</ul> 
</div>

</div>
<br>
<br>


 <!--  <script type="text/javascript" src="/js/prototype.js?v=596ca0a81b7fe741719c6df2f8b52a22"></script><script type="text/javascript" src="/js/horde.js?v=596ca0a81b7fe741719c6df2f8b52a22"></script>
  <script type="text/javascript" src="/js/login.js?v=596ca0a81b7fe741719c6df2f8b52a22"></script>
  <script type="text/javascript" src="/imp/js/login.js?v=00b6fb7403c5dd3e1dece8deb4772850"></script>
  <script type="text/javascript" src="/js/accesskeys.js?v=596ca0a81b7fe741719c6df2f8b52a22"></script>
  <script type="text/javascript">//<![CDATA[
  HordeLogin.user_error="Please enter a username.";HordeLogin.pass_error="Please enter a password.";HordeLogin.pre_sel="dynamic";HordeLogin.server_key_error="Please choose a mail server.";
  //]]></script> -->

  <!-- <script type="text/javascript" src="<m?php echo base_url('assets/js/login/prototype.js')?>"></script>
<script type="text/javascript" src="<m?php echo base_url('assets/js/login/horde.js')?>"></script>
<script type="text/javascript" src="<m?php echo base_url('assets/js/login/login.js')?>"></script>
  <script type="text/javascript" src="<m?php echo base_url('assets/js/loginjs.js')?>"></script> -->
  </body>
  </html>