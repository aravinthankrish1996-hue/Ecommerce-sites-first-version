<template>
  <div class="payment-container">
    <h2>Processing Your Payment...</h2>
    <p>Please wait, you will be redirected to the payment gateway shortly.</p>
    <div class="loader"></div>
    <form ref="payuForm" :action="action" method="post" name="payuForm" style="display: none;">
      <input type="hidden" name="key" :value="MERCHANT_KEY" />
      <input type="hidden" name="hash" :value="hash" />
      <input type="hidden" name="txnid" :value="txnid" />
      <input type="hidden" name="amount" :value="amount" />
      <input type="hidden" name="firstname" :value="name" />
      <input type="hidden" name="email" :value="email" />
      <input type="hidden" name="productinfo" :value="productinfo" />
      <input type="hidden" name="surl" :value="successURL" />
      <input type="hidden" name="furl" :value="failURL" />
    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
  action: String,
  // csrfToken is now a local variable, not a prop
  MERCHANT_KEY: String,
  hash: String,
  txnid: String,
  amount: String,
  name: String,
  email: String,
  productinfo: String,
  successURL: String,
  failURL: String,
});

// A local ref to store the CSRF token
const csrfToken = ref(null);
const payuForm = ref(null);

onMounted(() => { 
  if (payuForm.value) {
    payuForm.value.submit();
  }
});
</script>

<style scoped>
.payment-container {
  font-family: Arial, sans-serif;
  margin: 0;
  background-color: #f4f4f9;
  color: #333;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.loader {
  border: 8px solid #f3f3f3; /* Light grey */
  border-top: 8px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
  margin-top: 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>