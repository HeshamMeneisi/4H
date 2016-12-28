<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="js/register_form.js"></script>
<head>
<div id="register_label">
    <h2>Welcome to Socio!</h2>
    <p>Don't have a Socio account?</p>
    <input type="button" id="StartRegistration" value="Create an account" onclick="register()" />
</div>
<table class="xform" id="rform">
  <tr>
      <td><input type="text" placeholder="Nickname" name="nickname"></td>
  </tr>
  <tr>
      <td>
          <div class="error" id="uerror"></div>
      </td>
    </tr>
   <tr>
    <td><input type="text" name="email" placeholder="Email"></td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="eerror"></div>
      </td>
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
      <td><input type="password" name="cpassword" placeholder="Confirmation"></td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="pcerror"></div>
      </td>
      <td>
  </tr>

  <tr>
    <td><input type="text" name="fname" placeholder="First name"></td>
  </tr>
    <tr>
      <td colspan="2">
          <div class="error" id="nerror"></div>
      </td>
  </tr>
  <tr>
    <td><input type="text" name="lname" placeholder="Last name"></td>
  </tr>
  <tr>
    <td><label>Gender</label></td>
  </tr>
  <tr>
    <td>
	    <section id="first" class="section">
    <div class="container">
      	<input type="radio" name="gender" id="radio-1" value="0" checked="1">
      <label for="radio-1"><span class="radio">Prefer not to say</span></label>
    </div>
    <div class="container">
      <input type="radio" name="gender" id="radio-2" value="1">
      <label for="radio-2"><span class="radio">Male</span></label>
    </div>
    <div class="container">
      <input type="radio" name="gender" id="radio-3" value="2">
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
      	<input type="radio" name="status" id="radio-4" value="0" checked="1">
      <label for="radio-4"><span class="radio">Prefer not to say</span></label>
    </div>
    <div class="container">
      <input type="radio" name="status" id="radio-5" value="1">
      <label for="radio-5"><span class="radio">Single</span></label>
    </div>
    <div class="container">
      <input type="radio" name="status" id="radio-6" value="2">
      <label for="radio-6"><span class="radio">Engaged</span></label>
    </div>
	<div class="container">
      <input type="radio" name="status" id="radio-7" value="3">
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
    <td>
      <select id="country" selected="Country">
        <option value="" disabled selected hidden>Country</option>
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
    <td><input type="text" name="city" placeholder="City" value=""></td>
  </tr>
  <tr>
    <tr>
      <td><input type="number" name="pcode" placeholder="Postal Code" value=""></td>
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
