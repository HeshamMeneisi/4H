<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<a href="../"><img class="logo" src="files/logo.png" alt="Socio"/></a>
<table class="xform" id="lform">
    </tr>
      <td><label>Email</label></td>
      <td><label>Password</label></td>
    </tr>
    <tr>
        <td><input type="text" name="l_email" value=""></td>
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
