/**
 *
 * @param obj
 * @param msgStart
 * @param classAlert
 * @param msgEnd
 * @param time
 */
function alertMessage(obj, msgStart, classAlert, msgEnd, time)
{
    $(obj).html(msgStart)
          .addClass("text-" + classAlert)
          .animateCss("headShake");
    
    setTimeout(
        function () {
            $(obj)
                .animateCss("bounceOut", function () {
                    $(obj).html(msgEnd);
                });
        },
        time
    );
}