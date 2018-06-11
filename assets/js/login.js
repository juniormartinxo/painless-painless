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
        let url   = JS_PATH_WEB + '/password/recover/send';

        icoSpinner('#message');

        $.post(
            url,
            {
                email: email
            },
            function (data) {
                alertShake('#message', data, 'danger', 'Digite seu email', 3000);
            }
        );

        e.preventDefault();
    });
});