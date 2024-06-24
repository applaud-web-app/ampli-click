window.addEventListener("DOMContentLoaded", function (event) {
  
  websdkready();
});

function websdkready() {
  var testTool = window.testTool;
  if (testTool.isMobileDevice()) {
    vConsole = new VConsole();
  }
  ZoomMtg.preLoadWasm();
  
  // document.getElementById("display_name").value =
  //   "CDN" +
  //   ZoomMtg.getWebSDKVersion()[0] +
  //   testTool.detectOS() +
  //   "#" +
  //   testTool.getBrowserInfo();

    window.onload = function(){
    var meetingConfig = testTool.getMeetingConfig();
    if (!meetingConfig.mn || !meetingConfig.name) {
      // console.log("Meeting number or username is empty");
      return false;
    }

    testTool.setCookie("meeting_number", meetingConfig.mn);
    testTool.setCookie("meeting_pwd", meetingConfig.pwd);

    var signature = ZoomMtg.generateSDKSignature({
      meetingNumber: meetingConfig.mn,
      sdkKey: CLIENT_ID,
      sdkSecret: CLIENT_SECRET,
      role: meetingConfig.role,
      success: function (res) {
        meetingConfig.signature = res;
        meetingConfig.sdkKey = CLIENT_ID;
        var joinUrl = MEETING_LINK_IN+"?" + testTool.serialize(meetingConfig);
        window.open(joinUrl,"_self");
      },
    });
  };

}
