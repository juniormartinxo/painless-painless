$(document).ready(function () {
    $('#btnLogar').click(function (e) {
        let user = $('#iptLogin').val();
        let pass = $('#iptPassword').val();
        let url  = JS_PATH_WEB + '/auth/login';

        $.post(
            url,
            {
                user: user,
                pass: pass
            },
            function (data, status) {
                let msg, obj, sts;

                if (isJson(data)) {
                    obj = JSON.parse(data);

                    msg = obj.message;
                    sts = obj.status;
                } else {
                    msg = data;
                    sts = 'error';
                }

                if (sts === 'success') {
                    window.location.href = JS_PATH_WEB + '/index';
                } else {
                    alertShake('#message', msg, 'danger', 'Faça login primeiro', 3000);
                }
            }
        );

        e.preventDefault();
    });

    $('#btnEnviar').click(function (e) {
        let email = $('#iptEmail').val();
        let url   = JS_PATH_WEB + '/password/send';

        $.post(
            url,
            {
                email: email
            },
            function (data) {
                $('#msgRet').html(data);
                //alertShake('#msgRet', data, 'danger', 'Faça login primeiro', 3000);
            }
        );

        e.preventDefault();
    });

    $('#btnRecuperar').click(function (e) {
        let url = JS_PATH_WEB + '/session/load';

        $.post(
            url,
            function (data) {
                alertShake('#message', data, 'danger', 'Faça login primeiro', 3000);
            }
        );

        e.preventDefault();
    });
});