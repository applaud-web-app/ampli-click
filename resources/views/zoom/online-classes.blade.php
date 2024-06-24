<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONLINE CLASS</title>
</head>
<body>
    <div class="col-xl-12">
        <h2 style="text-align: center;margin-top:10px;">Connecting please wait...</h2>
        <input type="hidden" name="display_name" id="display_name" value="{{$fullName}}">
        <input type="hidden" name="meeting_number" id="meeting_number" value="{{$meetData->meeting_id}}">
        <input type="hidden" name="meeting_pwd" id="meeting_pwd" value="{{$meetData->passcode}}">
        <input type="hidden" name="meeting_email" id="meeting_email" value="">
        <input type="hidden" name="meeting_role" id="meeting_role" value="{{$meetData->is_host}}">
        <input type="hidden" name="meeting_china" id="meeting_china" value="0">
        <input type="hidden" name="meeting_lang" id="meeting_lang" value="en-US">
    </div>
    <script>
        var CLIENT_ID = '{{getenv("ZOOM_MEET_CLIENTID")}}';
        var CLIENT_SECRET = '{{getenv("ZOOM_MEET_CLIENTSECRET")}}';
        var MEETING_LINK_IN = "{{url('current-meeting')}}";
    </script>
    <script src="https://source.zoom.us/3.6.1/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.6.1/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.6.1/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.6.1/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.6.1/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/3.6.1/zoom-meeting-3.6.1.min.js"></script>
    <script src="{{asset("zoom/CDN/js/tool.js")}}"></script>
    <script src="{{asset("zoom/CDN/js/vconsole.min.js")}}"></script>
    <script src="{{asset('zoom/CDN/js/index.js')}}"></script>
</body>
</html>

