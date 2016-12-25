_sub = false;
function lsub() {
    if(_sub) return;
    _sub = true;
    errors = {};
    try {
        updateErrors("#lform");
        var identity = $('input[name=l_username]').val(),
            username, email,
            password = $('input[name=l_password]').val();

        checkEmail(identity);
        checkPassword(password);

        // if no errors, submit to server
        if (jQuery.isEmptyObject(errors)) {
            dispWaiting('lsub');
            var data = {
                'email': identity,
                'password': password,
                'op': 'l'
            };
            $.ajax({
                type: 'POST',
                url: 'auth.php',
                data: data,
                dataType: 'json',
                encode: true
            }).done(function(res) {
                if (res['success']) {
                    window.location.href = 'index.php';
                }
                stopWaiting('lsub');
                errors = res['errors'];
                updateErrors("#lform");
                _sub = false;
            });
        } else {
            updateErrors("#lform");
            _sub = false;
        }
    } catch (err) {
        console.log(err);
        _sub = false;
    }
}
function rsub() {
    if(_sub) return;
    _sub = true;
    errors = {};
    try {
        updateErrors("#rform");
        var username = $('input[name=r_username]').val(),
            email = $('input[name=email]').val(),
            password = $('input[name=r_password]').val();

        checkUsername(username);
        checkEmail(email);
        checkPassword(password);

        // cross check password
        if (password != $('input[name=cpassword]').val()) {
            errors['pcerror'] = "Confirmation does not match password.";
        }

        // if no errors, submit to server
        if (jQuery.isEmptyObject(errors)) {
            dispWaiting('rsub');
            var data = {
                'username': username,
                'email': email,
                'password': password,
                'op': 'r'
            };
            $.ajax({
                type: 'POST',
                url: 'auth.php',
                data: data,
                dataType: 'json',
                encode: true
            }).done(function(res) {
                if (res['success']) {
                    window.location.href = 'index.php';
                }
                stopWaiting('rsub');
                errors = res['errors'];
                updateErrors("#rform");
                _sub = false;
            });
        } else {
            updateErrors("#rform");
            _sub = false;
        }
    } catch (err) {
      console.log(err);
      _sub = false;
    }
}
