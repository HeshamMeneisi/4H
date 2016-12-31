<?php
   echo '<title>Friends - Hallo</title>';
   require_once 'core.php';

   include_once 'db.php';

   include_once 'header.php';

   $user = get_user();
   ?>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <script src="js/auth.js"></script>
   <script src="js/form.js"></script>
   <head>
<body>
   <div id="update_settings">
      <h1>Account Settings</h1>
      <table class="xform" id="settings">
         <tr>
            <td><label>Nickname</label></td>
         </tr>
         <tr>
            <td><input type="text" name="nickname" placeholder="Nickname" value="<?php
               echo $user['nickname']; ?>"</td>
         </tr>
         <tr>
            <td>
               <div class="error" id="uerror"></div>
            </td>
         </tr>
         <tr>
            <td><label>Email</label></td>
         </tr>
         <tr>
            <td><input type="text" name="email" placeholder="Email" value="<?php
               echo $user['email']; ?>"></td>
         </tr>
         <tr>
            <td colspan="2">
               <div class="error" id="eerror"></div>
            </td>
         </tr>
         <tr>
            <td><label>Password</label></td>
         </tr>
         <tr>
            <td><input type="password" name="password" placeholder="Password"></td>
         </tr>
         <tr>
            <td colspan="2">
               <div class="error" id="perror"></div>
            </td>
         </tr>
         <tr>
            <td><label>Gender</label></td>
         </tr>
         <tr>
            <td>
               <section id="first" class="section">
                  <div class="container">
                     <input type="radio" name="gender" id="radio-1" value="0" <?php
                        if ($user['gender'] == 'u') {
                            echo 'checked="1"';
                        } ?>>
                     <label for="radio-1"><span class="radio">Prefer not to say</span></label>
                  </div>
                  <div class="container">
                     <input type="radio" name="gender" id="radio-2" <?php
                        if ($user['gender'] == 'm') {
                            echo 'checked="1"';
                        } ?>>
                     <label for="radio-2"><span class="radio">Male</span></label>
                  </div>
                  <div class="container">
                     <input type="radio" name="gender" id="radio-3" value="2" <?php
                        if ($user['gender'] == 'f') {
                            echo 'checked="1"';
                        } ?>>
                     <label for="radio-3"><span class="radio">Female</span></label>
                  </div>
               </section>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <div class="error" id="gerror"></div>
            </td>
         </tr>
         <tr>
            <td><label>Status</label></td>
         </tr>
         <tr>
            <td>
               <section id="first" class="section">
                  <div class="container">
                     <input type="radio" name="status" id="radio-4" value="0" <?php
                        if ($user['mstatus'] == 'u') {
                            echo 'checked="1"';
                        } ?>>
                     <label for="radio-4"><span class="radio">Prefer not to say</span></label>
                  </div>
                  <div class="container">
                     <input type="radio" name="status" id="radio-5" value="1" <?php
                        if ($user['mstatus'] == 's') {
                            echo 'checked="1"';
                        } ?>>
                     <label for="radio-5"><span class="radio">Single</span></label>
                  </div>
                  <div class="container">
                     <input type="radio" name="status" id="radio-6" value="2" <?php
                        if ($user['mstatus'] == 'e') {
                            echo 'checked="1"';
                        } ?>>
                     <label for="radio-6"><span class="radio">Engaged</span></label>
                  </div>
                  <div class="container">
                     <input type="radio" name="status" id="radio-7" value="3" <?php
                        if ($user['mstatus'] == 'm') {
                            echo 'checked="1"';
                        } ?>>
                     <label for="radio-7"><span class="radio">Married</span></label>
                  </div>
               </section>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <div class="error" id="mserror"></div>
            </td>
         </tr>
         <tr>
            <td><label>Bio</label></td>
         </tr>
         <tr>
            <td><textarea name="about" id="about-field" placeholder="Bio"><?php
               echo $user['about']; ?></textarea>
            </td>
         </tr>
         <tr>
            <td align="center" colspan="2">
               <button class="sbtn" onclick="update_info()">Update Info</button>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <div class="error" id="serror"></div>
               <br/>
            </td>
         </tr>
      </table>
   </div>
</body>
