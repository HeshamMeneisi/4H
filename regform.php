<table class="xform" id="rform">
  <tr>
    <td><label>Nickname</label></td>
  </tr>
  <tr>
      <td><input type="text" name="nickname" value="test"></td>
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
    <td><input type="text" name="email" value="test@mail.com"></td>
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
      <td><input type="password" name="password" value="1234"></td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="perror"></div>
      </td>
  </tr>
  <tr>
    <td><label>Confirmation</label></td>
  </tr>
  <tr>
      <td><input type="password" name="cpassword" value="1234"></td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="pcerror"></div>
      </td>
      <td>
  </tr>
  <tr>
    <td><label>First Name</label></td>
  </tr>
  <tr>
    <td><input type="text" name="fname" value=""></td>
  </tr>
  <tr>
    <td><label>Last Name</label></td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="nerror"></div>
      </td>
  </tr>
  <tr>
    <td><input type="text" name="lname" value=""></td>
  </tr>
  <tr>
    <td><label>Gender</label></td>
  </tr>
  <tr>
    <td>
      <select id="gender">
        <option value="0">Don't Say</option>
        <option value="1">Male</option>
        <option value="2">Female</option>
      </select>
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
      <select id="mstatus">
        <option value="0">Don't Say</option>
        <option value="1">Single</option>
        <option value="2">Engaged</option>
        <option value="3">Married</option>
      </select>
    </td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="mserror"></div>
      </td>
  </tr>
  <tr>
    <td><label>Birth Date</label></td>
  </tr>
  <tr>
    <td><input type="date" name="bdate" value=""></td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="bderror"></div>
      </td>
  </tr>
  <tr>
    <td><label>Country</label></td>
  </tr>
  <tr>
    <td>
      <select id="country">
        <?php
        $cf = 'files/countries.dat';
        if (!file_exists($cf)) {
            die('Internal server error. (~CF)');
        }
        $myfile = fopen($cf, 'r');
        while (($l = fgets($myfile))) {
            $v = explode('|', $l);
            $c = $v[0];
            $name = $v[1];
            echo "<option value='{$c}'>{$name}</option>";
        }
        fclose($myfile);
         ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><label>City</label></td>
  </tr>
  <tr>
    <td><input type="text" name="city" value=""></td>
  </tr>
  <tr>
    <tr>
      <td><label>Post Code</label></td>
    </tr>
    <tr>
      <td><input type="number" name="pcode" value=""></td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="error" id="lerror"></div>
        </td>
    </tr>
  <!-- The Resgister button and loading animation -->
  <tr>
    <td align="center" colspan="2">
      <div class="subblock" id="rsub">
          <button class="sbtn" onclick="rsub()">Register</button>
          <div class="loading">
              <div class="balls">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
              </div>
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div class="error" id="serror"></div><br/>
    </td>
  </tr>
</table>
