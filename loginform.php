<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<a href="../"><img class="logo" src="files/logo.png" style="margin-top:20px;margin-left:20px;" alt="Hallo"/></a>
<table class="xform" id="lform">
    <tr>
      <td><label>Email</label></td>
      <td><label>Password</label></td>
    </tr>
    <tr>
        <form id="login_form">
        <td><input type="text" name="l_email" value=""></td>
        <td><input type="password" name="l_password" value=""></td>
        <td align="center">
          <div class="subblock" id="lsub">
              <button type="submit" class="sbtn" onclick="lsub()">Login</button>
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
        </form>
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