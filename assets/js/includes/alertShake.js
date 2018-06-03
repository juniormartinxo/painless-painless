/**
 *
 * @param obj
 * @param msgStart
 * @param classAlert
 * @param msgEnd
 * @param time
 */
function alertShake(obj, msgStart, classAlert, msgEnd, time)
{
    $(obj)
        .html(msgStart)
        .addClass("alert-text-" + classAlert)
        .addClass("container-shake");

    setTimeout(function () {
        $('#message')
            .removeClass('alert-text-' + classAlert)
            .removeClass('container-shake')
            .html(msgEnd);
    }, time);

}