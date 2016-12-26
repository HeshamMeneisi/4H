<table class="xform" id="lform">
    </tr>
      <td><label>Username or Email</label></td>
      <td><label>Password</label></td>
    </tr>
    <tr>
        <td><input type="text" name="l_username" value=""></td>
        <td><input type="password" name="l_password" value=""></td>
        <td align="center">
          <div class="subblock" id="lsub">
              <button class="sbtn" onclick="lsub()">Login</button>
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
        <div class="error" id="uerror"></div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
          <div class="error" id="perror"></div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <div class="error" id="serror"></div>
      </td>
    </tr>
</table>
