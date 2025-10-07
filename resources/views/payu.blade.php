<html>
<head>
    <style>
        /* General Styles */
/* General Styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  background-color: #f4f4f9;
}
 
/* Loading Icon */
#loading {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}
 
.loader {
  border: 8px solid #f3f3f3; /* Light grey */
  border-top: 8px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}
 
/* Spinner Animation */
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
 
/* Content Hidden During Loading */
body.hidden {
  visibility: hidden;
}
 
    </style>
</head>
<body onload="submitPayuForm()">
Processing Payment.....
<div id="loading">
    <div class="loader"></div>
  </div>
<form action="{{$action}}" method="post" name="payuForm"><br />
 
    <input type="hidden" name="key" value="{{$MERCHANT_KEY}}" /><br />
 
    <input type="hidden" name="hash" value="{{$hash}}"/><br />
 
    <input type="hidden" name="txnid" value="{{$txnid }}" /><br />
   
    <input type="hidden" name="amount" value="{{$amount}}" /><br />
 
    <input type="hidden" name="firstname" id="firstname" value="{{$name}}" /><br />
 
    <input type="hidden" name="email" id="email" value="{{$email}}" /><br />
 
    <input type="hidden" name="productinfo" value="{{$productinfo}}"><br />
 
    <input type="hidden" name="surl" value="{{ $successURL }}" /><br />
 
    <input type="hidden" name="furl" value="{{ $failURL }}" /><br />
    <!-- <label>Service Provider</label>
    <input type="hidden" name="service_provider" value="payu_paisa"  /><br /> -->
    <?php
    if(!$hash) { ?>
        <input type="submit" value="Submit" />
    <?php } ?>
</form>
<script>
var payuForm = document.forms.payuForm;
payuForm.submit();
 
document.addEventListener('DOMContentLoaded', () => {
  const loadingDiv = document.getElementById('loading');
 
  // Simulate some delay (e.g., loading resources)
  setTimeout(() => {
    loadingDiv.style.display = 'none';
    document.body.classList.remove('hidden');
  }, 10000); // 3 seconds
});
</script>
</body>
</html>
