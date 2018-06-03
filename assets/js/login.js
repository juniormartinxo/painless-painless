$(document).ready(function () {
    $('#btnLogar').click(function (e) {
        let user = $('#iptLogin').val();
        let pass = $('#iptPassword').val();
        let url  = 'http://localhost/painless/painless/auth/login';

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
                    window.location.href = 'http://localhost/painless/painless/index';
                } else {
                    alertShake('#message', msg, 'danger', 'Faça login primeiro', 3000);
                }
            }
        );

        e.preventDefault();
    });

    $('#btnEnviar').click(function (e) {
        let email = $('#iptEmail').val();

        e.preventDefault();
    });

    $('#btnRecuperar').click(function (e) {
        let url = 'http://localhost/painless/painless/session/load';

        $.post(
            url,
            function (data) {
                    alertShake('#message', data, 'danger', 'Faça login primeiro', 3000);
            }
        );

        e.preventDefault();
    });
});