// function DontRedirect()
// {
//   console.log(root_url);
//   console.log(appname);
//   console.log("function DontRedirect()");
//   document.getElementById("btnConnect").addEventListener("click", function (event)
//   {
//     console.log("event added on btnJanrainLogger");
//     event.preventDefault();
//   });
// };
// function CallJanrain()
// {
//   console.log("function CallJanrain()");
//   if (typeof window.janrain !== 'object') window.janrain = {};
//   if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
//
//   janrain.settings.tokenUrl = root_url+'/modules/JanrainLogger/action.rpx-token-url.php';
//   console.log(root_url+'/modules/JanrainLogger/action.rpx-token-url.php');
//   function isReady() { janrain.ready = true; };
//   if (document.addEventListener)
//   {
//     console.log('document.addEventListenenr');
//     document.addEventListener("DOMContentLoaded", isReady, false);
//   } else
//   {
//     console.log('!document.addEventListener');
//     window.attachEvent('onload', isReady);
//   }
//
//   var e = document.createElement('script');
//   e.type = 'text/javascript';
//   e.id = 'janrainAuthWidget';
//   console.log(e);
//
//   if (document.location.protocol === 'https:')
//   {
//     e.src = 'https://rpxnow.com/js/lib/'+appname+'/engage.js';
//   } else
//   {
//     e.src = 'http://widget-cdn.rpxnow.com/js/lib/'+appname+'/engage.js';
//   }
//
//   var s = document.getElementsByTagName('script')[0];
//   s.parentNode.insertBefore(e, s);
// };
