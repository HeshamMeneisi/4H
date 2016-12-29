_sub = false;
function lsub() {
    if(_sub) return;
    _sub = true;
    errors = {};
    try {
        updateErrors("#lform");
        var email = $('input[name=l_email]').val(),
            password = $('input[name=l_password]').val();

        validateEmail(email);
        validatePassword(password);

        // if no errors, submit to server
        if (jQuery.isEmptyObject(errors)) {
            dispWaiting('lsub');
            var data = {
                'email': email,
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
        var nickname = $('input[name=nickname]').val(),
            email = $('input[name=email]').val(),
            password = $('input[name=password]').val(),
            fname = $('input[name=fname]').val(),
            lname = $('input[name=lname]').val(),
            gender = $("input[name=gender]:checked").val()
            mstatus = $("input[name=status]:checked").val(),
            bdate = $('input[name=bdate]').val(),
            country = $('#country').val(),
            city = $('input[name=city]').val(),
            pcode = $('input[name=pcode]').val();


        validateNickname(nickname);
        validateEmail(email);
        validatePassword(password);

        // cross check password
        if (password != $('input[name=cpassword]').val()) {
            errors['pcerror'] = "Confirmation does not match password.";
        }

        // if no errors, submit to server
        if (jQuery.isEmptyObject(errors)) {
            dispWaiting('rsub');
            var data = {
                'nickname': nickname,
                'email': email,
                'password': password,
                'fname': fname,
                'lname': lname,
                'gender': gender,
                'mstatus': mstatus,
                'bdate': bdate,
                'country': country,
                'city': city,
                'pcode': pcode,
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
function update_info() {
    if(_sub) return;
    _sub = true;
    errors = {};
    try {
        updateErrors("#settings");
        var nickname = $('input[name=nickname]').val(),
            email = $('input[name=email]').val(),
            password = $('input[name=password]').val(),
            gender = $("input[name=gender]:checked").val()
            mstatus = $("input[name=status]:checked").val();
            about = $("#about-field").val();
        validateNickname(nickname);
        validateEmail(email);
        validatePassword(password);

        // if no errors, submit to server
        if (jQuery.isEmptyObject(errors)) {
            var data = {
                'nickname': nickname,
                'email': email,
                'password': password,
                'gender': gender,
                'mstatus': mstatus,
                'about': about
            };
            $.ajax({
                type: 'POST',
                url: 'update.php',
                data: data,
                dataType: 'json',
                encode: true
            }).done(function(res) {
                if (res['success']) {
                    window.location.reload(true);
                    window.location.href = 'profile.php';
                }
                errors = res['errors'];
                updateErrors("#settings");
                _sub = false;
            });
        } else {
            updateErrors("#settings");
            _sub = false;
        }
    } catch (err) {
      console.log(err);
      _sub = false;
    }
}