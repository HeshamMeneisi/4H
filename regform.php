<table class="xform" id="rform">
  <tr>
    <td><label>Username</label></td>
  </tr>
  <tr>
      <td><input type="text" name="r_username" value=""></td>
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
  <td><input type="text" name="email" value=""></td>
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
      <td><input type="password" name="r_password" value=""></td>
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
      <td><input type="password" name="cpassword" value=""></td>
  </tr>
  <tr>
      <td colspan="2">
          <div class="error" id="pcerror"></div>
      </td>
      <td>
  </tr>
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
