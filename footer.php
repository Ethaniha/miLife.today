<!-- Footer -->
<footer class="page-footer font-small" id="footer">

  <!-- Copyright -->
  <div class="container">
  <div class="footer-copyright text-center py-3">© 2019 Copyright miLife
      <hr>
      <p>Will Woodruff, Will Staff, Chloe Maddison, Jermaine Pemberton, George Collard, Ethan Richardson</p>
  </div>
</div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
<script>
  if (navigator.platform.substr(0,2) === 'iP'){
      //iOS (iPhone, iPod or iPad)
      var lte9 = /constructor/i.test(window.HTMLElement);
      var nav = window.navigator, ua = nav.userAgent, idb = !!window.indexedDB;
      if (ua.indexOf('Safari') !== -1 && ua.indexOf('Version') !== -1 && !nav.standalone){      
        //Safari (WKWebView/Nitro since 6+)
      } else if ((!idb && lte9) || !window.statusbar.visible) {
        //UIWebView
      } else if ((window.webkit && window.webkit.messageHandlers) || !lte9 || idb){
        //WKWebView
        
        document.getElementById("footer").remove();

      }
}
  </script>